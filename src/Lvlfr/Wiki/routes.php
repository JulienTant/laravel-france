<?php

Route::group(array('domain' => 'wiki.'. Config::get('app.domain')), function () {

    Route::any('login', '\Lvlfr\Login\Controller\LoginController@index');
    
    Route::any('list', '\Lvlfr\Wiki\Controller\HomeController@listAll');

    Route::get('{slug}/lock', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@lock',
        'before' => 'auth|hasRole:Wiki'
    ));

    Route::get('new', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@create',
        'before' => 'auth'
    ));
    Route::post('new', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@createPage',
        'before' => 'csrf|auth'
    ));
    Route::get('{slug}/edit', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@edit',
        'before' => 'auth'
    ));
    Route::post('{slug}/edit', array(
        'uses'=>'\Lvlfr\Wiki\Controller\HomeController@editPage',
        'before' => 'csrf|auth'
    ));

    Route::get('{slug}/versions', '\Lvlfr\Wiki\Controller\HomeController@versions');

    Route::get('/{slug?}/{version?}', '\Lvlfr\Wiki\Controller\HomeController@index');
});
