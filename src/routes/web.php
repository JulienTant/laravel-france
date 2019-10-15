<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as' => 'topics.index', 'uses' => 'TopicsController@index']);
Route::get('c/{slug}', ['as' => 'topics.by-category', 'uses' => 'TopicsController@index']);
Route::get('/t/{categorySlug}/{topicSlug}', ['as' => 'topics.show', 'uses' => 'TopicsController@show']);
Route::post('/t/{categorySlug}/{topicSlug}/solve', ['as' => 'topics.solve', 'uses' => 'TopicsController@solve']);
Route::get('/create', ['as' => 'topics.create', 'uses' => 'TopicsController@create']);
Route::post('/', ['as' => 'topics.store', 'uses' => 'TopicsController@store']);

Route::post('/t/{categorySlug}/{topicSlug}', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
Route::get('/m/{messageId}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
Route::get('/t/{categorySlug}/{topicSlug}/{messageId}', ['as' => 'messages.edit', 'uses' => 'MessagesController@edit']);
Route::put('/t/{categorySlug}/{topicSlug}/{messageId}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);

Route::get('/t/{categorySlug}/{topicSlug}/{messageId}/remove', ['as' => 'messages.remove', 'uses' => 'MessagesController@remove']);
Route::delete('/t/{categorySlug}/{topicSlug}/{messageId}', ['as' => 'messages.delete', 'uses' => 'MessagesController@delete']);

// Auth
Route::get('oauth/{provider}', ['as' => 'oauth.to', 'uses' => 'OAuthController@redirectToProvider']);
Route::get('oauth/{provider}/callback', ['as' => 'oauth.callback', 'uses' => 'OAuthController@handleProviderCallback']);


Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);
    Route::get('forums', ['as' => 'forums-preferences', 'uses' => 'UserController@forumsPreferences']);
    Route::post('forums', ['as' => 'forums-preferences.save', 'uses' => 'UserController@postForumsPreferences']);
    Route::get('change-username', ['as' => 'change-username', 'uses' => 'UserController@changeUsername']);
    Route::post('change-username', ['as' => 'change-username.save', 'uses' => 'UserController@postChangeUsername']);
    Route::get('change-email', ['as' => 'change-email', 'uses' => 'UserController@changeEmail']);
    Route::post('change-email', ['as' => 'change-email.save', 'uses' => 'UserController@postChangeEmail']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
});
