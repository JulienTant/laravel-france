<?php

Route::group(array('domain' => 'wiki.'. Config::get('app.domain')), function () {

    Route::any('login', 'Lvlfr\Login\Controller\LoginController@index');
    Route::get('{slug}/edit', '\Lvlfr\Wiki\Controller\HomeController@edit');
    Route::get('/{slug?}', '\Lvlfr\Wiki\Controller\HomeController@index');
});
