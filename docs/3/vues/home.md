# Vues et réponses

## Au menu

- [Les bases](#the-basics)
- [Attacher des données à une vue](#binding-data-to-views)
- [Imbriquement de vues](#nesting-views)
- [Vues nommées](#named-views)
- [Composeur de vue](#view-composers)
- [Redirections](#redirects)
- [Redirection avec des données temporaires](#redirecting-with-flash-data)
- [Téléchargement](#downloads)
- [Erreurs](#errors)

<a name="the-basics"></a>
## Les bases

Les vues contiennent le code HTML qui sera envoyé à l'utilisateur de votre application. En séparant la vue des données métiers de votre application, votre code sera beaucoup plus clair et facile à maintenir.

Toutes les vues sont stockées dans le dossier **application/views** et utilisent l'extension .php . La classe **View** fournit une manière simple de retrouver vos vues et de les retourner à l'utilisateur, depuis votre logique applicative. Voyons un exemple :

#### Création d'une vue :

    <html>
        Je suis stocké dans views/home/index.php !
    </html>

#### Envoi de la vue depuis une route :

    Route::get('/', function()
    {
        return View::make('home.index');
    });

#### Envoi de la vue depuis un contrôleur :

    public function action_index()
    {
        return View::make('home.index');
    });

#### Détermine si une vue existe :

    $exists = View::exists('home.index');

Parfois vous aurez besoin d'un peu plus de contrôle sur la réponse qui sera envoyée au navigateur. Par exemple, vous pourriez avoir besoin de mettre certaines entêtes, ou de changer le code de status HTTP. Voici comment faire :

#### Retourne une réponse personnalisée:

    Route::get('/', function()
    {
        $headers = array('foo' => 'bar');

        return Response::make('Hello World!', 200, $headers);
    });

#### Retourne une réponse personnalisée contenant une vue, avec des données liées :

    return Response::view('home', array('foo' => 'bar'));

#### Retourne une réponse au format JSON :

    return Response::json(array('name' => 'Batman'));

#### Retourne une réponse au format JSONP :

    return Response::jsonp('myCallback', array('name' => 'Batman'));

#### Retourne une modèle Eloquent au format JSON :

    return Response::eloquent(User::find(1));

<a name="binding-data-to-views"></a>
## Attacher des données à une vue

Typiquement, une route ou un contrôleur va demander à un modèle de lui fournir des données à afficher. Une fois ces données en sa possession, il faudra les transmettre à la vue. Il y a plusieurs manières de faire cela avec Laravel, choisissez celle que vous préférez !

#### Attache des données à une vue:

    Route::get('/', function()
    {
        return View::make('home')->with('name', 'Jean');
    });

#### Accès aux données attachées depuis la vue :

    <html>
        Bonjour, <?php echo $name; ?>.
    </html>

#### Enchaînement d'attachement de données à une vue :

    View::make('home')
        ->with('name', 'Jean')
        ->with('votes', 25);

#### Passage d'un tableau pour attacher les données :

    View::make('home', array('name' => 'James'));

#### En utilisant les propriétés "magiques" :

    $view->name  = 'Jean';
    $view->email = 'exemple@exemple.fr';

#### En utilisant l'interface ArrayAccess :

    $view['name']  = 'Jean';
    $view['email'] = 'exemple@exemple.exemple';

<a name="nesting-views"></a>
## Imbriquement de vues

Vous serez souvent amené à inclure une vue dans une autre. Les vues imbriquées sont parfois appelées "partials", et aident à garder vos vues petites et modulaires.

#### Attachement d'une vue imbriquée en utilisant la méthode "nest" :

    View::make('home')->nest('footer', 'partials.footer');

#### Passage d'arguments à une vue imbriquée :

    $view = View::make('home');

    $view->nest('content', 'orders', array('orders' => $orders));

Vous pouvez également inclure une vue directement dans votre vue, grâce à la méthode "helper" **render** :

#### Utilisation de l'helper "render" pour inclure une vue :

    <div class="content">
        <?php echo render('user.profile'); ?>
    </div>

Il arrive aussi également que l'on veuille inclure une vue qui serait responsable de l'affichage d'un élément d'une liste. Cela se fait simplement grâce à l'helper **render_each** :

#### Affiche une vue partielle pour chaque élément d'un tableau :

    <div class="orders">
        <?php echo render_each('partials.order', $orders, 'order');
    </div>

Le premier argument est le nom de la vue, le second est le tableau de données, et le troisième est le nom de la variable qui sera utilisée dans la vue partielle.

<a name="named-views"></a>
## Vues nommées

Les vues nommées existent pour rendre votre code plus expressif et organisé. Les utiliser est très simple :

#### Enregistrement d'une vue nommée :

    View::name('layouts.default', 'layout');

#### Obtenir une instance d'une vue nommée :

    return View::of('layout');

#### Attachement de données à une vue nommée :

    return View::of('layout', array('orders' => $orders));

<a name="view-composers"></a>
## Composeur de vue

Chaque fois qu'une vue est créée, un événement "composer" est lancé pour cette vue. Vous pouvez utiliser cet événement pour attacher des assets, ou des données communes chaque fois que la vue est créée. Une utilisation pratique de cette fonctionnalité pourrait être d'attacher à notre vue une vue partielle avec une liste de billets de blog choisis au hasard. Vous pouvez inclure votre vue partielle en la chargeant dans votre layout. Ensuite, mettre en place un composeur pour cette vue partielle. Le composeur peut déclencher une requête via le modèle et rassembler toutes les données nécessaires à l'affichage de votre vue. Les composeurs sont généralement définis dans le fichier **application/routes.php**. Voici un exemple :

#### Enregistre un composeur de vue pour la vue "home" :

    View::composer('home', function($view)
    {
        $view->nest('footer', 'partials.footer');
    });

Maintenant, chaque fois que la vue "home" sera créée, l'instance de la classe View sera passée à la fonction anonyme, vous permettant de préparer la vue comme vous le souhaitez.

#### Enregistrement d'un composeur qui gère plusieurs vues :

    View::composer(array('home', 'profile'), function($view)
    {
        //
    });

> **Note:** Une vue peut avoir plus d'un composeur !

<a name="redirects"></a>
## Redirections

Vous avez sans doute remarqué que les routes et les contrôleurs doivent retourner une réponse via la directive php `return`. Pour faire une redirection, ce sera la même chose. Ainsi, plutôt que d'appeler "Redirect::to()" n'importe où et n'importe quand, vous devrez utiliser "return Redirect::to()". Cette distinction est importante car il en est autrement dans la plupart des autres frameworks PHP.

#### Redirection vers une autre URI :

    return Redirect::to('user/profile');

#### Redirection avec un statut HTTP spécifique :

    return Redirect::to('user/profile', 301);

#### Redirection vers une URI HTTPS:

    return Redirect::to_secure('user/profile');

#### Redirection vers la racine de votre application :

    return Redirect::home();

#### Redirection vers l'action précédente :

    return Redirect::back();

#### Redirection vers une route nommée :

    return Redirect::to_route('profile');

#### Redirection vers une action d'un contrôleur :

    return Redirect::to_action('home@index');

Parfois, vous devez rediriger vers une route nommée, mais également lui passer des paramètres. Voici comment faire :

#### Redirection vers une route nommée avec des valeurs :

    return Redirect::to_route('profile', array($username));

#### Redirection vers une action avec des paramètres :

    return Redirect::to_action('user@profile', array($username));

<a name="redirecting-with-flash-data"></a>
## Redirection avec des données temporaires

Après qu'un utilisateur ait créé son compte, ou qu'il se soit connecté à votre application, il arrive souvent qu'il tombe sur une page qui lui souhaite la bienvenue. Mais, comment passer ce message pour qu'il soit disponible lors de la prochaine requête ? Utilisez ma méthode with() pour envoyer des données temporaires lors de la redirection :

    return Redirect::to('profile')->with('status', 'Bienvenue !');

Vous aurez alors accès au message grâce à la méthode get de la classe Session :

    $status = Session::get('status');

*Voir aussi:*

- *[Sessions](/docs/3/session/config)*

<a name="downloads"></a>
## Téléchargement

#### Envoi un fichier à télécharger:

    return Response::download('file/path.jpg');

#### Envoi un fichier à télécharger, avec le nom donné :

    return Response::download('file/path.jpg', 'photo.jpg');

<a name="errors"></a>
## Erreurs

Pour générer une réponse d'erreur propre, utilisez la méthode error de la classe Response en lui spécifiant le numéro de statut HTTP de l'erreur. La vue correspondante stockée dans **views/error** sera automatiquement retournée.

#### Génère une erreur 404:

    return Response::error('404');

#### Génère une erreur 500:

    return Response::error('500');
