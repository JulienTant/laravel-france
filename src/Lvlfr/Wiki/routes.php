<?php

Route::group(array('domain' => 'wiki.'. Config::get('app.domain')), function () {

    //Route::get('', '\Lvlfr\Wiki\Controller\HomeController@index');
    Route::any('login', 'Lvlfr\Login\Controller\LoginController@index');
    Route::get('/{slug?}', '\Lvlfr\Wiki\Controller\HomeController@index');
});
