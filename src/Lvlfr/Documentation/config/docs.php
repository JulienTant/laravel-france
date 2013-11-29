<?php

return array(
    'defaultVersion' => '4',
    'path' => '/docs',
    '4' => array(
        'default' => 'introduction',
        'menu' => 'documentation',
        'path' => '4'
    ),
    'admin' => array(
        'tmpDir' => function() {
            return sys_get_temp_dir();
        },
        'filePath' => function() {
            return 'https://github.com/laravel-france/documentation/archive/master.zip';
        }
    ),
);
