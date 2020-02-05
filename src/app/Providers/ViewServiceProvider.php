<?php

namespace LaravelFrance\Providers;

use \View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.forums_sidebar', 'LaravelFrance\Http\View\Composers\ForumsListComposer'
        );
    }
}
