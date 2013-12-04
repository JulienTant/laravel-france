<?php
namespace Lvlfr\Wiki;

use Illuminate\Support\ServiceProvider;
use \Validator;

/**
 * Description of WikiServiceProvider
 *
 * @author a
 */
class WikiServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->package('Lvlfr/Wiki', 'LvlfrWiki', __DIR__);

        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new \Lvlfr\Wiki\Validation\WikiValidator($translator, $data, $rules, $messages);
        });

        include __DIR__.'/filters.php';
        include __DIR__.'/helpers.php';
        include __DIR__.'/routes.php';
    }
    
    public function register()
    {
        $this->app->bind('Lvlfr\Wiki\Repositories\Page', '\Lvlfr\Wiki\Repositories\Eloquent\EloquentPageRepo');
    }
}
