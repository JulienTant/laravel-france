# Validation

## Au menu

- [Les bases](#the-basics)
- [Règles de validation](#validation-rules)
- [Retrouver les messages d'erreurs](#retrieving-error-messages)
- [Processus de validation](#validation-walkthrough)
- [Message d'erreur personnalisé](#custom-error-messages)
- [Règles de validations personnalisées](#custom-validation-rules)

<a name="the-basics"></a>
## Les bases

Presque toutes les applications web interactives ont besoin de valider des données. Par exemple, pour l'enregistrement d'un utilisateur, vous devez vérifier que le mot de passe est bien confirmé, que l'adresse email doit être unique. Valider des données peut être un processus lourd. Heureusement, ce n'est pas le cas avec Laravel. La classe `Validator` fournit un tableau de validation génial, qui transforme la validation en un jeu d'enfant. Voyons cela en exemple :

#### Obtient un tableau avec toutes les données que l'on souhaite valider :

	$input = Input::all();

#### Définition  du tableau de validation :

	$rules = array(
		'name'  => 'required|max:50',
		'email' => 'required|email|unique:users',
	);

#### Création d'une instance de Validator et validation des données :

	$validation = Validator::make($input, $rules);

	if ($validation->fails())
	{
		return $validation->errors;
	}

Avec la propriété *errors*, vous pouvez accéder simplement à une collection de la classe Message qui facilite le travail avec les messages d'erreurs. Bien sûr, des messages d'erreurs par défaut existent pour toutes les règles de validation existantes. Les messages par défaut se trouvent dans **language/fr/validation.php**.

Maintenant que vous êtes familiarisé avec l'utilisation basique de la classe Validator, nous pouvons creuser le sujet et en savoir plus à propos des règles de validation qui vous sont offertes par défaut avec Laravel

<a name="validation-rules"></a>
## Règles de validation

- [Requis](#rule-required)
- [Alpha, alpha-numerique, & alpha-tiret](#rule-alpha)
- [Taille](#rule-size)
- [Nombres](#rule-numeric)
- [Inclusion & Exclusion](#rule-in)
- [Confirmation](#rule-confirmation)
- [Acceptation](#rule-acceptance)
- [Identique & Différent](#same-and-different)
- [Expressions régulières](#regex-match)
- [Unicité et existence ](#rule-unique)
- [Dates](#dates)
- [Adresses E-Mail](#rule-email)
- [URLs](#rule-url)
- [Uploads](#rule-uploads)
- [Tableaux](#rule-arrays)

<a name="rule-required"></a>
### Requis

#### Valide qu'un attribut est présent et n'est pas une chaîne vide :

	'name' => 'required'

#### Valide qu'un attribut est présent, lorsqu'un autre attribut est présent :
	'last_name' => 'required_with:first_name'

<a name="rule-alpha"></a>
### Alpha, alpha-numerique, & alpha-tiret

#### Valide qu'un attribut ne contient que des lettres :

	'name' => 'alpha'

#### Valide qu'un attribut ne contient que des chiffres et des lettres:

	'username' => 'alpha_num'

#### Valide qu'un attribut ne contient que des chiffres, des lettres, des tirets et des underscore :

	'username' => 'alpha_dash'

<a name="rule-size"></a>
### Taille

#### Valide qu'un attribut fait la longueur donnée, ou alors si c'est un chiffre qu'il soit de la valeur donnée :

	'name' => 'size:10'

#### Valide que la taille d'un attribut soit dans cette plage :

	'payment' => 'between:10,50'

> **Note:** Tous les mins et les maxs sont inclusifs.

#### Valide qu'un attribut fasse au moins la taille donnée :

	'payment' => 'min:10'

#### Valide qu'un attribut ne soit pas plus grand que la taille donnée :

	'payment' => 'max:50'

<a name="rule-numeric"></a>
### Nombres

#### Valide que c'est un nombre :

	'payment' => 'numeric'

#### Valide que c'est un entier :

	'payment' => 'integer'

<a name="rule-in"></a>
### Inclusion & Exclusion

#### Valide qu'un attribut soit contenu dans la liste :

	'size' => 'in:small,medium,large'

#### Valide qu'un attribut ne soit pas dans la liste :

	'language' => 'not_in:cobol,assembler'

<a name="rule-confirmation"></a>
### Confirmation

La règle *confirmed* valide que pour un attribut donné (disons password), un second attribut nommé *password_confirmation* existe.

#### Valide que l'attribut est confirmé :

	'password' => 'confirmed'

<a name="rule-acceptance"></a>
### Acceptation

La règle *accepted* valide qu'un attribut est égal à *yes* ou à *1*. Cette règle est utile pour valider les checkbox d'acceptation des "conditions générales d'utilisations" par exemple :

#### Valide qu'un attribut est accepté :

	'terms' => 'accepted'

<a name="same-and-different"></a>
## Identique & Différent

#### Valide qu'un attribut soit identique à un autre :

	'token1' => 'same:token2'

#### Valide que deux attributs ont des valeurs différents :

	'password' => 'different:old_password',

<a name="regex-match"></a>
### Expressions régulières

La règle *match* vérifie qu'un attribut correspond à l'expression régulière .

#### Valide qu'un attribut correspond à l'expression régulière :

	'username' => 'match:/[a-z]+/';

<a name="rule-unique"></a>
### Unicité et existence

#### Valide qu'un attribut est unique dans la table de base de données donnée :

	'email' => 'unique:users'

Dans l'exemple ci dessus, l'unicité de l'attribut email sera vérifiée dans la table *users*. Si le nom de l'attribut ne correspond pas au nom de la colonne dans votre table, utilisez la syntaxe suivante :

#### Spécifie un nom de colonne personnalisé pour la règle d'unicité :

	'email' => 'unique:users,email_address'

Le cas de la mise à jour de données avec la règle d'unicité est particulier. En effet, si un utilisateur met à jour son profil, et ne change pas son adresse email, le système détectera celle-ci comme un doublon, étant donné qu'elle se trouve déjà dans la base. Pour résoudre ce problème, indiqué à la règle l'ID que vous souhaitez ignoré.

#### Force la règle 'unique' à ignorer l'ID donné :

	'email' => 'unique:users,email_address,10'

#### Valide qu'un attribut existe dans la table donnée :

	'state' => 'exists:states'

#### Spécifie un nom de colonne personnalisé pour la règle 'exists':

	'state' => 'exists:states,abbreviation'

<a name="dates"></a>
### Dates

#### Valide qu'une date est avant une date donnée :

	'birthdate' => 'before:1986-28-05';

#### Valide qu'une date est après une date donnée :

	'birthdate' => 'after:1986-28-05';

> **Note:** Les règles de validation **before** et **after** utilisent la fonction PHP `strtotime` pour convertir votre date en quelque chose que la règle peut comprendre.

#### Valide qu'une date respecte un format donné :

    'start_date' => 'date_format:H\\:i',

> **Note:** Le backslash échape le deux points pour qu'il ne soit pas considéré comme un séparateur de paramètre.

Les options de formatage des dates sont définies dans la [documentation PHP](http://php.net/manual/fr/datetime.createfromformat.php#refsect1-datetime.createfromformat-parameters).

<a name="rule-email"></a>
### Adresses E-Mail 

#### Valide qu'un attribut soit une adresse email :

	'address' => 'email'

> **Note:** Cette règle utilise la fonction PHP `filter_var`.

<a name="rule-url"></a>
### URLs

#### Valide qu'un attribut est une URL :

	'link' => 'url'

#### Valide qu'un attribut est une URL active :

	'link' => 'active_url'

> **Note:** La règle *active_url* utilise la fonction `checkdnsr` pour vérifier que l'URL est active.

<a name="rule-uploads"></a>
### Uploads

La règle *mimes* valide qu'un fichier uploadé à un MIME type donné. Cette règle utilise l'extension Fileinfo de PHP pour lire le contenu du fichier et déterminer le MIME type de ce dernier. N'importe quelle extension définie dans le fichier **config/mimes.php** peut être passée à cette règle en tant que paramètre :

#### Valide qu'un fichier est du type donné :

	'picture' => 'mimes:jpg,gif'

> **Note:** Lorsque vous validez un fichier, soyez sûr d'utiliser Input::file() ou Input::all() pour rassembler des données.

#### Valide qu'un fichier est une image :

	'picture' => 'image'

#### Valide qu'un fichier est une image qui ne fait pas plus de 100 kilobytes:

	'picture' => 'image|max:100'

<a name="rule-arrays"></a>
### Tableaux

#### Valide qu'un attribut est un tableau

    'categories' => 'array'

#### Valide qu'un attribut est un tableau de 3 éléments

    'categories' => 'array|count:3'

#### Valide qu'un attribut est un tableau, et a entre 1 et 3 éléments

    'categories' => 'array|countbetween:1,3'

#### Valide qu'un attribut est un tableau, et a au moins 2 éléments

    'categories' => 'array|countmin:2'

#### Valide qu'un attribut est un tableau, et a au plus 2 éléments

    'categories' => 'array|countmax:2'


<a name="retrieving-error-messages"></a>
## Retrouver les messages d'erreurs

Laravel rend le travail avec les messages d'erreur agréable grâce à une classe de collection d'erreur simple. Après avoir appelé les méthodes `passes` ou `fails` sur une instance de Validator, vous pourrez accéder aux messages d'erreur via la propriété *errors*. Le collecteur d'erreur a plusieurs fonctions simples pour retrouver les messages d'erreurs :

#### Détermine si un attribut a un message d'erreur :

	if ($validation->errors->has('email'))
	{
		// l'attribut email a des erreurs ...
	}

#### Retrouve le premier message d'erreur pour un attribut :

	echo $validation->errors->first('email');

Parfois il est nécessaire de formater le message d'erreur en le plaçant dans du code HTML. Avec le joker :message, passez le format de votre message en second argument à la méthode.

#### Formate un message d'erreur :

	echo $validation->errors->first('email', '<p>:message</p>');

#### Retourne tous les messages d'erreur d'un attribut donné :

	$messages = $validation->errors->get('email');

#### Formate tous les messages d'erreur d'un attribut donné :

	$messages = $validation->errors->get('email', '<p>:message</p>');

#### Retourne tous les messages d'erreur pour tous les attributs :

	$messages = $validation->errors->all();

#### Formate tous les messages d'erreur pour tous les attributs :

	$messages = $validation->errors->all('<p>:message</p>');

<a name="validation-walkthrough"></a>
## Processus de validation

Une fois que vous avez réalisé votre validation, vous avez besoin d'un moyen simple de retourner les erreurs à la vue. Laravel rend cela incroyablement simple. Voyons un scénario typique, et commençons par définir les routes :

	Route::get('register', function()
	{
		return View::make('user.register');
	});

	Route::post('register', function()
	{
		$rules = array(...);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
		{
			return Redirect::to('register')->with_errors($validation);
		}
	});

Bien, nous avons deux routes d'enregistrement simples : une pour afficher le formulaire, et une pour poster les données. Dans la route POST, nous exécutons quelques règles de validation sur les entrées. Si la validation échoue, nous redirigeons l'utilisateur vers le formulaire, et nous flashons les erreurs de validation dans la session, ils seront donc disponibles pour être affichés.

**Mais, remarquez que nous ne n'attachons à aucun moment les erreurs à la vue**. Cependant, une variable $errors sera disponible dans la vue. Laravel détermine intelligemment si une erreur existe dans la session, et si elle existe, elle sera automatiquement attachée à la vue pour vous. Si aucune erreur n'existe, la variable existera tout de même mais le conteneur sera vide. Cela nous permet de s'assurer que dans notre vue, une variable erreur existe quoi qu'il arrive. Nous aimons vous simplifier la vie !

Par exemple, si notre adresse email n'est pas valide, nous pouvons vérifier que le conteneur d'erreur a une erreur pour l'attribut 'email' :

	$errors->has('email')

Avec Blade, nous pouvons alors afficher un message d'erreur de manière conditionnelle.

	{{ $errors->has('email') ? 'Adresse email invalide' : 'Pas d'erreur, nous devrions ne rien écrire ici' }}

Ceci est également super quand nous avons besoin d'ajouter une classe lorsque nous utilisons par exemple Twitter Bootstrap : 

	<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
	
Lorsque la validation échoue, le class *error* sera ajoutée au div :

	<div class="control-group error">
	

<a name="custom-error-messages"></a>
## Messages d'erreur personnalisés

Vous ne souhaitez pas utiliser les messages d'erreur par défaut ? Peut-être que vous souhaitez utiliser un message d'erreur personnalisé pour un attribut et une règle précise. Avec la classe Validator, c'est vraiment facile.

#### Crée un tableau avec un message d'erreur personnel pour le validateur :

	$messages = array(
		'required' => 'Le champ :attribute field est requis.',
	);

	$validation = Validator::make(Input::get(), $rules, $messages);

Maintenant notre message d'erreur sera utilisé lorsque la validation échouera. Pour rendre votre vie plus facile, la classe Validator remplacera le joker **:attribute** par le nom de l'attribut. Il supprimera même les underscores par des espaces.

Il existe d'autres jokers : **:other**, **:size**, **:min**, **:max**, et **:values**. Voilà comment les utiliser :

#### Autres messages de validation :

	$messages = array(
		'same'    => 'Les attributs :attribute et :other doivent être identiques.',
		'size'    => 'Le :attribute doit être exactement :size.',
		'between' => 'Le :attribute doit être entre :min et :max.',
		'in'      => 'Le :attribute doit avoir un des types suivants : :values',
	);

Comment faire pour avoir un message d'erreur précis pour faire que le champ email soit requis ? Ajoutez le message au tableau en utilisant la convention **nomDeLattribut_nomDeLaRegle** :

#### Spécifie un message d'erreur personnalisé pour un attribut et une règle donnés :

	$messages = array(
		'email_required' => 'Nous avons besoin de votre adresse email !',
	);

Dans l'exemple ci-dessus, le message personnalisé sera utilisé pour l'attribut email, alors que tous les autres attributs auront le message par défaut.

Si vous allez utiliser un message d'erreur personnalisé dans plusieurs endroits de votre application, vous pouvez l'insérer dans l'élément **custom** du tableau se trouvant dans le fichier de la langue : 

#### Ajoute un message d'erreur personnalisé dans le fichier de langue :

	'custom' => array(
		'email_required' => 'Nous avons besoin de votre adresse email !',
	)

<a name="custom-validation-rules"></a>
## Règles de validation personnalisées

Laravel fourni un grand nombre de règles puissantes, cependant il est fort probable que vous ayez besoin d'écrire des règles propres à votre application. Il y a deux méthodes simples pour créer des règles de validation. Les deux méthodes sont efficaces, utilisez donc celle qui est la plus appropriée pour votre projet.

#### Enregistre une règle de validation personnalisée :

	Validator::register('genial', function($attribute, $value, $parameters)
	{
	    return $value == 'génial';
	});

Dans cet exemple, nous enregistrons une nouvelle règle de validation dans le Validator. La règle reçoit trois arguments : le premier est le nom de l'attribut qui est validé, le second est le valeur de l'attribut qui est validé, et le troisième est un tableau des paramètres passés à la règle.

Vous utiliserez votre règle personnalisée comme n'importe quelle autre règle : 

	$rules = array(
    	'username' => 'required|awesome',
	);

Et bien sîr, vous devrez définir un message d'erreur par défaut pour votre règle. 

	$messages = array(
    	'awesome' => 'L\'attribut n'est pas génial !',
	);

	$validator = Validator::make(Input::get(), $rules, $messages);

Ou en ajoutant votre entrée dans le fichier **language/LOCALE/validation.php** :

	'awesome' => 'L\'attribut n'est pas génial !',

Comment mentionné ci dessus, vous pouvez recevoir une liste d'arguments :

	// Création du tableau de validation...

	$rules = array(
	    'username' => 'required|awesome:yes',
	);

	// dans votre règle personnalisée...

	Validator::register('awesome', function($attribute, $value, $parameters)
	{
	    return $value == $parameters[0];
	});

Dans ce cas, l'argument parameters de votre règle de validation contiendra un tableau avec un seul élément : 'yes'.

Une autre méthode pour créer et stocker des règles de validation personnalisées est d'hériter de la classe Validator. En héritant votre classe de la classe Validator, vous pourrez profiter de toutes les règles existantes, des vôtres, et vous pourrez même réécrire certaines règles ! Voyons cela ensemble : 

Premièrement, créez une classe qui hérite de **Laravel\Validator** et placez la dans votre dossier **application/libraries** :

#### Définie une classe de validation personnalisée :

	<?php

	class Validator extends Laravel\Validator {}

Ensuite, supprimez l'alias Validator de votre fichier **config/application.php**. Cela est nécessaire pour ne pas avoir deux classes Validator dans votre espace de travail.

Ensuite, insérons notre règle "genial" : 

#### Ajout d'une règle personnelle dans notre classe de validation :

	<?php

	class Validator extends Laravel\Validator {

	    public function validate_genial($attribute, $value, $parameters)
	    {
	        return $value == 'génial';
	    }

	}

Remarquez que le nom de la règle respecte une convention : **validate_nomDeLaRegle**. Cette règle s'appelle "genial" alors la méthode doit s'appeler "validate_genial".

Gardez en tête que dans ce cas précis, vous devez également écrire vos messages d'erreurs par défaut. La méthode pour le faire est la même, qu'importe où la règle soit déclarée !
