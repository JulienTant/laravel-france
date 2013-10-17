# Redis

## Au menu

- [Les bases](#the-basics)
- [Configuration](#config)
- [Utilisation](#usage)

<a name="the-basics"></a>
## Les bases

[Redis](http://redis.io) est un stockage clé/value open-source avancé. Nous en parlons souvent comme un serveur de structure de données car les clés peuvent contenir des [strings](http://redis.io/topics/data-types#strings), des [hashes](http://redis.io/topics/data-types#hashes), [lists](http://redis.io/topics/data-types#lists), [sets](http://redis.io/topics/data-types#sets), et des [sorted sets](http://redis.io/topics/data-types#sorted-sets).

<a name="config"></a>
## Configuration

La configuration de Redis pour votre application se fait dans le fichier **application/config/database.php**. Dans ce fichier, vous trouverez un tableau **redis** qui contient les serveurs Redis utilisés par votre application :

    'redis' => array(
        'default' => array('host' => '127.0.0.1', 'port' => 6379),
    ),

La configuration du serveur par défaut devrait suffire pour le développement. Cependant, vous êtes libre de modifier ce tableau selon votre environnement. Donnez simplement un nom à chaque serveur, précisez une adresse et un port.

<a name="usage"></a>
## Utilisation

Vous recevrez une instance de Redis en appellant la méthode **db** de la classe **Redis** :

    $redis = Redis::db();

Cela vous donnera une instance du serveur Redis par **default**. Vous pouvez passer le nom du serveur à la méthode **db** pour obtenir une instance de Redis définie dans votre fichier de configuration :

    $redis = Redis::db('redis_2');

Bien ! Maintenant que nous avons une instance du client Redis, nous pouvons exécuter une [commande Redis](http://redis.io/commands). Laravel utilise des méthodes magiques pour passer les commandes au serveur :

    $redis->set('name', 'Taylor');

    $name = $redis->get('name');

    $values = $redis->lrange('names', 5, 10);


Les arguments de la commande sont simplement passés à la méthode magique. Vous pouvez ne pas utiliser les méthodes magiques, en utilisant la méthode **run** :

    $values = $redis->run('lrange', array(5, 10));

Vous souhaitez exécuter le plus simplement possible des commandes sur le serveur par défaut ? Vous pouvez utiliser simplement les méthodes magiques directement sur la classe **Redis** :

    Redis::set('name', 'Taylor');

    $name = Redis::get('name');

    $values = Redis::lrange('names', 5, 10);

> **Note:** Des drivers Redis pour le [cache](/docs/3/cache/config#redis) et les [sessions](/docs/3/session/config#redis) sont inclus avec Laravel.
