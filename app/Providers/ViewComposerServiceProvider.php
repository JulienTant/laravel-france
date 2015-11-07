<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance\Providers;


use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use LaravelFrance\Http\ViewComposers\Forums\Sidebar;

class ViewComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        view()->composer('forums._sidebar', Sidebar::class);
    }

    public function register(){}
}