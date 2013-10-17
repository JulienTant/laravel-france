# Requêtes

## Au menu

- [Travail avec les URI](#working-with-the-uri)
- [Autres helpers de requpetes](#other-request-helpers)

<a name="working-with-the-uri"></a>
## Travail avec les URI

#### Obtient l'URI courant de la requête :

	echo URI::current();

#### Obtient un segment spécifique de l'URI :

	echo URI::segment(1);

#### Retourne une valeur par défaut si un segment n'existe pas :

	echo URI::segment(10, 'Foo');

#### Obtient l'URL complète, y compris la query string :

	echo URI::full();

Si vous souhaitez déterminer si l'URI de la requête est une chaine de caractères donnée ou commence par une chaine de caractères donnée, alors vous pouvez utiliser la méthode **is** pour faire cela :

#### Détermine si l'URI est "home" :

	if (URI::is('home'))
	{
		// The current URI is "home"!
	}

#### Détermine si l'URI commence par "docs/*" :

	if (URI::is('docs/*'))
	{
		// The current URI begins with "docs/*"!
	}

<a name="other-request-helpers"></a>
## Autres helpers de requêtes

#### Retourne le verbe HTTP utilisé (GET, POST, ...)

	echo Request::method();

#### accès au tableau global $_SERVER :

	echo Request::server('http_referer');

#### Retourne l'adresse IP du client :

	echo Request::ip();

#### Détermine si la requête utilise HTTPS :

	if (Request::secure())
	{
		// This request is over HTTPS!
	}

#### Détermine si la requête courante est une requête AJAX :

	if (Request::ajax())
	{
		// This request is using AJAX!
	}

#### Détermine si la requête courrant se fait via Artisan :

	if (Request::cli())
	{
		// This request came from the CLI!
	}
