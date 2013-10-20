# Les files de travaux

- [Configuration](#configuration)
- [Utilisation](#basic-usage)
- [Mise en queue de fonction anonymes](#queueing-closures)
- [Activer le gestionnaire d'exécution de la file de travaux](#running-the-queue-listener)
- [Queues en mode Push](#push-queues)-

<a name="configuration"></a>
## Configuration

Le composant Queue fournit une API unique donnant accès à une variété de systèmes de files de travaux. Queue permet d'exécuter de manière différée une tâche consommatrice de temps comme l'envoi de message, ce qui accélère considérablement les requêtes d' application.

La configuration d'une file de travaux s'effectue dans le fichier `app/config/queue.php`. Dans ce fichier, vous y trouverez les éléments de déclaration de chacun des pilotes de file de travaux inclus dans le framework comme [Beanstalkd](http://kr.github.com/beanstalkd), [IronMQ](http://iron.io), [Amazon SQS](http://aws.amazon.com/sqs), et le pilote de synchronisation (pilote destiné à être utilisé en local).

Les dépendances suivantes sont requises pour les drivers de queues listés :

- Beanstalkd: `pda/pheanstalk`
- Amazon SQS: `aws/aws-sdk-php`
- IronMQ: `iron-io/iron_mq`

<a name="basic-usage"></a>
## Utilisation

Pour ajouter une tâche à la file d'attente, utilisez la méthode `Queue::push` :

**Ajouter une tâche à la file de travaux**

	Queue::push('SendEmail', array('message' => $message));

Le premier paramètre attendu par la méthode `push` est le nom de la classe à utiliser pour l'exécution de la tâche. Le second paramètre est un tableau de données à transmettre à la procédure d'exécution de la tâche.

**Définir une procédure d'exécution de tâche**

	class SendEmail {

		public function fire($job, $data)
		{
			//
		}

	}

Remarquez que seul l'appel de la méthode `fire` en joignant l'instance de tâche et le tableau de données associé sont nécessaires.

Si vous souhaitez que votre tâche utilise une autre méthode que `fire`, vous devez spécifier la méthode lorsque vous poussez la tâche :

**Spécifie une méthode personnalisée**

    Queue::push('SendEmail@send', array('message' => $message));

Une fois la tâche exécutée, vous devez la supprimer de la file d'attente à l'aide de la méthode `delete` au sein de l'instance de tâche :

**Supprimer une tâche terminée**

	public function fire($job, $data)
	{
		// Process the job...

		$job->delete();
	}

Pour réintégrer une tâche dans la file d'attente, utilisez la méthode `release` :

**Réintégrer une tâche dans la file d'attente**

	public function fire($job, $data)
	{
		// Process the job...

		$job->release();
	}

De plus, indiquez le temps d'attente en seconde avant réintégration :

	$job->release(5);

Si une exception survient à l'exécution d'une tâche, cette tâche est automatiquement réintégrée à la file d'attente. Contrôlez le nombre de tentatives effectuées à l'aide de la méthode `attempts` :

**Vérifier le nombre de tentatives d'exécution**

	if ($job->attempts() > 3)
	{
		//
	}

Vous pouvez également accéder à l'identifiant d'une tâche :

**Accès à l'ID d'une tâche**

    $job->getJobId();

<a name="queueing-closures"></a>
## Mise en queue de fonction anonymes

Vous pouvez également placer une fonction anonyme dans la queue. Ceci est vraiment pratique pour des tâches rapides et simples à placer dans la queue :

**Placer une fonction anonyme dans la queue**

    Queue::push(function() use ($id)
    {
        Account::delete($id);
    });

> **Note:** Lorsque vous placez une fonction anonyme dans la queue, les constantes `__DIR__` et `__FILE__` ne devraient pas être utilisées.

Lorseue vous utilisez Iron.io [en tant que queue en mode push](#push-queues), vous devriez prendre des précautions lorsque vous placez en queue des fonctions anonymes. Le point final qui reçoit votre message de queue devrait vérifier un token pour s'assurer que la requête vient effectivement de Iron.io. Par exemple, le point final de votre queue pourrait être quelque chose comme ceci : `https://yourapp.com/queue/receive?token=SecretToken`. Vous pouvez ensuite vérifier la valeur du token avant d'utiliser la méthode `marshal`.

<a name="running-the-queue-listener"></a>
##Activer le gestionnaire d'exécution de la file de travaux

Laravel fournit une commande Artisan permettant d'activer l'exécution des tâches lorsqu'elles sont ajoutées à la file d'attente. Il s'agit de la commande `queue:listen` :

**Démarrer l'exécution de la file de travaux**

	php artisan queue:listen

Vous pouvez aussi indiquer le gestionnaire que vous souhaitez démarrer :

	php artisan queue:listen connection

Notez qu'une fois le gestionnaire démarré, il reste actif jusqu'à ce qu'il soit stoppé manuellement. Utilisez un moniteur de tâches comme [Supervisor](http://supervisord.org/) pour vous assurer que le gestionnaire est bien arrêté.

Vous pouvez également définir le temps maximum en secondes qu'une tâche est autorisée à prendre :

**Spécification d'un délai maximum**

  php artisan queue:listen --timeout=60

Pour exécuter uniquement la première tâche de la file d'attente, utilisez la commande `queue:work` :

**Exécuter la première tâche de la file d'attente**

	php artisan queue:work

<a name="push-queues"></a>
## Queues en mode Push

Les queues en mode Push vous permettent d'utiliser la puissance des queue de Laravel 4 sans avoir à exécuter un service ou un gestionnaire de queue sur votre serveur. Actuellement, les queues en mode push sont uniquement supportées par le driver [Iron.io](http://iron.io). Avant de commencer, créez un compte Iron.io, et ajoutez vos identifiants dans le fichier de configuration `app/config/queue.php`.

Ensuite, vous pouvez utiliser la commande Artisan `queue:subscribe` pour enregistrer l'URL de votre application qui recevra les nouvelles tâches en queues :

**Enregistrement d'un receveur de tâches en mode Push**

	php artisan queue:subscribe queue_name http://foo.com/queue/receive

Maintenant, lorsque vous vous connectez au tableau de bord d'Iron, vous verrez votre nouvelle queue, ainsi que l'URL souscrite. Vous pouvez créer autant d'URL que vous le souhaitez pour une queue donnée. Ensuite, créez une route pour votre point d'arrivée `queue/receive` et retournez la réponse de la méthode `Queue::marshal` :

	Route::post('queue/receive', function()
	{
		return Queue::marshal();
	});

La méthode `marshal` se chargera d'exécuter la bonne classe de gestion de la tâche. Pour lancer une tâche dans les queues en mode Push, utilisez la même méthode `Queue::push` que pour les queues conventionelles.
