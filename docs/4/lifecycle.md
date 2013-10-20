# Cycle de vie d'une requête

- [Présentation](#overview)
- [Les fichiers de démarrage](#start-files)
- [Les gestionnaires d'événements](#application-events)

<a name="overview"></a>
## Présentation
Dans Laravel, le cycle de vie d'une requête est assez simple. Une requête est aiguillée vers la route ou le contrôleur approprié. La réponse correspondant à la route est retournée au navigateur et affichée à l'écran. Il est possible d'exécuter des opérations avant ou après la résolution d'une route. Les fichiers de démarrage et les gestionnaires d'événements sont deux moyens permettant d'y parvenir.

<a name="start-files"></a>
## Les fichiers de démarrage

Les fichiers de démarrage sont situés dans le répertoire `app/start`. Par défaut, les fichiers `global.php`, `local.php` et `artisan.php` sont inclus dans votre application. Pour plus de détails sur le fichier `artisan.php`, consultez la rubrique [Artisan CLI](/docs/commands#registering-commands).

Par défaut, le fichier `global.php` contient quelques éléments de base tels que l'enregistrement du [gestionnaire d'erreurs](/docs/errors) et l'inclusion de votre fichier `app/filters.php`. Vous pouvez compléter ce fichier en fonction de vos besoins sans limite particulière. Ce fichier est automatiquement inclus à _chaque_ requête de votre application indépendamment de l'environnement. Pour plus d'informations sur les environnements, consultez la rubrique [Configuration](/docs/configuration).

Bien sûr, si vous avez d'autres environnements que l'environnement `local`, vous devez créer un fichier de démarrage par environnement supplémentaire. A l'exécution d'un des environnements, le fichier de démarrage associé est automatiquement inclus dans votre application.

<a name="application-events"></a>
## Les gestionnaires d'événements

Vous pouvez ajouter des opérations précédant et suivant l'exécution de la requête en enregistrant les gestionnaires des événements `before`, `after`, `close`, `finish`, et `shutdown`.

**Enregistrer des gestionnaires d'événements**

	App::before(function()
	{
		//
	});

	App::after(function(request, $response)
	{
		//
	});

Les listeners de ces événements seront exécutées `avant` et `après` chaque requête de votre application.
