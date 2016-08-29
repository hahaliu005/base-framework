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

Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function() {
    Route::get('/', [
        'uses' => 'IndexController@index'
    ]);

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

/**
 * About Auth
 */
Route::get('/login', 'Admin\LoginController@showLoginForm');
Route::post('/login', 'Admin\LoginController@login');
Route::get('/logout', [
    'as' => 'logout',
    'uses' => 'Admin\LoginController@logout',
]);
Route::get('/register', 'Admin\RegisterController@showRegistrationForm');
Route::post('/register', 'Admin\RegisterController@register');
