# Modèles & bibliothèque

## Au menu

- [Modèles](#models)
- [Bibliothèque](#libraries)
- [Auto-Loading](#auto-loading)

<a name="models"></a>
## Modèles

Les modèles sont le cœur de votre application. Votre logique applicative et vos vues sont juste les moyens par lesquels l'utilisateur interagit avec vos modèles. Il est responsable du traitement des données, des interactions avec la base de données, etc. Il contient également les règles métiers.

*Quelques exemples de fonctionnalités qui doivent se trouver dans un modèle:*

- Interaction avec la base de données
- Lecture et écriture dans un fichier
- Interaction avec des Web Services

Prenons l'exemple d'un blog. Vous aurez certainement un modèle "Post". Les utilisateurs voudraient pouvoir poster des commentaires, alors vous aurez un modèle "Comment". Si vous gérez des utilisateurs, alors il vous faudra également un modèle "User". Vous comprenez le principe ?

<a name="libraries"></a>
## Bibliothèque

Les bibliothèques sont de classes qui exécutent des tâches qui ne sont pas spécifiques à votre application. Par exemple, vous pourriez avoir une bibliothèque qui convertit du code HTML en PDF. Cette tâche n'est pas spécifique à votre application, alors il faut la considérer comme une bibliothèque.

Créer une bibliothèque, c'est simplement créer une classe et la stocker dans le dossier **libraries**. Dans l'exemple suivant, nous allons créer une bibliothèque avec une méthode qui écrit à l'écran le texte qui lui aura été fourni. Nous créons le fichier **printer.php** dans le dossier **libraries** avec le code suivant :

    <?php

    class Printer {

        public static function write($text) {
            echo $text;
        }
    }

Vous pouvez maintenant appeler Printer::write('Ce texte sera écrit depuis ma bibliothèque !!') depuis n'importe quel endroit de votre application.

<a name="auto-loading"></a>
## Auto Loading

Les bibliothèques et les modèles sont vraiment faciles à utiliser grâce à l'auto-loader de Laravel. Pour en apprendre plus sur l'auto-loader, regardez la [documentation de l'Autoloading](/docs/3/loading).
