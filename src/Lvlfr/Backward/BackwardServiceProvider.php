<?php
namespace Lvlfr\Backward;

use Illuminate\Support\ServiceProvider;

/**
 * Description of BackwardServiceProvider
 *
 * @author a
 */
class BackwardServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('Lvlfr/Backward', 'LvlfrBackward', __DIR__);

        include __DIR__.'/routes.php';
    }

    public function register()
    {
        $this->app->bind('Lvlfr\Backward\Services\DocUpdaterInterface', 'Lvlfr\Backward\Services\DocUpdaterInterface\File');
    }
}
