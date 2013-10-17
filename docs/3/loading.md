# Autoloading

## Au menu

- [Les bases](#the-basics)
- [Enregistrement de répértoires](#directories)
- [Enregistrement d'une table de correspondance](#mappings)
- [Enregistrement de namespaces](#namespaces)

<a name="the-basics"></a>
## Les bases

L'autoloading vous autorise à utiliser des classes sans avoir à les **inclure** explicitement. Les seules classes chargées sont celles que vous utilisez lors d'une requête sur votre application, vous pouvez donc développer en utilisant ces classes sans avoir à les inclure manuellement.

Par défaut, les dossiers **models** et **libraries** sont enregistrés avec l'autoloader, dans le fichier **application/start.php**. Le chargeur de classes utilise le nom de fichier pour détecter où se trouvent les classes. La convention de nommage indique que le nom du fichier doit être en minuscule. Ainsi, si vous avez un modèle User dans votre dossier models, ce dernier doit résider dans un fichier nommé user.php. Lorsqu'une classe se trouve dans un sous-répertoire, donnez à votre classe un namespace qui correspond à son arborescence. Par exemple, une classe "Entities\User" se trouvera dans le fichier "entities/user.php", à l'intérieur du dossier models.

<a name="directories"></a>
## Enregistrement de répertoires

Comme vu ci-dessus, les dossiers models et libraries sont enregistrés par l'autoloader par défaut ; cependant, si vous souhaitez enregistrer un dossier qui respecte la convention de nommage de fichier décrite précédemment, vous pouvez le faire de la manière suivante :

#### Enregistre des dossiers avec l'autoloader:

	Autoloader::directories(array(
		path('app').'entities',
		path('app').'repositories',
	));

<a name="mappings"></a>
## Enregistrement d'une table de correspondance

Parfois vous voudrez faire correspondre manuellement une classe à un fichier. Cette technique est la plus performante :

#### Enregistrement d'une classe associée à son chemin:

	Autoloader::map(array(
		'User'    => path('app').'models/user.php',
		'Contact' => path('app').'models/contact.php',
	));

<a name="namespaces"></a>
## Enregistrement de namespaces

Beaucoup de bibliothèques tierces utilisent le standard PSR-0. Le PSR-0 dit que le nom de la classe doit correspondre au nom du fichier, et que le chemin vers ce fichier est indiqué par son namespace. Si vous utilisez une bibliothèque PSR-0, enregistrez simplement le namespace de base et le chemin pour y accéder :

#### Enregistre un namespace avec l'autoloader:

	Autoloader::namespaces(array(
		'Doctrine' => path('libraries').'Doctrine',
	));

Avant que les namespaces ne soient disponibles en PHP, beaucoup de projets utilisaient des underscores pour indiquer la structure des répertoires. Si vous utilisez une de ces libraries, vous pouvez également utiliser l'autoloader. Par exemple, si vous utilisez SwiftMailer, vous avez remarqué que toutes les classes commencent par "Swift_". Nous allons enregistrer "Swift" avec l'autoloader, en tant que base d'un projet utilisant les underscores.

#### Enregistre un projet "underscoré" avec l'autoloader:

	Autoloader::underscored(array(
		'Swift' => path('libraries').'SwiftMailer',
	));
