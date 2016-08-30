<?php
namespace App\Helpers;

use App\Video;
use FFMpeg\Coordinate\FrameRate;
use FFMpeg\Filters\Video\FrameRateFilter;

class VideoTrans
{

    public static function convertSetup()
    {
        /**
         * 转码逻辑中的插件会用到有一个叫escapeshellarg()的函数, 在换为php7后, 会把中文字幕忽略掉,
         * 需要setlocal设置utf-8才会正常
         */
        setlocale(LC_CTYPE, "en_US.UTF-8");

        restore_exception_handler();
    }

    public static function videoCheck($videoId)
    {
        self::convertSetup();
        if (!$video = Video::find($videoId)) {
            \Log::error('Can not find video of:' . $videoId);
            return false;
        }
        $input_file = Video::originDir($video->created_at) . basename($video->video_path);
        $duration = self::getTime($input_file);
        $size = self::getVideoSize($input_file);
        $result =  $video->update([
            'duration' => $duration,
            'size' => $size,
        ]);
        \Log::info('update_video_info video_id:' . $video . ' end.');
        return $result;
    }

    public static function videoTrans($videoId) {
        self::convertSetup();
        if (! $videoModel = Video::find($videoId)) {
            \Log::error('Can not find video of:' . $videoId);
            return false;
        }

        $convertStatus = [Video::STATUS_VERIFIED, Video::STATUS_CONVERT_FAILED];
        if (! in_array($videoModel->status, $convertStatus)) {
            \Log::error('Video status not correct, must in :' . implode(',', $convertStatus));
            return false;
        }

        $inputFile = Video::originDir($videoModel->created_at) . basename($videoModel->file_name);
        $convertDir = Video::releaseDir($videoModel->created_at);
        $shotDir = Video::thumbDir($videoModel->created_at);

        $videoModel->update([
            'status' => Video::STATUS_PROCESSING,
        ]);
        try {
            $data = self::converting($inputFile, $convertDir);
            self::shotting($inputFile, $shotDir);
            $videoModel->update([
                'status' => Video::STATUS_PROCESSED,
                'duration' => $data['duration'],
                'size' => $data['size'],
            ]);
            \Log::info('video_convert video_id:' . $videoId . ' success, mime_type: ' . $data['mime_type'] . ' video duration: ' . $data['duration'] . ' spend convert time: ' . $data['spend_time'] . ' s');
        } catch (\Exception $e) {
            \Log::critical("video_convert video_id:' . $videoId . ' failed:" . $e->getMessage());
            $videoModel->update([
                'status' => Video::STATUS_CONVERT_FAILED
            ]);
            return false;
        }

        return true;
    }


    public static function converting($input_file, $output_dir)
    {
        $start = \Carbon\Carbon::now();
        if (!is_dir($output_dir)) {
            mkdir($output_dir, 0755, true);
        }

        // 可容忍的转码参数, 如果视频本身的值未达到这些标准, 采用视频本身的值
        // 视频长宽
        $width = 640;
        $height = 360;
        // 视频帧率
        $frameRate = 24;
        // 视频码率, 单位k
        $bitRate = 250;
        // 声道
        $audioChannel = 1;
        // 音频码率, 单位k
        $audioBitRate = 16;
        $ffmpeg = \FFMpeg\FFMpeg::create(array(
            //'ffmpeg.binaries' => config('ffmpeg.ffmpeg'),
            //'ffprobe.binaries' => config('ffmpeg.ffprobe'),
            'timeout' => 7200, // The timeout for the underlying process
            'ffmpeg.threads' => 8,   // The number of threads that FFMpeg should use
        ), app('log'));

        $ffprobe = \FFMpeg\FFProbe::create();
        $stream = $ffprobe->streams($input_file)->videos()->first();

        // 计算长和宽
        $closure = (function() use ($stream, $width, $height) {
            $orgWidth = (int) $stream->get('width');
            $orgHeight = (int) $stream->get('height');
            if (($orgWidth > $width) || ($orgHeight > $height)) {

                $ratio = $orgWidth / $orgHeight;
                $newRatio = $width / $height;

                if ($ratio >= $newRatio) {
                    $height = (int) ($width * (1 / $ratio));
                } else {
                    $width = (int) ($height * $ratio);
                }
            } else {
                $width = $orgWidth;
                $height = $orgHeight;
            }

            // 长和宽是不能为奇数的, 不然ffmpeg会报错"not divisible by 2"
            if ($width % 2 != 0) {
                $width --;
            }
            if ($height % 2 != 0) {
                $height --;
            }
            $arr = [$width, $height];
            return $arr;
        });
        list($newWidth, $newHeight) = $closure();

        // 计算帧率
        $closure = (function() use ($stream, $frameRate) {
            $avgFrameRate = $stream->get('r_frame_rate');
            if (! empty($avgFrameRate)) {
                $orgFrameRate = explode('/', $avgFrameRate)[0];
            } else {
                $orgFrameRate = $frameRate;
            }
            if ($orgFrameRate < $frameRate) {
                return (int) $orgFrameRate;
            } else {
                return $frameRate;
            }
        });
        $newFrameRate = $closure();

        // 计算视频码率
        $closure = (function() use ($stream, $bitRate) {
            $orgBitRate = $stream->get('bit_rate');
            if (! empty($orgBitRate)) {
                return min([$orgBitRate, $bitRate]);
            } else {
                return $bitRate;
            }
        });
        $newBitRate = $closure();

        // 计算声道数
        $newAudioChannel = $audioChannel;

        // 计算音频码率
        $newAudioBitRate = $audioBitRate;

        //Converting..................................................................
        $video = $ffmpeg->open($input_file);
        $outputLinkND = $output_dir . basename($input_file) . Video::VIDEO_ND_SUFFIX;
        $mimeType = \File::mimeType($input_file);

        $video
            ->filters()
            ->resize(new \FFMpeg\Coordinate\Dimension($newWidth, $newHeight))
            ->synchronize();
        $format = new \FFMpeg\Format\Video\X264();

        $drawtext = 'welcome';
        $attributes['fontsize'] = (int) ($stream->get('height') / 10);
        $attributes['speed'] = (int) ($stream->get('height') / 5);

        if (! $drawtext) {
            $video->addFilter(new DrawTextFilter($drawtext, $attributes));
        }

        // 添加关键帧配置
        $video->addFilter(new TransFilter(['-movflags', 'faststart']));

        $video->addFilter(new FrameRateFilter(new FrameRate($newFrameRate), 250));

        $format
            ->setKiloBitrate($newBitRate)//视频码率
            ->setAudioChannels($newAudioChannel)//声道
            ->setAudioKiloBitrate($newAudioBitRate);    //音频码率

        $video->save($format, $outputLinkND);

        $duration = self::getTime($outputLinkND);
        $size = self::getVideoSize($outputLinkND);

        $end = \Carbon\Carbon::now();

        $data = [
            'duration' => $duration,
            'size' => $size,
            'spend_time' => $end->timestamp - $start->timestamp,
            'mime_type' => $mimeType,
        ];
        return $data;
    }

    public static function shotting($input_file, $output_dir)
    {
        if (!is_dir($output_dir)) {
            mkdir($output_dir, 0755, true);
        }
        //自动创建一个视频处理文件
        //$ffmpeg = FFMpeg\FFMpeg::create();
        //手动生成...
        $ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries' => config('ffmpeg.ffmpeg'),
            'ffprobe.binaries' => config('ffmpeg.ffprobe'),
            'timeout' => config('ffmpeg.timeout'), // The timeout for the underlying process
            'ffmpeg.threads' => config('ffmpeg.threads'),   // The number of threads that FFMpeg should use
        ], app('log'));

        $video = $ffmpeg->open($input_file);

        #Get the duration of the video..........................................................
        $timePeriod = self::getTime($input_file) / Video::VIDEO_THUMB_COUNT;
        $randMIN = 0;
        $randMAX = $timePeriod;
        $output_files = [];

        #screenshot 5 times.....................................................................
        for ($i = 1; $i <= Video::VIDEO_THUMB_COUNT; $i++) {
            $shot = rand($randMIN, $randMAX);
            $outputLink = $output_dir . basename($input_file) . Video::VIDEO_ORIGIN_THUMB_SUFFIX . $i . Video::VIDEO_THUMB_EXTENSION;
            $video
                ->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds($shot))
                ->save($outputLink);
            $randMIN += $timePeriod;
            $randMAX += $timePeriod;
            $output_files[] = $outputLink;

            $smallLink = $output_dir . basename($input_file) . Video::VIDEO_THUMB_SUFFIX . $i . Video::VIDEO_THUMB_EXTENSION;
            self::imgResize($outputLink, $smallLink, 200, 120);
        }
        return true;
    }

    public static function getTime($file)
    {
        if (!file_exists($file)) {
            \Log::error("no such file!" . $file) ;
            return 0;
        }
        $command = config('ffmpeg.ffmpeg') . " -i " . $file . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
        $output = array();
        exec($command, $output);
        $period = 0;
        if (isset($output[0])) {
            $duration = $output[0];
            $timeGeted = explode(":", $duration, 3);
            $period = $timeGeted[0] * 3600 + $timeGeted[1] * 60 + $timeGeted[2];
        }
        return $period;
    }


    public static function getVideoSize($name)
    {
        $command = "du -k $name | awk '{print $1}'";
        exec($command, $output);
        $videoSize = (int) $output[0];
        return $videoSize;
    }

    public static function imgResize($imgFile, $newimgFile, $newWidth, $newHeight){
        list($width, $height) = getimagesize($imgFile);
        $ratio = $width / $height;
        $newRatio = $newWidth / $newHeight;
        if ($ratio >= $newRatio) {
            $reHeight = $newHeight;
            $reWidth = (int) ($reHeight * $ratio);
        } else {
            $reWidth = $newWidth;
            $reHeight = (int) ($reWidth * (1 / $ratio));
        }

        $newSource = imagecreatetruecolor($reWidth, $reHeight);
        $source = imagecreatefromjpeg($imgFile);
        imagecopyresampled($newSource, $source, 0, 0, 0, 0, $reWidth, $reHeight, $width, $height);

        $finalSource = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($finalSource, $newSource, 0, 0, (int) (abs($reWidth - $newWidth) / 2), (int) (abs($reHeight - $newHeight) / 2), $newWidth, $newHeight, $newWidth, $newHeight);

        imagejpeg($finalSource, $newimgFile);
        imagedestroy($source);
        imagedestroy($newSource);
        imagedestroy($finalSource);
    }

}
