# Validation

- [Utilisation basique](#basic-usage)
- [Travail avec les messages d'erreurs](#working-with-error-messages)
- [Messages d'erreurs et vues](#error-messages-and-views)
- [Règles de validation disponibles](#available-validation-rules)
- [Messages d'erreur personnalisés](#custom-error-messages)
- [Règles de validation personnalisées](#custom-validation-rules)

<a name="basic-usage"></a>
## Utilisation basique

Laravel vous est livré avec un outil simple et pratique pour valider des données et retrouver les messages d'erreur de validation via la classe `Validation`.

**Exemple de validation basique**

	$validator = Validator::make(
		array('name' => 'Dayle'),
		array('name' => 'required|min:5')
	);

Le premier argument passé à la méthode `make` sont les données à valider. Le second argument est un tableau de règles de validation qui doit s'appliquer aux données.

De multiples règles peuvent être délimitées en utilisant le caractère "pipe" `|`, ou en tant qu'éléments séparés d'un tableau.

**Utilisation de tableau pour définir différentes règles**

	$validator = Validator::make(
		array('name' => 'Dayle'),
		array('name' => array('required', 'min:5'))
	);

Une fois que l'instance de `Validator` a été créée, les méthodes `fails` ou `passes` peuvent être utilisées pour effectuer la validation.

	if ($validator->fails())
	{
		// Les données ne passent pas la validation
	}

Si la validation échoue, vous pouvez récuperer les messages d'erreurs depuis le validateur.

	$messages = $validator->messages();

Vous pouvez également accéder à un tableau de règles de validation qui ont échoué, sans les messages. Pour ce faire, utilisez la méthode `failed` :

    $failed = $validator->failed();

**Validation de fichier**

La classe `Validator` fournit plusieurs règles spécifiques pour les fichiers, telles que `size`, `mimes`, et d'autres. Pour valider un fichier, passez le simplement au validateur avec vos autres données.

<a name="working-with-error-messages"></a>
## Travail avec les messages d'erreurs

Après avoir appelé la méthode `messages` de l'instance de la classe `Validator`, vous recevrez une instance de `MessageBag`, qui a quelques outils pour travailler avec les messages d'erreurs.

**Retrouve le premier message d'erreur pour un champ**

	echo $messages->first('email');

**Retrouve tous les messages d'erreur pour un champ**

	foreach ($messages->get('email') as $message)
	{
		//
	}

**Retrouve tous les messages d'erreur de tous les champs**

	foreach ($messages->all() as $message)
	{
		//
	}

**Détermine si un message d'erreur existe pour un champ**

	if ($messages->has('email'))
	{
		//
	}

**Retrouve un message d'erreur avec un format donné**

	echo $messages->first('email', '<p>:message</p>');

> **Note:** Par défaut, les messages sont formatés pour utiliser une syntaxe compatible avec Bootstrap.

**Retrouve tous les messages d'erreur avec un format donné**

	foreach ($messages->all('<li>:message</li>') as $message)
	{
		//
	}

<a name="error-messages-and-views"></a>
## Messages d'erreurs et vues

Une fois que vous avez effectué la validation, vous aurez besoin d'une manière simple de récuperer vos messages d'erreurs dans votre vue. C'est une chose prévue par Laravel. Considérez l'exemple ci-dessous :

	Route::get('register', function()
	{
		return View::make('user.register');
	});

	Route::post('register', function()
	{
		$rules = array(...);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('register')->withErrors($validator);
		}
	});

Notez que lorsque la validation échoue, nous passons une instance de `Validator` à la redirection grâce à la méthode `withErrors`. Cette méthode va flasher les messages d'erreurs vers la session pour les rendre disponibles lors de la prochaine requête.

Cependant, remarquez que nous n'avons pas lié explicitement les messages d'erreurs à notre vue dans la route GET. C'est parce que Laravel va toujours vérifier si des erreurs sont disponibles dans la session, et va automatiquement les lier à vos vues si c'est le cas. **Donc, il est important de noter qu'une variable `$errors` sera toujours disponible dans vos vues, pour toutes les requêtes**, vous permettant de partir du principe où la variable `$errors` sera toujours définie et peut être utilisée. La variable `$errors` sera une instance de `MessageBag`.

Donc, après une redirection vous pouvez utilisez la variable `$errors` liée automatiquement dans vos vues :

	<?php echo $errors->first('email'); ?>

<a name="available-validation-rules"></a>
## Règles de validation disponibles

Vous trouverez ci-dessous une liste des règles de validation et leurs fonctions :

- [Accepted](#rule-accepted)
- [Active URL](#rule-active-url)
- [After (Date)](#rule-after)
- [Alpha](#rule-alpha)
- [Alpha Dash](#rule-alpha-dash)
- [Alpha Numeric](#rule-alpha-num)
- [Before (Date)](#rule-before)
- [Between](#rule-between)
- [Confirmed](#rule-confirmed)
- [Date](#rule-date)
- [Date Format](#rule-date-format)
- [Different](#rule-different)
- [E-Mail](#rule-email)
- [Exists (Database)](#rule-exists)
- [Image (File)](#rule-image)
- [In](#rule-in)
- [Integer](#rule-integer)
- [IP Address](#rule-ip)
- [Max](#rule-max)
- [MIME Types](#rule-mimes)
- [Min](#rule-min)
- [Not in](#not-in)
- [Numeric](#rule-numeric)
- [Regular Expression](#rule-regex)
- [Required](#rule-required)
- [Required If](#rule-required-if)
- [Required With](#rule-required-with)
- [Same](#rule-same)
- [Size](#rule-size)
- [Unique (Database)](#rule-unique)
- [URL](#rule-url)

<a name="rule-accepted"></a>
#### accepted

Le champ sous validation doit être _yes_, _on_, ou _1_. Ceci est utile pour tester l'acceptation des Conditions Générales d'utilisation ou de vente par exemple.

<a name="rule-active-url"></a>
#### active_url

Le champ sous validation doit être une URL valide selon la fonction PHP `checkdnsrr`.

<a name="rule-after"></a>
#### after:_date_

Le champ sous validation doit être après une date donnée. Les dates seront passées à la fonction PHP `strtotime`.

<a name="rule-alpha"></a>
#### alpha

Le champ sous validation peut uniquement contenir des lettres.

<a name="rule-alpha-dash"></a>
#### alpha_dash

Le champ sous validation peut contenir des caractères alpha-numériques, ainsi que des tirets `-` et des underscores `_`.

<a name="rule-alpha-num"></a>
#### alpha_num

Le champ sous validation peut uniquement contenir des caractères alpha-numériques.

<a name="rule-before"></a>
#### before:_date_

Le champ sous validation doit être une date avant la date donnée. Les dates seront passées à la fonction PHP `strtotime`.

<a name="rule-between"></a>
#### between:_min_,_max_

Le champ sous validation doit avoir une taille entre _min_ et _max_. Les chaînes de caractères, les nombres et les fichiers sont évalués de la même manière que dans la règle `size`.

<a name="rule-confirmed"></a>
#### confirmed

Le champ sous validation doit avoir un champ de confirmation de type `foo_confirmation`. Par exemple, si votre champ sous validation est `password`, un champ `password_confirmation` doit être présent et avoir la même valeur.

<a name="rule-date"></a>
#### date

Le champ sous validation doit être une date valide selon la fonction PHP `strtotime`.

<a name="rule-date-format"></a>
#### date_format:_format_

Le champ sous validation doit correspondre au format _format_ défini, en accord avec la fonction PHP `date_parse_from_format`.

<a name="rule-different"></a>
#### different:_champ_

Le _champ_ donné doit être différent du champ sous validation.

<a name="rule-email"></a>
#### email

Le champ sous validation doit être une adresse mel correcte.

<a name="rule-exists"></a>
#### exists:_table_,_column_

Le champ sous validation doit exister dans la base de données.

**Usage basique de la règle exists**

	'state' => 'exists:states'

**Spécification d'une colonne particulière**

	'state' => 'exists:states,abbreviation'

Vous pouvez également spécifier plus de conditions qui seront ajoutés en tant que clause "WHERE" à la requête :

    'email' => 'exists:staff,email,account_id,1'

<a name="rule-image"></a>
#### image

Le fichier sous validation doit être une image (jpeg, png, bmp, ou gif).

<a name="rule-in"></a>
#### in:_foo_,_bar_,...

Le champ sous validation doit être inclus dans la liste donnée de valeurs.

<a name="rule-integer"></a>
#### integer

Le champ sous validation doit être un entier.

<a name="rule-ip"></a>
#### ip

Le champ sous validation doit être une adresse IP.

<a name="rule-max"></a>
#### max:_value_

Le champ sous validation doit être plus petit que la valeur maximum _value_. Les chaînes de caractères, les chiffres et les fichiers sont évalués comme dans la règle `size`.

<a name="rule-mimes"></a>
#### mimes:_foo_,_bar_,...

Le fichier sous validation doit avoir un type MIME qui correspond à une des extensions données.

**Utilisation basique du filtre mimes**

	'photo' => 'mimes:jpeg,bmp,png'

<a name="rule-min"></a>
#### min:_value_

Le champ sous validation doit avoir une taille minimum de _value_. Les chaînes de caractères, les chiffres et les fichiers sont évalués comme dans la règle `size`.

<a name="rule-not-in"></a>
#### not_in:_foo_,_bar_,...

Le champ sous validation ne doit pas être inclus dans la liste de valeurs données.

<a name="rule-numeric"></a>
#### numeric

Le champ sous validation doit être un chiffre.

<a name="rule-regex"></a>
#### regex:_pattern_

Le filtre sous validation doit correspondre à l'expression régulière donnée.

> **Note:** Lorsque vous utilisez la règle `regex`, il peut être nécessaire d'implémenter les règles dans un tableau plutôt qu'avec le délimiteur pipe `|`, surtout si ce dernier est utilisé dans l'expression régulière.

<a name="rule-required"></a>
#### required

Le champ sous validation doit être présent dans les données.

<a name="rule-required-if"></a>
#### required_if:_field_,_value_

Le champ sous validation doit être présent si le champ _field_ est égale à la valeur _value_.

<a name="rule-required-with"></a>
#### required_with:_foo_,_bar_,...

Le champ sous validation doit être présent _seulement si_ les autres champs spécifiés sont présents.

<a name="rule-same"></a>
#### same:_field_

Le champ _field_ doit correspondre au champ sous validation.

<a name="rule-size"></a>
#### size:_value_

Le champ sous validation doit avoir une taille correpondant à la valeur _value_. Pour les chaînes de caractères, _value_ correspond au nombre de caractères. Pour les chiffres, _value_ correspond à l'entier donné. Pour les fichiers, _value_ correspond à la taille du fichier en kilobytes.

<a name="rule-unique"></a>
#### unique:_table_,_column_,_except_,_idColumn_

Le champ sous validation doit être unique dans la table de la base de donnée. Si l'option `column` n'est pas spécifié, le nom du champ sera utilisé.

**Usage basique de la règle**

	'email' => 'unique:users'

**Spécification de la colonne**

	'email' => 'unique:users,email_address'

**Force la règle à ignorer l'id donné**

	'email' => 'unique:users,email_address,10'

<a name="rule-url"></a>
#### url

Le champ sous validation doit être formé comme une URL.

<a name="custom-error-messages"></a>
## Messages d'erreur personnalisés

Si besoin, vous pouvez utiliser des messages d'erreurs personnalisés pour la validation plutôt que ceux par défaut. Il y a plusieurs manières de définir ces messages.

**Passage des messages à la méthode make**

	$messages = array(
		'required' => 'The :attribute field is required.',
	);

	$validator = Validator::make($input, $rules, $messages);

*Note:* Le joker `:attribute` sera remplacé par le nom du champ sous validation. Vous pouvez également utiliser d'autres jokers dans les messages de validation.

**Autres jokers de validation**

	$messages = array(
		'same'    => ':attribute et :other doivent être identiques.',
		'size'    => ':attribute doit faire :size.',
		'between' => ':attribute doit être entre :min et :max.',
		'in'      => ':attribute doit être une des valeurs suivantes : :values',
	);

Parfois vous pourrez vouloir spécifier un message personnalisé uniquement pour un champ spécifique :

**Spécification d'un message d'erreur personnalisé pour un attribut précis**

	$messages = array(
		'email.required' => 'Nous avons besoin de connaître votre adresse mel !',
	);

Dans certains cas, vous pourriez vouloir spécifier vos messages d'erreurs personnalisés dans un fichier de langue plutôt que de les passer directement à `Validator`. Pour ce faire, ajoutez vos messages au tableau `custom` du fichier de langue `app/lang/xx/validation.php`.

**Spécification d'un message d'erreur personnalisé dans un fichier de langue**

	'custom' => array(
		'email' => array(
			'required' => 'Nous avons besoin de connaître votre adresse mel !',
		),
	),

<a name="custom-validation-rules"></a>
## Règles de validation personnalisées

Laravel fournit une variété de règles de validation utiles, cependant vous pourriez avoir besoin de créer vos propres règles. Une méthode pour enregistrer des règles de validation personnalisées est d'utiliser la méthode `Validator::extend` :

**Enregistrement d'une règle personnalisée**

	Validator::extend('foo', function($attribute, $value, $parameters)
	{
		return $value == 'foo';
	});

> **Note:** Le nom de la règle passée à la méthode `extend` doit être en "snake_case".

La fonction anonyme de validation reçoit trois arguments : le nom du champ (`$attribute`) qui se fait valider, la valeur (`$value`) du champ, et le tableau des paramètres (`$parameters`) passés à la règle.

Vous pouvez également utiliser une classe et une méthode à la méthode `extend` plutôt qu'une fonction anonyme :

    Validator::extend('foo', 'FooValidator@validate');

Notez que vous devrez également définir un message d'erreur personnalisé. Vous pouvez le faire soit en utilisant un tableau avec votre message personnel à chaque fois que vous appellerez votre règle de validation personnalisée, soit en ajoutant une entrée dans le fichier de langue de validation.

Plutôt que d'utiliser des fonctions anonymes pour étendre le validateur, vous pouvez étendre la classe Validator elle-même. Pour ce faire, écrivez une classe Validator qui hérite de `Illuminate\Validation\Validator`. Vous pouvez ensuite ajouter vos méthodes de validation en préfixant leur nom par `validate`:

**Extension de la classe Validator**

	<?php

	class CustomValidator extends Illuminate\Validation\Validator {

		public function validateFoo($attribute, $value, $parameters)
		{
			return $value == 'foo';
		}

	}

Ensuite, vous devez enregistrer votre classe de validation personnalisée :

**Enregistrement d'une nouvelle classe de validation**

	Validator::resolver(function($translator, $data, $rules, $messages)
	{
		return new CustomValidator($translator, $data, $rules, $messages);
	});

Lorsque vous créez une règle de validation personnalisée, vous pourriez avoir besoin de créer des jokers personnalisés pour les messages d'erreurs. Vous pouvez les créer en ajoutant une méthode `replaceXXX` au validateur.

	protected function replaceFoo($message, $attribute, $rule, $parameters)
	{
		return str_replace(':foo', $parameters[0], $message);
	}
