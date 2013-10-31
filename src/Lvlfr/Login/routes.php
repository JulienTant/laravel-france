<?php

Route::group(array('domain' => Config::get('app.domain')), function () {
    Route::any('login/check', 'Lvlfr\Login\Controller\LoginController@check');
    Route::any('logout', 'Lvlfr\Login\Controller\LoginController@logout');
    Route::any('login/{provider}', 'Lvlfr\Login\Controller\LoginController@login');
    Route::any('login', 'Lvlfr\Login\Controller\LoginController@index');

    Route::any('loginAs/{id}', array(
        'before' => 'envLocal',
        function($id) {
            Auth::loginUsingId($id);
            return Redirect::to('/');
        }
    ));

});
