# Contrôleurs

## Au menu

- [Les bases](#the-basics)
- [Routage de contrôleur](#controller-routing)
- [Contrôleurs de Bundle](#bundle-controllers)
- [Filtres d'actions](#action-filters)
- [Contrôleurs imbriqués](#nested-controllers)
- [Contrôleurs RESTful](#restful-controllers)
- [Injection de dépendancee](#dependency-injection)
- [Usine de contrôleur](#controller-factory)

<a name="the-basics"></a>
## Les bases

Les contrôleurs sont des classes qui sont responsables d'accepter les entrées des utilisateurs, de manager les interactions entre les modèles, les bibliothèques et les vues. Typiquement, ils vont demander des données à un modèle, et ensuite retourner une vue qui présente les données à l'utilisateur dans un format convenu ( html, xml, json... ).

L'usage de contrôleurs est la méthode la plus courante pour implémenter la logique applicative dans le développement web moderne. Cependant, vous avez également vu dans le chapitre précédent qu'avec Laravel, vous avez la possibilité d'implémenter la logique directement dans le routage. Lors de la création d'une véritable application web, nous vous encourageons à utiliser principalement les contrôleurs. Tout ce que vous pouvez faire dans une application basée sur les routes peut être également fait avec une application où votre code se trouve dans les contrôleurs.

Les contrôleurs doivent être placés dans le dossier **application/controllers** et doivent hériter de la classe Base\_Controller. Une classe Home\_Controller est inclue dans le package de base de Laravel.

#### Création d'un simple contrôleur.

    class Admin_Controller extends Base_Controller
    {

        public function action_index()
        {
            //
        }

    }

Les **Actions** sont le nom donné aux méthodes qui doivent être accessibles via le web. Les actions doivent toujours commencer par le préfixe "action\_". Toutes les autres méthodes, peu importe qu'elles soient publiques ou privées, ne seront pas accessibles via le web.

> **Note:** La classe Base\_Controller hérite de la classe de base **Controller** de Laravel, et est un emplacement idéal pour placer toutes les méthodes qui sont communes à plusieurs contrôleurs.

<a name="controller-routing"></a>
## Routage de contrôleur

Il est important de comprendre que dans Laravel, toutes les routes possibles doivent être définies, même les routes vers les contrôleurs.

Cela signifie que les méthodes d'un contrôleur qui ne sont pas liées à une route **ne seront pas** accessibles. Il est possible d'exposer automatiquement toutes les méthodes d'un contrôleur dans Laravel, grâce au système d'enregistrement de routes de contrôleur. Comme toujours jusqu'ici pour les routes, toutes ces routes se trouvent par défaut dans **application/routes.php**.

Regardez la [page sur le routage](/docs/3/routes#controller-routing) pour plus d'informations.

<a name="bundle-controllers"></a>
## Contrôleurs de Bundle

Les Bundles sont le sytème de paquets modulaires de Laravel. Les bundles peuvent facilement être configurés pour réagir à certaines requêtes, nous reviendrons sur les [bundles plus en détail](/docs/3/bundles) plus tard.

Créer un contrôleur qui appartient à un bundle est quasiment identique au fait de créer un contrôleur pour votre application. Il faut préfixer le nom du contrôleur avec le nom du bundle, si vous souhaitez créer un contrôleur Home dans le bundle admin, votre classe ressemblera à cela :

#### Création d'un contrôleur de bundle :

    class Admin_Home_Controller extends Base_Controller
    {

        public function action_index()
        {
            return "Bonjour Admin!";
        }

    }

Mais, comment enregistrer un contrôleur de bundle dans le routeur ? En fait, c'est assez simple, voyez par vous même :

#### Enregistrement d'un contrôleur de bundle avec le routeur :

    Route::controller('admin::home');

Bien, nous pouvons maintenant accéder à notre contrôleur de bundle via le web !

> **Note:** Avec Laravel, les doubles deux points sont utilisés pour désigner les bundles. Plus d'informations sur les bundles peuvent être trouvés dans la [documentation des bundles](/docs/3/bundles).

<a name="action-filters"></a>
## Filtre d'actions

Les filtres d'actions sont des méthodes qui peuvent être exécutées avant ou après l'exécution d'une action. Avec Laravel, vous n'avez pas uniquement le contrôle sur quels filtres sont assignés à quelles actions, vous pouvez également choisir quels verbes HTTP ( get, post, put ou delete ) vont activer un filtre.

Vous pouvez assigner un filtre "before" ou "after" aux actions d'un contrôleur directement dans le constructeur du contrôleur.

#### Atachement d'un filtre sur toutes les actions :

    $this->filter('before', 'auth');

Dans cet exemple, le filtre 'auth' sera exécuté avant chaque action de ce contrôleur. Le filtre 'auth' est fourni d'origine par Laravel et peut être trouvé dans **application/routes.php**.  Il vérifie qu'un utilisateur est connecté et les redirige vers 'login' s'ils ne le sont pas.

#### Attachement d'un filtre pour quelques actions :

    $this->filter('before', 'auth')->only(array('index', 'list'));

Dans cet exemple, le filtre 'auth' sera exécuté avant que `action_index()` ou `action_list()` ne le soit. Les utilisateurs doivent être connectés pour accéder à ces pages. Cependant, les autres actions de ce contrôleur sont accessibles à tout le monde.

#### Attachement d'un filtre à tous les méthodes, sauf quelques unes :

    $this->filter('before', 'auth')->except(array('add', 'posts'));

Cette fois-ci, le filtre 'auth' sera exécuté sur toutes les actions, sauf sur les actions `action_add()` et `action_posts()`. Parfois il est plus sûr d'utiliser 'except()', notamment si l'on ajoute une nouvelle action et que l'on oublie de la placer dans 'only()'. Cela pourrait rendre certaines actions accessibles à des utilisateurs qui ne sont pas identifiés.

#### Attachement d'un first qui s'exécute lors d'une requête POST :

    $this->filter('before', 'csrf')->on('post');

Cet exemple nous montre comment un filtre peut être executé uniquement lors de l'utilisation d'un verbe HTTP précis. Dans ce cas, nous utilisons le filtre csrf seulement lorsqu'une requête POST est effectuée. Le filtre csrf, qui est également fourni par défaut, et visible dans le fichier **application/routes.php**. Il est conçu pour empêcher des requêtes POST qui proviennent de systèmes externes (bot de spam par exemple).

*Voir également:*

- *[Filtres de routes](/docs/3/routes#filters)*

<a name="nested-controllers"></a>
## Contrôleurs imbriqués

Les contrôleurs peuvent être placés dans des sous répertoires du dossier principal **application/controllers**.

#### Définition d'un contrôleur se trouvant dans le fichier **controllers/admin/panel.php**.

    class Admin_Panel_Controller extends Base_Controller
    {

        public function action_index()
        {
            //
        }

    }

#### Enregistrement du contrôleur imbriqué dans le routeur en utilisant la syntaxe "point" :

    Route::controller('admin.panel');

> **Note:** Quand vous utilisez les contrôleurs imbriqués, enregistrez les toujours du plus imbriqué au moins imbriqué, afin d'éviter que certaines routes ne soient interceptées par le mauvais contrôleur.

#### Accès à l'action "index" du contrôleur :

    http://localhost/admin/panel(/index)

<a name="restful-controllers"></a>
## Contrôleur RESTful

Grâce aux contrôleurs RESTful, plutôt que de préfixer vos actions avec "action_", vous avez la possibilité de les préfixer avec des verbes HTTP.

#### ajout de la propriété $restful au contrôleur :

    class Home_Controller extends Base_Controller
    {

        public $restful = true;

    }

#### Construction d'un contrôleur RESTful :

    class Home_Controller extends Base_Controller
    {

        public $restful = true;

        public function get_index()
        {
            //
        }

        public function post_index()
        {
            //
        }

    }

Ceci est particulièrement pratique lorsque vous construisez des méthodes CRUD ( Create, Read, Update, Delete ), car vous pouvez séparer la logique selon le verbe HTTP, et avoir pour une même route, une méthode qui fournit le formulaire ( get_ ) et une qui valide les données ( post_ ).

<a name="dependency-injection"></a>
## Injection de dépendance

Si vous souhaitez écrire des tests unitaires, vous allez probablement avoir besoin d'utiliser l'injection de dépendance dans le constructeur de votre contrôleur. Pas de problème, enregistrez juste votre contrôleur dans le  conteneur IoC [IoC container](/docs/3/ioc). Lorsque vous enregistrez votre contrôleur dans le conteneur, préfixez le avec la clé **controller**. Dans votre fichier **application/start.php**, vous pouvez enregistrer vos contrôleurs de la manière suivante :

    IoC::register('controller: user', function()
    {
        return new User_Controller;
    });

Lorsqu'une requête vers un contrôleur entre dans votre application, Laravel va automatiquement déterminer si le contrôleur est enregistré dans le conteneur, et si il l'est, il va utiliser le conteneur pour résoudre une instance du contrôleur.

> **Note:** Avant de vous lancer dans l'injection de dépendance de contrôleurs, vous pouvez lire un peu la documentation du superbe [IoC container](/docs/3/ioc) de Laravel.

<a name="controller-factory"></a>
## Usine de contrôleur

Si vous souhaitez encore plus de contrôle lors de l'instanciation de vos contrôleurs, pour utiliser par exemple un conteneur IoC tiers, vous devrez utiliser le "Controller Factory" de Laravel.

**Enregistrement d'un événement qui gère l'instanciation de contrôleurs :**

    Event::listen(Controller::factory, function($controller)
    {
        return new $controller;
    });

L’événement va recevoir le nom de la classe qui doit être résolue. Tout ce que avez à faire est de retourner une instance du contrôleur.
