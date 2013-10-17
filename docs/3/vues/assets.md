# Management des assets

## Au menu

- [Enregistrement d'assets](#registering-assets)
- [Écriture des assets](#dumping-assets)
- [Gestion des dépendances](#asset-dependencies)
- [Conteneur d'assets](#asset-containers)
- [Assets de bundle](#bundle-assets)

<a name="registering-assets"></a>
## Enregistrement d'assets

La classe **Asset** fournit une manière simple de gérer le CSS et le Javascript utilisés par votre application. Pour enregistrer un asset, appelez simplement la méthode **add** de la classe **Asset** :

#### Enregistrement d'un asset :

    Asset::add('jquery', 'js/jquery.js');

La méthode **add** accepte trois paramètres. Le premier est le nom de l'asset, le second est le chemin de l'asset relatif au dossier **public**, et le troisième est une liste des dépendances de l'asset ( nous y reviendrons plus tard ). Remarquez que nous n'avons pas indiqué à la méthode s'il s'agissait d'un fichier Javascript ou CSS. En fait, la méthode *add** regardera l'extension du fichier pour déterminer son type.

<a name="dumping-assets"></a>
## Écriture des assets

Quand vous serez prêt à écrire les liens des assets enregistrés dans votre vue, utilisez les méthodes **styles** et **scripts** de la classe Asset :

#### Écriture des assets dans une vue :

    <head>
        <?php echo Asset::styles(); ?>
        <?php echo Asset::scripts(); ?>
    </head>

<a name="asset-dependencies"></a>
## Dépendances des assets

Vous pouvez spécifié lors de l'ajout d'un asset que ce dernier à des dépendances. Cela signifie que dans votre vue, les dépendances devront être affichées de manière prioritaires par rapport à ce dernier. La gestion de dépendances ne pourrait être plus simple qu'avec Laravel. Vous vous souvenez du name que vous avez donné à votre asset ? Vous pouvez le passer en tant que troisième argument de la fonction **add** pour déclarer une dépendance :

#### Enregistrement d'un asset qui a une dépendance :

    Asset::add('jquery-ui', 'js/jquery-ui.js', 'jquery');

Dans cet exemple, nous enregistrons l'asset **jquery-ui** et nous indiquons que ce dernier est dépendant de jquery. jQuery sera donc toujours déclaré dans notre vue **avant** jQuery UI. Besoin de déclarer plus d'une dépendance ? Pas de problème :

#### Enregistrement d'un asset qui a de multiples dépendances :

    Asset::add('jquery-ui', 'js/jquery-ui.js', array('first', 'second'));

<a name="asset-containers"></a>
## Conteneur d'assets

Pour augmenter le temps de réponse, les règles de bonnes pratiques nous indiquent qu'il faut écrire les fichiers javascript en bas du document HTML. Mais, comment faire si nous devons inclure certains fichiers dans la tête du document ? La classe Asset fournie une manière simple de gérer des conteneurs. Appelez simplement la méthode **container** sur la classe Asset et passez lui en argument un nom. Vous pouvez ajouter autant d'assets que vous le désirez à un conteneur, de la manière suivante :

#### Ajout d'un asset dans le conteneur d'assets footer :

    Asset::container('footer')->add('example', 'js/example.js');

#### Affichage des assets de type Javascript du conteneur 'footer' :

    echo Asset::container('footer')->scripts();

<a name="bundle-assets"></a>
## Assets de bundle

Avant d'apprendre comment ajouter et afficher les assets d'un bundle, vous devriez lire la documentation sur [la création et la publication d'assets de bundle](/docs/3/bundles#bundle-assets).

Lorsque vous enregistrez des assets, le chemin est relatif au dossier  **public**. Cependant, ceci n'est pas pratique lorsque l'on gère des assets de bundle, puisqu'ils se trouvent dans le dossier **public/bundles**. Laravel est là pour vous rendre la tache plus facile ! Vous pouvez créer un conteneur qui gérera les assets d'un de vos bundles :

#### Précise que le conteneur foo gère les assets du bundle admin:

    Asset::container('foo')->bundle('admin');

Maintenant, vous pouvez utiliser des chemins relatifs au dossier public du bundle, Laravel génèrera les chemins corrects.
