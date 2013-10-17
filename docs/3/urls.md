# Génération d'URLs

## Au menu

- [Les bases](#the-basics)
- [URLs vers une route](#urls-to-routes)
- [URLs vers une action de contrôleur](#urls-to-controller-actions)
- [URLs vers un asset](#urls-to-assets)
- [Helpers d'URL](#url-helpers)

<a name="the-basics"></a>
## Les bases

#### Retourne l'URL de l'application :

    $url = URL::base();

#### Retourne une URL relative à la base de l'application :

    $url = URL::to('user/profile');

#### Génére une URL HTTPS :

    $url = URL::to_secure('user/login');

#### Retourne l'URL courante :

    $url = URL::current();

#### Retourne l'URL courante, avec les query string:

    $url = URL::full();

<a name="urls-to-routes"></a>
## URLs vers une route

#### Génération d'une URL vers une route nommée :

    $url = URL::to_route('profile');

Vous devrez parfois fournir à une route des arguments, pour ce faire, passez les en tant que tableau en second argument :
#### Génère une URL vers une route nommée avec des arguments :

    $url = URL::to_route('profile', array($username));

*Voir aussi:*

- [Route nommées](/docs/3/routes#named-routes)

<a name="urls-to-controller-actions"></a>
## URLs vers une action de contrôleur

#### Génère une URL vers une action de contrôleur :

    $url = URL::to_action('user@profile');

#### Génère une URL vers une action de contrôleur avec des paramètres :

    $url = URL::to_action('user@profile', array($username));

<a name="urls-to-a-different-language"></a>
## URLs vers une langue différente

#### Génère une url vers la même page dans une langue différente :

    $url = URL::to_language('fr');

#### Génère une url vers la page d'accueil dans une langue différente :

    $url = URL::to_language('fr', true);

<a name="urls-to-assets"></a>
## URLs vers des assets

Les URLs générées pour les assets ne contiendront pas l'option de configuration **application.index**.

#### Génère une URL d'un asset :

    $url = URL::to_asset('js/jquery.js');

<a name="url-helpers"></a>
## URL Helpers

Il y a plusieurs fonctions globales pour générer des URLs, afin de vous rendre la vie plus simple et votre code plus propre :

#### Génère une URL relative à la base de l'application :

    $url = url('user/profile');

#### Génère une URL vers un asset :

    $url = asset('js/jquery.js');

#### Génère une URL vers une route nommée :

    $url = route('profile');

#### Génère une URL vers une route nommée avec des arguments :

    $url = route('profile', array($username));

#### Génère une URL vers une action de contrôleur :

    $url = action('user@profile');

#### Génère une URL vers une action de contrôleur avec des arguments :

    $url = action('user@profile', array($username));
