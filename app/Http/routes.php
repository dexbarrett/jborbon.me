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
Route::get('feed', 'FeedController@render');
Route::get('goodreads-read-list', 'ReadListController@getReadList');


Route::get('login', 'SessionController@index');
Route::post('login', 'SessionController@create');
Route::get('logout', 'SessionController@destroy');

Route::get('/{slug}', 'PostController@findBySlug');
Route::get('{postType}/tag/{tagslug}', 'PostController@findByTag');
Route::get('{postType}/category/{categorySlug}', 'PostController@findByCategory');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('profile', 'AdminController@editProfile');
    Route::post('profile', 'AdminController@saveProfile');
    Route::get('settings', 'AdminController@showSettings');
    Route::get('auth/imgur/callback', 'AdminController@imgurAuth');
    Route::resource('post', 'PostController', ['except' => ['create', 'show', 'destroy']]);
    Route::get('{postType}/create', 'PostController@create');
    Route::get('dashboard/{postType?}/{postStatus?}', 'AdminController@index');
    Route::post('delete/{postID}/{forceDelete}', 'PostController@destroy');
    Route::post('post/{id}/restore', 'PostController@restore');
    Route::post('post/attachImage', 'PostController@attachImage')
      ->middleware(['auth.imgur']);

    Route::get('testing', 'PostController@getAlbumImages')
        ->middleware(['auth.imgur']);
});