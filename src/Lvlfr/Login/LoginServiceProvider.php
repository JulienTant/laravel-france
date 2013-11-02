<?php
namespace Lvlfr\Login;

use Illuminate\Support\ServiceProvider;

/**
 * Description of LoginServiceProvider
 *
 * @author a
 */
class LoginServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('Lvlfr/Login', 'LvlfrLogin', __DIR__);

        include __DIR__.'/routes.php';
    }
    
    public function register()
    {

        }
}
