<?php


Route::group(array('domain' => Config::get('app.domain')), function () {
    Route::pattern('anything', '(.*)?');

    Route::get('forums/{anything?}', function($anything = null) {
        return Redirect::away('http://forums.'.Config::get('app.domain').'/'.$anything, 301);
    });

    Route::get('docs/{anything?}', function($anything = null) {
        return Redirect::away('http://docs.'.Config::get('app.domain').'/'.$anything, 301);
    });
});
