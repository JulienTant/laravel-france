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
            return app('path.storage') . '/documentation-master.zip';
        }
    ),
);
