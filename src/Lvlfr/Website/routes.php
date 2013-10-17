<?php

Route::group(array('domain' => Config::get('app.domain')), function () {
    Route::controller('contact', 'Lvlfr\Website\Controller\ContactController');
    Route::controller('irc', 'Lvlfr\Website\Controller\IrcController');
    Route::controller('/', 'Lvlfr\Website\Controller\HomeController');
});
