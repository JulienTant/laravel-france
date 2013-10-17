# Configuration

- [Introduction](#introduction)
- [Configuration des environnements](#environment-configuration)
- [Mode de maintenance](#maintenance-mode)

<a name="introduction"></a>
## Introduction

Tous les fichiers de configuration du framework Laravel sont situés dans le dossier `app/config`. Chaque option dans les fichiers est documentée, alors n'hésitez pas à regarder ces fichiers et à vous familiariser avec les options disponibles.

Parfois vous pourriez avoir besoin d'accéder aux valeurs de configuration durant l'exécution de l'application. Vous pouvez le faire en utilisant la classe `Config` :

**Accède à une valeur de configuration**

	Config::get('app.timezone');

Remarquez que la syntaxe de style "point" peut être utilisée pour accéder aux valeurs des fichiers de configuration. Si vous souhaitez définir une valeur pendant l'exécution : 

**Définit une valeur de configuration**

	Config::set('database.default', 'sqlite');

<a name="environment-configuration"></a>
## Configuration des environnements

Il est souvent utile d'avoir différentes valeurs de configuration basées sur l'environnement sur lequel l'application tourne. Par exemple, vous pourriez vouloir utiliser un driver de cache différent pour votre environnement de développement et votre serveur de production. Ceci est facile à accomplir grâce aux fichiers de configuration basés sur l'environnement.

Créez simplement dans un dossier dans votre dossier `config` qui correspond au nom de votre environnement, comme par exemple `local`. Ensuite, créez les fichiers de configuration que vous souhaitez surcharger et spécifiez les options que vous souhaitez changer. Par exemple, pour surcharger le driver de cache de votre environnement "local", vous devrez créer un fichier `cache.php` dans `app/config/local` avec le contenu suivant :

	<?php
	return array(
		'driver' => 'file',
	);

> **Note:** N'utilisez pas le nom d'environnement 'testing' en tant que nom d'environnement, ce nom est réservé pour les tests unitaires.

Notez que vous n'avez pas à spécifier _toutes_ les options qui se trouvent dans le fichier de base, mais seulement celles que vous souhaitez réécrire. Les fichiers de configuration des environnements sont en cascade vis à vis du fichier de base.

Ensuite, nous devons indiquer au framework comment déterminer sur quel environnement il tourne actuellement. Par défaut, l'environnement sera toujours `production`. Cependant, vous pouvez configurer d'autres environnements dans le fichier `bootstrap/start.php` depuis la racine de votre installation. Dans ce fichier, vous trouverez un appel à `$app->detectEnvironment`. Le tableau passé à cette méthode est utilisé pour déterminer l'environnement courant. Vous pouvez ajouter d'autres environnements et noms de machines dans le tableau au besoin.

	<?php

	$env = $app->detectEnvironment(array(
		'local' => array('your-machine-name'),
	));

Vous pouvez également passer une fonction anonyme à la méthode `detectEnvironment`, vous permettant d'implémenter votre propre détection d'environnement :

	$env = $app->detectEnvironment(function()
	{
		return $_SERVER['MY_LARAVEL_ENV'];
	});


Vous pouvez accéder à l'environnement courant de l'application par la méthode `environment` :

**Accède à l'environnement courant de l'application**

	$environment = App::environment();
    
<a name="maintenance-mode"></a>
## Mode de maintenance

Lorsque votre application est en mode de maintenance, une vue personnalisée sera afficher sur toutes les routes de votre applications. C'est une manière simple de "désactiver" votre application pendant sa mise à jour. Un appel à la méthode `App::down` est déjà présent dans votre fichier `app/start/global.php`. La réponse de cette méthode sera envoyée aux utilisateurs lorsque l'application est en mode de maintenance.

Pour activer le mode de maintenance, exécutez la commande Artisan `down` :

	php artisan down

Et pour désactiver ce mode, utilisez la commande `up` :

	php artisan up
	
Pour afficher une vue lorsque votre application est en mode maintenance, vous pouvez ajouter quelque chose comme cela dans votre fichier app/start/global.php :

	App::down(function()
	{
    		return Response::view('maintenance', array(), 503);
	});
