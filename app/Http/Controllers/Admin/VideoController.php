<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Jobs\VideoTrans;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends AdminController
{
    public function getUpload()
    {
        return view('video.upload', [
            'uploadUrl' => $this->getUploadUrl(),
        ]);
    }

    public function postUpload(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'video_id' => 'required|numeric',
            'file_name' => 'required',
        ]);
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
            'status' => Video::STATUS_VERIFIED,
            'user_id' => \Auth::user()->id,
        ];

        // move file and update video path
        $origin_dir = Video::originDir($video->created_at);
        if (!is_dir($origin_dir)) {
            mkdir($origin_dir, 0755, true);
        }
        \File::move(Video::tempDir($video->created_at) . $fileName, Video::originDir($video->created_at) . $fileName);

        $video->update($attrs);

        $this->dispatch((new VideoTrans($video->id))->onQueue(QUEUE_VIDEO_TRANS));

        return $this->ajaxResponse(true);
    }
}
