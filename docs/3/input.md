# Entrées et cookies

## Au menu

- [Entrées](#input)
- [Entrées en JSON](#json)
- [Fichiers](#files)
- [VIeilles entrées](#old-input)
- [Redirection avec de vieilles entrées](#redirecting-with-old-input)
- [Cookies](#cookies)
- [Fusion et remplacement](#merge)

<a name="input"></a>
## Input

La classe **Input** gère les entrées qui viennent à notre application via les requêtes GET, POST, PUT ou DELETE. Voici quelques exemples qui montrent comment accéder aux entrées avec la classe Input :

#### Retourne une valeur depuis le tableau d'entrée :

    $email = Input::get('email');

> **Note:** La méthode "get" est utilisée pour tous les types de requête (GET, POST, PUT, and DELETE), pas seulement pour les GET.

#### Retourne toutes les entrées :

    $input = Input::get();

#### Retourne toutes les entrées, incluant le tableau $_FILES :

    $input = Input::all();

Par défaut, *null* sera retourné si la clé n'existe pas. Vous pouvez passer en tant que second argument une valeur par défaut :

#### Retourne une valeur par défaut si la clé 'name' n'existe pas :

    $name = Input::get('name', 'Fred');

#### Utilisation d'une fonction anonyme pour retourner une valeur par défaut :

    $name = Input::get('name', function() {return 'Fred';});

#### Détermine si l'entrée contient la clé donnée :

    if (Input::has('name')) ...

> **Note:** La méthode "has" retournera *false* si l'entrée est une chaine de caractères vide.

<a name="json"></a>
## Entrées en JSON

Quand vous travaillez avec des frameworks javascript MVC tel que Backbone.js, vous aurez besoin de récupérer le JSON envoyé par l'application. Pour vous faciliter la vie, nous avons inclus la méthode `Input::json` :

#### Récupère l'entrée JSON :

    $data = Input::json();

<a name="files"></a>
## Fichiers

#### Retourne tous les éléments du tableau $_FILES :

    $files = Input::file();

#### Retourne un élément du tableau $_FILES :

    $picture = Input::file('picture');

#### Retourne une information précise du tableau $_FILES :

    $size = Input::file('picture.size');

<a name="old-input"></a>
## Vieilles entrées

Vous aurez couramment besoin de repeupler vos formulaires après qu'ils aient été refusés lors d'une soumission. La classe Input de Laravel a été conçue avec ce problème dans l'esprit. Voici un exemple de comment vous pouvez facilement retrouver les entrées de la requête précédente. Premièrement, vous avez besoin de "flasher" les entrées dans une session :

#### Insertion des entrées en session "flash" :

    Input::flash();

#### Insertion sélective des entrées en session "flash" :

    Input::flash('only', array('username', 'email'));

    Input::flash('except', array('password', 'credit_card'));

#### Retrouve les entrées flashées dans la requête précédente :

    $name = Input::old('name');

> **Note:** Vous devez spécifier un driver de session avant d'utiliser la méthode "old".

*Voir aussi :*

- *[Sessions](/docs/3/session/config)*

<a name="redirecting-with-old-input"></a>
## Redirection avec de vieilles entrées

Maintenant que vous savez comment flasher vos entrées en session, voici un raccourci qui vous permet de faire le flash automatiquement lors d'une redirection :

#### Flash des entrées dans une instance de redirection :

    return Redirect::to('login')->with_input();

#### Flash sélectif des données dans une instance de redirection :

    return Redirect::to('login')->with_input('only', array('username'));

    return Redirect::to('login')->with_input('except', array('password'));

<a name="cookies"></a>
## Cookies

Laravel fournit une couche de gestion des cookies vraiment simple à utiliser. Il y a cependant certaines choses à savoir avant de l'utiliser. Premièrement, tous les cookies Laravel contiennent une signature cryptée. Cela permet au framework de vérifier que le cookie n'a pas été modifié sur le poste du client. Secondement, lorsque vous posez un cookie, le cookie n'est pas immédiatement envoyé au navigateur, mais est mis en attente et est envoyé en même temps que la réponse. Cela signifie que vous ne pouvez pas déclarer un cookie et l'exploiter dans la même requête.

#### Retrouve la valeur d'un cookie :

    $name = Cookie::get('name');

#### Retourne une valeur par défaut si le cookie demandé n'existe pas :

    $name = Cookie::get('name', 'Fred');

#### Pose un cookie qui dure 60 minutes:

    Cookie::put('name', 'Fred', 60);

#### Crée un cookie "permanent" ( qui dure en fait, 5 ans ) :

    Cookie::forever('name', 'Fred');

#### Supression d'un cookie :

    Cookie::forget('name');

<a name="merge"></a>
## Fusion & remplacement

Parfois vous souhaitez fusionner ou remplacer les entrées actuelles. Voilà comment faire :

#### Fusion de nouvelles données dans l'input :

    Input::merge(array('name' => 'Spock'));

#### Remplace l'input par le tableau fourni :

    Input::replace(array('doctor' => 'Bones', 'captain' => 'Kirk'));

## Supression des entrées

Pour vider toutes les entrées de la requête courante, utilisez la méthode `clear` :

    Input::clear();
