# Tasks

## Au menu

- [Les bases](#the-basics)
- [Création et exécution de tâches](#creating-tasks)
- [Tâches de bundles](#bundle-tasks)
- [Options de la ligne de commandes](#cli-options)

<a name="the-basics"></a>
## Les bases

L'outil en ligne de commande de Laravel s'appelle Artisan. Artisan peut être utilisé pour exécuter des tâches comme des migrations, des tâches programmées, tests unitaires, ou ce que vous voulez.

<a name="creating-tasks"></a>
## Création & exécution de tâches

Pour créer une tâche, créez une nouvelle classe dans le dossier **application/tasks**. Le nom de la classe doit finir par "_Task", et doit avoir au minimum une méthode "run" :

#### Création d'une tâche :

	class Notify_Task {

		public function run($arguments)
		{
			// faire quelque chose d'incroyable !
		}

	}

Maintenant vous pouvez exécuter la méthode "run" via la ligne de commande. Vous pouvez aussi passer des arguments :

#### Appel de la tâche en ligne de commande:

	php artisan notify

#### Appel de la tâche en lui passant un argument :

	php artisan notify taylor

#### Appel de la tâche depuis l'application :

	Command::run(array('notify'));

#### Appel de la tâche depuis l'application avec des arguments :

	Command::run(array('notify', 'taylor'));

Souvenez-vous, vous pouvez appeler une méthode spécifique de votre classe. Ajoutons une méthode "urgent" à la classe Notify_Task :

#### Ajout d'une méthode à notre tâche :

	class Notify_Task {

		public function run($arguments)
		{
			// Do awesome notifying...
		}

		public function urgent($arguments)
		{
			// This is urgent!
		}

	}

Maintenant nous pouvons appeler la méthode "urgent" :

#### Appel d'une méthode spécifique :

	php artisan notify:urgent

<a name="bundle-tasks"></a>
## Tâches de bundle

Pour créer une tâche pour un bundle, préfixez le nom de votre tâche avec le nom de votre bundle. Donc si votre bundle s'appelle "admin", une tâche ressemblera à cela : 

#### Création d'une tâche qui appartient à un bundle :

	class Admin_Generate_Task {

		public function run($arguments)
		{
			//  faire un truc d'admin
		}

	}

Pour lancer votre tâche, utilisez un double deux points ( :: ) pour indiquer le bundle, comme d'habitude avec Laravel :

#### Exécute une tâche d'un bundle :

	php artisan admin::generate

#### Exécute une méthode précise d'une tâche d'un bundle:

	php artisan admin::generate:list

<a name="cli-options"></a>
## Options de la ligne de commande

#### Définition de l'environnement :

	php artisan foo --env=local

#### Définition de la base de donnée utilisée :

	php artisan foo --database=sqlite
