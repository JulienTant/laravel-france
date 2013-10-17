# Evénements

## Au menu

- [Les bases](#the-basics)
- [Lancer un événement](#firing-events)
- [Ecouter un événement](#listening-to-events)
- [Queue d'événements](#queued-events)
- [Les événements Laravel](#laravel-events)

<a name="the-basics"></a>
## Les bases

Les événements peuvent fournir un bon moyen de construire une application découplée, et autoriser des plugins à intéragir avec le coeur de votre application, sans en modifier le code.

<a name="firing-events"></a>
## Lancer un événement

Pour lancer un événement, dites juste à la méthode **fire** de la classe **Event** l'événement que vous souhaitez lancer :

#### Lance un événement :

	$responses = Event::fire('loaded');

Remarquez que nous avons assigné le résultat de la méthode **fire** à une variable. Cette méthode retournera un tableau qui contiendra les réponses de tous les "écouteurs" d'événement.

Pour lancer un événement et obtenir uniquement la première réponse, il vous faudra utiliser ~~la force~~ la méthode **first** :

#### Lance un événement et obtient la première réponse :

	$response = Event::first('loaded');

> **Note:** La méthode **first** va tout de même exécuter tous les "écoutera" qui gèrent cet événement, mais il retournera que la première réponse.

La méthode **Event::until** va exécuter tous les gestionnaires d'événements jusqu'à ce qu'une réponse différente de null lui soit retournée.

#### Lance un événement jusqu'à une réponse différente de null :

	$response = Event::until('loaded');

<a name="listening-to-events"></a>
## Ecouter un événement

A quoi bon lancer des événements si personne ne les écoute ? Enregistrer un écouteur d'événement qui sera appelé quand un événement est déclenché :

#### Enregistre un écouteur d'événement :

	Event::listen('loaded', function()
	{
		// I'm executed on the "loaded" event!
	});

La fonction anonyme fournie à la méthode sera exécutée chaque fois que l'événement "loader" sera lancé.

<a name="queued-events"></a>
## Queue d'événements

Vous avez la possibilité avec Laravel de créer une queue, une salle d'attente d'événements, et de les lancer plus tard. Cela est possible grâce aux méthodes `queue` et `flush`. Premièrement, mettons un événement dans une queue avec un identifiant unique :

#### Enregistrer une événement délayé :

	Event::queue('foo', $user->id, array($user));

Cette méthode accepte trois paramètres. Le premier est le nom de la queue, le second est un identifiant unique pour cet événement, et le troisième est un tableau avec les données à passer au videur de queue.

Maintenant, enregistrer un déclencheur pour la queue `foo` :

#### Enregistre un videur de queue d'événements :

	Event::flusher('foo', function($key, $user)
	{
		//
	});

Notez que le videur de queue d'événements reçoit deux arguments. Le premier est l'identifiant unique de l'événement en queue, qui dans notre cas sera l'identifiant de l'utilisateur. Le second ( et les suivants en général ) correspond à l'argument passé lors de l'enregistrement de l'événement dans la queue. 

Pour finir, nous pouvons déclencher notre videur et lancer tous les événements grâce à la méthode `flush` :

	Event::flush('foo');

<a name="laravel-events"></a>
## Les événements Laravel

Il y a plusieurs événements qui sont lancés par le coeur du framework Laravel, les voici :

#### Événement lancé quand un bundle est démarré :

	Event::listen('laravel.started: bundle', function() {});

#### Événement lancé quand une requête sur la base de donnée est exécutée :

	Event::listen('laravel.query', function($sql, $bindings, $time) {});

#### Événement lancé juste avant que la réponse ne soit envoyée au navigateur:

	Event::listen('laravel.done', function($response) {});

#### Événement lancé quand un message est loggué avec la classe Log:

	Event::listen('laravel.log', function($type, $message) {});
