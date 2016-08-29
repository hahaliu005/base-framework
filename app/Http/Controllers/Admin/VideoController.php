<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends AdminController
{
    public function getUpload()
    {
        return view('video.upload');
    }

    public function postUpload(Request $request)
    {
        dd($request->input());
    }

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
                'id' => $video->id
            ];
        });
    }
}
