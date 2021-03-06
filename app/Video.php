<?php

namespace App;

class Video extends AppModel
{
    /**
     * status
     */
    // 视频已经上传至服务器, 但是还未提交
    const STATUS_UPLOADING = 0;
    // 提交了视频, 等待审核, 如果是后台上传的视频, 无需审核, 直接进入已审核状态
    const STATUS_UPLOADED = 1;
    // 视频审核通过
    const STATUS_VERIFIED = 2;
    // 视频审核被拒绝
    const STATUS_REFUSED = 3;
    // 视频进入等待转码处理队列
    const STATUS_WAIT_PROCESS = 4;
    // 视频正在转码处理中
    const STATUS_PROCESSING = 5;
    // 视频转码处理完毕
    const STATUS_PROCESSED = 6;
    // 处于定时发布队列中
    const STATUS_TIMED = 7;
    // 视频处于发布状态, 此状态的视频才能在前台播放
    const STATUS_PUBLISHED = 8;
    // 视频处于冻结状态, 待用
    const STATUS_FREEZED = 9;
    // 视频转码失败
    const STATUS_CONVERT_FAILED = 10;

    // the thumb file suffix
    const VIDEO_THUMB_SUFFIX = '_thumb_';
    const VIDEO_ORIGIN_THUMB_SUFFIX = '_origin_thumb_';
    const VIDEO_THUMB_EXTENSION = '.jpg';

    const VIDEO_ND_SUFFIX = '_ND.mp4';
    const VIDEO_HD_SUFFIX = '_HD.mp4';
    const VIDEO_SD_SUFFIX = '_SD.mp4';

    // 想要生成的截图数量
    const VIDEO_THUMB_COUNT = 8;

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'video_tag', 'video_id', 'tag_id');
    }

    public static function genFileName(){
        return str_random(20);
    }

    public static function storeDir(){
        return storage_path().'/data/';
    }

    /**
     * 临时上传的视频文件路径
     * @param $date
     * @return string
     */
    public static function tempDir($date){
        return self::storeDir().'video/tmp/' . self::dateFormat($date) . '/';
    }

    /**
     * 上传后点击提交,视频文件转移至此路径
     * @param $date
     * @return string
     */
    public static function originDir($date){
        return self::storeDir().'video/origin/' . self::dateFormat($date) . '/';
    }

    /**
     * 处理后的文件在此路径下
     * @param $date
     * @return string
     */
    public static function releaseDir($date){
        return self::storeDir().'video/released/' . self::dateFormat($date) . '/';
    }

    /**
     * 截屏的文件路径
     * @param $date
     * @return string
     */
    public static function thumbDir($date)
    {
        return self::storeDir().'image/thumb/' . self::dateFormat($date) . '/';
    }

    public static function dateFormat($date)
    {
        if (! ($date instanceof \Carbon\Carbon)) {
            $date = new \Carbon\Carbon($date);
        }
        return $date->format('Y-m-d');
    }

    public function videoHref()
    {
        $fileName = $this->file_name;
        $host = env('PLAY_HOST', '127.0.0.1');
        $port = env('PLAY_PORT', '80');
        $portStr = $port == 80 ? '' : ':' . $port;

        if (strpos($fileName, 'test') === 0) {
            return 'http://' . $host . $portStr . '/' . $fileName . self::VIDEO_ND_SUFFIX;
        } else {
            return 'http://' . $host . $portStr . '/' . $this->dateFormat($this->created_at) . '/' . $fileName . self::VIDEO_ND_SUFFIX;
        }
    }

    public function thumbHref()
    {
        $host = env('IMG_HOST', '127.0.0.1');
        $port = env('IMG_PORT', '80');
        $portStr = $port == 80 ? '' : ':' . $port;

        if (strpos($this->file_name, 'test') === 0) {
            $name = $this->file_name . self::VIDEO_THUMB_SUFFIX . random_int(1, self::VIDEO_THUMB_COUNT) . self::VIDEO_THUMB_EXTENSION;
            return 'http://' . $host . $portStr . '/thumb/' . '/' . $name;
        } else {
            $name = $this->file_name . self::VIDEO_THUMB_SUFFIX . random_int(1, self::VIDEO_THUMB_COUNT) . self::VIDEO_THUMB_EXTENSION;
            return 'http://' . $host . $portStr . '/thumb/' . self::dateFormat($this->created_at) . '/' . $name;
        }
    }


    // 将秒数转换为00:00:00的格式
    public function durationReadable()
    {
        $seconds = $this->duration;
        $hours = (int)($seconds / 3600);
        $rest = $seconds % 3600;
        $minutes = (int)($rest / 60);
        $seconds = $rest % 60;

        return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
    }

    public function releaseReadable()
    {
        return $this->released_at->diffForHumans(\Carbon\Carbon::now());
    }
}
