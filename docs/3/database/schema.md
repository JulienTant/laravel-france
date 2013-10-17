# Schema Builder

## Au menu

- [Les bases](#the-basics)
- [Création et suppression de tables](#creating-dropping-tables)
- [Ajout de colonnes](#adding-columns)
- [Suppression de colonnes](#dropping-columns)
- [Ajout d'index](#adding-indexes)
- [Suppression d'index](#dropping-indexes)
- [Clé étrangère](#foreign-keys)

<a name="the-basics"></a>
## Les bases

Le Schema Builder fournit des méthodes pour créer et modifier les tables de votre base de données. En utilisant une syntaxe fluide, vous pouvez travailler sur vos tables sans savoir à utiliser la syntaxe SQL.

*Voir aussi:*

- [Migrations](/docs/3/database/migrations)

<a name="creating-dropping-tables"></a>
## Création & suppression de tables

La classe **Schema** est utilisée pour créer, modifier ou supprimer des tables. Voyons cela en exemple :

#### Création d'une simple table :

    Schema::create('users', function($table)
    {
        $table->increments('id');
    });

Revenons sur cet exemple. La méthode **create** indique au schema builder que c'est une nouvelle table, et donc qu'elle doit être créée. Le second argument est une fonction anonyme, qui reçoit une instance de Table. En utilisant l'objet Table, nous pouvons enchainer l'ajout ou la suppression de colonnes et d'index sur cette table.

#### Suppression d'une table :

    Schema::drop('users');

#### Suppression d'une table depuis la base de donnée indiquée.

    Schema::drop('users', 'connection_name');

Lors de la création vous pourriez avoir besoin de spécifié sur quelle base de données l'opération doit être effectuée.

#### Spécifie sur quelle connexion travailler :

    Schema::create('users', function($table)
    {
        $table->on('connection');
    });

<a name="adding-columns"></a>
## Ajout de colonnes


Les méthodes du constructeur de table fluide vous permettent d'ajouter des colonnes sans utiliser de syntaxe SQL particulière à un SGBDR :

Command  | Description
------------- | -------------
`$table->increments('id');`  |  ID incrémental
`$table->string('email');`  |  colonne de type VARCHAR
`$table->string('name', 100);`  |  colonne de type VARCHAR avec une taille
`$table->integer('votes');`  |  colonne de type INTEGER
`$table->float('amount');`  |  colonne de type FLOAT
`$table->decimal('amount', 5, 2);`  |  colonne de type DECIMAL avec une précision et une échelle
`$table->boolean('confirmed');`  |  colonne de type BOOLEAN
`$table->date('created_at');`  |  colonne de type DATE
`$table->timestamp('added_on');`  | colonne de type TIMESTAMP
`$table->timestamps();`  |  Ajoute **created\_at** et **updated\_at** à la table ( type DATE )
`$table->text('description');`  |  colonne de type TEXT
`$table->blob('data');`  |  colonne de type BLOG
`->nullable()`  |  colonne pouvant être nulles
`->default($value)`  |  colonne ayant une valeur par défaut
`->unsigned()`  |  Défini un INTEGER comme non signé

> **Note:** Laravel faire correspondre "boolean" avec le plus petit type d'entier disponible.

#### Exemple de création de table avec ajout de colonnes

    Schema::table('users', function($table)
    {
        $table->create();
        $table->increments('id');
        $table->string('username');
        $table->string('email');
        $table->string('phone')->nullable();
        $table->text('about');
        $table->timestamps();
    });

<a name="dropping-columns"></a>
## Suppression de colonnes

#### Supprime une colonne de la table:

    $table->drop_column('name');

#### Supprime plusieurs colonnes de la table:

    $table->drop_column(array('name', 'email'));

<a name="adding-indexes"></a>
## Ajout d'index

Le Schema builder supporte plusieurs type d'index. Il y a deux manières d'ajouter des index. Chaque type d'index a sa propre méthode, cependant vous pouvez aussi définir de manière fluide un index sur la même ligne que l'ajout de la colonne :

#### Crée de manière fluide une colonne avec un index:

    $table->string('email')->unique();

Si vous préférez définir vos clés sur une ligne à part, alors voici comment faire :

Command  | Description
------------- | -------------
`$table->primary('id');`  |  Ajoute une clé primaire
`$table->primary(array('fname', 'lname'));`  |  Ajoute une clé primaire sur plusieurs colonnes
`$table->unique('email');`  |  Ajoute un index d'unicité
`$table->fulltext('description');`  | Ajoute un index full-text
`$table->index('state');`  |  Ajoute un index basique

<a name="dropping-indexes"></a>
## Suppression d'index :

Pour supprimer un index, vous devez spécifier son nom. Laravel assigne un nom cohérent à tous les index. concaténez simplement le nom de la table, et le nom des colonnes, ensuite ajoutez le type d'index.

Command  | Description
------------- | -------------
`$table->drop_primary('users_id_primary');`  |  Supprime une clé primaire de la table users.
`$table->drop_unique('users_email_unique');`  |  Supprime un index unique sur la tables users.
`$table->drop_fulltext('profile_description_fulltext');`  |  Supprime un index full-text de la table profile.
`$table->drop_index('geo_state_index');`  |  Supprime un index basique de la table geo.

<a name="foreign-keys"></a>
## Clé étrangère

Vous pouvez ajouter facilement des clés étrangères à vos tables en utilisant le Schema builder. Par exemple, disons que vous avez une colonne **user_id** sur une table **posts**, qui représente la colonne **id** de la table **users**. Voici comment ajouter une contrainte de clé étrangère pour la colonne :

    $table->foreign('user_id')->references('id')->on('users');

Vous pouvez également spécifier des options pour le "on delete" et le "on update" à la clé étrangère :

    $table->foreign('user_id')->references('id')->on('users')->on_delete('restrict')->on_update('cascade');

Vous pouvez facilement supprimer une clé étrangère en utilisant [la même convention de nommage](#dropping-indexes) que pour les autres index :

    $table->drop_foreign('posts_user_id_foreign');

> **Note:** Le champ référencé dans la clé étrangère sera sûrement un champ de type entier non signé, avec un autoincrement. Veuillez vous assurer de créer le champ de la clé étrangère avec la méthode **unsigned()** étant donné que les deux champs doivent être exactement du même type, et que le moteur utilisé soit InnoDB, car c'est le seul qui supporte correctement les clé étrangères :

    $table->engine = 'InnoDB';

    $table->integer('user_id')->unsigned();
