# Le constructeur de schéma

- [Introduction](#introduction)
- [Création et suppression de table](#creating-and-dropping-tables)
- [Ajout de colonnes](#adding-columns)
- [Renommage de colonnes](#renaming-columns)
- [Suppression de colonnes](#dropping-columns)
- [Vérification d'existence](#checking-existence)
- [Ajout d'index](#adding-indexes)
- [Clés étrangères](#foreign-keys)
- [Suppression d'index](#dropping-indexes)
- [Moteur de stockage](#storage-engines)

<a name="introduction"></a>
## Introduction

La classe `Schema` de Laravel fournit une manière indépendante du type de base de données pour manipuler les tables. Le constructeur marche bien avec toutes les bases de données supportées par Laravel, et a une API unifiée pour tous ces systèmes.

<a name="creating-and-dropping-tables"></a>
## Création et suppression de table

Pour créer une nouvelle table, la méthode `Schema::create` est utilisée :

    Schema::create('users', function($table)
    {
        $table->increments('id');
    });

Le premier argument passé à la méthode `create` est le nom de la table, et le second argument est une fonction anonyme, qui va recevoir un objet `Blueprint` qui doit être utilisé pour définir la nouvelle table.

Pour spécifier quelle connexion doit être utilisée par le constructeur de schéma, utilisez la méthode `Schema::connection` :

    Schema::connection('foo')->create('users', function($table)
    {
        $table->increments('id'):
    });

Pour supprimer une table, vous pouvez utiliser la méthode `Schema::drop` :

    Schema::drop('users');

    Schema::dropIfExists('users');

<a name="adding-columns"></a>
## Ajout de colonnes

Pour éditer une table existante, nous utiliserons la méthode `Schema::table` :

    Schema::table('users', function($table)
    {
        $table->string('email');
    });

Le constructeur de table contient une variété de types de colonne que vous pouvez utiliser pour construire vos tables :

Commande  | Description
------------- | -------------
`$table->increments('id');`  |  Clé primaire de type auto-incrémentale.
`$table->string('email');`  |  Equivalent de VARCHAR
`$table->string('name', 100);`  |  Equivalent de VARCHAR avec une taille
`$table->integer('votes');`  |  Equivalent d'INTEGER
`$table->bigInteger('votes');`  |  Equivalent de BIGINT
`$table->smallInteger('votes');`  |  Equivalent de SMALLINT
`$table->float('amount');`  |  Equivalent de FLOAT
`$table->decimal('amount', 5, 2);`  |  Equivalent de DECIMAL avec une précision et une échelle
`$table->boolean('confirmed');`  |  Equivalent de BOOLEAN
`$table->date('created_at');`  |  Equivalent de DATE
`$table->dateTime('created_at');`  |  Equivalent de DATETIME
`$table->time('sunrise');`  |  Equivalent de TIME
`$table->timestamp('added_on');`  |  Equivalent de TIMESTAMP
`$table->timestamps();`  |  Ajoute les colonnes **created\_at** et **updated\_at**
`$table->text('description');`  |  Equivalent de TEXT
`$table->binary('data');`  |  Equivalent de BLOB
`$table->enum('choices', array('foo', 'bar'));` | Equivalent de ENUM
`->nullable()`  |  Désigne une colonne qui autorise NULL
`->default($value)`  |  Déclare une valeur par défaut pour la colonne
`->unsigned()`  |  Définit un INTEGER comme étant UNSIGNED

Si vous utilisez une base de données MySQL, vous pouvez utiliser la méthode `after` pour spécifier l'ordre des colonnes :

**Utilisation de after sur MySQL**

    $table->string('name')->after('email');

<a name="renaming-columns"></a>
## Renommage de colonnes

Pour renommer une colonne, vous devez utiliser la méthode `renameColumn` sur le constructeur de schéma :

**Renommage d'une colonne**

	Schema::table('users', function($table)
	{
		$table->renameColumn('from', 'to');
	});

> **Note:** Le renommage de colonne de type `enum` n'est pas supporté.

<a name="dropping-columns"></a>
## Suppression de colonnes

**Suppression d'une colonne d'une table**

    Schema::table('users', function($table)
    {
        $table->dropColumn('votes');
    });

**Suppression de plusieurs colonnes d'une table**

    Schema::table('users', function($table)
    {
        $table->dropColumn('votes', 'avatar', 'location');
    });

<a name="checking-existence"></a>
## Vérification d'existence

Vous pouvez vérifier facilement l'existence d'une table ou d'une colonne en utilisant les méthodes `hasTable` et `hasColumn` :

**Vérifie l'existence d'une table**

	if (Schema::hasTable('users'))
	{
		//
	}

**Vérifie l'existence d'une colonne**

	if (Schema::hasColumn('users', 'email'))
	{
		//
	}

<a name="adding-indexes"></a>
## Ajout d'index

Le constructeur de schéma supporte plusieurs types d'index. Il y a deux manières de les ajouter. La première est de manière fluide, lors de la définition d'une colonne :

**Crée de manière fluide une colonne et un index**

    $table->string('email')->unique();

Ou, vous pouvez choisir d'ajouter les index sur des lignes séparées. Vous trouverez ci-dessous une liste des types d'index:

Commande  | Description
------------- | -------------
`$table->primary('id');`  |  Ajout d'une clé primaire
`$table->primary(array('first', 'last'));`  |  Ajout d'une clé primaire composite
`$table->unique('email');`  |  Ajout d'un index d'unicité
`$table->index('state');`  |  Ajout d'un index basique

<a name="foreign-keys"></a>
## Clés étrangères

Laravel fournit également de quoi ajouter des clés étrangères à vos tables :

**Ajout d'une clé étrangère à une table**

    $table->foreign('user_id')->references('id')->on('users');

Dans cet exemple, nous définissons que la colonne `user_id` référence la colonne `id` de la table `users`.

Vous pouvez également spécifier des options de contrainte pour les actions "on delete" et "on update" :

    $table->foreign('user_id')
          ->references('id')->on('users')
          ->onDelete('cascade');

Pour supprimer une clé étrangère, vous pouvez utiliser la méthode `dropForeign`. Une convention de nommage similaire aux autres clés est utilisée pour les clés étrangères :

    $table->dropForeign('posts_user_id_foreign');

> **Note:** Lors de la création d'une clé étrangère qui référence un entier autoincrémental, souvenez vous de toujours rendre la clé étrangère `unsigned`.

<a name="dropping-indexes"></a>
## Suppression d'index

Pour supprimer un index, vous devez spécifier le nom de l'index. Laravel assigne un nom raisonnable aux index par défaut. Concatenez simplement le nom de la table, le nom des colonnes dans l'index, et le type d'index. Voici quelques exemples :

Command  | Description
------------- | -------------
`$table->dropPrimary('users_id_primary');`  |  Supprime une clé primaire de la table "users"
`$table->dropUnique('users_email_unique');`  |  Supprime une clé d'unicité de la table "users"
`$table->dropIndex('geo_state_index');`  |  Supprime une clé basique de la table "geo"

<a name="storage-engines"></a>
## Moteur de stockage

Pour définir le moteur de stockage d'une table, définissez la propriété `engine` sur le constructeur de schéma:

    Schema::create('users', function($table)
    {
        $table->engine = 'InnoDB';

        $table->string('email');
    });
