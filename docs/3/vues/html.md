# Construction de code HTML

## Au menu

- [Entités HTML](#entities)
- [Scripts et feuilles de style](#scripts-and-style-sheets)
- [Liens](#links)
- [Liens vers des routes nommées](#links-to-named-routes)
- [Liens vers des actions de contrôleur](#links-to-controller-actions)
- [Lien pour l'envoi d'email](#mail-to-links)
- [Images](#images)
- [Listes](#lists)
- [Fonctions persos](#custom-macros)

<a name="entities"></a>
## Entités HTML

Lorsque l'on affiche le résultat d'une entrée utilisateur dans notre vue, c'est important de convertir tous les caractères qui ont un sens en HTML en leur représentation en tant qu'entité HTML.

Par exemple, les symboles < et > doivent être représentés en tant que tel, et non interprétés en tant que "tag" d'ouverture et de fermeture de balise. Cela vous protège notamment du cross-site scripting:

#### Convertion d'une chaine en sa représentation en tant qu'entité HTML :

    echo HTML::entities('<script>alert('hi');</script>');

#### En utiliant l'helper "e" :

    echo e('<script>alert('hi');</script>');

<a name="scripts-and-style-sheets"></a>
## Scripts et feuilles de style

#### Génération d'une référence à un fichier javascript :

    echo HTML::script('js/scrollTo.js');

#### Génération d'une référence à un fichier CSS :

    echo HTML::style('css/common.css');

#### Génération d'une référence à un fichier CSS, en précisant le media type :

    echo HTML::style('css/common.css', array('media' => 'print'));

*Voir également:*

- *[Management des assets](/docs/3/vues/assets)*

<a name="links"></a>
## Liens

#### Génération d'un lien vers une URI :

    echo HTML::link('user/profile', 'Profil de l\'utilisateur');

#### Génération d'un lien HTTPS :

    echo HTML::link_to_secure('user/profile', 'Profil de l\'utilisateur');

#### Génération d'un lien, avec des attributs HTML :

    echo HTML::link('user/profile', 'Profil de l\'utilisateur', array('id' => 'profile_link'));

<a name="links-to-named-routes"></a>
## Liens vers des routes nommées

#### Génération d'un lien vers une route nommée :

    echo HTML::link_to_route('profile', 'Profil de l\'utilisateur');

#### Génération d'un lien vers une route nommée avec des paramètres :

    $url = HTML::link_to_route('profile', 'Profil de l\'utilisateur', array($username));

*Voir aussi:*

- *[Routes nommées](/docs/3/routes#named-routes)*

<a name="links-to-controller-actions"></a>
## Liens vers des actions de contrôleur

#### Génération d'un lien vers une action d'un contrôleur:

    echo HTML::link_to_action('home@index', 'Profil de l\'utilisateur');

### Génération d'un lien vers une action d'un contrôleur avec des paramètres :

    echo HTML::link_to_action('user@profile', 'Profil de l\'utilisateur', array($username));

<a name="links-to-a-different-language"></a>
## Liens vers un langage différent

#### Génère un lien vers la même page dans un langage différent:

    echo HTML::link_to_language('fr');

#### Génère un lien vers la page d'accueil dans un langage différent

    echo HTML::link_to_language('fr', true);

<a name="mail-to-links"></a>
## Lien pour l'envoi d'email

La méthode "mailto" de la classe HTML "crypte" l'adresse email donnée pour ne pas qu'elle soit aspirée par des robots.

#### Création d'un lien "mailto" :

    echo HTML::mailto('exemple@gmail.com', 'Contactez moi');

#### Création d'un lien "mailto" utilisant l'adresse email en tant que texte du lien :

    echo HTML::mailto('exemple@gmail.com');

<a name="images"></a>
## Images

#### Génération d'un tag HTML pour une image:

    echo HTML::image('img/smile.jpg', $alt_text);

#### Génération d'un tag HTML pour une image, avec des attributs HTML :

    echo HTML::image('img/smile.jpg', $alt_text, array('id' => 'smile'));

<a name="lists"></a>
## Listes

#### Création de listes depuis un tableau :

    echo HTML::ol(array('Element 1', 'Element 2', 'Element 3'));

    echo HTML::ul(array('Ubuntu', 'Snow Leopard', 'Windows'));

    echo HTML::dl(array('Ubuntu' => 'Un système d\'exploitation de Canonical', 'Windows' => 'Un système d\'exploitation de Microsoft'));

<a name="custom-macros"></a>
## Fonctions persos

Il est très facile de créer ses propres méthodes pour la classe HTML, nous appelons ces méthodes des "macros". Voilà comment ça marche : Premièrement, enregistrer la macro avec un nom donné et une fonction anonyme :

#### Enregistrement d'une macro HTML:

    HTML::macro('mon_element', function()
    {
        return '<article type="genial">';
    });

Maintenant, vous pouvez appeler votre macro par son nom :

#### Appel de notre macro :

    echo HTML::mon_element();
