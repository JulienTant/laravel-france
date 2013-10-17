# Conteneur IoC

- [Définition](/docs/3/ioc#definition)
- [Objets enregistrés](/docs/3/ioc#register)
- [Résolution d'objets](/docs/3/ioc#resolve)

<a name="definition"></a>
## Définition

Un conteneur IoC est une voie simple de manager la création d'objets. Vous pouvez l'utiliser pour définir la création d'objets complexes, vous permettant de les résoudre tout au long de votre application en utilisant une simple ligne de code. Vous pouvez également l'utiliser pour "injecter" des dépendances dans vos classes et les contrôleurs.

Les conteneurs IoC aide à concevoir votre application de façon plus flexible et testable. Depuis que vous pouvez enregistrer des implémentations alternatives d'une interface avec le conteneur, vous pouvez isoler le code que vous testez à partir des dépendances externes en utilisant [stubs et mocks](http://martinfowler.com/articles/mocksArentStubs.html).

<a name="register"></a>
## Objets enregistrés

#### Enregistrez un résolveur dans le conteneur IoC :

    IoC::register('mailer', function()
    {
        $transport = Swift_MailTransport::newInstance();

        return Swift_Mailer::newInstance($transport);
    });

Bien ! Maintenant que nous avons enregistré un résolveur pour SwiftMailer dans notre conteneur. Mais, si nous ne voulons pas que le conteneur ne crée une nouvelle instance "mailer" tout le temps que quand nous en avons besoin ? Peut-être que nous voulons juste que le conteneur retourne la même instance après que l'instance initiale ait été créée. Dites juste au conteneur que l'objet doit être un singleton :

#### Enregistrez un singleton dans le conteneur :

    IoC::singleton('mailer', function()
    {
        //
    });

Vous pouvez aussi enregistrer une instance d'objet existant comme un singleton dans le conteneur.

#### Enregistrez une instance existante dans le conteneur :

    IoC::instance('mailer', $instance);

<a name="resolve"></a>
## Résolution d'objets

Maintenant que vous avez enregistré SwiftMailer dans le conteneur, nous pouvons le résoudre en utilisant la méthode **resolve** sur la classe **IoC** :

    $mailer = IoC::resolve('mailer');

> **Note:** Vous pouvez aussi [enregistrer les contrôleurs dans le conteneur](/docs/3/controllers#dependency-injection).
