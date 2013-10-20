# Contrôleurs

- [Contrôleurs basiques](#basic-controllers)
- [Filtres de contrôleurs](#controller-filters)
- [Contrôleurs RESTful](#restful-controllers)
- [Contrôleurs de ressource](#resource-controllers)
- [Gestion de méthodes manquantes](#handling-missing-methods)

<a name="basic-controllers"></a>
## Contrôleurs basiques

Plutôt que de définir toute la logique de votre application au niveau des routes dans le fichier `routes.php`, il est d'usage de déplacer le comportement de votre application dans des contrôleurs. Les contrôleurs permettent de regrouper en une classe, la logique de routes connexes, et aussi de prendre avantage des fonctionnalités avancées du framework comme [l'injection de dépendances](/docs/4/ioc).

Les contrôleurs sont stockés dans le dossier `app/controllers`, et ce dossier est enregistré dans l'option `classmap` de votre fichier `composer.json` par défaut.

Voici un exemple d'un contrôleur basique :

	class UserController extends BaseController {

		/**
		 * Show the profile for the given user.
		 */
		public function showProfile($id)
		{
			$user = User::find($id);

			return View::make('user.profile', array('user' => $user));
		}

	}

Tous les contrôleurs doivent hériter de la classe `BaseController`. La classe `BaseController` est également présente dans le dossier `app/controllers`, et peut être utilisée pour placer des éléments partagés. `BaseController` hérite de la classe `Controller` du framework. Maintenant, nous pouvons router vers notre contrôleur de la manière suivante :

	Route::get('user/{id}', 'UserController@showProfile');

Si vous organisez votre code avec des namespaces PHP, utilisez simplement le nom complet de la classe lors de la définition de la route :

	Route::get('foo', 'Namespace\FooController@method');

Vous pouvez également nommer ces routes avec la propriété `as` :

	Route::get('foo', array('uses' => 'FooController@method',
											'as' => 'name'));

Pour générer une URL vers une action de contrôleur, utilisez la méthode `URL::action` :

    $url = URL::action('FooController@method');

Vous pouvez accéder au nom de l'action du contrôleur qui est lancé en utilisant la méthode `currentRouteAction` :

    $action = Route::currentRouteAction();

<a name="controller-filters"></a>
## Filtres de contrôleurs

[Les filtres](/docs/4/routing#route-filters) peuvent être spécifiés sur les routes de contrôleurs comme pour toutes les autres routes :

	Route::get('profile', array('before' => 'auth',
				'uses' => 'UserController@showProfile'));

Cependant, vous pouvez également spécifier des filtres à l'intérieur de votre contrôleur :

	class UserController extends BaseController {

		/**
		 * Instantiate a new UserController instance.
		 */
		public function __construct()
		{
			$this->beforeFilter('auth');

			$this->beforeFilter('csrf', array('on' => 'post'));

			$this->afterFilter('log', array('only' =>
								array('fooAction', 'barAction')));
		}

	}

Vous pouvez également spécifier des filtres directement avec une fonction anonyme :

	class UserController extends BaseController {

		/**
		 * Instantiate a new UserController instance.
		 */
		public function __construct()
		{
			$this->beforeFilter(function()
			{
				//
			});
		}

	}

<a name="restful-controllers"></a>
## Contrôleurs RESTful

Laravel vous permet de définir une seule route pour gérer toutes les actions d'un contrôleur en utilisant une simple convention de nommage REST. Premièrement, définissez la route en utilisant la méthode `Route::controller` :

**Définition d'un contrôleur RESTful**

	Route::controller('users', 'UserController');

La méthode `controller` prend deux arguments. Le premier est la base d'URI qui conduit au contrôleur, le second est le nom de la classe du contrôleur. Ensuite, ajoutez simplement des méthodes à votre contrôleur, préfixés par le verbe HTTP auquel ils doivent répondre :

	class UserController extends BaseController {

		public function getIndex()
		{
			// répond à GET /users
		}

		public function postProfile()
		{
			// répond à POST /users/profile
		}

	}

La méthode `index` répondra à la racine de l'URI défini dans la route, qui dans notre cas est `users`.

Si votre méthode de contrôleur contient plusieurs mots, vous devrez accéder à l'action en utilisant un "tiret" entre les mots dans l'URI. Par exemple, la méthode de contrôleur dans notre `UserController` répondra à l'URI `users/admin-profile` :

	public function getAdminProfile() {}

<a name="resource-controllers"></a>
## Contrôleurs de ressource

Les contrôleurs de ressource rendent plus facile la construction de contrôleur RESTful autour d'une ressource. Par exemple, vous pourriez créer un contrôleur qui gère des photos stockées par votre application. En utilisant la commande `controller:make` d'Artisan et avec la méthode `Route::resource`, nous pouvons créer facilement ce type de contrôleur.

Pour créer le contrôleur en ligne de commande, exécutez la commande suivante :

	php artisan controller:make PhotoController

Maintenant nous pouvons enregistrer une route "resourceful" vers notre contrôleur :

	Route::resource('photo', 'PhotoController');

Cette simple déclaration de route crée de multiples routes pour gérer une variété d'actions RESTful sur notre ressource "photo". De plus, le contrôleur généré contiendra déjà des méthodes pour chacune de ces actions avec une note vous informant à quelles URIs et à quels verbes HTTP ils répondent.

**Actions gérées par un contrôleur de ressource**

Verb      | Path                  | Action       | Route Name
----------|-----------------------|--------------|---------------------
GET       | /resource             | index        | resource.index
GET       | /resource/create      | create       | resource.create
POST      | /resource             | store        | resource.store
GET       | /resource/{id}        | show         | resource.show
GET       | /resource/{id}/edit   | edit         | resource.edit
PUT/PATCH | /resource/{id}        | update       | resource.update
DELETE    | /resource/{id}        | destroy      | resource.destroy

Parfois vous aurez seulement besoin d'une partie des méthodes du contrôleur de ressource :

	php artisan controller:make PhotoController --only=index,show

	php artisan controller:make PhotoController --except=index

Et, vous pouvez aussi spécifier quelles méthodes doivent être disponibles via le routage:

	Route::resource('photo', 'PhotoController',
					array('only' => array('index', 'show')));

<a name="handling-missing-methods"></a>
## Gestion de méthodes manquantes

Une méthode attrape-tout peut être créée, elle sera appelée quand aucune autre méthode n'est trouvée dans un contrôleur donné. La méthode doit s'appeler `missingMethod`, et elle reçoit le tableau de paramètres de la requête en tant que seul argument :

**Définition d'une méthode attrape-tout**

	public function missingMethod($parameters)
	{
		//
	}
