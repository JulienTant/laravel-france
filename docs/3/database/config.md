# Database Configuration

## Au menu

- [Démarrage rapide avec SQLite](#quick)
- [Configuration des autres types de base de données](#server)
- [Définir le nom des connexions par défaut](#default)
- [Surcharge des options PDO](#options)

Laravel supporte d'origine les bases de données suivantes :

- MySQL
- PostgreSQL
- SQLite
- SQL Server

Toutes les options de configuration des bases de données se trouvent dans le fichier **application/config/database.php**.

<a name="quick"></a>
## Démarrage rapide avec SQLite

[SQLite](http://sqlite.org) est une base de donnée géniale, nécessitant zéro configuration. Par défaut, Laravel est configuré pour utiliser MySQL. Pour passer à SQLite, changez l'option **default** et mettez : sqlite. Voilà c'est tout, vous n'avez rien d'autre à changer.

Bien sûr, si vous souhaitez que votre base de donnée ne s'appelle pas "application", vous pouvez modifier l'option 'database' du fichier **application/config/database.php** :

    'sqlite' => array(
         'driver'   => 'sqlite',
         'database' => 'your_database_name',
         'prefix' => ''
    )

Si votre application reçoit moins de 100 000 hits par jour, SQLite est une bonne solution pour la production. Sinon, pensez à MySQL ou PostgreSQL.

<a name="server"></a>
## Configuration des autres types de base de données

Si vous utilisez MySQL, SQL Server, ou PostgreSQL, vous aurez besoin de modifier les options de configuration dans **application/config/database.php**. Dans le fichier de configuration, vous trouverez des exemples de configuration pour chacun de ces SGBDR. Changez simplement les options nécessaires pour votre serveur.

<a name="default"></a>
## Définir le nom des connexions par défaut

Comme vous avez pu le remarquer, chaque connexion définie dans le fichier **application/config/database.php** a un nom. Par défaut, il y a quatres connexions définies : **sqlite**, **mysql**, **sqlsrv**, et **pgsql**. Vous êtes libre de changer ces noms de connexion. La connexion par défaut est spécifiée via l'option **default** :

    'default' => 'sqlite'

La connexion par défaut sera toujours utilisée par le [Fluent query builder](/docs/3/database/fluent). Si vous devez changer la connexion par défaut pour une requête, utilisez la méthode `Config::set`.

<a href="options"></a>
## Surcharge des options PDO

La classe Connector (**laravel/database/connectors/connector.php**) a un lot d'attributs PDO définis qui peuvent être surchargés dans le tableau de configuration de chaque système. Par exemple, l'un des attributs par défaut est de forcer le nom des colonnes en minuscule (**PDO::CASE_LOWER**) même s'ils sont définis en majuscule ou en camelCase dans la table. Par conséquent, les variables des objets générés ne seront accessibles qu'en minuscule.
Voici un exemple de configuration du système MySQL avec des attributs PDO ajoutés :

    'mysql' => array(
        'driver'   => 'mysql',
        'host'     => 'localhost',
        'database' => 'database',
        'username' => 'root',
        'password' => '',
        'charset'  => 'utf8',
        'prefix'   => '',
        PDO::ATTR_CASE              => PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS      => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES  => false,
    ),

Plus d'informations à propos des attributs de connexion PDO peuvent être trouvés [dans le manuel PHP](http://php.net/manual/fr/pdo.setattribute.php).
