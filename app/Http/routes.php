<?php

/*
|--------------------------------------------------------------------------
| Forums Routes
|--------------------------------------------------------------------------
*/
$router->group(['domain' => Config::get('app.app_domain')], function ($router) {
    get('/', ['as' => 'forums.index', 'uses' => 'ForumsController@topics']);

    get('c/{slug}', ['as' => 'forums.by-category', 'uses' => 'ForumsController@topics']);
    get('search', ['as' => 'forums.search', 'uses' => 'ForumsController@search']);
    get('/t/{categorySlug}/{topicSlug}', ['as' => 'forums.show-topic', 'uses' => 'ForumsController@topic']);
    get('/m/{messageId}', ['as' => 'forums.show-message', 'uses' => 'ForumsController@message']);


    $router->group(['middleware' => 'auth'], function () {

        get('sujets-suivis', ['as' => 'my-forums.watched-topics', 'uses' => 'MyForumController@watchedTopics']);
        get('mes-sujets', ['as' => 'my-forums.my-topics', 'uses' => 'MyForumController@myTopics']);
        get('mes-messages', ['as' => 'my-forums.my-messages', 'uses' => 'MyForumController@myMessages']);

    });

    /*
    |--------------------------------------------------------------------------
    | Login & Socialite Routes
    |--------------------------------------------------------------------------
    */
    get('socialite/{driver}', ['as' => 'socialite.login', 'uses' => 'SocialiteController@redirectToProvider'])
        ->where('driver', 'google|github|twitter');
    get('socialite/{driver}/callback',
        ['as' => 'socialite.callback', 'uses' => 'SocialiteController@handleProviderCallback'])
        ->where('driver', 'google|github|twitter');
    get('logout', ['as' => 'logout', 'uses' => 'SocialiteController@logout']);


    /*
    |--------------------------------------------------------------------------
    | Slack Routes
    |--------------------------------------------------------------------------
    */
    get('slack', ['as' => 'slack', 'uses' => 'SlackController@index']);
    post('slack', ['as' => 'slack.invite', 'uses' => 'SlackController@invite']);

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

        get('/', ['as' => 'profile', 'uses' => 'ProfileController@index']);

        get('change-username', ['as' => 'profile.change-username', 'uses' => 'ProfileController@changeUsername']);
        post('change-username', ['as' => 'profile.change-username.post', 'uses' => 'ProfileController@postChangeUsername']);


        get('change-avatar', ['as' => 'profile.change-avatar', 'uses' => 'ProfileController@changeAvatar']);
        post('change-avatar', ['as' => 'profile.change-avatar.post', 'uses' => 'ProfileController@postChangeAvatar']);

        get('forums', ['as' => 'profile.forums', 'uses' => 'ProfileController@forums']);
        post('forums', ['as' => 'profile.forums.post', 'uses' => 'ProfileController@postForums']);

    });


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    /** @var \Illuminate\Routing\Router $router */
    $router->group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
        resource('users', 'Admin\\UserControler', ['only' => 'index']);
        get('users/{user}/groups', ['uses' => 'Admin\\UserControler@groups', 'as' => 'admin.users.groups']);
        post('users/{user}/groups', ['uses' => 'Admin\\UserControler@saveGroups', 'as' => 'admin.users.save-groups']);
    });


    /*
    |--------------------------------------------------------------------------
    | API Related Routes
    |--------------------------------------------------------------------------
    */
    /** @var \Illuminate\Routing\Router $router */
    $router->group(['laroute' => true, 'namespace' => 'Api', 'prefix' => 'api'], function () {
        post('renderMarkdown', ['as' => 'api.markdown', 'uses' => 'MarkdownController@render']);

        get('forums/{topicId}/watch', ['as' => 'api.forums.watch', 'uses' => 'ForumsController@watch', 'middleware' => 'auth']);
        post('forums/{topicId}/toggle-watch', ['as' => 'api.forums.toggle-watch', 'uses' => 'ForumsController@toggleWatch', 'middleware' => 'auth']);

        post('forums/post', ['as' => 'api.forums.post', 'uses' => 'ForumsController@post']);
        post('forums/{topicId}/reply', ['as' => 'api.forums.reply', 'uses' => 'ForumsController@reply']);

        get('forums/{topicId}/messages/{messageId}',
            ['as' => 'api.forums.message', 'uses' => 'ForumsController@message']);
        put('forums/{topicId}/messages/{messageId}',
            ['as' => 'api.forums.message.update', 'uses' => 'ForumsController@updateMessage']);
        delete('forums/{topicId}/messages/{messageId}',
            ['as' => 'api.forums.message.delete', 'uses' => 'ForumsController@deleteMessage']);
        post('forums/{topicId}/messages/{messageId}/solve_topic',
            ['as' => 'api.forums.message.solved_topic', 'uses' => 'ForumsController@solveTopic']);
    });
});


/*
|--------------------------------------------------------------------------
| Retro forums routes
|--------------------------------------------------------------------------
*/
/** @var \Illuminate\Routing\Router $router */
$router->group(['domain' => 'forums.' . Config::get('app.app_domain')], function ($router) {

    $router->get('/', function () {
        return redirect()->route('forums.index', [], 301);
    });

    Route::pattern('old_slug', '[A-Za-z0-9\-]+');
    Route::pattern('old_categoryId', '\d+');
    Route::pattern('old_topicId', '\d+');


    get('{old_slug}-c{old_categoryId}', function ($old_slug, $old_categoryId) {
        return redirect()->route('forums.by-category',
            ['slug' => \LaravelFrance\ForumsCategory::findOrFail($old_categoryId)->slug], 301);
    });

    get('{old_slug}-t{old_topicId}', function ($old_slug, $old_topicId) {
        $forumTopic = \LaravelFrance\ForumsTopic::with('forumsCategory')->findOrFail($old_topicId);

        return redirect()->route('forums.show-topic', [
            'categorySlug' => $forumTopic->forumsCategory->slug,
            'topicSlug' => $forumTopic->slug,
        ], 301);
    });
});