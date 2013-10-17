# Développement de packages

- [Introduction](#introduction)
- [Création d'un package](#creating-a-package)
- [Structure d'un package](#package-structure)
- [Fournisseurs de services](#service-providers)
- [Conventions des packages](#package-conventions)
- [Processus de développement](#development-workflow)
- [Routage de package](#package-routing)
- [Configuration de package](#package-configuration)
- [Migration dans un package](#package-migrations)
- [Ressources d'un package](#package-assets)
- [Publication d'un package](#publishing-packages)

<a name="introduction"></a>
## Introduction

Les Packages sont la manière principale d'ajouter des fonctionnalités à Laravel. Un package peut être n'importe quoi, un outil pour travailler efficacement avec les dates comme [Carbon](https://github.com/briannesbitt/Carbon), ou un framework entier de test en BDD comme [Behat](https://github.com/Behat/Behat).

Bien sûr, il y a différents types de packages. Certains packages sont autonomes, cela signifie qu'ils marcheront dans tous les contextes, pas juste avec Laravel. Par exemple, Carbon et Behat font partie de ces packages autonomes. Ces packages peuvent être ajouter facilement à votre projet en ajoutant une ligne dans le fichier `composer.json`.

Et d'un autre côté, il y a des packages développés spécifiquement pour Laravel. Dans les versions précédentes de Laravel, ces packages étaient connus sous le nom de "bundles". Ces packages peuvent avoir des routes, des contrôleurs, des vues, des fichiers de configuration et des migrations développés spécifiquement pour améliorer une application Laravel. Etant donné qu'aucune règle particulière n'existe pour développer un package autonome, ce guide couvrira le développement des packages spécifiques pour Laravel.

Tous les packages Laravel sont distribués via [Packagist](http://packagist.org) et [Composer](http://getcomposer.org), il est donc essentiel de savoir utiliser ces merveilleux outils de distribution de packages PHP.

<a name="creating-a-package"></a>
## Création d'un package

La manière la plus simple de créer un package Laravel est d'utiliser la commande Artisan `workbench` de Laravel. D'abord, vous aurez besoin de définir quelques options dans le fichier `app/config/workbench.php`. Dans ce fichier, vous trouverez une option `name` et `email`. Ces valeurs sont utilisées pour générer un fichier `composer.json` pour vos nouveaux packages. Une fois que vous avez inscrit ces valeurs, vous êtes prêt à construire un package !

**Exécution de la commande Artistan `workbench`**

	php artisan workbench vendor/package --resources

Le nom du vendor est une manière de distinguer votre package de celui des autres qui aurait le même nom. Par exemple, si je (Taylor Otwell) créais un nouveau package nommé "Zapper", le nom du vendor pourrait être `Taylor` et le nom du package serait `Zapper`. Par défaut, le framework va créer un package générique ; cependant, la commande `resource` dit au workbench de générer le package avec les dossiers spécifiques de Laravel tels que `migrations`, `views`, `config`, etc.

Une fois que la commande `workbench` a été exécutée, votre package sera disponible dans le dossier `workbench` de votre installation Laravel. Ensuite, vous devez enregistrer le `ServiceProvider` qui a été créé pour votre package. Vous devez enregistrer le fournisseur en l'ajoutant dans le tableau `providers` du fichier de configuration `app/config/app.php`. Cela dira à Laravel de charger votre package lorsque votre application démarre. Les fournisseurs de services utilisent une convention de nommage de la forme suivante : `[NomDuPackage]ServiceProvider`. Donc, en utilisant l'exemple précédent, vous ajouterez la ligne `Taylor\Zapper\ZapperServiceProvider` au tableau `providers`.

Une fois que le fournisseur a été enregistré, vous êtes prêt à développer votre package ! Cependant, avant de se lancer dedans, vous devriez lire les sections ci-dessous pour être plus familier avec la structure d'un package et avoir un bon processus de développement.

<a name="package-structure"></a>
## Structure d'un package

Lorsque vous utilisez la commande `workbench`, votre package sera créé en respectant des conventions qui permettront au package de s'intégrer facilement avec les autres parties du framework Laravel :

**Structure basique d'un package Laravel**

	/src
		/Vendor
			/Package
				PackageServiceProvider.php
		/config
		/lang
		/migrations
		/views
	/tests
	/public

Décrivons un peu cette structure. Le dossier `src/Vendor/Package` est la racine de toutes les classes de votre package, y compris le `ServiceProvider`. Les dossiers `config`, `lang`, `migrations`, et `views`, comme vous l'aurez deviné, contiennent les ressources correspondantes pour votre package. Les packages peuvent contenir n'importe laquelle de ces ressources, tout comme une "application régulière".

<a name="service-providers"></a>
## Fournisseurs de services

Les fournisseurs de services sont des classes de démarrage pour les packages. Par défaut, elles contiennent deux méthodes : `boot` et `register`. Dans ces méthodes vous pouvez faire ce que vous souhaitez : inclure un fichier de route, enregistrer des liaisons dans le conteneur IoC, écouter des événements...

La méthode `register` est appelée directement lors de l'enregistrement du fournisseur de service, tandis que la méthode `boot` est appelée juste avant qu'une requête soit routée. Donc, si des actions dans votre fournisseur de service dépendent d'un autre fournisseur de service déjà enregistré, ou que vous souhaitez surcharger des services liés par un autre fournisseur, vous devrez le faire dans la méthode `boot`.

Lors de la création d'un package avec `workbench`, la commande `boot` contient déjà une action :

	$this->package('vendor/package');

Cette méthode autorise Laravel à connaitre comment charger correctement les vues, la configuration, et les autres ressources dans votre application. En général, il ne doit pas y avoir besoin de changer cette ligne de code, étant donné qu'elle met en place le package en utilisant les conventions.

<a name="package-conventions"></a>
## Conventions des packages

Lorsque vous utilisez une ressource depuis un package, comme des options de configuration ou des vues, un double deux points ( :: ) sera généralement utilisé :

**Chargement d'une vue depuis un package**

	return View::make('package::view.name');

**Récupération d'une option de configuration depuis un package**

	return Config::get('package::group.option');

> **Note:** Si votre package contient des migrations, préfixez le nom de votre migration avec le nom de votre package pour éviter d'avoir des conflits de nom de classes avec d'autres packages.

<a name="development-workflow"></a>
## Processus de développement

Lorsque vous développez un package, il est utile de pouvoir développer dans le contexte d'une application, vous permettant de voir facilement et de faire des essais sur vos templates, etc... Alors pour commencer, installer une copie fraîche du framework Laravel, ensuite utilisez la commande `workbench` pour créer la structure d'un package.

Une fois que la commande `workbench` a créé le package, vous pouvez utiliser `git init` depuis le dossier `workbench/[vendor]/[package]` et `git push` votre package directement depuis le workbench ! Cela vous permettra de développer commodément votre package dans le contexte d'une application sans avoir à lancer sans arrêt la commande `composer update` pour avoir une copie à jour de ce dernier.

Étant donné que vos packages sont dans le dossier `workbench`, vous pouvez vous demander comment Composer sait comment charger les fichiers de votre package. En fait, quand le dossier `workbench` existe, Laravel va intelligemment le scanner à la recherche de package, et charger leurs fichiers d'autoload Composer au démarrage de l'application !

<a name="package-routing"></a>
## Routage de package

Dans les versions précédentes de Laravel, une clause `handles` était utilisée pour spécifier à quelles URIs le package peut répondre. Cependant dans Laravel 4, un package peut répondre à n'importe quelle URI. Pour charger un fichier de route pour votre package, ajoutez simplement un `include` vers le fichier dans la méthode `boot`.

**Inclusion d'un fichier de route dans le fournisseur de service**

	public function boot()
	{
		$this->package('vendor/package');

		include __DIR__.'/../../routes.php';
	}

<a name="package-configuration"></a>
## Configuration de package

Certains packages peuvent avoir besoin de fichiers de configuration. Ces fichiers doivent être définis de la même manière que les autres fichiers de configuration de votre application. Et, si vous utilisez la méthode `$this->package` écrite par défaut avec l'outil workbench, alors vous pourrez accéder à vos fichiers de configuration en utilisant la syntaxe habituelle des doubles deux points :

**Accès à une option de configuration d'un package**

	Config::get('package::file.option');

Cependant, si votre package contient uniquement un fichier de configuration, vous pouvez simplement l'appeler `config.php`. S'il s'appelle ainsi, vous pouvez accéder directement à ces options, sans avoir à spécifier le nom du fichier :

**Accès directe à une option du fichier config.php**

	Config::get('package::option');

### Fichiers de configuration en cascade

Quand d'autres développeurs installent votre package, ils peuvent vouloir surcharger certaines options de configuration. Cependant, s'ils changent les valeurs dans le code source de votre package, ils seront écrasés quand Composer mettra à jour le package. A la place, la commande artisan `config:publish` devrait être utilisée :

**Execution de la commande config:publish**

	php artisan config:publish vendor/package

Quand cette commande est exécutée, les fichiers de configuration de votre package sont copiés dans le dossier `app/config/packages/vendor/package` où ils peuvent être modifiés en toute sécurité par le développeur !

> **Note:** Le développeur peut également créer des fichiers de configuration spécifiques aux environnements pour votre package en les plaçant dans `app/config/packages/vendor/package/environment`.

<a name="package-migrations"></a>
## Migration dans un package

Vous pouvez créer et exécuter facilement des migrations pour n'importe lequel de vos packages. Pour créer une migration pour un package dans le workbench, utilisez l'option `--bench` :

**Création d'une migration pour un package dans le workbench**

	php artisan migrate:make create_users_table --bench="vendor/package"

**Exécution de migrations d'un package dans le workbench**

	php artisan migrate --bench="vendor/package"

Pour lancer les migrations d'un package terminé qui a été installé via Composer, dans le dossier `vendor`, vous devez utiliser l'option `--package` :

**Exécution de migrations d'un package installé**

	php artisan migrate --package="vendor/package"

<a name="package-assets"></a>
## Ressources d'un package

Certains packages peuvent contenir des ressources tels que du JavaScript, CSS, des images. Cependant, nous sommes incapables de créer un lien vers les dossiers `vendor` ou `workbench`, nous devons trouver un moyen de bouger ses ressources dans le dossier `public` de notre application. La commande artisan `asset:publish` se charge de cela pour vous :

**Déplace les ressources d'un package vers le dossier public**

    php artisan asset:publish

	php artisan asset:publish vendor/package

Si le package se trouve dans le `workbench`, utilisez la directive `--bench` :

	php artisan asset:publish --bench="vendor/package"

La commande va bouger les ressources dans le dossier `public/packages` en accord avec le nom du vendor et du package. Donc, un package nommé `userscape/kudos` aura ses ressources dans le dossier `public/packages/userscape/kudos`. Utiliser ces conventions de publication de ressources permet de coder de manière sûre le chemin de vos ressources dans les vues de vos packages.

<a name="publishing-packages"></a>
## Publication d'un package

Quand votre package est prêt à être publié, vous devez le soumettre au dépôt [Packagist](http://packagist.org). Si le package est spécifique à Laravel, vous devriez ajouter le tag `laravel` à votre fichier `composer.json`.

Aussi, il est courtois et utile de tagger vos releases pour que les développeurs peuvent utiliser des versions stables lorsqu'ils demandent votre package dans leurs fichier `composer.json`. Si une version stable n'est pas prête, vous devriez utiliser la directive `branch-alias` de Composer.

Une fois que votre package a été publié, continuez vos développements sur ce package dans le contexte de l'application créé par `workbench`. C'est une bonne manière de continuer. Il s'agit d'une excellente façon de continuer à développer idéalement le package même après qu'il ait été publié.

Certaines organisations choisissent d'héberger leurs propres dépôts de packages pour leurs développeurs. Si vous êtes intéressé par cela, voyez la documentation du projet [Satis](http://github.com/composer/satis) fourni par l'équipe de Composer.
