<?php

Route::group(array('domain' => 'docs.'. Config::get('app.domain')), function()
{
    Route::get('{version?}/{document?}', '\Lvlfr\Documentation\Controller\DocumentationController@showDocs');
});

