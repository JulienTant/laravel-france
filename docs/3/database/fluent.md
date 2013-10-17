# Fluent Query Builder

## Au menu

- [Les bases](#the-basics)
- [Récupération de données](#get)
- [Clause WHERE](#where)
- [Clauses WHERE imbriquées](#nested-where)
- [Clauses WHERE dynamiques](#dynamic)
- [Jointure](#joins)
- [Tri du résultat](#ordering)
- [Groupage de résultats](#grouping)
- [Passer & prendre](#limit)
- [Agrégats](#aggregates)
- [Expressions brutes](#expressions)
- [Insertion de lignes](#insert)
- [Updating Records](#update)
- [Suppression d'enregistrements](#delete)

## Les bases

Fluent Query Builder est une [interface fluide](http://fr.wikipedia.org/wiki/D%C3%A9signation_cha%C3%AEn%C3%A9e) puissante de Laravel, qui permet de construire des requêtes SQL et de travailler avec votre base de données. Toutes les requêtes utilisent des déclarations préparées et sont protégées contre les injections SQL.

Vous pouvez commencer à utiliser une requête fluide en utilisant la méthode **table** de la classe DB. Mentionnez juste la table sur laquelle vous souhaitez faire vos requêtes :

	$query = DB::table('users');

Vous avez maintenant une constructeur de requête fluide pour la table "users". En utilisant ce constructeur de requête, vous pouvez récupérer, insérer, mettre à jour ou supprimer des entrées de la table.

<a name="get"></a>
## Récupération de données

#### Récupère un tableau d'entrées depuis la table :

	$users = DB::table('users')->get();

> **Note:** La méthode **get** retourne un tableau d'objets avec des propriétés correspondantes aux noms des colonnes de la table.

#### Récupère une seule ligne de la table :

	$user = DB::table('users')->first();
	
#### Récupère une seule ligne par sa clé primaire :

	$user = DB::table('users')->find($id);

> **Note:** Si aucun résultat n'est trouvé, la méthode **first** renvoie NULL. La méthode **get** retournera un tableau vide.

#### Récupère la valeur d'une seule colonne de la table :

	$email = DB::table('users')->where('id', '=', 1)->only('email');

#### Sélectionne uniquement certaines colonnes de la table :

	$user = DB::table('users')->get(array('id', 'email as user_email'));

#### Récupère un tableau avec les valeurs des colonnes données :

    $users = DB::table('users')->take(10)->lists('email', 'id');

> **Note:** Le second paramètre est optionnel.

#### Sélectionne les résultats distincts de la table :

	$user = DB::table('users')->distinct()->get();

<a name="where"></a>
## Clause WHERE

### where et or\_where

Il y a une variété de méthodes pour vous assister à construire votre clause WHERE. Les plus basiques sont les méthodes **where** et **or_where**. Voici comment les utiliser :

	return DB::table('users')
		->where('id', '=', 1)
		->or_where('email', '=', 'example@gmail.com')
		->first();

Bien sûr, vous n'êtes pas limité à une simple vérification d'égalité. Vous pouvez également utiliser **plus grand que**, **plus petit que**, **différent**, et **like**:

	return DB::table('users')
		->where('id', '>', 1)
		->or_where('name', 'LIKE', '%Taylor%')
		->first();

La méthode **where** est ajoutée à la requête avec un AND, tandis que la méthode **or_where** sera ajoutée avec un OR.

### where\_in, where\_not\_in, or\_where\_in, and or\_where\_not\_in

La collection de méthodes **where_in** vous permet de construire facilement des requêtes qui doivent chercher un tableau de données :

	DB::table('users')->where_in('id', array(1, 2, 3))->get();

	DB::table('users')->where_not_in('id', array(1, 2, 3))->get();

	DB::table('users')
		->where('email', '=', 'example@gmail.com')
		->or_where_in('id', array(1, 2, 3))
		->get();

	DB::table('users')
		->where('email', '=', 'example@gmail.com')
		->or_where_not_in('id', array(1, 2, 3))
		->get();

### where\_null, where\_not\_null, or\_where\_null, and or\_where\_not\_null

La collection de méthodes **where_null** rendent la recherche de valeur NULL vraiment facile :

	return DB::table('users')->where_null('updated_at')->get();

	return DB::table('users')->where_not_null('updated_at')->get();

	return DB::table('users')
		->where('email', '=', 'example@gmail.com')
		->or_where_null('updated_at')
		->get();

	return DB::table('users')
		->where('email', '=', 'example@gmail.com')
		->or_where_not_null('updated_at')
		->get();

### where\_between, where\_not\_between, or\_where\_between, and or\_where\_not\_between

La collection de méthodes **where_between** permet de savoir si une valeur se trouve entre un minimum et un maximum super facilement :
    
    return DB::table('users')->where_between($column, $min, $max)->get();   

    return DB::table('users')->where_between('updated_at', '2000-10-10', '2012-10-10')->get();

    return DB::table('users')->where_not_between('updated_at', '2000-10-10', '2012-01-01')->get();

    return DB::table('users')
        ->where('email', '=', 'example@gmail.com')
        ->or_where_between('updated_at', '2000-10-10', '2012-01-01')
        ->get();

    return DB::table('users')
        ->where('email', '=', 'example@gmail.com')
        ->or_where_not_between('updated_at', '2000-10-10', '2012-01-01')
        ->get();


<a name="nested-where"></a>
## Clauses WHERE imbriquées

Vous aurez parfois besoin de regrouper des portions d'une clause WHERE entre parenthèses. Passez une fonction anonyme en tant que paramètre aux méthodes **where** ou **or_where** :

	$users = DB::table('users')
		->where('id', '=', 1)
		->or_where(function($query)
		{
			$query->where('age', '>', 25);
			$query->where('votes', '>', 100);
		})
		->get();

L'exemple ci-dessus génère la requête suivante : :

	SELECT * FROM "users" WHERE "id" = ? OR ("age" > ? AND "votes" > ?)

<a name="dynamic"></a>
## Clauses WHERE dynamiques

Les méthodes where dynamiques sont un bon moyen d'**améliorer considérablement la lisibilité de votre code**. Voici quelques exemples :

	$user = DB::table('users')->where_email('example@gmail.com')->first();

	$user = DB::table('users')->where_email_and_password('example@gmail.com', 'secret');

	$user = DB::table('users')->where_id_or_name(1, 'Fred');


<a name="joins"></a>
## Jointure

Besoin de joindre deux tables ? Essayez les méthodes **join** et **left\_join** :

	DB::table('users')
		->join('phone', 'users.id', '=', 'phone.user_id')
		->get(array('users.email', 'phone.number'));

La **table** que vous souhaitez joindre est passée en tant que premier paramètre, les trois autres paramètres sont utilisés pour construire la clause ON de la jointure.

Une fois que vous savez utiliser la méthode join, vous savez comment utiliser la méthode **left_join**. Cette méthode à la même signature que la précédente :

	DB::table('users')
		->left_join('phone', 'users.id', '=', 'phone.user_id')
		->get(array('users.email', 'phone.number'));

Vous pouvez spécifié plusieurs conditions de jointure pour la clause **ON** en passant une fonction anonyme en tant que second paramètre de la jointure :

	DB::table('users')
		->join('phone', function($join)
		{
			$join->on('users.id', '=', 'phone.user_id');
			$join->or_on('users.id', '=', 'phone.contact_id');
		})
		->get(array('users.email', 'phone.number'));

<a name="ordering"></a>
## Tri du résultat

Vous pouvez trier facilement les résultats en utilisant la méthode **order_by**. Mentionnez simplement la colonne et la direction (desc ou asc) :

	return DB::table('users')->order_by('email', 'desc')->get();

Bien sûr, vous pouvez trier autant de colonnes que vous le souhaitez :

	return DB::table('users')
		->order_by('email', 'desc')
		->order_by('name', 'asc')
		->get();

<a name="grouping"></a>
## Groupage de résultats

Vous pouvez grouper les résultats de vos requêtes en utilisant la méthode **group_by** :

    return DB::table(...)->group_by('email')->get();

<a name="limit"></a>
## Passer & prendre

Si vous souhaitez limiter le nombre de résultats retournés par votre requête, utilisez la méthode **take** :

	return DB::table('users')->take(10)->get();

Pour placer un décalage sur les résultats de votre requête, utilisez la méthode **skip** :

	return DB::table('users')->skip(10)->get();

<a name="aggregates"></a>
## Agrégats

Besoin d'utiliser **MIN**, **MAX**, **AVG**, **SUM**, ou **COUNT** ? Passez le nom de la colonne à la requête :

	$min = DB::table('users')->min('age');

	$max = DB::table('users')->max('weight');

	$avg = DB::table('users')->avg('salary');

	$sum = DB::table('users')->sum('votes');

	$count = DB::table('users')->count();

Bien sûr, vous pouvez limiter la requête en plaçant une clause WHERE d'abord :

	$count = DB::table('users')->where('id', '>', 10)->count();

<a name="expressions"></a>
## Expressions brutes

Vous pourrez avoir besoin d'utiliser des functions MySQL telle que **NOW()**. En écrivant simplement NOW() dans une méthode, des guillemets seraient placées autour et NOW() serait considéré comme une simple chaîne. Pour éviter cela, il faut utiliser la méthode **raw** de la classe **DB**. Voilà à quoi cela ressemble :

	DB::table('users')->update(array('updated_at' => DB::raw('NOW()')));

La méthode **raw** indique à la requête que le contenu de l'expression doit être inséré dans la requête en tant que tel, et non pas en tant que paramètre attaché. Vous pouvez utiliser cette méthode pour incrémenter un champ par exemple :

	DB::table('users')->update(array('votes' => DB::raw('votes + 1')));

Mais, sachez que le Fluent Query Builder de Laravel fournit des méthodes **increment** et **decrement** :

	DB::table('users')->increment('votes');

	DB::table('users')->decrement('votes');

<a name="insert"></a>
## Insertion de lignes

La méthode insert attend un tableau de données à insérer. Elle retourne true si l'insertion s'est bien déroulée, et false dans le cas contraire :

	DB::table('users')->insert(array('email' => 'example@gmail.com'));

Si vous insérez une ligne qui contient un ID qui s'auto-incrémente, vous pouvez utiliser la méthode **insert\_get\_id** pour insérer une entrée et récupérer l'ID de la ligne :

	$id = DB::table('users')->insert_get_id(array('email' => 'example@gmail.com'));

> **Note:** La méthode **insert\_get\_id** nécessite que la colonne qui s'auto-incrémente soit nommée "id".

<a name="update"></a>
## Mise à jour d'enregistrements

Pour mettre à jour des enregistrements, passez simplement un tableau de données à la méthode **update** :

	$affected = DB::table('users')->update(array('email' => 'new_email@gmail.com'));

Bien sûr, si vous souhaitez ne mettre à jour que quelques enregistrements, vous pouvez utiliser des clauses WHERE avant la méthode update :

	$affected = DB::table('users')
		->where('id', '=', 1)
		->update(array('email' => 'new_email@gmail.com'));

<a name="delete"></a>
## Suppression d'enregistrements

Quand vous souhaitez supprimer des données, utilisez la méthode **delete** :

	$affected = DB::table('users')->where('id', '=', 1)->delete();

Pour supprimer un enregistrement dont vous connaissez l'ID, passez ce dernier en tant qu'argument :

	$affected = DB::table('users')->delete(1);
