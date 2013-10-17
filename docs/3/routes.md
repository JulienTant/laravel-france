# Routes

## Au programme

- [Les bases](#the-basics)
- [Jokers](#wildcards)
- [L'événement 404](#the-404-event)
- [Filtres](#filters)
- [Filtres de modèles](#pattern-filters)
- [Filtres globaux](#global-filters)
- [Routes groupées](#route-groups)
- [Route nommées](#named-routes)
- [Routes HTTPS](#https-routes)
- [Route de bundles](#bundle-routes)
- [Routage de contrôleur](#controller-routing)
- [Test de route en CLI](#cli-route-testing)

<a name="the-basics"></a>
## Les bases

Laravel utilise les dernières fonctionnalités de PHP 5.3 pour rendre le routage simple et expressif. L'important étant de rendre l'écriture de routes aussi simple que possible, autant pour une simple API que pour un site web complet et complexe. Les routes sont généralement définies dans le fichier **application/routes.php**.

Contrairement aux autres frameworks, Laravel permet deux modes de fonctionnement pour l'exécution de code applicatif. La manière classique que vous connaissez dans d'autres frameworks, c'est l'écriture de code dans un contrôleur, mais Laravel permet également l'écriture de code directement dans les routes. Ceci est **extrêmement** pratique pour les petits sites qui ne contiennent que peu de pages, car vous n'avez pas à créer tout un tas de contrôleurs pour écrire au plus une ou deux méthodes à l'intérieur.

Dans l'exemple suivant, le premier paramètre est une route que nous enregistrons dans le routeur. Le second paramètre est la fonction qui contient la logique applicative pour cette route. Les routes sont définies sans slash devant. La seule exception est la route par défaut, qui est représentée **uniquement** par un slash.

> **Note:** Les routes sont évaluées dans l'ordre où elles sont enregistrées, enregistrez donc les routes "attrape tout" à la fin de votre fichier **routes.php**.

#### Enregistrement d'une route résolvant un appel à "GET /":

    Route::get('/', function()
    {
        return "Hello World!";
    });

#### Enregistrement d'une route valide pour tous les verbes HTTP (GET, POST, PUT, et DELETE):

    Route::any('/', function()
    {
        return "Hello World!";
    });

#### Enregistrement de routes diverses, répondant aux verbes POST, PUT, et DELETE:

    Route::post('user', function()
    {
        //
    });

    Route::put('user/(:num)', function($id)
    {
        //
    });

    Route::delete('user/(:num)', function($id)
    {
        //
    });

**Enregistrement d'une URI pour plusieurs verbes HTTP :**

    Router::register(array('GET', 'POST'), $uri, $callback);

<a name="wildcards"></a>
## Jokers

#### Obliger une partie de l'URI à être un nombre :

    Route::get('user/(:num)', function($id)
    {
        //
    });

#### Autoriser une partie de l'URI à être n'importe quelle chaîne de caractères alphanumériques :

    Route::get('post/(:any)', function($title)
    {
        //
    });

#### Récuperer le reste de l'URI sans aucune limitation :

    Route::get('files/(:all)', function($path)
    {
        //
    });

#### Autoriser une partie de l'URI à être optionnelle:

    Route::get('page/(:any?)', function($page = 'index')
    {
        //
    });

<a name="the-404-event"></a>
## L'événement 404

Si une requête sur votre application ne correspond à aucune route, alors un événement 404 sera levé. Vous pouvez trouver le comportement par défaut dans le fichier **application/routes.php**

#### Le comportement par défaut pour une page 404 :

    Event::listen('404', function()
    {
        return Response::error('404');
    });

Libre à vous de charger cela pour que cela corresponde à ce que vous désirez faire dans votre application !

*Voir aussi :*

- *[Événements](/docs/3/evenements)*

<a name="filters"></a>
## Filtres

Les filtres de routes peuvent être exécutés avant ou après l'exécution d'une route. Si un filtre est exécuté "avant", la route retourne une valeur, alors cette valeur sera considérée comme une réponse, et la route ne sera pas exécutée, ce qui peut s'avérer pratique lorsque l'on implémente un système d'authentification par exemple. Les filtres sont généralement définis dans le fichier **application/routes.php**.

#### Enregistrement d'un filtre:

    Route::filter('monFiltre', function()
    {
        return Redirect::to('home');
    });

#### Attachement du filtre avant l'exécution d'une route ( mot clé : **before** ) :

    Route::get('blocked', array('before' => 'monFiltre', function()
    {
        return View::make('blocked');
    }));

#### Attachement d'un filtre "après" l'exécution d'une route ( mot clé : **after** ) :

    Route::get('telechargement', array('after' => 'log', function()
    {
        //
    }));

#### Attachement de plusieurs filtres à une route:

    Route::get('create', array('before' => 'auth|csrf', function()
    {
        //
    }));

#### Passage de paramètre à un filtre :

    Route::get('panel', array('before' => 'role:admin', function()
    {
        //
    }));

<a name="pattern-filters"></a>
## Filtres de modèles

Derrière ce nom un peu barbare, se cache une fonctionnalité fort pratique. Parfois vous souhaiteriez attacher un filtre à toutes les routes qui répondent à un modèle, par exemple, vous pourriez attacher un événement "auth" à toutes les URIs qui commencent par "admin". Voici comment faire avec Laravel :

#### Définition d'un filtre basé sur un modèle de route :

    Route::filter('pattern: admin/*', 'auth');

Optionnellement, vous pouvez enregistrer les filtres directement quand vous les attachez à une URI donnée, en passant en tant que second argument un tableau contenant le nom du filtre puis la fonction de callback.

#### Définition d'un filtre et d'un modèle de route en une fois :

    Route::filter('pattern: admin/*', array('name' => 'auth', function()
    {
        //
    }));

<a name="global-filters"></a>
## Filtres globaux

Laravel a deux filtres globaux qui s'exécutent **avant** et **après** toutes les requêtes de l'application. Vous trouverez ces deux filtres dans le fichier **application/routes.php**. Ces filtres sont un endroit idéal pour démarrer les bundles communs ou ajouter des assets globaux.

> **Note:** Les filtres **after** reçoivent en paramètre l'objet de type **Response** de la requête actuelle.

<a name="route-groups"></a>
## Routes groupées

Les routes groupées servent à attacher un certain nombre d'attributs à un groupe de routes, vous permettant de garder votre code propre et léger.

    Route::group(array('before' => 'auth'), function()
    {
        Route::get('panel', function()
        {
            //
        });

        Route::get('dashboard', function()
        {
            //
        });
    });

<a name="named-routes"></a>
## Route nommées

Écrire soit même ses liens et faire des redirections sur des URLs "hardcodées peut poser des problèmes si vous décidez un jour de changer le pattern de votre route. Laravel apporte une solution simple à ce problème : donner un nom à votre route. Ainsi dans votre application, vous pouvez faire référence à une route par son nom, et un changement de pattern sera alors immédiatement effectif.

#### Enregistrement d'une route nommée :

    Route::get('/', array('as' => 'home', function()
    {
        return "Hello World";
    }));

#### Génération d'une URL depuis le nom d'une route :

    $url = URL::to_route('home');

#### Redirection vers une route nommée :

    return Redirect::to_route('home');

Une fois que vous avez donné un nom à une route, vous pouvez facilement vérifier si la requête courante répond à une une route donnée :

#### Détermine si une route répond à la route nommée fournie :

    if (Request::route()->is('home'))
    {
        // La route "home" a interceptéé la requête !
    }

<a name="https-routes"></a>
## Routes HTTPS

Lorsque vous définissez une route, vous pouvez utiliser l'attribut https pour indiquer que le protocole HTTPS doit être utilisé lorsque vous générez l'URL ou créez une redirection vers cette route :

#### Définition d'une route HTTPS :

    Route::get('login', array('https' => true, function()
    {
        return View::make('login');
    }));

#### Utilisation de la méthode statique "secure", un raccourci pour l'attribut https:

    Route::secure('GET', 'login', function()
    {
        return View::make('login');
    });

<a name="bundle-routes"></a>
## Route de bundles

Les Bundles sont le système de paquets modulaires de Laravel. Les bundles peuvent facilement être configurés pour réagir à certaines requêtes, nous reviendrons sur les [bundles plus en détail](/docs/3/bundles) plus tard. Pour l'instant, lisez cette section et gardez en tête que vous pouvez enregistrer des routes pour mener aux fonctionnalités d'un bundle, mais vous pouvez également enregistrer vos routes directement dans le bundle.

Ouvrez le fichier **application/bundles.php** et ajoutez ceci :

#### Enregistrement d'un bundle qui réagit à des routes :

    return array(

        'admin' => array('handles' => 'admin'),

    );

Vous voyez la nouvelle option **handles** dans notre tableau de configuration du bundle ? Cela indique à Laravel de charger le bundle admin lorsque l'URI commence par "admin".

Maintenant, vous êtes prêt à enregistrer quelques routes pour votre bundle. Alors créez un fichier routes.php dans le répertoire de base de votre base, et ajoutez la route suivante :

#### Enregistre une route de base pour un bundle :

    Route::get('(:bundle)', function()
    {
        return 'Bienvenu dans le bundle Admin !';
    });

Concentrons nous sur cet exemple. Vous voyez le joker **(:bundle)** ? Cela sera remplacé par la valeur de l'option **handles** que vous définissez lors de l'enregistrement de votre bundle. Cela conserve votre code [D.R.Y.](http://fr.wikipedia.org/wiki/Ne_vous_r%C3%A9p%C3%A9tez_pas) et permet à ceux qui utilisent votre bundle de changer la base de l'URI savoir avoir à casser les routes ! Génial non ?

Bien sûr, vous pouvez utiliser le joker **(:bundle)** dans toutes vos routes, pas uniquemement dans la route de base :

#### Enregistrement d'une route du bundle :

    Route::get('(:bundle)/panel', function()
    {
        return "Je gère les requêtes sur admin/panel!";
    });

<a name="controller-routing"></a>
## Routage de contrôleur

Les contrôleurs fournissent une autre manière de géré la logique applicative. Si vous n'êtes pas familiarisé avec ce principe, vous devriez [vous renseigner sur les contrôleurs](/docs/3/controleurs) puis revenir ici.

Il est important de comprendre que dans Laravel, toutes les routes possibles doivent être définies, même les routes vers les contrôleurs. Cela signifie que les méthodes d'un contrôleur qui ne sont pas liées à une route **ne seront pas** accessibles. Il est possible d'exposer automatiquement toutes les méthodes d'un contrôleur dans Laravel, grâce au système d'enregistrement de routes de contrôleur. Comme toujours jusqu'ici pour les routes, toutes ces routes se trouvent par défaut dans **application/routes.php**.

En général, vous enregistrerez vos contrôleurs dans le dossier "controllers" de votre application. Pour exposer tous vos contrôleurs, vous pouvez utiliser la méthode suivante :

#### Enregistre tous les contrôleurs de l'application:

    Route::controller(Controller::detect());

La méthode **Controller::detect** retourne simplement un tableau de tous les contrôleurs qui se trouvent dans votre application.

Si vous souhaitez faire la même chose pour les contrôleurs d'un bundle, passez en argument à la méthode `detect` le nom du bundle. Si aucun bundle n'est spécifié, ce sont les contrôleurs du dossier **application/controllers** qui seront pris en compte ( comme dans l'exemple ci dessus ).

> **Note:** Il est important de noter que cette méthode ne vous donne **aucun** contrôle sur l'ordre dans lequel les contrôleurs seront chargés. Controller::detect() ne devrait être utilisé que sur des petits sites. Le routage "manuel" de contrôleurs vous donne beaucoup plus de maitrises, est plus facile à maintenir et est plutôt conseillé.

#### Enregistrement de tous les contrôleurs du bundle "admin" :

    Route::controller(Controller::detect('admin'));

#### Enregistrement du contrôleur "home" avec le routeur :

    Route::controller('home');

#### ENregistrement de plusieurs contrôleurs avec le routeur :

    Route::controller(array('dashboard.panel', 'admin'));

Une fois qu'un contrôleur est enregistré, vous pouvez y accéder en respectant une convention d'URI simple :

    http://votresite.tld/controller/method/arguments

Cette convention est similaire à celle employée par CodeIgniter et bien d'autres frameworks, où le premier segment correspond au nom du contrôleur, le second au nom de la méthode, et tous les segments suivants sont passés à la méthode en tant qu'arguments. Si aucun segment de méthode n'est utilisé, alors le comportement par défaut sera d'appeler la méthode "index".

Cette convention de routage peut ne pas convenir à toutes les situations, vous pouvez alors écrire des routes manuelles avec une syntaxe simple et intuitive :

#### Enregistrement d'une route qui pointe sur la méthode index du contrôleur home

    Route::get('welcome', 'home@index');

#### Enregistrement d'une route filtrée qui pointe vers un contrôleur :

    Route::get('welcome', array('after' => 'log', 'uses' => 'home@index'));

#### Enregistrement d'une route nommée qui pointe vers un contrôleur :

    Route::get('welcome', array('as' => 'home.welcome', 'uses' => 'home@index'));

<a name="cli-route-testing"></a>
## Test de route en CLI

Vous pouvez tester vos routes en utilisant l'outil CLI "Artisan" de Laravel. Vous aurez à préciser le verbe HTTP désiré ainsi que l'URI désirée, et la réponse vous sera **var_dump**ée en réponse directement dans votre console :

#### Appel d'une route via Artisan :

    php artisan route:call get user/1
