<?php

Route::group(array('domain' => 'forums.'. Config::get('app.domain')), function () {
    Route::get('/', '\Lvlfr\Forums\Controller\HomeController@index');
    Route::get('{slug}-c{categoryId}/new', '\Lvlfr\Forums\Controller\TopicsController@newTopic')->where('slug', '[A-Za-z0-9\-]+')->where('categoryId', '\d+');
    Route::post('{slug}-c{categoryId}/new', '\Lvlfr\Forums\Controller\TopicsController@postNew')->where('slug', '[A-Za-z0-9\-]+')->where('categoryId', '\d+');
    Route::get('{slug}-c{categoryId}', '\Lvlfr\Forums\Controller\TopicsController@index')->where('slug', '[A-Za-z0-9\-]+')->where('categoryId', '\d+');
    Route::get('{slug}-t{topicId}', '\Lvlfr\Forums\Controller\TopicsController@show')->where('slug', '[A-Za-z0-9\-]+')->where('topicId', '\d+');
    Route::get('{slug}-t{topicId}/lastpage', '\Lvlfr\Forums\Controller\TopicsController@moveToLast')->where('slug', '[A-Za-z0-9\-]+')->where('topicId', '\d+');
});
