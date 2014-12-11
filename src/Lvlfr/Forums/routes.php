<?php

Route::group(array('domain' => 'forums.'. Config::get('app.domain')), function () {

    Route::pattern('slug', '[A-Za-z0-9\-]+');
    Route::pattern('categoryId', '\d+');
    Route::pattern('topicId', '\d+');
    Route::pattern('messageId', '\d+');

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
    );
    Route::post(
        '{slug}-c{categoryId}/new',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@postNew',
            'before' => 'csrf|auth'
        )
    );

    /*********************************************
     *************** REPLY ***********************
     ********************************************/
    Route::get(
        '{slug}-t{topicId}/reply',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@newReply',
            'before' => 'auth'
        )
    );
    Route::post(
        '{slug}-t{topicId}/reply',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@postReply',
            'before' => 'csrf|auth'
        )
    );

    /*********************************************
     *************** EDIT ***********************
     ********************************************/
    Route::get(
        '{slug}-t{topicId}/edit/{messageId}',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@editMessage',
            'before' => 'auth'
        )
    );
    Route::post(
        '{slug}-t{topicId}/edit/{messageId}',
        array(
            'uses'=>'\Lvlfr\Forums\Controller\TopicsController@postEditMessage',
            'before' => 'auth'
        )
    );

    Route::get('{slug}-c{categoryId}', '\Lvlfr\Forums\Controller\TopicsController@index');
    Route::get('{slug}-t{topicId}', '\Lvlfr\Forums\Controller\TopicsController@show');
    Route::post('solveTopic', '\Lvlfr\Forums\Controller\TopicsController@solve');
    Route::get('{slug}-t{topicId}/lastpage', '\Lvlfr\Forums\Controller\TopicsController@moveToLast');
});
