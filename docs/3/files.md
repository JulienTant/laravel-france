# Travail avec des fichiers

## Au menu

- [Lecture](#get)
- [Écriture](#put)
- [Suppression](#delete)
- [Upload d'un fichier](#upload)
- [Extension d'un fichier](#ext)
- [Vérifier le type d'un fichier](#is)
- [Obtention du type MIME](#mime)
- [Copie de dossier](#cpdir)
- [Suppression de dossier](#rmdir)

<a name="get"></a>
## Lecture

#### Obtient le contenu d'un fichier :

    $contents = File::get('chemin/vers/fichier');

<a name="put"></a>
## Écriture

#### Ecrit dans un fichier :

    File::put('chemin/vers/fichier', 'contenu du fichier');

#### Ajout dans un fichier :

    File::append('chemin/vers/fichier', 'ajout au fichier');

<a name="delete"></a>
## Suppression

#### Supprime un fichier :

    File::delete('chemin/vers/fichier');

<a name="upload"></a>
## Upload d'un fichier

#### Déplace un fichier du tableau $_FILE vers un emplacement permanent :

    Input::upload('picture', 'chemin/vers/img', 'fichier.ext');

> **Note:** Vous pouvez facilement valider l'image mise en ligne grâce à la [classe Validator](/docs/3/validation).

<a name="ext"></a>
## Extension d'un fichier

#### Obtient l'extension d'un fichier :

    File::extension('picture.png');

<a name="is"></a>
## Vérifier le type d'un fichier

#### Détermine si un fichier est du type donné :

    if (File::is('jpg', 'chemin/vers/fichier.jpg'))
    {
        //
    }

La méthode **is** ne regarde pas uniquement l'extension. Elle vérifie aussi le type MIME grâce à l'extension Fileinfo de PHP.

> **Note:** Vous pouvez passer n'importe quelle extension définie dans le fichier **application/config/mimes.php** à la méthode **is**.
> **Note:** L'extension PHP Fileinfo est requise pour cette fonctionnalité. Plus d'information sur la [page Fileinfo de PHP.net](http://php.net/manual/fr/book.fileinfo.php).

<a name="mime"></a>
## Obtention du type MIME

#### Obtient le type MIME associé à une extension :

    echo File::mime('gif'); // retourne 'image/gif'

> **Note:** Cette méthode retourne simplement le type MIME défini dans le fichier **application/config/mimes.php**.

<a name="cpdir"></a>
## Copie de dossier

#### Copie récursivement un dossier vers une emplacement donné :

    File::cpdir($dossier, $destination);

<a name="rmdir"></a>
## Suppression de dossier

#### Supprime récursivement un dossier :

    File::rmdir($dossier);
