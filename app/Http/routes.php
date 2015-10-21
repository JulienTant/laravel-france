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

get('/', ['as' => 'forums.index', 'uses' => 'ForumsController@topics']);

get('c/{slug}', ['as' => 'forums.by-category', 'uses' => 'ForumsController@topics']);
get('search', ['as' => 'forums.search', 'uses' => 'ForumsController@search']);
get('/t/{categorySlug}/{topicSlug}', ['as' => 'forums.show-topic', 'uses' => 'ForumsController@topic']);
get('/m/{messageId}', ['as' => 'forums.show-message', 'uses' => 'ForumsController@message']);

get('socialite/{driver}', ['as' => 'socialite.login', 'uses' => 'SocialiteController@redirectToProvider'])
    ->where('driver', 'google|github|twitter');
get('socialite/{driver}/callback', ['as' => 'socialite.callback', 'uses' => 'SocialiteController@handleProviderCallback'])
    ->where('driver', 'google|github|twitter');
get('logout', ['as' => 'logout', 'uses' => 'SocialiteController@logout']);


get('slack', ['as' => 'slack', 'uses' => 'StaticController@slack']);
get('contact', ['as' => 'contact', 'uses' => 'ContactController@index']);

/** @var \Illuminate\Routing\Router $router */
$router->group(['laroute' => true, 'namespace' => 'Api', 'prefix' => 'api'], function () {
    post('forums/post', ['as' => 'api.forums.post', 'uses' => 'ForumsController@post']);
    post('forums/{topicId}/reply', ['as' => 'api.forums.reply', 'uses' => 'ForumsController@reply']);

    get('forums/{topicId}/messages/{messageId}', ['as' => 'api.forums.message', 'uses' => 'ForumsController@message']);
    put('forums/{topicId}/messages/{messageId}', ['as' => 'api.forums.message.update', 'uses' => 'ForumsController@updateMessage']);
    delete('forums/{topicId}/messages/{messageId}', ['as' => 'api.forums.message.delete', 'uses' => 'ForumsController@deleteMessage']);
});