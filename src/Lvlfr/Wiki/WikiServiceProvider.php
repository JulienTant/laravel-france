<?php
namespace Lvlfr\Wiki;

use Illuminate\Support\ServiceProvider;

/**
 * Description of WikiServiceProvider
 *
 * @author a
 */
class WikiServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('Lvlfr/Wiki', 'LvlfrWiki', __DIR__);

        include __DIR__.'/routes.php';
    }
    
    public function register()
    {
        $this->app->bind('Lvlfr\Wiki\Repositories\Page', '\Lvlfr\Wiki\Repositories\File\FilePageRepo');
    }
}
