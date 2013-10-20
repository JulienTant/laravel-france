# Redis

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Utilisation](#usage)
- [Pipelining](#pipelining)

<a name="introduction"></a>
## Introduction

[Redis](http://redis.io) est une base de données open source de type clé-valeur. Il est souvent présenté comme un gestionnaire de données structurées puisque les clés peuvent être de type [strings](http://redis.io/topics/data-types#strings), [hashes](http://redis.io/topics/data-types#hashes), [lists](http://redis.io/topics/data-types#lists), [sets](http://redis.io/topics/data-types#sets), et [sorted sets](http://redis.io/topics/data-types#sorted-sets).

<a name="configuration"></a>
## Configuration

La configuration Redis pour votre application est située dans le fichier **app/config/database.php**. Dans ce fichier, l'élément **redis** est un tableau contenant les serveurs Redis utilisés par votre application :

	'redis' => array(
        'cluster' => true,
		'default' => array('host' => '127.0.0.1', 'port' => 6379),
	),

La configuration de serveur par défaut doit être suffisante pour le développement. Toutefois, vous pouvez modifier ce tableau à votre convenance. Donnez seulement un nom à chacun de vos serveurs Redis, puis indiquez le host et le port utilisés pour chaque serveur.

L'option `cluster` indiquera au client Redis de Laravel de faire du Sharding côté client sur les noeuds Redis, vous permettant de mettre en commun des noeuds et de créer un grand nombre de RAM disponibles. Cependant, notez que le sharding côté client ne gère pas les défaillances, de ce fait l'usage sera plutôt pour mettre en cache des données qui sont disponibles depuis une autre source.

<a name="usage"></a>
## Utilisation

Vous devez obtenir une instance Redis en appelant la méthode `Redis::connection` :

	$redis = Redis::connection();


Une instance du serveur Redis par défaut vous sera retournée. Vous devez indiquer le nom du serveur à la méthode `connection` afin d'obtenir un serveur spécifique comme défini dans votre configuration Redis :


	$redis = Redis::connection('other');

Une fois en possession d'une instance du client Redis, vous pouvez lui appliquer des [commandes Redis](http://redis.io/commands). Laravel utilise des méthodes magiques pour passer les commandes au serveur Redis :

	$redis->set('name', 'Taylor');

	$name = $redis->get('name');

	$values = $redis->lrange('names', 5, 10);

Notez la simplicité avec laquelle les arguments des commandes sont passés à la méthode magique. Evidemment, vous n'êtes pas obligé d'utiliser les méthodes magiques, vous pouvez aussi transmettre des commandes au serveur en utilisant la méthode `command` :

	$values = $redis->command('lrange', array(5, 10));

Pour exécuter des commandes sans utiliser la connexion par défaut, utilisez les méthodes statiques magiques de la classe `Redis` :

	Redis::set('name', 'Taylor');

	$name = Redis::get('name');

	$values = Redis::lrange('names', 5, 10);

> **Note:** Les drivers [cache](/docs/4/cache) et [session](/docs/4/session) de Redis sont fournis avec Laravel.

<a name="pipelining"></a>
## Pipelining

Le Pipelining doit être utilisé lorsque vous avez besoin d'envoyer plusieurs commandes au serveur en une opération. Pour ce faire, utilisez la méthode `pipeline` :

**Envoi de plusieurs commandes au serveur**

    Redis::pipeline(function($pipe)
    {
        for ($i = 0; $i < 1000; $i++)
        {
            $pipe->set("key:$i", $i);
        }
    });


