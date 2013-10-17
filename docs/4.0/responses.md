# Vues & Réponses

- [Réponses basiques](#basic-responses)
- [Redirections](#redirects)
- [Vues](#views)
- [Compositeurs de vues](#view-composers)
- [Réponses spéciales](#special-responses)

<a name="basic-responses"></a>
## Réponses basiques

**Retourne une chaîne de caractères depuis une route**

	Route::get('/', function()
	{
		return 'Hello World';
	});

**Création d'une réponse personnalisée**

Une instance de `Response` hérite de la classe `Symfony\Component\HttpFoundation\Response`, qui fournit une multitude de méthodes pour construire une réponse HTTP.

	$response = Response::make($contents, $statusCode);

	$response->headers('Content-Type', $value);

	return $response;

**Attachement d'un cookie à une réponse**

	$cookie = Cookie::make('name', 'value');

	return Response::make($content)->withCookie($cookie);

<a name="redirects"></a>
## Redirections

**Retourne une redirection**

	return Redirect::to('user/login');

**Retourne une redirection vers une route nommée**

	return Redirect::route('login');

**Retourne une redirection vers une route nommée avec des paramètres**

	return Redirect::route('profile', array(1));

**Retourne une redirection vers une route nommée avec des paramètres nommés**

	return Redirect::route('profile', array('user' => 1));

**Retourne une redirection vers une action d'un contrôleur**

	return Redirect::action('HomeController@index');

**Retourne une redirection vers une action d'un contrôleur avec des paramètres**

	return Redirect::action('UserController@profile', array(1));

**Retourne une redirection vers une action d'un contrôleur avec des paramètres nommés**

	return Redirect::action('UserController@profile', array('user' => 1));

<a name="views"></a>
## Vues

Les vues contiennent habituellement les fichiers HTML de votre application et fournissent une manière simple de séparer vos contrôleurs et la logique métier de la partie présentation. Les vues sont stockées dans le dossier `app/views`.

Une vue peut ressembler à ceci :

	<!-- View stored in app/views/greeting.php -->

	<html>
		<body>
			<h1>Hello, <?php echo $name; ?></h1>
		</body>
	</html>

Cette vue peut être retournée en tant que réponse comme ceci :

	Route::get('/', function()
	{
		return View::make('greeting', array('name' => 'Taylor'));
	});

Le second argument passé ici à `View::make` est un tableau de données qui doivent être passées à la vue.

**Passage de données à une vue**

	$view = View::make('greeting', $data);

	$view = View::make('greeting')->with('name', 'Steve');

Dans l'exemple ci-dessus, `$name` sera accessible dans la vue, et aura comme valeur `Steve`.

Vous pouvez également partager des données avec toutes les vues :

    View::share('name', 'Steve');

**Passage d'une sous-vue à une vue**

Vous pouvez également passer une vue à une autre vue. Par exemple, nous pouvons passer une sous-vue qui se trouve dans le fichier `app/views/child/view.php`, à une autre vue de la manière suivante :

	$view = View::make('greeting')->nest('child', 'child.view');

	$view = View::make('greeting')->nest('child', 'child.view', $data);

La sous-vue peut alors être rendue depuis la vue parent :

	<html>
		<body>
			<h1>Hello!</h1>
			<?php echo $child; ?>
		</body>
	</html>

<a name="view-composers"></a>
## Compositeurs de vues

Les compositeurs de vues sont des fonctions anonymes ou des méthodes de classes qui sont appelées lorsqu'une vue est créée. Si vous avez des données que vous souhaitez lier à une vue chaque fois qu'elle est créée dans votre application, alors un compositeur de vue peut organiser ce code en un seul endroit. Par conséquent, les compositeurs de vues peuvent fonctionner comme des "VueModèle" ( design pattern MVVM ) ou des "Présentation" (design pattern MVP).

**Définition d'un compositeur de vue**

	View::composer('profile', function($view)
	{
		$view->with('count', User::count());
	});

Maintenant, chaque fois que la vue `profile` est créée, la donnée `count` lui sera liée.

Vous pouvez également définir un même comportement pour plusieurs vues :

    View::composer(array('profile','dashboard'), function($view)
    {
        $view->with('count', User::count());
    });

Si vous préférez utiliser une classe en tant que compositeur de vue de type classe, qui fournit l'avantage de pouvoir utiliser le [conteneur IoC](/docs/4/ioc), vous devez faire comme ceci :

	View::composer('profile', 'ProfileComposer');

Une classe compositeur de vue doit être définie comme ceci :

	class ProfileComposer {

		public function compose($view)
		{
			$view->with('count', User::count());
		}

	}

Notez qu'il n'y a pas de convention sur l'endroit où les compositeurs de vues doivent être stockés. Vous êtes libres de les mettre où vous le souhaitez, tant qu'ils peuvent être chargés automatiquement par l'une des directives de votre fichier `composer.json`.

<a name="special-responses"></a>
## Réponses spéciales

**Création d'une réponse JSON**

	return Response::json(array('name' => 'Steve', 'state' => 'CA'));

**Création d'une réponse JSONP**

	return Response::json(array('name' => 'Steve', 'state' => 'CA'))->setCallback(Input::get('callback'));

**Création d'un téléchargement de fichier**

	return Response::download($pathToFile);

	return Response::download($pathToFile, $status, $headers);
