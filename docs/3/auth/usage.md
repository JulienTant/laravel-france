# Utilisation de l'authentification

## Au menu

- [Salage & cryptage](#hash)
- [Connexion](#login)
- [Protection de routes](#filter)
- [Obtenir des infos sur l'utilisateur connecté](#user)
- [Déconnexion](#logout)

> **Note:** Avant d'utiliser la classe Auth, vous devez [configurer un driver de sessions](/docs/3/session/config).

<a name="hash"></a>
## Salage & chiffage Hashing

Si vous utilisez la classe Auth, nous vous recommandons fortement de crypter et salé vos mots de passe.

Le salage et le cryptage se font en utilisant la classe **Hash** qui utilise **bcrypt**. Jetez un oeil à cet exemple :

    $password = Hash::make('secret');

La méthode **make** retournera une chaine cryptée de 60 caractères.

Vous pouvez comparer une chaine cryptée et une non cryptée avec la méthode **check** de la classe **Hash** :

    if (Hash::check('secret', $hashed_value))
    {
        return 'Le mot de passe est valide !';
    }

<a name="login"></a>
## Connexion

Connecter un utilisateur sur votre application est simple : il suffit d'utiliser la méthode **attempt** de la classe Auth. Passez simplement un tableau avec le nom d'utilisateur et le mot de passe, et le tour est joué. Les informations sont placées dans un tableau, car ce moyen de transport des données est très flexible, et permettra à certains drivers d'utiliser d'autre types de données. La méthode attempt retournera **true** si les informations sont valides. Sinon, elle retournera en tout logique false :

    $credentials = array('username' => 'exemple@gmail.com', 'password' => 'secret');

    if (Auth::attempt($credentials))
    {
         return Redirect::to('user/profile');
    }

Si les informations sont valides, l'ID de l'utilisateur sera stocké en sessions et l'utilisateur sera considéré comme connecté pour les prochaines requêtes sur votre application.

Pour savoir si un utilisateur est connecté, utilisez la méthode **check** :

    if (Auth::check())
    {
         return "Vous êtes connecté !";
    }

Utilisez la méthode **login** pour connecter un utilisateur sans utiliser ses identifiants, juste avec son id :

    Auth::login($user->id);

    Auth::login(15);

<a name="filter"></a>
## Protection de routes

C'est une chose très commune de limiter l'accès à certaines parties du site aux anonymes. Avec Laravel, cela peut être fait très facilement en utilisant le [filtre auth](/docs/3/routes#filters). Si l'utilisateur est connecté, la requête continue son exécution, sinon il sera redirigé vers la [route nommée](/docs/3/routes#named-routes) "login".

Pour protéeger une route, attachez simplement le filtre **auth** :

    Route::get('admin', array('before' => 'auth', function() {}));

> **Note:** Vous êtes libre de gérer le filtre auth à votre guise. Le comportement par défaut se trouve dans le fichier **application/routes.php**.

<a name="user"></a>
## Obtenir des infos sur l'utilisateur connecté

Lorsqu'un utilisateur est connecté, la méthode **user** vous retournera ses informations :

    return Auth::user()->email;

> **Note:** Si l'utilisateur n'est pas connecté, la méthode **user** retourne NULL.

<a name="logout"></a>
## Déconnexion

Pour déconnecter un utilisateur :

    Auth::logout();

Cette méthode supprime le Used ID de la session, l'utilisateur sera considéré comme déconnecter lors des requêtes futures.

