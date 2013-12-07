<?php
namespace Lvlfr\PasteApi;

use Illuminate\Support\ServiceProvider;

/**
 * Description of PasteApiServiceProvider
 *
 * @author a
 */
class PasteApiServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('Lvlfr/PasteApi', 'LvlfrPasteApi', __DIR__);

        include __DIR__.'/routes.php';
    }

    public function register()
    {
    }
}
