# Documentation de Laravel 3

## Au menu

- [Le choix d'un framework](#le-choix-d-un-framework)
- [Pourquoi Laravel ?](#pourquoi-Laravel)
- [Laravel est différent](#Laravel-est-different)
- [Structure de l'application](#structure-de-l-application)
- [La communauté Laravel](#Laravel-community)
    - [Laravel France](#Laravel-France)
- [Licence](#Laravel-license)

<a name="le-choix-d-un-framework"></a>
## Le choix d'un framework

Il existe une multitude de frameworks PHP, plus ou moins lourds et offrant différentes fonctionnalités et modes de fonctionnement. Le choix d'un framework n'est pas un choix aisé, il faut savoir prendre le temps d'en appréhender quelqu'uns pour pouvoir choisir celui qui nous correspond le mieux. Plusieurs critères entrent en compte : la lisibilité du code, la facilité d'apprentissage, la documentation, les outils fournis par le framework...

Je ne prendrais malheureusement pas le temps de vous présenter différents frameworks, uniquement celui pour lequel vous êtes sans doute sur ce site : Laravel


<a name="pourquoi-Laravel"></a>
## Pourquoi Laravel?

Nous aimons php, mais il faut bien avouer que ce langage a des défauts. Un exemple concret : nous connaissons la fonction `str_replace` qui remplace toutes les occurences d'une chaine dans une autre. Et nous connaissons également `strtolower`, qui prend une chaine de caractères et le transforme en minuscule. Quel est le problème ? il n'y a aucune cohérence dans le nom de ces fonctions ! Ce n'est qu'un petit échantillon, nous aurions également pu parler des noms d'erreur incompéhensible (ex: T_PAAMAYIM_NEKUDOTAYIM)...
Laravel nous apporte une solution, avec une approche qui rend la compréhension du code intuitive, presque naturelle. Le framework est aussi doté d'outils puissants, que vous aurez l'occasion de découvrir dans ce guide.

<a name="Laravel-est-different"></a>
## Laravel est différent

Il y a beaucoup de choses qui rendent Laravel différent des autres frameworks, jetez un oeil par vous même:

- **Les bundles** sont des 'plugins' pour Laravel. [Le dépôt de bundle Laravel](http://bundles.laravel.com/) contient déjà un certain nombre de bundles qui peuvent être ajoutés facilement à votre application web. Vous pouvez télécharger votre bundle directement depuis internet, en le téléchargeant dans le dossier /bundles, ou utiliser "Artisan", l'outil en ligne de commande pour automatiser le téléchargement de celui-ci.
- **L'ORM Eloquent**, qui est l'implémentation d'ActiveRecord la plus complète disponible en PHP ! Avec sa capacité d'appliquer des contraintes de relations des plus simples aux plus complexes, et son système de chargement imbriqué, vous obtenez un contrôle complet sur vos données avec tout le confort d'utilisation d'ActiveRecord. Eloquent supporte nativement toutes les méthodes de Fluent, le générateur de requête de Laravel.
- **La logique applicative** ( ou logique de contrôle ) peut être placée soit dans un controller (ce qui est la norme chez les développeurs avec le modèle MVC) ou directement dans la déclaration de la route, grâce aux fonctions anonymes. Vous avez alors grâce à Laravel la possible liberté de choisir un modèle qui correspond le mieux au besoin de votre site, qu'il soit gros ou petit.
- **Les routes nommées** vous donne la possibilité de nommer une route 'login' et de demander au framework d'appeler la route nommée 'login', ainsi vous pouvez changer à volonté le design de la route, vos liens resteront corrects.
- **Les controlleurs RESTful** sont une option disponible pour séparer la logique applicative des requêtes GET et POST. Ainsi dans un controlleur de login, la méthode get_login() aura pour rôle de fournir le formulaire, tandis que la méthode post_login() traitera ce dernier, le validera et redirigera l'utilisateur en fonction du résultat.
- **Le chargement automatique de classes** nous permet de ne pas avoir à maintenir un fichier de chargement automatique, ou à faire des includes dans chacune de nos classes. Vous avez besoin d'utiliser un modèle ? Ne vous embêtez pas à le charger, Laravel s'occupe de tout !
- **Les composeurs de vues** sont des blocks de codes qui sont exécutés lorsqu'une vue est chargée. Un bon exemple serait une sidebar dans un blog, qui afficherait des articles au hasard. Le composeur contiendra le code qui chargera ces articles au hasard. Cela vous permet de ne pas avoir ce code dans votre controlleur principal, alors qu'il n'a aucun lien direct avec la méthode appelée.
- **Le conteneur IoC** (Inversion de Contrôle) est un injecteur de dépendances, qui vous permet donc de générer des objets, et également d'instancier des singletons. Grâce à l'IoC, vous ne devriez que très rarement instancié des bibliothèques externes. Cela signifie également que ces objets sont accessibles partout dans votre code, le rendant ainsi plus flexible et moins monolithique. 
- **Les migrations** vous permettent de garder le contrôle sur l'évolution des tables de votre base de données. Vous pouvez les générer et les exécuter grâce à l'outil en ligne de commande "Artisan". En équipe, quand votre collègue récupère le projet, il n'aura plus qu'à lancer l'execution de l'outil de migration et sa base de données sera à jour !
- **Les tests unitaires** ont une place très importante pour Laravel. Le framework Laravel contient lui même une batterie d'une centaine de tests pour s'assurer que les changements apportés à ce dernier ne cassent rien. Laravel vous fournit grâce à "Artisan", l'outil en ligne de commande, la possibilité d'exécuter facilement vos tests.
- **La pagination automatique** est utile pour ne pas avoir à gérer la logique de pagination. A la place d'obtenir le nombre d'enregistrements dans la base de données puis de sélectionner les données avec un offset et une limite, appelez simplement `paginate` et dites à Laravel où écrire la liste des pages dans votre vue. Laravel s'occupe de tout. Le système de pagination de Laravel a été conçu pour être facile à implementer. Une chose à garder en mémoire, qui vaut également pour le reste, ce n'est pas parce que Laravel peut le faire pour vous que vous êtes obligé de le faire par Laravel. Rien ne vous empêche de créer un système manuel !

Vous avez là un aperçu de ce qui rend Laravel différent des autres frameworks PHP. Toutes ces fonctionnalités et bien d'autres vous seront présentées dans la documentation.

<a name="structure-de-l-application"></a>
## Structure de l'application

La structure des répertoires de Laravel est très proche des autres frameworks PHP. La structure est adaptée aux sites de toutes tailles, et vous permet de vous concentrer immédiatement sur ce qui est important pour votre projet.

Cependant, l'architecture de Laravel est flexible. Cela signifie que vous pouvez, si vous le souhaitez, modifier l'architecture pour correspondre à des besoins précis, notamment si vous travaillez sur de gros sites, ou sur de gros projets tels que des CMS.

Dans cette documentation, nous partirons du principe que l'architecture par défaut est respectée. 

<a name="Laravel-community"></a>
## La communauté Laravel

Laravel a la chance d'être supportée par une communauté qui grandit rapidement, avec des membres amicaux et enthousiastes. Les [Forums de Laravel[en]](http://forums.Laravel.com) sont une bonne place pour trouver de l'aide, répondre aux questions, proposer des suggestions ou simplement voir ce qui se passe.

La plupart d'entre nous passons du temps sur le channel IRC [#laravel](irc://freenode.net/laravel) sur le réseau FreeNode [Voir sur le forum comment nous rejoindre[en]](http://forums.laravel.com/viewtopic.php?id=671). C'est une place idéale pour apprendre beaucoup de choses sur le monde du développement web en utilisant Laravel. Vous pouvez poser des questions, répondre aux questions des autres personnes, venir discuter de l'actualité des technos du web, etc... Nous aimons Laravel, et nous adorons en parler, alors n'hésitez pas à nous rejoindre.

### Laravel France

Notre but est de monter une communauté d'aide et de partage.

Si vous êtes Francophone et que vous souhaitez participer au projet, n'hésitez pas à prendre contact avec nous, sur notre channel IRC [#laravel.fr](irc://freenode.net/laravel.fr) du réseau FreeNode


<a name="Laravel-license"></a>
## Licence

Laravel est une application open source sous [licence MIT](http://www.opensource.org/licenses/mit-license.php).
