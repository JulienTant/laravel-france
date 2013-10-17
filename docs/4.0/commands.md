# Développement de commandes

- [Introduction](#introduction)
- [Construction d'une commande](#building-a-command)
- [Enregistrement d'une commande](#registering-commands)
- [Appel d'autres commandes](#calling-other-commands)

<a name="introduction"></a>
## Introduction

En plus des commandes fournies par Laravel, vous pouvez aussi créer vos propres commandes pour votre application. Vous pouvez les stocker dans le dossier `app/commands`. Cependant, vous êtes libre de choisir votre propre lieu de stockage tant qu'il peut être chargé automatiquement selon la configuration de votre fichier `composer.json`.

<a name="building-a-command"></a>
## Construction d'une commande

### Génération d'une commande

Pour créer une nouvelle commande, vous pouvez utiliser la commande Artisan `command:make`, qui va générer un modèle de commande pour vous aider à démarrer :

**Génération d'une nouvelle commande**

	php artisan command:make FooCommand

Par défaut, la commande générée sera placée dans le dossier `app/commands`. Vous pouvez cependant préciser un chemin personnalisé et un namespace :

	php artisan command:make FooCommand --path="app/classes" --namespace="Classes"

### Ecriture de la commande

Une fois que votre commande est générée, vous devez remplir les propriétés nom et description de la classe, qui seront affichées dans le listing des commandes.

La méthode `fire` sera appelée quand votre commande est exécutée. Vous devez placer le contenu de votre commande dans cette méthode.

### Arguments & Options

Les méthodes `getArguments` et `getOptions` sont les lieux où vous devez définir les arguments et les options de votre commande. Ces deux méthodes retournent un tableau qui contient la liste des arguments/options, ainsi que leur description.

Lors de la définition des `arguments`, le tableau de définition des valeurs se présente de la manière suivante :

	array($name, $mode, $description, $defaultValue)

L'argument `mode` peut être n'importe laquelle de ces valeurs : `InputArgument::REQUIRED` ou `InputArgument::OPTIONAL`.

Lors de la définition des `options`, le tableau de définition des valeurs se présente de la manière suivante :

	array($name, $shortcut, $mode, $description, $defaultValue)

Par les options, l'argument `mode` peut être : `InputOption::VALUE_REQUIRED`, `InputOption::VALUE_OPTIONAL`, `InputOption::VALUE_IS_ARRAY`, `InputOption::VALUE_NONE`.

Le mode `VALUE_IS_ARRAY` indique que l'option peut être utilisée plusieurs fois lors de l'appel à la commande :

	php artisan foo --option=bar --option=baz

L'option `VALUE_NONE` indique que l'option est utilisée comme un "interrupteur":

	php artisan foo --option

### Récupération des entrées

Tandis que votre commande est exécutée, vous aurez évidemment besoin d'accéder aux valeurs des arguments et des options acceptés par votre commande. Pour ce faire, vous devez utiliser les méthodes `argument` et `option` :

**Récupère la valeur d'un argument**

	$value = $this->argument('name');

**Récupère tous les arguments**

	$arguments = $this->argument();

**Récupère la valeur d'une option**

	$value = $this->option('name');

**Récupère toutes les options**

	$options = $this->option();

### Ecrire des messages

Pour envoyer des messages à la console, vous pouvez utiliser les méthodes `info`, `comment`, `question` et `error`. Chacune de ces méthodes utilisera la couleur AINSI appropriée pour leur rôle.

**Envoi d'information à la console**

	$this->info('Display this on the screen');

**Envoi d'un message d'erreur à la console**

	$this->error('Something went wrong!');

### Poser des questions

Vous pouvez également utiliser les méthodes `ask` et `confirm` pour demander des entrées à l'utilisateur :

**Demande d'une information à l'utilisateur**

	$name = $this->ask('What is your name ?');

**Demande d'une information secrète**

    $password = $this->secret('What is the password ?');


**Demande une confirmation à l'utilisateur**

	if ($this->confirm('Do you wish to continue? [yes|no]'))
	{
		//
	}

Vous pouvez également spécifier une valeur par défaut à la méthode `confirm`, qui doit être `true` ou `false`:

	$this->confirm($question, true);

<a name="registering-commands"></a>
## Enregistrement d'une commande

Une fois que le développement de votre commande est terminé, vous devez l'enregistrer auprès d'Artisan pour être capable de l'utiliser. Cette opération est généralement réalisée dans le fichier `app/start/artisan.php`. Dans ce fichier, vous devez utiliser la méthode `Artisan::add` pour enregistrer votre commande :

**Enregistre une commande Artisan**

	Artisan::add(new CustomCommand);

Si votre commande est enregistrée dans le [conteneur IoC](/docs/4/ioc) de votre application, vous pouvez utiliser la méthode `Artisan::resolve` pour la rendre disponible à Artisan :

**Enregistre une commande qui se trouve dans le conteneur IoC**

	Artisan::resolve('binding.name');

<a name="calling-other-commands"></a>
## Appel d'autres commandes

Si vous avez besoin d'appeler une autre commande depuis votre commande, vous pouvez le faire en utilisant la méthode `call` :

**Appel d'une autre commande**

	$this->call('command.name', array('argument' => 'foo', '--option' => 'bar'));
