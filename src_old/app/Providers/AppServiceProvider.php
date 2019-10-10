<?php

namespace LaravelFrance\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Maknz\Slack\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {
            return new Client('https://hooks.slack.com/services/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');
        });

        if ($this->app->environment('local')) {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(DebugbarServiceProvider::class);
        }
    }
}
