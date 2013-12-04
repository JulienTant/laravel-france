<?php

Route::group(array('domain' => 'wiki.'. Config::get('app.domain')), function () {
    Route::pattern('slug', '(.*)?');

    Route::any('login', '\Lvlfr\Login\Controller\LoginController@index');

    Route::any('list', '\Lvlfr\Wiki\Controller\HomeController@listAll');

    Route::any('changes.rss', '\Lvlfr\Wiki\Controller\HomeController@changes');

    Route::get('{slug}/lock', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@lock',
        'before' => 'auth|hasRole:Wiki'
    ));

    Route::get('new', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@create',
        'before' => 'auth|canUpdateWiki'
    ));
    Route::post('new', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@createPage',
        'before' => 'csrf|auth|canUpdateWiki'
    ));
    Route::get('{slug}/edit', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@edit',
        'before' => 'auth|canUpdateWiki'
    ));
    Route::post('{slug}/edit', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@editPage',
        'before' => 'csrf|auth|canUpdateWiki'
    ));

    Route::get('{slug}/versions', '\Lvlfr\Wiki\Controller\HomeController@versions');

    Route::get('/{slug?}', '\Lvlfr\Wiki\Controller\HomeController@index');
});
