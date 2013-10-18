<?php

Route::group(array('domain' => Config::get('app.domain')), function () {
    Route::get('contact', array('uses' => 'Lvlfr\Website\Controller\ContactController@getIndex'));
    Route::post('contact', array('uses' => 'Lvlfr\Website\Controller\ContactController@postIndex'));
    Route::get('contact/success', array('uses' => 'Lvlfr\Website\Controller\ContactController@getSuccess'));
    Route::get('irc', array('uses' => 'Lvlfr\Website\Controller\IrcController@getIndex'));
    Route::get('/', array('as' => 'home', 'uses' => 'Lvlfr\Website\Controller\HomeController@getIndex'));
});
