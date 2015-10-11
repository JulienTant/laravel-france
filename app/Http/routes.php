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
