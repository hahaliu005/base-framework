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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'video_id' => 'required|numeric',
            'file_name' => 'required',
        ]);
        return ['aa'];
        $inputs = $request->input();
        $videoId = $inputs['video_id'];
        $fileName = $inputs['file_name'];
        if (empty($videoId) || empty($fileName)) {
            return $this->ajaxResponse(false, 'Param not enough');
        }

        if (! $video = Video::where('id', $videoId)->where('file_name', $fileName)->first()) {
            return $this->ajaxResponse(false, 'Video not found');
        }

        $attrs = [
            'title' => $inputs['title'],
            'description' => $inputs['description'],
            'status' => Video::STATUS_UPLOADED,
            'user_id' => \Auth::user()->id,
        ];
        $video->update($attrs);

        return $this->ajaxResponse(true);
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
                'video_id' => $video->id,
                'file_name' => $video->file_name,
            ];
        });
    }
}
