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

Route::get('/', 'PostController@index');

Route::get('sitemap.xml', 'SitemapController@render');

Route::get('login', 'SessionController@index');
Route::post('login', 'SessionController@create');
Route::get('logout', 'SessionController@destroy');

Route::get('/{slug}', 'PostController@findBySlug');
Route::get('{postType}/tag/{tagslug}', 'PostController@findByTag');
Route::get('{postType}/category/{categorySlug}', 'PostController@findByCategory');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('post', 'PostController', ['except' => ['create', 'show']]);
    Route::get('{postType}/create', 'PostController@create');
    Route::get('dashboard/{postType?}/{postStatus?}', 'AdminController@index');
});