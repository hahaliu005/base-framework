<?php
namespace App\Http\Controllers\Transcoder;

use App\Http\Controllers\TranscoderController;
use App\Video;

class VideoController extends TranscoderController
{
    public function uploading()
    {
        return \Plupload::file('file', function ($file) {
            $file_name = Video::genFileName();

            $created_at = \Carbon\Carbon::now();

            $file->move(Video::tempDir($created_at), $file_name);
            $video = Video::create([
                'status' => Video::STATUS_UPLOADING,
                'file_name' => $file_name,
                'created_at' => $created_at,
            ]);

            return [
                'video_id' => $video->id,
                'file_name' => $video->file_name,
            ];
        });
    }
}
