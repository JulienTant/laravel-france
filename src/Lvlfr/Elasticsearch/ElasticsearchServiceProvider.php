<?php
namespace Lvlfr\Elasticsearch;

use Config;
use Elasticsearch\Client as ElasticsearchClient;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;


/**
 * Class ElasticsearchServiceProvider
 **/
class ElasticsearchServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('elasticsearch', function () {

            $connParams = [];
            $connParams['hosts'] = ['localhost:9200'];
            $connParams['logPath'] = storage_path() . '/logs/elasticsearch-' . php_sapi_name() . '.log';
            $connParams['logLevel'] = Logger::INFO;

            // merge settings from app/config/elasticsearch.php
            $params = array_merge($connParams, Config::get('elasticsearch'));

            return new ElasticsearchClient($params);
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Elasticsearch', 'Lvlfr\Elasticsearch\ElasticsearchFacade');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['elasticsearch'];
    }

}