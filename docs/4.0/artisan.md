# Artisan CLI

- [Introduction](#introduction)
- [Utilisation](#usage)

<a name="introduction"></a>
## Introduction

Artisan est le nom de l'interface en ligne de commande présente dans Laravel. Elle fournit un ensemble de commandes puissantes et utilisables pendant le développement des applications. Cette interface est basée sur le puissant composant Console de Symfony.

<a name="usage"></a>
## Utilisation

La commande `list` permet de visualiser la liste exhaustive des commandes disponibles dans Artisan :

**Afficher la liste des commandes disponibles**

	php artisan list

De plus, chaque commande possède un écran d'aide décrivant les arguments et les options disponibles. Insérer le terme `help` avant le nom d'une commande permet d'afficher cet écran d'aide : 

**Afficher l'écran d'aide d'une commande**

	php artisan help migrate

Vous pouvez indiquer l'environnement devant être utilisé pour l'exécution d'une commande à l'aide de l'option `--env` :

**Indiquer l'environnement d'exécution**

	php artisan migrate --env=local

Vous pouvez aussi afficher la version de votre installation Laravel à l'aide de l'option `--version` : 

**Afficher la version de Laravel**

	php artisan --version
