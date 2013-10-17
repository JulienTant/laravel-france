# Cache Configuration

## Au menu

- [Les bases](#the-basics)
- [Base de données](#database)
- [Memcached](#memcached)
- [Redis](#redis)
- [Cache Keys](#keys)
- [In-Memory Cache](#memory)

<a name="the-basics"></a>
## Les bases

Imaginez que votre application affiche les dix chansons les plus populaires pour vos visiteurs. Avez-vous vraiment besoin de remonter ces 10 chansons chaque fois que quelqu'un visite votre site ? Et si vous les stockiez pour 10 minutes, ou même une heure, vous permettant d'accélérer fortement votre application ? Le système de cache de Laravel le fait simplement.

Laravel propose cinq drivers de cache par défaut :

- Système de fichier
- Base de données
- Memcached
- APC
- Redis
- Memory (Tableaux)

Par défaut, Laravel est configuré pour utiliser le driver **file** comme système de cache. C'est disponible de suite sans configuration. Ce système stocke les éléments à mettre en cache comme des fichiers dans le répertoire **cache**. Si vous êtes satisfait par ce driver, aucune autre configuration n'est requise. Vous êtes prêt à l'utiliser.

> **Note:** Avant d'utiliser le système de cache par fichiers, soyez sûr que le répertoire **storage/cache** est en mode écriture.

<a name="database"></a>
## Base de données

Le driver de cache par la base de données utilise une table de base de données donnée comme un simple stockage clé-valeur. Pour commencer, réglez d'abord le nom de la table de base de données dans le fichier  **application/config/cache.php** :

    'database' => array('table' => 'laravel_cache'),

Ensuite, créez la table dans votre base de données. La table doit avoir trois colonnes :

- key (varchar)
- value (text)
- expiration (integer)

C'est tout. Une fois votre configuration et votre table configurées, vous pouvez commencer à faire du cache !

<a name="memcached"></a>
## Memcached

[Memcached](http://memcached.org) est un système d'usage général servant à gérer la mémoire cache distribuée, gérant les données et les objets en RAM, utilisé par des sites comme Wikipedia et Facebook. Avant d'utiliser le driver Memcached de Laravel, vous devrez installer et configurer Memcached et l'extension PHP Memcache sur votre serveur.

Une fois que Memcached est installé sur votre serveur, vous devez modifier l'option **driver** dans le fichier **application/config/cache.php** :

    'driver' => 'memcached'

Ensuite, ajoutez vos serveurs Memcached dans le tableau **servers** :

    'servers' => array(
         array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100),
    )

<a name="redis"></a>
## Redis

[Redis](http://redis.io) est un système de gestion de base de données clef-valeur scalable, très hautes performances, sur la mouvance NoSQL, pouvant contenir [strings](http://redis.io/topics/data-types#strings), [hashes](http://redis.io/topics/data-types#hashes), [lists](http://redis.io/topics/data-types#lists), [sets](http://redis.io/topics/data-types#sets), et [sorted sets](http://redis.io/topics/data-types#sorted-sets).

Avant d'utiliser le driver de cache pour Redis, vous devez [configurer vos serveurs Redis](/docs/3/database/redis#config). Maintenant vous pouvez modifier l'option **driver** du fichier **application/config/cache.php** :

    'driver' => 'redis'

<a name="keys"></a>
### Cache Keys

Pour éviter les collisions de nommage avec d'autres applications utilisant APC, Redis ou un serveur Memcached, Laravel fait précéder une **key** à chaque élément stocké dans le cache utilisé par ces drivers. Soyez libre de modifier cette valeur :

    'key' => 'laravel'

<a name="memory"></a>
### In-Memory Cache

Le driver de cache "memory" ne met pas vraiment en cache n'importe quoi sur le disque dur. Il maintient simplement un tableau interne des données en cache pour la requête courante. C'est parfait pour des tests unitaires de votre application indépendamment des mécanismes de stockage. Il ne doit jamais être utilisé comme driver de cache "réel".
