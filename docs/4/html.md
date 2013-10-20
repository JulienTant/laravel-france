# Formulaires & HTML

- [Ouverture d'un formulaire](#opening-a-form)
- [Protection CSRF](#csrf-protection)
- [Formulaire lié à un modèle](#form-model-binding)
- [Labels](#labels)
- [Texte, Textarea et champs cachés](#text)
- [Checkbox et boutons radios](#checkboxes-and-radio-buttons)
- [Fichiers](#file-input)
- [Listes de séléction](#drop-down-lists)
- [Boutons](#buttons)
- [Macros personnalisées](#custom-macros)

<a name="opening-a-form"></a>
## Ouverture d'un formulaire

**Ouverture d'un formulaire**

    {{ Form::open(array('url' => 'foo/bar')) }}
        //
    {{ Form::close() }}

Par défaut, la méthode `POST` sera utilisée ; cependant, vous êtes libre de spécifier une autre méthode :

    echo Form::open(array('url' => 'foo/bar', 'method' => 'put'))

> **Note:** Etant donné que les formulaires HTML ne supportent que les méthodes `POST`, les méthodes `PUT` et `DELETE` seront simulées en ajoutant un champ caché `_method` à votre formulaire.

Vous pouvez également ouvrir un formulaire qui pointe vers une route nommée ou une action de contrôleur :

    echo Form::open(array('route' => 'route.name'))

    echo Form::open(array('action' => 'Controller@method'))

Si votre formulaire contient un champ pour la mise en ligne de fichier, ajoutez l'option `files` à votre tableau :

    echo Form::open(array('url' => 'foo/bar', 'files' => true))

<a name="csrf-protection"></a>
## Protection CSRF

Laravel fournit une méthode simple pour protéger votre application des attaques Cross-Site Request Forgery. Premièrement, un jeton aléatoire est placé dans la session de l'utilisateur. Ne vous en inquiétez pas, cela se fait tout seul. Le jeton CSRF sera ajouté à vos formulaires en tant que champ caché automatiquement. Cependant, si vous souhaitez générer le code HTML pour le champ caché, vous pouvez utiliser la méthode `token` :

**Ajout du jeton CSRF à un formulaire**

    echo Form::token();

**Attache un filtre CSRF à une route**

    Route::post('profile', array('before' => 'csrf', function()
    {
        //
    }));

<a name="form-model-binding"></a>
## Formulaire lié à un modèle

Souvent, vous voudrez remplir un formulaire selon le contenu d'un modèle. Pour ce faire, utilisez la méthode `Form::model` :

**Ouverture d'un formulaire lié à un modèle**

    echo Form::model($user, array('route' => 'user.update'))

Maintenant, quand vous générez un élément de formulaire, comme un champ texte, la valeur du modèle qui correspond au nom du champ sera automatiquement défini comme la valeur du champ. Donc, par exemple, pour un champ texte nommé `email`, la valeur de l'attribut `email` du modèle User sera définie comme la valeur du champ. Cependant, il y a plus ! S'il y a un élément dans le flash de la Session qui correspond au nom du champ, cette valeur sera prioritaire sur celle du modèle. Les priorités sont les suivantes :

1. Données dans le flash de la session (vieilles données)
2. Valeurs passées explicitement
3. Données des attributs du modèle

Cela vous permet de construire des formulaires plus rapidement car cela lit les valeurs du modèle, et en plus cela re-remplit votre formulaire s'il y a une erreur de validation sur le serveur !

> **Note:** Lorsque vous utilisez `Form::model`, n'oubliez pas de fermer vos formulaires avec `Form::close` !

<a name="labels"></a>
## Labels

**Génération d'un label**

    echo Form::label('email', 'E-Mail Address');

**Ajour d'attributs HTML supplémentaires**

    echo Form::label('email', 'E-Mail Address', array('class' => 'awesome'));

> **Note:** Après avoir créé un label, n'importe quel élément du formulaire que vous créerez avec le même nom aura automatiquement l'ID correspondant au nom.

<a name="text"></a>
## Texte, Textarea et champs cachés

**Génération d'un champ de texte simple**

    echo Form::text('username');

**Ajout d'une valeur par défaut**

    echo Form::text('email', 'example@gmail.com');

> **Note:** Les méthodes *hidden* et *textarea* ont la même signature que la méthode *text*.

**Génération d'un champ mot de passe**

    echo Form::password('password');

<a name="checkboxes-and-radio-buttons"></a>
## Checkbox et boutons radios

**Génération d'un champ checkbox ou radio**

    echo Form::checkbox('name', 'value');
    echo Form::radio('name', 'value');

**Génération d'un champ checkbox ou radio coché**

    echo Form::checkbox('name', 'value', true);
    echo Form::radio('name', 'value', true);

<a name="file-input"></a>
## Fichiers

**Génération d'un champ fichier**

    echo Form::file('image');

<a name="drop-down-lists"></a>
## Listes de sélection

**Génération d'une liste de sélection**

    echo Form::select('size', array('L' => 'Large', 'S' => 'Small'));

**Génération d'une liste de sélection avec un champ sélectionné par défaut**

    echo Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S');

**Génération d'une liste avec groupes**

    echo Form::select('animal', array(
        'Cats' => array('leopard' => 'Leopard'),
        'Dogs' => array('spaniel' => 'Spaniel'),
    ));

<a name="buttons"></a>
## Boutons

**Génération d'un bouton submit**

    echo Form::submit('Click Me!');

> **Note:** Besoin de créer un élément "button" ? Essayez la méthode *button*. Elle a la même signature que *submit*.

<a name="custom-macros"></a>
## Macros personnalisées

Il est simple de définir vos propres helpers de classes de formulaire personnalisés appelés "macros". Voilà comment ça marche. Premièrement, enregistrez simplement la macro avec un nom et une fonction anonyme :

**Enregistrement d'une macro**

    Form::macro('myField', function()
    {
        return '<input type="awesome">';
    });

Maintenant, vous pouvez l'appeler par son nom :

**Appel d'une macro personnalisée**

    echo Form::myField();
