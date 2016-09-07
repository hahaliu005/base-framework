<?php
namespace App\Http\Controllers\Portal;

use App\Http\Controllers\PortalController;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends PortalController
{
    public function play(Request $request)
    {
        $id = $request->input('id');
        if (! $video = Video::find($id)) {
            return $this->ajaxResponse(false, 'video not found');
        }

        return view('video.play', [
            'video' => $video
        ]);
    }
}
