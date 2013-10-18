<?php

/*
* Transform namespaces like "Test/One/Two" into "TestOneTwo"
*/
function simplifyNamespace($moduleName)
{
    return implode('', array_map('ucfirst', explode('/', $moduleName)));
}


/*
 * Manually handling modules, so i can easily choose the order
 * The Website module must be the last, because it handles the "/" route, which catch everything
 */
$modules = array(
    'Lvlfr/Login',
    'Lvlfr/Forums',
    'Lvlfr/Documentation',
    'Lvlfr/Website',
);

$basePath = app('path.src');

// Foreach existing modules
foreach ($modules as $module) {
    if (is_dir($modulePath = $basePath . '/' . $module)) {

        $simplifiedNamespace = simplifyNamespace($module);

        // if views folder exists, register namespace
        if (is_dir($moduleViewPath = $modulePath . '/Views')) {
            View::addNamespace($simplifiedNamespace, $moduleViewPath);
        }

        // if Config folder exists, register namespace
        if (is_dir($moduleConfigPath = $modulePath . '/Config')) {
            Config::addNamespace($simplifiedNamespace, $moduleConfigPath);
        }

        // if routes file exists, then include it
        if (file_exists($moduleRouteFile = $modulePath . '/routes.php')) {
            require $moduleRouteFile;
        }
    }
}
