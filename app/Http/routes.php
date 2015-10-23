<?php

/*
|--------------------------------------------------------------------------
| Forums Routes
|--------------------------------------------------------------------------
*/

get('/', ['as' => 'forums.index', 'uses' => 'ForumsController@topics']);

get('c/{slug}', ['as' => 'forums.by-category', 'uses' => 'ForumsController@topics']);
get('search', ['as' => 'forums.search', 'uses' => 'ForumsController@search']);
get('/t/{categorySlug}/{topicSlug}', ['as' => 'forums.show-topic', 'uses' => 'ForumsController@topic']);
get('/m/{messageId}', ['as' => 'forums.show-message', 'uses' => 'ForumsController@message']);

/*
|--------------------------------------------------------------------------
| Login & Socialite Routes
|--------------------------------------------------------------------------
*/
get('socialite/{driver}', ['as' => 'socialite.login', 'uses' => 'SocialiteController@redirectToProvider'])
    ->where('driver', 'google|github|twitter');
get('socialite/{driver}/callback', ['as' => 'socialite.callback', 'uses' => 'SocialiteController@handleProviderCallback'])
    ->where('driver', 'google|github|twitter');
get('logout', ['as' => 'logout', 'uses' => 'SocialiteController@logout']);


/*
|--------------------------------------------------------------------------
| Slack Routes
|--------------------------------------------------------------------------
*/
get('slack', ['as' => 'slack', 'uses' => 'StaticController@slack']);

/*
|--------------------------------------------------------------------------
| Contact Routes
|--------------------------------------------------------------------------
*/
get('contact', ['as' => 'contact', 'uses' => 'ContactController@index']);
post('contact', ['as' => 'contact.send', 'uses' => 'ContactController@send']);
get('contact/sent', ['as' => 'contact.sent', 'uses' => 'ContactController@sent']);


/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
/** @var \Illuminate\Routing\Router $router */
$router->group(['prefix' => 'profile', 'middleware' => 'auth'], function () {

    get('change-username', ['as' => 'profile.change-username', 'uses' => 'ProfileController@changeUsername']);

});
/*
|--------------------------------------------------------------------------
| API Related Routes
|--------------------------------------------------------------------------
*/
/** @var \Illuminate\Routing\Router $router */
$router->group(['laroute' => true, 'namespace' => 'Api', 'prefix' => 'api'], function () {
    post('renderMarkdown', ['as' => 'api.markdown', 'uses' => 'MarkdownController@render']);

    post('forums/post', ['as' => 'api.forums.post', 'uses' => 'ForumsController@post']);
    post('forums/{topicId}/reply', ['as' => 'api.forums.reply', 'uses' => 'ForumsController@reply']);

    get('forums/{topicId}/messages/{messageId}', ['as' => 'api.forums.message', 'uses' => 'ForumsController@message']);
    put('forums/{topicId}/messages/{messageId}', ['as' => 'api.forums.message.update', 'uses' => 'ForumsController@updateMessage']);
    delete('forums/{topicId}/messages/{messageId}', ['as' => 'api.forums.message.delete', 'uses' => 'ForumsController@deleteMessage']);
    post('forums/{topicId}/messages/{messageId}/solve_topic', ['as' => 'api.forums.message.solved_topic', 'uses' => 'ForumsController@solveTopic']);
});