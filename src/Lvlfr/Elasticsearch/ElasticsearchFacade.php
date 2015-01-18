<?php
namespace Lvlfr\Elasticsearch;

use Illuminate\Support\Facades\Facade;


class ElasticsearchFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'elasticsearch';
    }
}