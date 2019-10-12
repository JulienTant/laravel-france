<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld\Providers;


use Illuminate\Support\ServiceProvider;
use LaravelFranceOld\Http\ViewComposers\Forums\Sidebar;

class ViewComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        view()->composer('forums._sidebar', Sidebar::class);
    }

    public function register(){}
}
