<?php
namespace App\Http\Controllers\Portal;

use App\Http\Controllers\PortalController;
use App\Video;

class IndexController extends PortalController
{
    public function index()
    {
        //newest video
        $newVideos = Video::where('status', Video::STATUS_PUBLISHED)->limit(15)->get();
        return view('index', [
            'newVideos' => $newVideos,
        ]);
    }
}
