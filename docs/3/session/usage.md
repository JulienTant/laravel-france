# Utilisation des sessions

## Au menu

- [Stockage d'éléments](#put)
- [Récupération d'éléments](#get)
- [Suppression d'élément](#forget)
- [Flashage d'élément](#flash)
- [Régénération de l'ID de session](#regeneration)

<a name="put"></a>
## Stockage d'éléments

Pour stocker des éléments dans la session, utilisez la méthode **put** de la classe **Session** :

	Session::put('name', 'Taylor');

le premier paramètre est la **clé** de l'élément de session. le second paramètre est la **valeur** associée à la clé.

<a name="get"></a>
## Récupération d'éléments

Vous pouvez utiliser la méthode **get** sur la classe Session pour récuperer un élément dans la session, incluant les données flashées. Passez ensuite la clé dont la valeur associée vous interesse :

	$name = Session::get('name');

Par défaut, NULL sera retourné si l'élément n'existe pas dans la session. Pour définir un paramètre par défaut, passez en second argument une chaîne de caractères, ou alors une fonction anonyme :

	$name = Session::get('name', 'Fred');

	$name = Session::get('name', function() {return 'Fred';});

Maintenant, "Fred" sera retourné si l'élément ayant pour clé "name" n'existe pas.

Laravel fournit une manière simple de savoir si un élément existe en sessions avec la méthode **has** :

	if (Session::has('name'))
	{
	     $name = Session::get('name');
	}

<a name="forget"></a>
## Suppression d'élément

Pour supprimer un élément, utilisez la méthode **forget** :

	Session::forget('name');

Et pour les supprimer tous, la méthode **flush** est la méthode qu'il vous faut :

	Session::flush();

<a name="flash"></a>
## Flashage d'élément

La méthode **flash** stocke un élément dans la session, qui expirera lors de la prochaine requête. C'est utile pour stocker des données temporaires, telles que des messages d'erreurs :

	Session::flash('status', 'Welcome Back!');
	
Les données flashées qui devraient être effacées lors de la requête en cours, peuvent être reflasher grâce à la méthode **reflash** pour tous les éléments, ou **keep** préciser les éléments à conserver :

#### Renouvelle le flash de toutes les données :

	Session::reflash();
	
#### Renouvelle un seul élément du flash :
	
	Session::keep('status');
	
#### Renouvelle plusieurs éléments du flash :
	
	Session::keep(array('status', 'other_item'));

<a name="regeneration"></a>
## Régénération de l'ID de session 

Pour regénérer l'ID d'une session, utilisez simplement la méthode **regenerate**, et un nouvel ID de session aléatoire sera attribué à la session :

	Session::regenerate();