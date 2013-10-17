# Les migrations & et la population

- [Introduction](#introduction)
- [Création de migrations](#creating-migrations)
- [Exécution de migrations](#running-migrations)
- [Annulation de migrations](#rolling-back-migrations)
- [Population de base de donnée](#database-seeding)

<a name="introduction"></a>
## Introduction

Les migrations sont une sorte de contrôle de version pour votre base de données. Elles permettent de modifier le schéma des tables et de rester à jour sur l'état courant du schéma des tables. Les migrations sont souvent couplées avec le [Constructeur de Schéma](/docs/4/schema) pour gérer facilement les schémas de votre application.

<a name="creating-migrations"></a>
## Création de migrations

Pour créer une migration, vous pouvez utiliser la commande `migrate:make` d'Artisan en ligne de commande :

**Création d'une migration**

	php artisan migrate:make create_users_table

La migration sera placée dans votre dossier `app/database/migrations`, et contiendra un timestamp pour permettre au framework de déterminer l'ordre de vos migrations.

Vous pouvez également spécifier une option `--path` lorsque vous créez la migration. Le chemin doit être relatif à la racine de votre installation :

	php artisan migrate:make foo --path=app/migrations

Les options `--table` et `--create` peuvent être également utilisées pour indiquer le nom de la table, et si la migration va créer une nouvelle table :

	php artisan migrate:make create_users_table --table=users --create

<a name="running-migrations"></a>
## Exécution de migrations

**Exécute toutes les migrations non lancées**

	php artisan migrate

**Exécute toutes les migrations non lancées d'un chemin**

	php artisan migrate --path=app/foo/migrations

**Exécute toutes les migrations non lancées d'un package**

	php artisan migrate --package=vendor/package

> **Note:** Si vous recevez une erreur "class not found" lors de l'exécution des migrations, essayez de lancer la commande `composer update`.

<a name="rolling-back-migrations"></a>
## Annulation de migrations

**Annule la dernière opération de migration**

	php artisan migrate:rollback

**Annule toutes les migrations**

	php artisan migrate:reset

**Annule toutes les migrations et les relance toutes**

	php artisan migrate:refresh

	php artisan migrate:refresh --seed

<a name="database-seeding"></a>
## Population de base de données

Laravel fournit également une manière simple de peupler votre base de données avec des données de test en utilisant des classes de population. Toutes les classes de population sont stockées dans le dossier `app/database/seeds`. Les classes de population peuvent avoir le nom que vous souhaitez, mais vous devrez probablement suivre une convention, telle que `UserTableSeeder` par exemple. Par défaut, une classe `DatabaseSeeder` est définie pour vous. Depuis cette classe, vous pouvez utiliser la méthode `call` pour exécuter d'autres classes de population, vous permettant de contrôler l'ordre de la population.

**Exemple de classe de population de base de données**

    class DatabaseSeeder extends Seeder {

        public function run()
        {
             $this->call('UserTableSeeder');

             $this->command->info('User table seeded!');
        }
     }

    class UserTableSeeder extends Seeder {

         public function run()
         {
             DB::table('users')->delete();

             User::create(array('email' => 'foo@bar.com'));
         }

    }

Pour peupler votre base de données, vous pouvez utiliser la commande `db:seed` avec Artisan en ligne de commande :

	php artisan db:seed

Vous pouvez également peupler votre base de données en utilisant la commande `migrate:refresh`, qui va également annuler les migrations et les relancer :

	php artisan migrate:refresh --seed
