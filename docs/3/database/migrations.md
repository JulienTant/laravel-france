# Migrations

## Au menu

- [Les bases](#the-basics)
- [Préparation de la base de données](#prepping-your-database)
- [Créer une migration](#creating-migrations)
- [Lancer une migration](#running-migrations)
- [Marche arrière](#rolling-back)

<a name="the-basics"></a>
## Les bases

Pensez aux migrations comme un type de contrôle de version pour votre base de données. Disons que vous travaillez en équipe, et que vous avez une base de donnée locale pour le développement. Votre pote Eric fait un changement dans la base de données et vérifie que son code utilise la colonne nouvellement créée. Vous récuperez le nouveau code source, et là rien ne marche, car vous n'avez pas la nouvelle colonne. Que faire ? Les migrations sont la solution. Creusons un peu le sujet pour comprendre comment les utiliser.

<a name="prepping-your-database"></a>
## Préparation de la base de données

Avant d'utiliser les migrations, vous devez effectuer une opération. Laravel utilise une table spéciale pour garder une trace des migrations qui ont déjà été exécutées. Pour créer cette table, utilisez Artisan en ligne de commande :

**Crée la table de migration de Laravel :**

    php artisan migrate:install

<a name="creating-migrations"></a>
## Créer une migration

Vous pouvez facilement créer une des migrations avec Artisan. Une simple commande suffit :

**Création d'une migration**

    php artisan migrate:make create_users_table

Maintenant, direction le dossier **application/migrations**. Vous trouverez notre nouveau fichier de migration ! Le nom de ce fichier contient un timestamp, cela permet à Laravel d'exécuter les fichiers dans l'ordre de création.

Vous pouvez également créer des migrations pour un bundle :

**Crée une migration pour un bundle :**

    php artisan migrate:make bundle::create_users_table

*Voir aussi:*

- [Schema Builder](/docs/3/database/schema)

<a name="running-migrations"></a>
## Lancer une migration

**Exécute toutes les migrations pour l'application et les bundles :**

    php artisan migrate

**Exécute toutes les migrations pour l'application :**

    php artisan migrate application

**Exécute toutes les migrations pour les bundles :**

    php artisan migrate bundle

<a name="rolling-back"></a>
## Marche arrière

Lorsque vous effectuez un retour en arrière, Laravel défait entièrement toute la dernière opération de migration. Donc si votre migration était en réalité un lot de 122 migrations, les 122 seront défaites.

**Annulation de la dernière migration :**

    php artisan migrate:rollback

**Annulation de toutes les migrations :**

    php artisan migrate:reset
