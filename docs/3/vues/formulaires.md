# Construction de formulaires

## Au menu

- [Ouvrir un formulaire](#opening-a-form)
- [Protection contre les attaques CSRF](#csrf-protection)
- [Labels](#labels)
- [Texte, Textarea, Mots de passes & champs cachés](#text)
- [Checkboxes et boutons radio](#checkboxes-and-radio-buttons)
- [Liste Select](#drop-down-lists)
- [Boutons](#buttons)
- [Macros](#custom-macros)

> **Note:** Toutes les données passées à un élément de formulaire sera **automatiquement** filtré via la méthode HTML::entities.

<a name="opening-a-form"></a>
## Ouvrir un formulaire

#### Ouverture d'un formulaire qui POST sur l'URL courante :

    echo Form::open();

#### Ouverture d'un formulaire utilisant une URI donnée avec un verbe HTTP donné :

    echo Form::open('user/profile', 'PUT');

#### Ouverture d'un formulaire qui POST sur une URL HTTPS :

    echo Form::open_secure('user/profile');

#### Précisions d'attributs HTML à la balise form :

    echo Form::open('user/profile', 'POST', array('class' => 'awesome'));

#### Ouverture d'un formulaire qui accepte l'upload de fichiers :

    echo Form::open_for_files('users/profile');

#### Ouverture d'un formulaire d'upload de fichier en HTTPS :

    echo Form::open_secure_for_files('users/profile');

#### Fermeture d'un formulaire:

    echo Form::close();

<a name="csrf-protection"></a>
## Protection contre les attaques CSRF

Laravel fournit une méthode simple pour protéger vos applications d'une attaque de type cross-site request forgeries. Premièrement, un jeton généré aléatoirement est placé dans la session de vos utilisateurs. Ceci est totalement automatique. Ensuite, utilisez la méthode token pour générer un champs caché qui contient le jeton aléatoire dans votre formulaire :

#### Génération d'un champ caché avec le jeton :

    echo Form::token();

#### Attachement du filtre CSRF à votre route :

    Route::post('profile', array('before' => 'csrf', function()
    {
        //
    }));

#### Retrouvez le jeton en session :

    $token = Session::token();

> **Note:** Vous devez préciser un driver de session avant d'utiliser la solution anti-CSRF de Laravel.

*Voir également:*

- [Filtres de routes](/docs/3/routes#filters)
- [Cross-Site Request Forgery](http://fr.wikipedia.org/wiki/Cross-site_request_forgery)

<a name="labels"></a>
## Labels

#### Génération d'un label :

    echo Form::label('email', 'Adresse e-Mail');

#### Ajout d'attributs HTML au label :

    echo Form::label('email', 'Adresse e-Mail', array('class' => 'awesome'));

> **Note:** Après avoir créé un label, n'importe quel élément de formulaire que vous crérez avec le même nom aura un ID qui aura pour valeur ce même nom.

<a name="text"></a>
## Texte, Textarea, Mot de passes & champs cachés

#### Génération d'un input de type 'text' :

    echo Form::text('username');

#### Précision d'une valeur par défault :

    echo Form::text('email', 'exemple@gmail.com');

> **Note:** Les méthodes *hidden* et *textarea* ont la même signature que la méthode *text*. Vous venez d'apprendre à utiliser trois méthodes pour le prix d'une !

#### Génération d'un input de type password :

    echo Form::password('password');

<a name="checkboxes-and-radio-buttons"></a>
## Checkboxes and boutons radio

#### Générating d'un checkbox :

    echo Form::checkbox('name', 'value');

#### Génération d'un checkbox coché par défault:

    echo Form::checkbox('name', 'value', true);

> **Note:** La méthode *radio* a la même signature que la méthode *checkbox*. Deux pour le prix d'un!

<a name="drop-down-lists"></a>
## Liste Select

#### Génération d'une liste Select depuis un tableau :

    echo Form::select('size', array('L' => 'Large', 'S' => 'Small'));

#### Génération d'une liste Select avec un élément sélectionné par défaut :

    echo Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S');

<a name="buttons"></a>
## Boutons

#### Génération d'un bouton submit :

    echo Form::submit('Click moi!');

> **Note:** Besoin de créer un simple bouton ? Essayez la méthode *button*. Elle a la même signature que *submit*.

<a name="custom-macros"></a>
## Macros

Vous pouvez créer facilement des macros pour la classe Form, de la même manière que pour les [macros HTML](/docs/3/vues/html#custom-macros) :

#### Enregistrement du macro :

    Form::macro('mon_champ', function()
    {
        return '<input type="awesome">';
    });

#### Appel du macro :

    echo Form::mon_champ();
