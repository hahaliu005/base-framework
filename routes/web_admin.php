<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
    'uses' => 'Admin\IndexController@index'
]);

Route::group(['namespace' => 'Admin'], function() {
    Route::get('/video/upload', [
        'as' => 'video.getUpload',
        'uses' => 'VideoController@getUpload'
    ]);
    Route::post('/video/uploading', [
        'as' => 'video.uploading',
        'uses' => 'VideoController@uploading'
    ]);
    Route::post('/video/upload', [
        'as' => 'video.postUpload',
        'uses' => 'VideoController@postUpload'
    ]);
});
