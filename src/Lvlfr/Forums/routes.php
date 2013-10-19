<?php

Route::group(array('domain' => 'forums.'. Config::get('app.domain')), function () {

    Route::get('/', '\Lvlfr\Forums\Controller\HomeController@index');
    Route::any('login', 'Lvlfr\Login\Controller\LoginController@index');

    /*********************************************
     *********** NEW POST ***********************
     ********************************************/
    Route::get(
        '{slug}-c{categoryId}/new',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@newTopic',
            'before' => 'auth'
        )
    )
    ->where('slug', '[A-Za-z0-9\-]+')
    ->where('categoryId', '\d+');
    Route::post(
        '{slug}-c{categoryId}/new',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@postNew',
            'before' => 'csrf|auth'
        )
    )
    ->where('slug', '[A-Za-z0-9\-]+')
    ->where('categoryId', '\d+');

    /*********************************************
     *************** REPLY ***********************
     ********************************************/
    Route::get(
        '{slug}-t{topicId}/reply',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@newReply',
            'before' => 'auth'
        )
    )
    ->where('slug', '[A-Za-z0-9\-]+')
    ->where('topicId', '\d+');
    Route::post(
        '{slug}-t{topicId}/reply',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@postReply',
            'before' => 'csrf|auth'
        )
    )
    ->where('slug', '[A-Za-z0-9\-]+')
    ->where('topicId', '\d+');

    Route::get('{slug}-c{categoryId}', '\Lvlfr\Forums\Controller\TopicsController@index')->where('slug', '[A-Za-z0-9\-]+')->where('categoryId', '\d+');
    Route::get('{slug}-t{topicId}', '\Lvlfr\Forums\Controller\TopicsController@show')->where('slug', '[A-Za-z0-9\-]+')->where('topicId', '\d+');
    Route::get('{slug}-t{topicId}/lastpage', '\Lvlfr\Forums\Controller\TopicsController@moveToLast')->where('slug', '[A-Za-z0-9\-]+')->where('topicId', '\d+');
});
