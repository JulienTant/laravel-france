<?php

use Illuminate\Support\Facades\Route;

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
