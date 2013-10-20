# IoC Container

- [Introduction](#introduction)
- [Utilisation basique](#basic-usage)
- [Résolution automatique](#automatic-resolution)
- [Usage pratique](#practical-usage)
- [Fournisseur de services](#service-providers)
- [Evénements du conteneur](#container-events)

<a name="introduction"></a>
## Introduction

Le conteneur d'inversion de contrôle de Laravel est un outil puissant pour gérer les dépendances des classes. L'injection de dépendance est une méthode pour supprimer les dépendances hardcodées. A la place, les dépendances sont injectées à l'exécution, vous permettant d'avoir une grande flexibilité étant donné que les dépendances peuvent être échangées facilement.

Comprendre le conteneur IoC de Laravel est essentiel pour construire des applications larges et puissantes, et également pour contribuer au coeur du framework Laravel lui même.

<a name="basic-usage"></a>
## Utilisation basique

Il y a deux manières pour faire résoudre des dépendances au conteneur IoC : via des fonctions anonymes, ou alors en résolution automatique. Nous allons d'abord voir l'utilisation de fonctions anonymes. Premièrement, un "type" doit être lié dans le conteneur :

**Liaison d'un type dans le conteneur**

    App::bind('foo', function($app)
    {
        return new FooBar;
    });

**Résolution d'un type depuis le conteneur**

    $value = App::make('foo');

Quand la méthode `App::make` est appelée, la fonction anonyme est exécutée et le résultat est retourné.

Parfois, vous voudrez lier quelque chose dans le conteneur qui ne doit pas être instancié à chaque appel, mais vous souhaiteriez que la même instance soit retournée à chaque fois :

**Liaison d'un type "partagé" dans le conteneur**

    App::singleton('foo', function()
    {
        return new FooBar;
    });

Vous pouvez également lier un objet existant au conteneur en utilisant la méthode `instance` :

**Liaison d'un object existant dans le conteneur**

    $foo = new Foo;

    App::instance('foo', $foo);

<a name="automatic-resolution"></a>
## Résolution automatique

Le conteneur IoC est assez puissant pour résoudre des classes sans aucune configuration dans la plupart des cas. Par exemple :

**Résolution automatique d'une classe**

    class FooBar {

        public function __construct(Baz $baz)
        {
            $this->baz = $baz;
        }

    }

    $fooBar = App::make('FooBar');

Malgré que nous n'avons pas enregistré la classe FooBar dans le conteneur, ce dernier a réussi à résoudre la classe, et même à injecter la dépendance `Baz` automatiquement !

Quand un type n'est pas lié dans le conteneur, il utilisera la Reflexion PHP pour inspecter la classe et lire le typage objet implicite des paramètres du constructeur. En utilisant ces informations, le conteneur peut automatiquement construire une instance de cette classe.

Cependant, dans certains cas, une classe peut dépendre d'une interface et non d'un type "concret". Quand le cas se produit, la méthode `App::bind` peut être utilisée pour informer le conteneur de quelle implémentation de l'interface doit être injectée :

**Liaison d'une implémentation d'une interface**

    App::bind('UserRepositoryInterface', 'DbUserRepository');

Maintenant, imaginons le contrôleur suivant :

    class UserController extends BaseController {

        public function __construct(UserRepositoryInterface $users)
        {
            $this->users = $users;
        }

    }

Etant donné que nous avons lié l'interface `UserRepositoryInterface`, le type concret `DbUserRepository` sera automatiquement injecté dans ce contrôleur quand celui-ci sera créé.

<a name="practical-usage"></a>
## Usage pratique

Laravel fournit plusieurs opportunités d'utiliser le conteneur IoC pour augmenter la flexibilité et la testabilité de votre application. Un exemple peut être la résolution d'un contrôleur. Tous les contrôleurs sont résolus par le conteneur IoC, cela signifie que l'on peut utiliser le typage objet implicite dans le constructeur du contrôleur, et ils seront automatiquement injectés.

**Déclaration de dépendance par typage object implicite dans le contrôleur**

    class OrderController extends BaseController {

        public function __construct(OrderRepository $orders)
        {
            $this->orders = $orders;
        }

        public function getIndex()
        {
            $all = $this->orders->all();

            return View::make('orders', compact('all'));
        }

    }

Dans cet exemple, la classe `OrderRepository` sera automatiquement injectée dans le contrôleur. Cela signifie que lors des [tests unitaires](/docs/4/testing), une classe d'imitation (mock) `OrderRepository` peut être liée dans le conteneur et injectée dans le contrôleur, vous permettant de créer facilement des bouchons (stub) de la couche d'intéraction avec la base de données.

[Les filtres](/docs/4/routing#route-filters), [les composeurs](/docs/4/responses#view-composers), et [les gestionnaires d'événements](/docs/4/events#using-classes-as-listeners) peuvent également être résolus par le conteneur IoC. Lors de leur enregistrement, donnez simplement le nom de la classe qui doit être utilisée :

**Exemple d'utilisation de l'IoC**

    Route::filter('foo', 'FooFilter');

    View::composer('foo', 'FooComposer');

    Event::listen('foo', 'FooHandler');

<a name="service-providers"></a>
## Fournisseur de services

Les fournisseurs de services sont une bonne manière de grouper des enregistrements "liés" dans le conteneur IoC à un seul endroit. Pensez à eux comme étant une manière de charger des composants dans votre application. Dans un fournisseur de service, vous pouvez enregistrer un driver d'identification personnalisé, enregistrer les repositories de votre application dans le conteneur IoC, ou même définir une commande Artisan personnalisée.

En fait, une grande partie des composants du coeur du framework Laravel inclut un fournisseur de services. Tous les fournisseurs de services enregistrés dans votre application sont listés dans le tableau `providers` dans le fichier de configuration `app/config/app.php`.

Pour créer un fournisseur de service, votre classe doit hériter de la classe `Illuminate\Support\ServiceProvider` et définir une méthode `register` :

**Définition d'un fournisseur de service**

    use Illuminate\Support\ServiceProvider;

    class FooServiceProvider extends ServiceProvider {

        public function register()
        {
            $this->app->bind('foo', function()
            {
                return new Foo;
            });
        }

    }

Notez que dans la méthode `register`, le conteneur IoC de l'application est disponible via la propriété `$this->app`. Une fois que vous avez créé un fournisseur de service et êtes prêt à l'enregistrer dans votre application, ajoutez le simplement dans le tableau `providers` du fichier de configuration `app`.

Vous pouvez également enregistrer un fournisseur de service lors de l'exécution de la méthode `App::register` :

**Enregistrement d'un fournisseur de service lors de l'exécution**

    App::register('FooServiceProvider');

<a name="container-events"></a>
## Evénements du conteneur

Le conteneur lance des événements chaque fois qu'il résout un objet. Vous pouvez écouter cet événement en utilisant la méthod `resolving` :

**Enregistrement d'un écouteur de résolution**

    App::resolving(function($object)
    {
        //
    });

Notez que l'objet qui a été résolu va être passé à la fonction de rappel (callback).
