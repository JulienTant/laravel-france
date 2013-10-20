# Les tests unitaires

- [Introduction](#introduction)
- [Définition et exécution des tests](#defining-and-running-tests)
- [Environnement de test](#test-environment)
- [Appel de routes depuis un test](#calling-routes-from-tests)
- [Mockage de Facades](#mocking-facades)
- [Assertions du Framework](#framework-assertions)
- [Méthodes "Helper"](#helper-methods)

<a name="introduction"></a>
## Introduction

Laravel est construit avec les tests unitaires en tête. En fait, le support des tests avec PHPUnit est inclus dans Laravel, et un fichier `phpunit.xml` est déjà configuré pour votre application. En plus de PHPUnit, Laravel utilise également les composants HttpKernel, DomCrawler, et BrowserKit de Symfony pour vous permettre d'inspecter et manipuler vos vues lors des tests, et de simuler un navigateur web.

Un fichier de test d'exemple est fourni dans le dossier `app/tests`. Après avoir installé une nouvelle application Laravel, lancez simplement la commande `phpunit` sur la ligne de commande pour lancer vos tests.

<a name="defining-and-running-tests"></a>
## Définition et exécution des tests

Pour créer un cas de test, créez simplement un nouveau fichier de test dans le dossier `app/tests`. La classe pour tester doit hériter de `TestCase`. Vous pouvez ensuite définir vos méthodes de test comme vous le feriez d'habitude avec PHPUnit.

**Exemple de classe de test**

    class FooTest extends TestCase {

        public function testSomethingIsTrue()
        {
            $this->assertTrue(true);
        }

    }

Vous pouvez exécuter tous vos tests en lançant la commande `phpunit` dans votre terminal.

> **Note:** Si vous avez défini votre propre méthode `setUp`, n'oubliez pas d'appeler `parent::setUp`.

<a name="test-environment"></a>
## Environnement de test

Lors de l'exécution de vos tests unitaires, Laravel va automatiquement définir que l'environnement de votre application est `testing`. Aussi, Laravel fournit des fichiers de configuration pour `session` et `cache` pour l'environnement de test. Ces deux drivers sont réglés à `array` dans l'environnement de test, ce qui signifie qu'aucune session et qu'aucune donnée en cache ne sera persistante durant les tests. Vous pouvez créer plusieurs environnements de tests si vous le souhaitez.

<a name="calling-routes-from-tests"></a>
## Appel de routes depuis un test

Vous pouvez facilement appeler une de vos routes pour un test en utilisant la méthode `call` :

**Appel d'une route depuis un test**

    $response = $this->call('GET', 'user/profile');

    $response = $this->call($method, $uri, $parameters, $files, $server, $content);

Vous pouvez ensuite inspecter l'objet `Illuminate\Http\Response` retourné :

    $this->assertEquals('Hello World', $response->getContent());

Vous pouvez également appeler un contrôleur depuis un test :

**Appel d'un contrôleur depuis un test**

    $response = $this->action('GET', 'HomeController@index');

    $response = $this->action('GET', 'UserController@profile', array('user' => 1));

La méthode `getContent` retournera le contenu de la chaîne évaluée de la réponse. Si votre route retourne une instance de la classe `View`, vous pouvez accéder à la vue en utilisant la propriété `original` :

    $view = $response->original;

    $this->assertEquals('John', $view['name']);

Pour appeler une route HTTPS, vous pouvez utiliser la méthode `callSecure` :

    $response = $this->callSecure('GET', 'foo/bar');

### Inspecteur de DOM

Vous pouvez également appeler une route et recevoir une instance de l'inspecteur de DOM que vous pouvez utiliser pour regarder le contenu :

    $crawler = $this->client->request('GET', '/');

    $this->assertTrue($this->client->getResponse()->isOk());

    $this->assertCount(1, $crawler->filter('h1:contains("Hello World!")'));

Pour plus d'informations sur l'utilisateur de l'inspecteur de DOM, visitez sa [documentation officielle](http://symfony.com/doc/master/components/dom_crawler.html).

<a name="mocking-facades"></a>
## Mockage de Facades

Lorsque vous testez, vous voudrez souvent mocker un appel à une façade statique de Laravel. Par exemple, considérons l'action de contrôleur suivante :

    public function getIndex()
    {
        Event::fire('foo', array('name' => 'Dayle'));

        return 'All done!';
    }

Nous pouvons mocker l'appel à la classe `Event` en utilisant la méthode `shouldReceive` sur la facade, qui retournera une instance d'un mock [Mockery](https://github.com/padraic/mockery).

**Mockage d'une Façade**

    public function testGetIndex()
    {
        Event::shouldReceive('fire')->once()->with(array('name' => 'Dayle'));

        $this->call('GET', '/');
    }

> **Note:** Vous ne pouvez pas mocker la façade `Request`. A la place, passez les données d'entrée désirées à la méthode `call` lorsque vous exécutez vos tests.

<a name="framework-assertions"></a>
## Assertions du Framework

Laravel est livré avec plusieurs méthodes `assert` pour vous faciliter les tests :

**Affirme qu'une réponse est OK**

    public function testMethod()
    {
        $this->call('GET', '/');

        $this->assertResponseOk();
    }

**Affirme que le statut de la réponse est correct**

    $this->assertResponseStatus(403);

**Affirme qu'une réponse est une redirection**

    $this->assertRedirectedTo('foo');

    $this->assertRedirectedToRoute('route.name');

    $this->assertRedirectedToAction('Controller@method');

**Affirme qu'une vue a des données**

    public function testMethod()
    {
        $this->call('GET', '/');

        $this->assertViewHas('name');
        $this->assertViewHas('age', $value);
    }

**Affirme qu'une session a des données**

    public function testMethod()
    {
        $this->call('GET', '/');

        $this->assertSessionHas('name');
        $this->assertSessionHas('age', $value);
    }

<a name="helper-methods"></a>
## Méthodes "Helper"

La classe `TestCase` contient plusieurs "Helper" pour faciliter le test de vos applications.

Vous pouvez définir l'utilisateur actuellement connecté avec la méthode `be` :

**Définit un utilisateur comme étant connecté**

    $user = new User(array('name' => 'John'));

    $this->be($user);

Vous pouvez re-peupler votre base de données depuis les tests unitaires en utilisant la méthode `seed` :

**Re-popule la base de données depuis les tests**

    $this->seed();

    $this->seed($connection);

Plus d'informations sur la peuplement de base de données dans la section [migrations et populations](/docs/4/migrations#database-seeding) de la documentation.
