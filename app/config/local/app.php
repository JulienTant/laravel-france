<?php

return array(
    'debug' => true,
    'url' => 'http://laravelfr.app',
    'domain' => 'laravelfr.app',

    'providers' => append_config([
        \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class
    ])
);
