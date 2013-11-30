<?php

Route::filter('canUpdateWiki', function () {
    if (Auth::guest() || !Auth::user()->canUpdateWiki()) {
        throw new Exception("Vous ne pouvez pas mettre à jour le wiki", 1);
    }
});