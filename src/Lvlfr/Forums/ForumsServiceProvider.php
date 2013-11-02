<?php
namespace Lvlfr\Forums;

use Illuminate\Support\ServiceProvider;

/**
 * Description of ForumsServiceProvider
 *
 * @author a
 */
class ForumsServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('Lvlfr/Forums', 'LvlfrForums', __DIR__);

        include __DIR__.'/routes.php';
    }
    
    public function register()
    {
    }
}
