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

    /**
     * USER PANEL
     */
    Route::group(array('prefix' => 'user', 'before' => 'auth'), function () {
        Route::any('profile', 'Lvlfr\Login\Controller\ProfileController@index'); 

        Route::get('pseudo', 'Lvlfr\Login\Controller\ProfileController@pseudo'); 
        Route::post('pseudo', 'Lvlfr\Login\Controller\ProfileController@submitPseudo'); 
        Route::post('pseudo\check', 'Lvlfr\Login\Controller\ProfileController@checkPseudo'); 

        Route::get('gravatar', 'Lvlfr\Login\Controller\ProfileController@avatar'); 
        Route::post('gravatar', 'Lvlfr\Login\Controller\ProfileController@submitAvatar');
    });   

    /**
     * FORUMS ADMIN
     */
    Route::group(array('prefix' => 'admin/forums', 'before' => 'hasRole:Forums'), function () {
        Route::get('categories', 'Lvlfr\Login\Controller\Admin\ForumsController@categories'); 
        Route::post('categories', 'Lvlfr\Login\Controller\Admin\ForumsController@categoriesPost'); 
    });   

    /**
     * DOC ADMIN
     */
    Route::group(array('prefix' => 'admin/doc', 'before' => 'hasRole:Doc'), function () {
        Route::get('update', 'Lvlfr\Login\Controller\Admin\DocController@update'); 
        Route::post('update', 'Lvlfr\Login\Controller\Admin\DocController@postUpdate'); 
    });   
    
    /**
     * USERS ADMIN
     */
    Route::group(array('prefix' => 'admin/users', 'before' => 'hasRole:SuperAdmin'), function () {
        Route::get('list', 'Lvlfr\Login\Controller\Admin\UsersController@lists'); 
    });   

    
    
    
    });
