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

Route::group(['namespace' => 'Portal'], function () {
    Route::get('/', [
        'uses' => 'IndexController@index'
    ]);

    Route::get('/video/play/{id}', [
        'as' => 'video.play',
        'uses' => 'VideoController@play'
    ]);
});
