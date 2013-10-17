# Tests unitaires

## Au menu

- [Les bases](#the-basics)
- [Création d'une classe de tests](#creating-test-classes)
- [Exécution de tests](#running-tests)
- [Appel d'un contrôleur depuis un test](#calling-controllers-from-tests)

<a name="the-basics"></a>
## Les bases

Les tests unitaires servent à tester votre code et vérifier qu'il fonctionne correctement. En fait, certains affirment qu'il faut d'abord écrire les tests et ensuite écrire votre code, afin qu'il réponde positivement aux tests. Laravel fournit une intégration de la bibliothèque la plus utilisé en PHP : [PHPUnit](http://www.phpunit.de/manual/current/fr/), ce qui rend facile le démarrage rapide de l'écriture test ! Le framework Laravel lui même a des centaines de tests unitaires.

<a name="creating-test-classes"></a>
## Création d'une classe de tests

Tous les tests de notre application se trouveront dans le dossier **application/tests**. Dans ce dossier existe un fichier fourni de base avec Laravel : **example.test.php**. C'est un fichier de test très basique. Ouvrez le et observez son contenu :

	<?php

	class TestExample extends PHPUnit_Framework_TestCase {

		/**
		 * Test that a given condition is met.
		 *
		 * @return void
		 */
		public function testSomethingIsTrue()
		{
			$this->assertTrue(true);
		}

	}

Prenez note également que l'extension du fichier est **.test.php**. Cela indique à Laravel que ce fichier doit être considéré comme un cas de test lorsque vous exécuterez vos tests. Les fichiers dans ce dossier qui ne finissent pas par .test.php ne seront pas considérés.

Si vous écrivez des tests pour un bundle, alors placez le dans un dossier **tests** à la racine de votre bundle. Laravel va gérer le reste !

Pour plus d'informations concernant la création de cas de tests, lisez la [documentation de PHPUnit](http://www.phpunit.de/manual/current/fr/).

<a name="running-tests"></a>
## Exécution de tests

Pour exécuter vos tests, vous pouvez utiliser Artisan :

#### Exécution des tests de l'application via Artisan :

	php artisan test

#### Exécution des test d'un bundle :

	php artisan test bundle-name

<a name="#calling-controllers-from-tests"></a>
## Appel d'un contrôleur depuis un test

Voici un exemple qui illustre comment vous pouvez appeler vos contrôleurs depuis vos tests :

#### Appel d'un contrôleur depuis un test :

	$response = Controller::call('home@index', $parameters);

#### Résolution d'une instance d'un contrôleur depuis un test :

	$controller = Controller::resolve('application', 'home@index');

> **Note:** Les filtres d'action de votre contrôleur seront exécutés lorsque vous utilisez `Controller::call`.
