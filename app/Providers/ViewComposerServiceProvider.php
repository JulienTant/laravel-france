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

class ViewComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        view()->composer('forums._sidebar', function(View $view) {

            /** @var \Illuminate\Contracts\Cache\Repository $cache */
            $cache = app('cache');

            $categories = $cache->remember('forums_categories', Carbon::now()->addDay(1), function () {
                return \LaravelFrance\ForumsCategory::orderBy('order', 'asc')->get();
            });

            return $view->with(
                'categories',
                $categories
            );
        });
    }

    public function register(){}
}