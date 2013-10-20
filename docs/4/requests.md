# Les requêtes et les entrées

- [Lecture des entrées utilisateur](#basic-input)
- [Utilisation de cookies](#cookies)
- [Les données anciennes](#old-input)
- [Utilisation de fichiers](#files)
- [Les éléments de requête](#request-information)

<a name="basic-input"></a>
## Lecture des entrées utilisateur

Les entrées utilisateur sont accessibles facilement à l'aide de quelques méthodes. Ces méthodes sont disponibles et utilisables de la même manière quelque soit la commande HTTP.

**Lit la valeur d'une entrée**

	$name = Input::get('name');

**Retourne une valeur par défaut si une entrée n'a pas de valeur**

	$name = Input::get('name', 'Sally');

**Détermine si une entrée possède une valeur**

	if (Input::has('name'))
	{
		//
	}

**Retourne toutes les entrées de la requête**

	$input = Input::all();

**Retourne certaines entrées de la requête**

	$input = Input::only('username', 'password');

	$input = Input::except('credit_card');

Certaines librairies Javascript comme Backbone peuvent transmettre à l'application les entrées au format JSON. Vous pouvez accéder à ces données via `Input::get()` comme d'habitude.

<a name="cookies"></a>
## Utilisation de cookies

Les cookies créés par Laravel sont cryptés et signés avec un code d'authentification. Par conséquent, les cookies sont considérés invalides dès lors qu'il sont modifiés par le client.

**Lit le contenu d'un cookie**

	$value = Cookie::get('name');

**Attache un cookie à une réponse**

	$response = Response::make('Hello World');

	$response->withCookie(Cookie::make('name', 'value', $minutes));

**Crée un cookie permanent**

	$cookie = Cookie::forever('name', 'value');

<a name="old-input"></a>
## Les anciennes entrées

Supposons que vous devez conserver une entrée d'une requête à l'autre. Par exemple, vous devez ré-afficher un formulaire après sa validation.

**Enregistre les entrées dans la session**

	Input::flash();

**Enregistre certaines entrées dans la session**

	Input::flashOnly('username', 'email');

	Input::flashExcept('password');

Puisqu'il est souvent nécessaire de combiner l'enregistrement des entrées avec la redirection vers la page précédente, il est possible d'enchaîner l'enregistrement des entrées avec la redirection.

	return Redirect::to('form')->withInput();

	return Redirect::to('form')->withInput(Input::except('password'));

> **Remarque:** Vous pouvez transmettre d'autres données à l'aide de la classe [Session](/docs/session).

**Lit une ancienne donnée**

	Input::old('username');

<a name="files"></a>
## Utilisation de fichiers

**Lit un fichier téléchargé**

	$file = Input::file('photo');

**Détermine si un fichier est téléchargé**

	if (Input::hasFile('photo'))
	{
		//
	}

L'objet retourné par la méthode `file` est une instance de la classe `Symfony\Component\HttpFoundation\File\UploadedFile`. Cette classe est une extension de la classe PHP `SplFileInfo` fournissant un ensemble de méthodes permettant d'intéragir avec le fichier.

**Déplace un fichier téléchargé**

	Input::file('photo')->move($destinationPath);

	Input::file('photo')->move($destinationPath, $fileName);

**Retourne le chemin d'un fichier téléchargé**

	$path = Input::file('photo')->getRealPath();

**Retourne la taille d'un fichier téléchargé**

	$size = Input::file('photo')->getSize();

**Retourne le type MIME d'un fichier téléchargé**

	$mime = Input::file('photo')->getMimeType();

<a name="request-information"></a>
## Les éléments de requête

La classe `Request` fournit beaucoup de méthodes permettant d'examiner les éléments de la requête HTTP. Cette classe est une extension de la classe `Symfony\Component\HttpFoundation\Request`. Voici quelques méthodes majeures :

**Retourne l'URI d'une requête**

	$uri = Request::path();

**Détermine si le chemin d'une requête respecte un motif**

	if (Request::is('admin/*'))
	{
		//
	}

**Retourne l'URL d'une requête**

	$url = Request::url();

**Retourne un des segments d'une URI**

	$segment = Request::segment(1);

**Retourne l'en-tête d'une requête**

	$value = Request::header('Content-Type');

**Retourne une valeur dans le tableau $_SERVER**

	$value = Request::server('PATH_INFO');

**Détermine si une requête est de type AJAX**

	if (Request::ajax())
	{
		//
	}

**Détermine si le protocole de la requête est HTTPS**

	if (Request::secure())
	{
		//
	}
