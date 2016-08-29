<?php
Route::group(['namespace' => 'Transcoder'], function() {
    Route::get('/', function() {
        return 'welcome';
    });
    Route::post('/video/uploading', [
        'as' => 'video.uploading',
        'uses' => 'VideoController@uploading'
    ]);
});
