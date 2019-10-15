<?php

/*
|--------------------------------------------------------------------------
| Web Dev Routes
|--------------------------------------------------------------------------
|
| Those routes are loaded when env is not prodution
|
*/

Route::get('/as/{id}', function ($id) {
    Auth::loginUsingId($id);

    return Redirect::to('/');
});

Route::get('/logout', function () {
    Auth::logout();
    return Redirect::to('/');
});


Route::get('/alert', function () {
    alert()->success('coucou')->autoclose(5000);

    return Redirect::to('/');
});
