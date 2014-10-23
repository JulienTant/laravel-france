<?php

return array(
    'defaultVersion' => '4.2',
    'path' => '/docs',
    'versions' => array(
        'dev' => array(
            'default' => 'introduction',
            'menu' => 'documentation',
            'path' => 'dev'
        ),
        '4.2' => array(
            'default' => 'introduction',
            'menu' => 'documentation',
            'path' => '4.2'
        ),
        '4.1' => array(
            'default' => 'introduction',
            'menu' => 'documentation',
            'path' => '4.1'
        ),
        '4.0' => array(
            'default' => 'introduction',
            'menu' => 'documentation',
            'path' => '4.0'
        ),
        '3' => array(
            'default' => 'home',
            'menu' => 'contents',
            'path' => '3'
        ),
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
