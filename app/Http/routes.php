<?php

/*
|--------------------------------------------------------------------------
| Forums Routes
|--------------------------------------------------------------------------
*/
$router->group(['domain' => Config::get('app.app_domain')], function ($router) {
    $router->get('/', ['as' => 'forums.index', 'uses' => 'ForumsController@topics']);

    $router->get('c/{slug}', ['as' => 'forums.by-category', 'uses' => 'ForumsController@topics']);
    $router->get('search', ['as' => 'forums.search', 'uses' => 'ForumsController@search']);
    $router->get('/t/{categorySlug}/{topicSlug}', ['as' => 'forums.show-topic', 'uses' => 'ForumsController@topic']);
    $router->get('/m/{messageId}', ['as' => 'forums.show-message', 'uses' => 'ForumsController@message']);


    $router->group(['middleware' => 'auth'], function ($router) {

        $router->get('sujets-suivis', ['as' => 'my-forums.watched-topics', 'uses' => 'MyForumController@watchedTopics']);
        $router->get('mes-sujets', ['as' => 'my-forums.my-topics', 'uses' => 'MyForumController@myTopics']);
        $router->get('mes-messages', ['as' => 'my-forums.my-messages', 'uses' => 'MyForumController@myMessages']);

    });

    /*
    |--------------------------------------------------------------------------
    | Login & Socialite Routes
    |--------------------------------------------------------------------------
    */
    $router->get('socialite/{driver}', ['as' => 'socialite.login', 'uses' => 'SocialiteController@redirectToProvider'])
        ->where('driver', 'google|github|twitter');
    $router->get('socialite/{driver}/callback',
        ['as' => 'socialite.callback', 'uses' => 'SocialiteController@handleProviderCallback'])
        ->where('driver', 'google|github|twitter');
    $router->get('logout', ['as' => 'logout', 'uses' => 'SocialiteController@logout']);


    /*
    |--------------------------------------------------------------------------
    | Slack Routes
    |--------------------------------------------------------------------------
    */
    $router->get('slack', ['as' => 'slack', 'uses' => 'SlackController@index']);
    $router->post('slack', ['as' => 'slack.invite', 'uses' => 'SlackController@invite']);

    /*
    |--------------------------------------------------------------------------
    | Contact Routes
    |--------------------------------------------------------------------------
    */
    $router->get('contact', ['as' => 'contact', 'uses' => 'ContactController@index']);
    $router->post('contact', ['as' => 'contact.send', 'uses' => 'ContactController@send']);
    $router->get('contact/sent', ['as' => 'contact.sent', 'uses' => 'ContactController@sent']);


    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */
    /** @var \Illuminate\Routing\Router $router */
    $router->group(['prefix' => 'profile', 'middleware' => 'auth'], function ($router) {

        $router->get('/', ['as' => 'profile', 'uses' => 'ProfileController@index']);

        $router->get('change-username', ['as' => 'profile.change-username', 'uses' => 'ProfileController@changeUsername']);
        $router->post('change-username', ['as' => 'profile.change-username.post', 'uses' => 'ProfileController@postChangeUsername']);


        $router->get('change-avatar', ['as' => 'profile.change-avatar', 'uses' => 'ProfileController@changeAvatar']);
        $router->post('change-avatar', ['as' => 'profile.change-avatar.post', 'uses' => 'ProfileController@postChangeAvatar']);

        $router->get('forums', ['as' => 'profile.forums', 'uses' => 'ProfileController@forums']);
        $router->post('forums', ['as' => 'profile.forums.post', 'uses' => 'ProfileController@postForums']);

    });


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    /** @var \Illuminate\Routing\Router $router */
    $router->group(['prefix' => 'admin', 'middleware' => 'auth'], function ($router) {
        $router->resource('users', 'Admin\\UserControler', ['only' => 'index']);
        $router->get('users/{user}/groups', ['uses' => 'Admin\\UserControler@groups', 'as' => 'admin.users.groups']);
        $router->post('users/{user}/groups', ['uses' => 'Admin\\UserControler@saveGroups', 'as' => 'admin.users.save-groups']);
    });


    /*
    |--------------------------------------------------------------------------
    | API Related Routes
    |--------------------------------------------------------------------------
    */
    /** @var \Illuminate\Routing\Router $router */
    $router->group(['laroute' => true, 'namespace' => 'Api', 'prefix' => 'api'], function ($router) {
        $router->post('renderMarkdown', ['as' => 'api.markdown', 'uses' => 'MarkdownController@render']);

        $router->get('forums/{topicId}/watch', ['as' => 'api.forums.watch', 'uses' => 'ForumsController@watch', 'middleware' => 'auth']);
        $router->post('forums/{topicId}/toggle-watch', ['as' => 'api.forums.toggle-watch', 'uses' => 'ForumsController@toggleWatch', 'middleware' => 'auth']);

        $router->post('forums/post', ['as' => 'api.forums.post', 'uses' => 'ForumsController@post']);
        $router->post('forums/{topicId}/reply', ['as' => 'api.forums.reply', 'uses' => 'ForumsController@reply']);

        $router->get('forums/{topicId}/messages/{messageId}',
            ['as' => 'api.forums.message', 'uses' => 'ForumsController@message']);
        put('forums/{topicId}/messages/{messageId}',
            ['as' => 'api.forums.message.update', 'uses' => 'ForumsController@updateMessage']);
        delete('forums/{topicId}/messages/{messageId}',
            ['as' => 'api.forums.message.delete', 'uses' => 'ForumsController@deleteMessage']);
        $router->post('forums/{topicId}/messages/{messageId}/solve_topic',
            ['as' => 'api.forums.message.solved_topic', 'uses' => 'ForumsController@solveTopic']);
    });
});
