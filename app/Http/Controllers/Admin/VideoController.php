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
        return \Plupload::file('file', function($file) {
            // Store the uploaded file
            $file->move(storage_path('upload/images'), $file->getClientOriginalName());

            // Save the record to the db
            //$photo = \App\Photo::create([
            //    'name' => $file->getClientOriginalName(),
            //    'type' => 'image',
            //    //...
            //]);

            // This will be included in JSON response result
            return [
                'success'   => true,
                'message'   => 'Upload successful.',
            //    'id'        => $photo->id,
                // 'url'       => $photo->getImageUrl($filename, 'medium'),
                // 'deleteUrl' => action('MediaController@deleteDelete', [$photo->id])
            ];
        });
    }
}
