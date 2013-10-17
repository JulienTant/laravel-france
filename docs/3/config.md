# Configuration

## Au menu

- [Les bases](#the-basics)
- [Obtention d'options](#retrieving-options)
- [Définition d'options](#setting-options)

<a name="the-basics"></a>
## Les bases

Parfois vous devez obtenir et définir des options lors de l'exécution de votre application. Pour cela, utilisez la classe **Config**, qui utilise la syntaxe "point" pour accéder aux fichiers de configuration et à leurs éléments.

<a name="retrieving-options"></a>
## Obtention d'options

#### Retourne une option de configuration :

	$value = Config::get('application.url');

#### Retourne une valeur par défaut si l'option de configuration n'existe pas :

	$value = Config::get('application.timezone', 'UTC');

#### Retourne un tableau avec toutes les valeurs de configuration :

	$options = Config::get('database');

<a name="setting-options"></a>
## Définition d'options

#### Définit une option de configuration :

	Config::set('cache.driver', 'apc');
