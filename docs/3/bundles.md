# Bundles

## Au menu

- [Les bases](#the-basics)
- [Création de bundles](#creating-bundles)
- [Enregistrement de bundles](#registering-bundles)
- [Bundles & chargement de classes](#bundles-and-class-loading)
- [Démarrage de bundles](#starting-bundles)
- [Routage de bundles](#routing-to-bundles)
- [Utilisation de bundles](#using-bundles)
- [Assets de bundles](#bundle-assets)
- [Installation de bundles](#installing-bundles)
- [Mise à jour de bundles](#upgrading-bundles)

<a name="the-basics"></a>
## Les bases

Les bundles sont le coeur des améliorations apportées à Laravel 3.0. Ils sont un moyen simple de grouper ce qui appartient à un même module. Un bundle peut avoir ses propres vues, sa configuration, ses routes, ses migrations, ses tâches, etc…  Un bundle peut être tout ce que vous souhaitez, d'un ORM à un système complet d'authentification. La modularité est un aspect important qui a virtuellement conduit toutes les décisions de conception de Laravel. En fait, vous pouvez imaginer que le dossier application est un bundle spécial fourni par Laravel, qui est pré-programmé et prêt à être utilisé.

<a name="creating-and-registering"></a>
## Création de bundles

La première étape pour créer un bundle est de créer un dossier pour ce dernier dans le répertoire **bundles**. Pour cet exemple, créons un bundle "admin", dans lequel sera logé le backend de notre application. Le fichier **application/start.php** fournit quelques options de configuration qui nous aident à définir comment va fonctionner notre application. De la même manière, nous allons créer un fichier **start.php** à la racine de notre bundle, qui aura le même rôle. Ce fichier est exécuté chaque fois que notre bundle est chargé.

#### Création du fichier start.php de note bundle:

    <?php

    Autoloader::namespaces(array(
        'Admin' => Bundle::path('admin').'models',
    ));

Dans ce fichier de démarrage, nous informons l'autoloader que les classes du namespace Admin doivent être chargées dans le dossier models de notre bundle. Vous pouvez faire ce que vous souhaitez dans votre fichier de démarrage, mais en général il est utilisé pour enregistrer vos classes dans l'autoloader. **En fait, vous n'êtes même pas obligé de créer le fichier start.php.**

Maintenant, nous allons voir comment enregistrer ce bundle dans notre application !

<a name="registering-bundles"></a>
## Enregistrement de bundles

Maintenant que nous avons notre bundle "admin", nous devons le déclarer avec Laravel. Ouvrez le fichier **application/bundles.php**. Ce fichier est l'endroit où vous enregistrerez tous les bundles utilisés pour votre application. Ajoutons le notre :

#### Déclaration simple d'un bundle :

    return array('admin'),

Par convention, Laravel va charger le bundle directement à la racine du dossier bundles. Vous trouverez ci dessous un exemple montrant comment changer ce chemin pour votre bundle :

#### Déclaration d'un bundle avec une chemin personnalisé :

    return array(

        'admin' => array('location' => 'userscape/admin'),

    );

Maintenant, Laravel chargera ce bundle depuis **bundles/userscape/admin**.

<a name="bundles-and-class-loading"></a>
## Bundles & chargement de classes

Typiquement, le fichier **start.php** d'un bundle contient uniquement les déclarations d'autoloading des classes. Vous pouvez alors ne pas créer le fichier **start.php** et déclarer les règles d'autoloading lors de la déclaration de votre bundle. Voici comment faire :

#### Définition de l'autoloading dans l'enregistrement du bundle :

    return array(

        'admin' => array(
            'autoloads' => array(
                'map' => array(
                    'Admin' => '(:bundle)/admin.php',
                ),
                'namespaces' => array(
                    'Admin' => '(:bundle)/lib',
                ),
                'directories' => array(
                    '(:bundle)/models',
                ),
            ),
        ),

    );

Remarquez que chacune de ces options correspond à une fonction de [l'autoloader](/docs/3/loading) Laravel. En fait, les valeurs de ces options seront automatiquement passées aux méthodes de l'autoloader.

Vous avez probablement remarqué le joker **(:bundle)**. Celui-ci sera automatiquement remplacé par le chemin du bundle. Un vrai jeu d'enfant !

<a name="starting-bundles"></a>
## Démarrage de bundles

Notre bundle est créé et déclaré, mais nous ne pouvons pas encore l'utiliser. Nous devons d'abord le démarrer :

#### Démarrage d'un bundle :

    Bundle::start('admin');

Cela demande à Laravel d'exécuter le fichier **start.php** du bundle, qui enregistrera les règles d'autoloading des classes. La méthode start charge également le fichier **routes.php** s'il existe.

> **Note:** Le bundle ne peut être démarré qu'une fois. Si vous effectuez d'autres appels, ils seront ignorés.

Si vous utilisez un bundle partout dans votre application, vous devrez alors le démarrer à chaque requête. Dans ce cas, vous pouvez configurer le bundle pour qu'il démarre automatiquement dans votre fichier **application/bundles.php** :

#### Configuration d'un bundle pour un démarrage automatique :

    return array(

        'admin' => array('auto' => true),

    );

En vrai, vous n'avez pas besoin de le démarrer explicitement. Vous pouvez simplement partir du principe qu'il est démarré, et si vous essayez d'utiliser une vue, un fichier de configuration, de traduction, une route ou un filtre d'un bundle, Laravel le démarrera automatiquement pour vous !

Chaque fois qu'un bundle est démarré, un événement est lancé. Vous pouvez suivre cet événement de la manière suivante :

#### Ecoute l'événement de démarrage d'un bundle :

    Event::listen('laravel.started: admin', function()
    {
        // The "admin" bundle has started...
    });

Il est également possible de désactiver un bundle, afin qu'il ne soit jamais démarré.

#### Désactive un bundle pour qu'il ne puisse pas être démarré :

    Bundle::disable('admin');

<a name="routing-to-bundles"></a>
## Routage de bundles

Veuillez vous référer à la documentation sur [le routage de bundles](/docs/3/routes#bundle-routes) et [les contrôleurs de bundles](/docs/3/controleurs#bundle-controllers) pour plus d'informations.

<a name="using-bundles"></a>
## Utilisations de bundles

Comme indiqué précédemment, les bundles peuvent contenir des vues, des fichiers de configuration, de langue, et plus encore. Laravel utilise la syntaxe **::** pour les charger. Voyons quelques exemples :

#### Charge une vue d'un bundle :

    return View::make('bundle::view');

#### Charge une option d'un fichier de configuration d'un bundle :

    return Config::get('bundle::file.option');

#### Charge une ligne d'un fichier de langue d'un bundle :

    return Lang::line('bundle::file.line');

Parfois vous souhaitez rassembler des informations "meta" à propos d'un bundle, tel que le fait qu'il existe, sa localisation, son tableau de configuration complet… voici comment faire :

#### Détermine si un bundle existe :

    Bundle::exists('admin');

#### Retrouve la localisation d'un bundle :

    $location = Bundle::path('admin');

#### Retrouve le tableau de configuration d'un bundle :

    $config = Bundle::get('admin');

#### Retrouve le nom de tous les bundles installés :

    $names = Bundle::names();

<a name="bundle-assets"></a>
## Assets de bundle

Si votre bundle contient des vues, il est possible que vous ayez des assets, tel que des fichiers javascripts et des images que vous avez besoin de rendre disponibles dans le dossier **public** de l'application. Pas de problème, créez simplement un dossier public dans votre bundle et placez vos bundles à l'intérieur.

Mais, comment les rendre disponibles dans le dossier **public** de l'application ? L'outil en ligne de commande "Artisan" fournit une commande simple pour copier tous les assets de votre bundle vers le dossier public.

#### Publie les assets d'un bundle dans le dossier public:

    php artisan bundle:publish

Cette commande crée un dossier pour les assets du bundle dans le dossier **public/bundles** de l'application. Par exemple, si votre bundle s'appelle "admin", alors le dossier **public/bundles/admin** sera créé, et contiendra tous les fichiers du dossier public de votre bundle.

Pour plus d'informations sur l'exploitation d'assets de bundle, référez vous à la documentation sur [le management d'assets](/docs/3/vues/assets#bundle-assets).

<a name="installing-bundles"></a>
## Installation de bundles

Bien sûr, vous pouvez installer les bundles manuellement, nous avons appris comment faire dans ce document. Cependant, "Artisan" fournit une méthode géniale pour installer et mettre à jour vos bundles. Le framework utilise un simple dézippage pour installer les bundles. Voilà comment faire :

#### Installe un bundle via Artisan:

    php artisan bundle:install eloquent

Bien, maintenant que votre bundle est installé, vous êtes prêt pour [l'enregistrer](#registering-bundles) et [publier ses assets](#bundle-assets).

Pour obtenir une liste des assets disponibles, rendez vous sur le [répertoire de bundles Laravel[en]](http://bundles.laravel.com)

<a name="upgrading-bundles"></a>
## Mise à jour d'un bundle

Quand vous mettez à jour un Bundle, Laravel va en fait supprimer la vieille version et réinstaller une copie à jour.

#### Mise à jour via Artisan:

    php artisan bundle:upgrade eloquent

> **Note:** Après la mise à jour d'un bundle, vous devez [republier ses assets](#bundle-assets).

**Important:** Etant donné que lors d'une mise à jour, le bundle est complètement supprimé, les changements que vous avez apporté seront perdus. Il arrive parfois qu'il faille mettre à jour le fichier de configuration d'un bundle. Plutôt que de modifier le bundle directement, utilisez l'événement start pour configurer vos options. Placez quelque chose comme cela dans le fichier  **application/start.php** :

#### Ecoute pour l'événement de démarrage d'un bundle :

    Event::listen('laravel.started: admin', function()
    {
        Config::set('admin::file.option', true);
    });
