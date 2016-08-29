<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chunking Path
    |--------------------------------------------------------------------------
    |
    | Here you may specify path that should be stored chunk files.
    |
    | See https://github.com/moxiecode/plupload/wiki/Chunking
    |
    */

    'chunk_path' => storage_path('data/video/chunks'),

    /*
    |--------------------------------------------------------------------------
    | Plupload Global Options
    |--------------------------------------------------------------------------
    |
    | Set default global options for Plupload.
    |
    | See https://github.com/moxiecode/plupload/wiki/Options
    |
    */

    'flash_swf_url'       => '/plupload/js/Moxie.swf',
    'silverlight_xap_url' => '/plupload/js/Moxie.xap',

];
