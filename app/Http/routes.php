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

Route::get('/', ['as' => 'forums.index', 'uses' => 'ForumsController@topics']);

Route::get('c/{slug}', ['as' => 'forums.by-category', 'uses' => 'ForumsController@topics']);
Route::get('search', ['as' => 'forums.search', 'uses' => 'ForumsController@search']);
Route::get('/t/{categorySlug}/{topicSlug}', ['as' => 'forums.show-topic', 'uses' => 'ForumsController@topic']);

Route::get('socialite/{driver}', ['as' => 'socialite.login', 'uses' => 'SocialiteController@redirectToProvider'])
    ->where('driver', 'google|github|twitter');
Route::get('socialite/{driver}/callback', ['as' => 'socialite.callback', 'uses' => 'SocialiteController@handleProviderCallback'])
    ->where('driver', 'google|github|twitter');
Route::get('logout', ['as' => 'logout', 'uses' => 'SocialiteController@logout']);


Route::get('slack', ['as' => 'slack', 'uses' => 'StaticController@slack']);

Route::get('contact', ['as' => 'contact', 'uses' => 'ContactController@index']);