# Traduction & Localisation

- [Introduction](#introduction)
- [Fichiers de langues](#language-files)
- [Utilisation basique](#basic-usage)
- [Plurialisation](#pluralization)

<a name="introduction"></a>
## Introduction

La classe `Lang` fournit une manière efficace de retrouver des chaînes de caractères de différentes langues, vous permettant de supporter facilement plusieurs langues au sein de votre application.

<a name="language-files"></a>
## Fichiers de langues

Les chaînes de langues sont stockées dans des fichiers à l'intérieur du dossier `app/lang`. Dans ce dossier, il doit y avoir un dossier pour chaque langue supportée par votre application.

	/app
		/lang
			/en
				messages.php
			/fr
				messages.php

Les fichiers de langues sont simplements des tableaux avec des clés. Par exemple:

**Fichier de langue d'exemple**

	<?php

	return array(
		'welcome' => 'Bienvenue sur notre application'
	);

La langue par défaut est définie dans le fichier de configuration `app/config/app.php`. Vous pouvez changer la langue durant l'exécution grâce à la méthode `App::setLocale` :

**Changement de langue durant l'exécution**

	App::setLocale('fr');

<a name="basic-usage"></a>
## Utilisation basique

**Retrouve une ligne depuis un fichier de traduction**

	echo Lang::get('messages.welcome');

Le premier segment passé à la méthode `get` est le nom du fichier de traduction, dans notre cas il s'agit de 'messages'. La seconde partie est le nom de la ligne qui doit être retrouvée, dans notre cas 'welcome'.

> **Note*: Si la ligne n'existe pas dans le fichier, la clé sera renvoyée par la méthode `get`.

**Ligne de traduction variable**

Vous pouvez placer une variable dans votre ligne de langue :

	'welcome' => 'Bienvenue, :name',

Ensuite, passez un tableau de correspondance en tant que second argument à la méthode `Lang::get` :

	echo Lang::get('messages.welcome', array('name' => 'Dayle'));

**Determine si un fichier de traduction contient une ligne**

	if (Lang::has('messages.welcome'))
	{
		// la ligne est trouvée
	}

<a name="pluralization"></a>
## Plurialisation

Pluralisation est un problème complexe, étant donné que les règles ne sont pas les mêmes selon les langues. Vous pouvez gérer cela facilement dans vos fichiers de langues. En utilisant le caractère '|', vous pouvez séparer le singulier et le pluriel d'une chaîne :

	'pommes' => 'Il y a une pomme|Il y a plusieurs pommes',

Ensuite, vous utiliserez la méthode `Lang::choice` pour retrouver cette ligne:

	echo Lang::choice('messages.apples', 10);

Etant donné que le traducteur de Laravel utilise le composant Translation de Symfony, vous pouvez créer des règles de plurialisation très explicites facilement :

	'apples' => '{0} Il n\'y en a pas|[1,19] Il y en a quelques une|[20,Inf] Il y en a beaucoup',
