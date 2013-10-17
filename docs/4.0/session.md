# Les sessions

- [Configuration](#configuration)
- [Utilisation](#session-usage)
- [Flasher des données](#flash-data)
- [Enregistrer les sessions en base de données](#database-sessions)

<a name="configuration"></a>
## Configuration

Puisque l'état des variables n'est pas conservé par les applications basées sur le protocole HTTP, les sessions sont un moyen de conserver des informations d'une requête à l'autre. Laravel inclut des gestionnaires de données à travers une API claire et unifiée. Laravel supporte [Memcached](http://memcached.org), [Redis](http://redis.io) et les gestionnaires de bases de données.

Les sessions sont paramétrables dans le fichier `app/config/session.php`. Examinez bien les options de ce fichier, elles sont bien documentées. Par défaut, Laravel est configuré pour l'utilisation du driver de session `native` convenant à la majorité des applications.

<a name="session-usage"></a>
## Utilisation

**Enregistrer une information dans une variable de session**

	Session::put('key', 'value');

**Lire une variable de session**

	$value = Session::get('key');

**Lire une variable ou retourner une valeur par défaut**

	$value = Session::get('key', 'default');

	$value = Session::get('key', function() { return 'default'; });

**Déterminer l'existence d'une variable de session**

	if (Session::has('users'))
	{
		//
	}

**Supprimer une variable de session**

	Session::forget('key');

**Supprimer toutes les variables de session**

	Session::flush();

**Régénérer l'identifiant de session**

	Session::regenerate();

<a name="flash-data"></a>
## Flasher des données

Si vous souhaitez enregistrer des variables de session uniquement pour les transmettre à la prochaine requête, utilisez la méthode `Session::flash` :

	Session::flash('key', 'value');

**Répéter le flash pour une autre requête**

	Session::reflash();

**Répéter le flash de certaines variables**

	Session::keep(array('username', 'email'));

<a name="database-sessions"></a>
## Enregistrer les sessions en base de données

Pour utiliser le driver de session `database`, vous devez créer une table destinée à stocker les variables de sessions. Voici un exemple de création d'une telle table :

	Schema::create('sessions', function($t)
	{
		$t->string('id')->unique();
		$t->text('payload');
		$t->integer('last_activity');
	});

Evidemment, vous pouvez utiliser la commande Artisan `session:table` pour générer cette migration :

	php artisan session:table

	composer dump-autoload

	php artisan migrate
