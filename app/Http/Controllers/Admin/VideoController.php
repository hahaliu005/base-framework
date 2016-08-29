<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

class VideoController extends AdminController
{
    public function getUpload()
    {
        return view('video.upload');
    }

    public function postUpload()
    {

    }

    public function uploading()
    {

    }
}
