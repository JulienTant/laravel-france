# Erreurs & Journalisations

- [Détail des erreurs](#error-detail)
- [Gestion des erreurs](#handling-errors)
- [Exceptions HTTP](#http-exceptions)
- [Gestion des erreurs 404](#handling-404-errors)
- [Logging](#logging)

<a name="error-detail"></a>
## Détail des erreurs

Par défaut, les détails des erreurs sont autorisés par votre application. Cela signifie que quand une erreur se déroule, une page d'erreur vous sera affichée avec la pile d'exécution et un message d'erreur. Vous pouvez désactiver cela en mettant l'option `debug` du fichier `app/config/app.php` à `false`. **Il est fortement recommandé de passer cette option à false dans un environnement de production.**

<a name="handling-errors"></a>
## Gestion des erreurs

Par défaut, le fichier `app/start/global.php` contient un gestionnaire d'erreur pour toutes les exceptions :

    App::error(function(Exception $exception)
    {
        Log::error($exception);
    });

C'est le gestionnaire d'erreur le plus basique. Cependant, vous pouvez spécifier plus de gestionnaires si besoin. Les gestionnaires sont appelés en se basant sur le type d'exception qu'ils gèrent. Par exemple, si vous créez un gestionnaire qui gère une instance de `RuntimeException` :

    App::error(function(RuntimeException $exception)
    {
        // Handle the exception...
    });

Si un gestionnaire d'exception retourne une réponse, cette réponse sera envoyée au navigateur et aucun autre gestionnaire d'erreur ne sera appelé :

    App::error(function(InvalidUserException $exception)
    {
        Log::error($exception);

        return 'Sorry! Something is wrong with this account!';
    });

Pour écouter une erreur fatale PHP, vous devez utiliser la méthode `App::fatal` :

    App::fatal(function($exception)
    {
        //
    });

<a name="http-exceptions"></a>
## Exceptions HTTP

Les exceptions HTTP sont des erreurs qui peuvent intervenir pendant une requête d'un client. Cela peut être une page non trouvée (404), un problème d'autorisation (401) ou même une erreur 500. Pour retourner une erreur de la sorte, utilisez la méthode suivante :

    App::abort(404, 'Page not found');

Le premier argument est le code HTTP, suivi d'un message d'erreur personnalisé que vous aimeriez montrer.

Pour lever une erreur 401 "non autorisé", faites comme ceci :

    App::abort(401, 'You are not authorized.');

Ces exceptions peuvent être exécutées n'importe quand durant le cycle de vie de la requête.

<a name="handling-404-errors"></a>
## Gestion des erreurs 404

Vous pouvez enregistrer un gestionnaire qui gère toutes les erreurs 404 de votre application, vous permettant de retourner une page d'erreur 404 personnalisée :

    App::missing(function($exception)
    {
        return Response::view('errors.missing', array(), 404);
    });

<a name="logging"></a>
## Logging

Laravel vous fournit une classe pour faire de la journalisation, qui se base sur le puissant [Monolog](http://github.com/seldaek/monolog). Par défaut, Laravel est configuré pour créer des fichiers journaliers pour votre application, et ils seront stockés dans `app/storage/logs`. Vous pouvez écrire dans ces fichiers de logs de la manière suivante :

    Log::info('This is some useful information.');

    Log::warning('Something could be going wrong.');

    Log::error('Something is really going wrong.');

Le journaliseur fournit les 7 niveaux de journalisation définis dans la [RFC 5424](http://tools.ietf.org/html/rfc5424) : **debug**, **info**, **notice**, **warning**, **error**, **critical**, et **alert**.

Monolog a une multitude de gestionnaires supplémentaires que vous pouvez utiliser pour faire de la journalisation. Si besoin, vous pouvez accéder directement à l'objet Monolog utilisé par Laravel :

    $monolog = Log::getMonolog();

Vous pouvez également enregistrer un événement pour attraper tous les messages passés à la journalisation :

**Enregistrement d'un écouteur de journalisation**

    Log::listen(function($level, $message, $context)
    {
        //
    });