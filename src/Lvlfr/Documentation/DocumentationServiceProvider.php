<?php
namespace Lvlfr\Documentation;

use Illuminate\Support\ServiceProvider;

/**
 * Description of DocumentationServiceProvider
 *
 * @author a
 */
class DocumentationServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('Lvlfr/Documentation', 'LvlfrDocumentation', __DIR__);

        include __DIR__.'/routes.php';
    }
    
    public function register()
    {
        $this->app->bind('Lvlfr\Documentation\Services\DocUpdaterInterface', 'Lvlfr\Documentation\Services\DocUpdaterInterface\File');
    }
}
