<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('front.blog.viewpost');
});

Route::get('login', 'SessionController@index');
Route::post('login', 'SessionController@create');
Route::get('logout', 'SessionController@destroy');

Route::group(['prefix' => 'admin'], function () {
    Route::resource('post', 'PostController', ['except' => ['index', 'destroy']]);
});