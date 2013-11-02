<?php
namespace Lvlfr\Website;

use Illuminate\Support\ServiceProvider;

/**
 * Description of WebsiteServiceProvider
 *
 * @author a
 */
class WebsiteServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('Lvlfr/Website', 'LvlfrWebsite', __DIR__);

        include __DIR__.'/routes.php';
    }
    
    public function register()
    {

    }
}
