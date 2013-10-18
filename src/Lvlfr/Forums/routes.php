<?php

Route::group(array('domain' => 'forums.'. Config::get('app.domain')), function () {
    Route::get('/', '\Lvlfr\Forums\Controller\HomeController@index');
    Route::get('{slug}-c{categoryId}', '\Lvlfr\Forums\Controller\TopicsController@index')->where('slug', '[A-Za-z0-9\-]+');
    Route::get('{slug}-t{topicId}', '\Lvlfr\Forums\Controller\TopicsController@show')->where('slug', '[A-Za-z0-9\-]+');
    Route::get('{slug}-t{topicId}/lastpage', '\Lvlfr\Forums\Controller\TopicsController@moveToLast')->where('slug', '[A-Za-z0-9\-]+');
});
