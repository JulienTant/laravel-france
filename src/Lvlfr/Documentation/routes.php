<?php

Route::group(array('domain' => 'docs.'. Config::get('app.domain')), function()
{
    Route::any('login', 'Lvlfr\Login\Controller\LoginController@index');

    Route::get('{version?}/{document?}', '\Lvlfr\Documentation\Controller\DocumentationController@showDocs');
});

