# Routage

- [Routage basique](#basic-routing)
- [Paramètres de routes](#route-parameters)
- [Filtre de routes](#route-filters)
- [Routes nommées](#named-routes)
- [Routes groupées](#route-groups)
- [Routage de sous domaine](#sub-domain-routing)
- [Prefixage de routes](#route-prefixing)
- [Liaison de modèle à une route](#route-model-binding)
- [Lancer une erreur 404](#throwing-404-errors)
- [Contrôleurs de resources](#resource-controllers)

<a name="basic-routing"></a>
## Routage basique

La plupart des routes de votre application seront définies dans le fichier `app/routes.php`. La route la plus simple sur Laravel consiste en une URI et une fonction de retour anonyme.

**Route GET basique**

	Route::get('/', function()
	{
		return 'Hello World';
	});

**Route POST basique**

	Route::post('foo/bar', function()
	{
		return 'Hello World';
	});

**Enregistrement d'une route répondant à tous les verbes HTTP**

	Route::any('foo', function()
	{
		return 'Hello World';
	});

**Force une route à utiliser HTTPS**

	Route::get('foo', array('https', function()
	{
		return 'Must be over HTTPS';
	}));

Vous aurez souvent besoin de générer des URLs vers vos routes, pour ce faire utilisez la méthode `URL::to` :

    $url = URL::to('foo');

<a name="route-parameters"></a>
## Paramètres de routes

	Route::get('user/{id}', function($id)
	{
		return 'User '.$id;
	});

**Paramètre optionnel de routes**

	Route::get('user/{name?}', function($name = null)
	{
		return $name;
	});

**Paramètre optionnel de routes avec une valeur par défaut**

	Route::get('user/{name?}', function($name = 'John')
	{
		return $name;
	});

**Routes avec paramètre contraintes par une expression régulière**

	Route::get('user/{name}', function($name)
	{
		//
	})
	->where('name', '[A-Za-z]+');

	Route::get('user/{id}', function($id)
	{
		//
	})
	->where('id', '[0-9]+');

<a name="route-filters"></a>
## Filtres de routes

Les filtres de routes fournissent une manière simple de limiter l'accès à certaines routes, ce qui est utile par exemple pour les parties d'un site qui nécessitent une identification. Il y a plusieurs filtres inclus avec le framework Laravel par défaut, dont un filtre `auth`, un filtre `auth.basic`, un filtre `guest`, et un filtre `csrf`. Ils sont situés dans le fichier `app/filters.php`.

**Définition d'un filtre de route**

	Route::filter('old', function()
	{
		if (Input::get('age') < 200)
		{
			return Redirect::to('home');
		}
	});

Si une réponse est retournée par un filtre, cette réponse sera considérée comme la réponse de la requête et la route ne sera pas exécutée, et les filtres `after` seront annulés également.

**Attachement d'un filtre à une route**

	Route::get('user', array('before' => 'old', function()
	{
		return 'You are over 200 years old!';
	}));

**Attachement de plusieurs filtres à une route**

	Route::get('user', array('before' => 'auth|old', function()
	{
		return 'You are authenticated and over 200 years old!';
	}));

**Spécification des paramètres de filtres**

	Route::filter('age', function($route, $request, $value)
	{
		//
	});

	Route::get('user', array('before' => 'age:200', function()
	{
		return 'Hello World';
	}));

Les filtres 'after' reçoivent une `$response` en tant que troisième argument du filtre :

    Route::filter('log', function($route, $request, $response, $value)
    {
        //
    });

**Filtres basés sur un patron de route**

Vous pouvez aussi spécifier qu'un filtre s'applique sur un jeu entier de routes en se basant sur leurs URIs.

	Route::filter('admin', function()
	{
		//
	});

	Route::when('admin/*', 'admin');

Dans l'exemple ci-dessus, le filtre `admin` s'applique sur tous les routes qui commencent par `admin/`. L'étoile est utilisée en tant que joker, et correspond à n'importe quelle combinaison de caractères.

Vous pouvez également spécifier une contrainte selon le verbe HTTP :

    Route::when('admin/*', 'admin', array('post'));

**Classes de filtres**

Pour du filtrage avancé, vous pouvez utiliser une classe plutôt qu'une fonction anonyme. Comme les filtres de classes sont résolus par [le conteneur IoC](/docs/4/ioc), vous serez en mesure d'utiliser l'injection de dépendance dans ces filtres pour une meilleure testabilité.

**Définition d'une classe de filtre**

	class FooFilter {

		public function filter()
		{
			// Filter logic...
		}

	}

**Enregistrement d'un filtre basé sur une classe**

	Route::filter('foo', 'FooFilter');

<a name="named-routes"></a>
## Routes nommées

Les routes nommées rendent agréable le référencement d'une route lors de la génération d'un lien ou d'une redirection. Pour spécifier un nom à une route, faites de la manière suivante :

	Route::get('user/profile', array('as' => 'profile', function()
	{
		//
	}));

Vous pouvez également spécifier un nom de route pour les actions de contrôleurs :

    Route::get('user/profile', array('as' => 'profile', 'uses' => 'UserController@showProfile'));

Mantenant, vous pouvez utiliser le nom de la route lorsque vous générez une URL ou redirigez l'utilisateur :

	$url = URL::route('profile');

	$redirect = Redirect::route('profile');

Vous pouvez accéder au nom de la route qui est actuellement utilisé par la méthode `currentRouteName` :

    $name = Route::currentRouteName();

<a name="route-groups"></a>
## Routes groupées

Parfois, vous pourriez avoir besoin d'appliquer un filtre sur tout un groupe de route. Plutôt que de définir l'appel à ce filtre route par route, vous pouvez utiliser les groupes de routes :

	Route::group(array('before' => 'auth'), function()
	{
		Route::get('/', function()
		{
			// Has Auth Filter
		});

		Route::get('user/profile', function()
		{
			// Has Auth Filter
		});
	});

<a name="sub-domain-routing"></a>
## Routage de sous-domaine

Les routes de Laravel permettent également de router à partir d'un sous-domaine. En utilisant un paramètre de routes en sous-domaine, ce dernier sera alors passé en tant que paramètre à la route :

**Enregistrement d'un groupe de routes à partir du sous-domaine**

	Route::group(array('domain' => '{account}.myapp.com'), function()
	{

		Route::get('user/{id}', function($account, $id)
		{
			//
		});

	});
<a name="route-prefixing"></a>
## Préfixage de routes

Un groupe de route peut être préfixé en utilisant l'option `prefix` dans le tableau d'attribut d'un groupe de routes :

**Préfixage d'un groupe de routes**

	Route::group(array('prefix' => 'admin'), function()
	{

		Route::get('user', function()
		{
			//
		});

	});

<a name="route-model-binding"></a>
## Liaison d'un modèle à une route

La liaison de modèle fournit une manière agréable d'injecter l'instance d'un modèle à l'intérieur d'une route. Par exemple, plutôt que d'injecter un ID d'utilisateur, Vous pouvez injecter le modèle entier qui correspond à l'ID. Premièrement, utilisez la méthode `Route::model` pour spécifier le modèle qui doit être utilisé pour un paramètre spécifique :

**Liaison d'un paramètre à un modèle**

	Route::model('user', 'User');

Ensuite, définissez une route qui contient le paramètre `{user}` :

	Route::get('profile/{user}', function(User $user)
	{
		//
	});

Etant donné que nous avons lié au paramètre `{user}` le modèle `User`, une instance de `User` sera injectée à la route. Donc, par exemple, une requête sur `profile/1` injectera une instance `User` qui a un ID de 1.

> **Note:** Si une instance d'un modèle n'est pas trouvée dans la base de données, alors une erreur 404 est lancée.

Si vous souhaitez spécifier un comportement non trouvé personnalisé, vous pouvez passer une fonction anonyme en tant que troisième argument de la méthode `model` :

    Route::model('user', 'User', function()
    {
        throw new NotFoundException;
    });


Si vous avez besoin de résoudre vous-même la manière de trouver un modèle, utilisez la méthode `Route::bind` :

	Route::bind('user', function($value, $route)
	{
		return User::where('name', $value)->first();
	});

<a name="throwing-404-errors"></a>
## Lancer une erreur 404

Il y a deux manières de lancer une erreur 404 depuis une route. Première méthode, utilisez la méthode `App::abort` :

	App::abort(404);

Seconde méthode, vous pouvez lever une exception de type `Symfony\Component\HttpKernel\Exception\NotFoundHttpException`.

Plus d'informations sur la gestion des exceptions 404 et l'utilisation de réponses personalisées pour ces erreurs peuvent être trouvées dans la section [erreurs](/docs/4/errors#handling-404-errors) de la documentation.

<a name="resource-controllers"></a>
## Contrôleurs de resources

Les contrôleurs de ressources rendent plus facile la construction de contrôleurs RESTful autour d'une ressource.

Voir la documentation des [contrôleurs](/docs/4/controllers#resource-controllers) pour plus d'informations.

