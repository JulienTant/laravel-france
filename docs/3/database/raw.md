# Requêtes brutes

## Au menu

- [Les bases](#the-basics)
- [Autres méthodes de requêtes](#other-query-methods)
- [Utiliser directement PDO](#pdo-connections)

<a name="the-bascis"></a>
## Les bases

La méthode **query** est utilisée pour exécuter des requêtes SQL brutes sur votre base de données. 

#### Sélection d'enregistrement depuis la base de données :

	$users = DB::query('select * from users');

#### Sélection d'enregistrement depuis la base de données utilisant des paramètres :

	$users = DB::query('select * from users where name = ?', array('test'));

#### Insertion d'une ligne dans la base 

	$success = DB::query('insert into users values (?, ?)', $bindings);

#### Mise à jour des enregistrements d'une table, et retour du nombre de lignes affectées :

	$affected = DB::query('update users set name = ?', $bindings);

#### Suppression de lignes d'une table et obtention du nombre de lignes supprimées :

	$affected = DB::query('delete from users where id = ?', array(1));

<a name="other-query-methods"></a>
## Autres méthodes de requêtes

Larvel fournit quelques autres méthodes pour rendre le requêtage plus simple :

#### Exécute une requête SELECT et obtient uniquement le premier résultat :

	$user = DB::first('select * from users where id = 1');

#### Exécute une requête et obtient la valeur d'une seule colonne :

	$email = DB::only('select email from users where id = 1');

<a name="pdo-connections"></a>
## Utiliser directement PDO 

Si vous souhaitez utiliser directement la connexion PDO, voici comment faire :

#### Obtient la connexion PDO pour une base de données :

	$pdo = DB::connection('sqlite')->pdo;

> **Note:** Si aucun nom de connexion n'est spécifiée, alors la connexion **default** sera utilisée.
