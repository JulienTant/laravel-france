# Eloquent ORM

## Au menu

- [Les bases](#the-basics)
- [Conventions](#conventions)
- [Récupération de modèles](#get)
- [Agrégats](#aggregates)
- [Insertion & mise à jour du modèle](#save)
- [Relations](#relationships)
- [Insertion de modèles liés](#inserting-related-models)
- [Travail avec les tables pivots](#intermediate-tables)
- [Chargement lié](#eager)
- [Ajout de contraintes au chargement lié](#constraining-eager-loads)
- [Getter & Setter](#getter-and-setter-methods)
- [Assignement de masse](#mass-assignment)
- [Conversion d'un modèle en tableau](#to-array)
- [Suppression de modèle](#delete)

<a name="the-basics"></a>
## Les bases

Laravel est fourni avec un [ORM](http://fr.wikipedia.org/wiki/Mapping_objet-relationnel), qui vous adorerez utiliser ! Son nom est "Eloquent" car il vous permet de travailler avec des objets de base de données et des relations en utilisant une syntaxe éloquente et expressive. En général, vous définirez un modèle Eloquent pour chaque table de votre base de données. Pour démarrer, définissez un modèle simple :

    class User extends Eloquent {}

Cool ! Remarquez que notre modèle hérite de la classe **Eloquent**. Cette classe fournira toutes les fonctionnalités que vous avez besoin pour travailler avec éloquence sur votre base de données.

> **Note:** Typiquement, les modèles Eloquent seront dans le dossier **application/models**.

<a name="conventions"></a>
## Conventions

Pour utiliser Eloquent, vous devez savoir qu'il fera les hypothèses suivantes sur la structure de votre base de données :

- Chaque table doit avoir une clé primaire nommée **id**.
- Chaque table a un nom qui correspond au pluriel du nom du modèle associé.

Si vous souhaitez utiliser un nom de table qui n'est pas le pluriel du nom du modèle, ou choisir vous même le nom de la clé primaire, ajoutez simplement une propriété statique **table** et/ou **key** à votre modèle :

    class User extends Eloquent {

         public static $table = 'my_users';
         public static $key = 'my_user_id';

    }

<a name="get"></a>
## Récupération de modèles

La récupération de modèles en utilisant Eloquent est vraiment très simple. La manière la plus basique pour ce faire est d'utiliser la méthode statique **find**. Cette méthode retournera un simple modèle par sa clé primaire avec des propriétés correspondantes à chaque nom de colonnes :

    $user = User::find(1);

    echo $user->email;

La méthode find exécute la requête suivante :

    SELECT * FROM "users" WHERE "id" = 1

Besoin de récupérer une table entière ? Utilisez la méthode statique **all** :

    $users = User::all();

    foreach ($users as $user)
    {
         echo $user->email;
    }

Bien sûr, récupérer une table entière n'est pas très utile. Heureusement, **toutes les méthode du Fluent Query Builder sont disponibles avec Eloquent**. Commencez à requêter votre modèle avec une méthode statique disponible avec le [constructeur de requête fluide](/docs/3/database/fluent), et exécutez la requête avec les méthodes **get** ou **first**. La méthode get retournera un tableau de modèles, tandis que first retournera un simple modèle :

    $user = User::where('email', '=', $email)->first();

    $user = User::where_email($email)->first();

    $users = User::where_in('id', array(1, 2, 3))->or_where('email', '=', $email)->get();

    $users = User::order_by('votes', 'desc')->take(10)->get();

> **Note:** Si aucun résultat n'est trouvé, la méthode `first` retournera NULL. Les méthodes `all` et `get` retournent un tableau vide.

<a name="aggregates"></a>
## Agrégats

Besoin d'utiliser **MIN**, **MAX**, **AVG**, **SUM**, ou **COUNT** ? Passez le nom de la colonne à la requête :

    $min = User::min('age');

    $max = User::max('weight');

    $avg = User::avg('salary');

    $sum = User::sum('votes');

    $count = User::count();

Bien sûr, vous pouvez limiter la requête en plaçant une clause WHERE d'abord :

    $count = User::where('id', '>', 10)->count();


<a name="save"></a>
## Insertion & mise à jour du modèle

L'insertion d'un modèle Eloquent dans vos tables ne pourrait pas être plus facile. Instanciez un nouveau modèle, définissez ses propriétés, et pour finir appelez la méthode **save** :

    $user = new User;

    $user->email = 'example@gmail.com';
    $user->password = 'secret';

    $user->save();

Vous pouvez alternativement utiliser la méthode **create**, qui insérera une nouvelle ligne dans la base de données et retournera une nouvelle instance de modèle pour la ligne nouvellement insérée, ou **false** si l'insertion échoue.

    $user = User::create(array('email' => 'example@gmail.com'));

La mise à jour est tout aussi simple. Seule la première étape change : au lieu de créer une nouvelle instance vide, utilisez une instance qui provient de la base de données. Ensuite, définissez les propriétés et sauvegardez :

    $user = User::find(1);

    $user->email = 'new_email@gmail.com';
    $user->password = 'new_secret';

    $user->save();

Besoin de maintenir une date de création et de mise à jour pous vos enregistrements ? Avec Eloquent, vous n'avez pas en vous en occuper. Ajoutez simplement une propriété statique **timestamps** à votre modèle :

    class User extends Eloquent {

         public static $timestamps = true;

    }

Ensuite, ajoutez les clonnes **created_at** et **updated_at** de type DateTime à vos tables. Maintenant, dès que vous sauvegarderez le modèle, la date de création et de modification seront automatiquement mises à jour. Ne nous remerciez pas, c'est tout naturel :-)

> **Note  :** la propriété `$timestamps` est à true par défaut. Donc si à l'inverse vous n'en avez pas besoin, placez la à false pour éviter des erreurs lors de l'insertion et la modification de vos lignes.

Dans certain cas, il peut être utile de mettre à jour la colonne **updated_at** sans modifier réellement des données de la table. Utilisez simplement la méthode **touch**, qui sauvegardera alors automatiquement votre ligne :

    $comment = Comment::find(1);
    $comment->touch();

Vous pouvez aussi utiliser la méthode **timestamp**, qui elle ne fera pas de sauvegarde automatique. Cependant, l'intérêt est limité car cela est fait automatiquement lors de l'appel à save :

    $comment = Comment::find(1);
    $comment->timestamp();
    $comment->save();

> **Note:** Vous pouvez changer la timezone par défaut dans le fichier **application/config/application.php**.

<a name="relationships"></a>
## Relations

Vos tables auront probablement des relations avec d'autres. Par exemple, une commande appartient à un utilisateur. Ou, un post peut avoir plusieurs commentaires. Eloquent rend la définition des relations et la récupération des modèles liés simple et intuitive. Laravel supporte trois types de relations :

- [One-To-One](#one-to-one)
- [One-To-Many](#one-to-many)
- [Many-To-Many](#many-to-many)

Pour définir une relation dans un modèle Eloquent, vous créez simplement une méthode qui retourne le résultat d'une des méthodes suivantes : **has\_one**, **has\_many**, **belongs\_to**, ou **has\_many\_and\_belongs\_to**. Examinons tout cela en détail :

<a name="one-to-one"></a>
### One-To-One

Une relation `un vers un` est la plus basique de toute. Par exemple, disons qu'un utilisateur a un téléphone. Décrivez cette relation avec Eloquent :

    class User extends Eloquent {

         public function phone()
         {
              return $this->has_one('Phone');
         }

    }

Remarquez que le nom du modèle lié est passé à la méthode **has_one**. Vous pouvez maintenant récupérer le téléphone de l'utilisateur via la méthode **phone** :

    $phone = User::find(1)->phone()->first();

Examinons les requêtes SQL générées. Deux requêtes sont exécutées : une pour retrouver l'utilisateur, et une pour retrouver le téléphone de l'utilisateur

    SELECT * FROM "users" WHERE "id" = 1

    SELECT * FROM "phones" WHERE "user_id" = 1

Notez qu'Eloquent assume que la clé étrangère sera **user\_id**. La plupart des clés suivront le modèle **model\_id**; cependant si vous souhaitez utiliser un nom de colonne différent pour votre clé, passez en second paramètre le nom de cette colonne :

    return $this->has_one('Phone', 'my_foreign_key');

Si vous souhaitez récupérer le téléphone de l'utilisateur sans appelé la méthode `first()`, utilisez la **propriété dynamique phone**. Eloquent créera automatiquement le chargement de la relation pour vous, et est assez malin pour deviner s'il doit appelé la méthode get (pour les relations one-to-many) ou first (pour les relations one-to-one) :

    $phone = User::find(1)->phone;

Et maintenant, comment retrouver l'utilisateur d'un téléphone ? Étant donné que la clé étrangère (**user\_id**) est sur la table phone, nous devons décrire cette relation en utilisant la méthode **belongs\_to** ( appartient à ). C'est logique, non ? Les téléphones appartiennent aux utilisateurs. Lorsque l'on utilise la méthode **belongs\_to**, le nom de la méthode de relation doit correspondre au nom de la clé étrangère sans le **\_id**. Étant donné que la clé étrangère est  **user\_id**, votre méthode de relation doit s'appeler **user**:

    class Phone extends Eloquent {

         public function user()
         {
              return $this->belongs_to('User');
         }

    }

Bien, nous pouvons accéder à l'utilisateur depuis le modèle Phone en utilisant soit la méthode, soit la propriété dynamique user :

    echo Phone::find(1)->user()->first()->email;

    echo Phone::find(1)->user->email;

<a name="one-to-many"></a>
### One-To-Many

Disons qu'un post de blog a plusieurs commentaires. C'est facile de définir cette relation avec la méthode **has_many** :

    class Post extends Eloquent {

         public function comments()
         {
              return $this->has_many('Comment');
         }

    }

Maintenant, accédez simplement aux commentaires d'un post depuis la méthode de relation ou la propriété dynamique :

    $comments = Post::find(1)->comments()->get();
    $comments = Post::find(1)->comments;

Ces deux instructions exécuteront les requêtes suivantes :

    SELECT * FROM "posts" WHERE "id" = 1
    SELECT * FROM "comments" WHERE "post_id" = 1

Pour changer le nom de la clé étrangère, c'est identique aux relations one-to-one. Passez donc le nom de la colonne en second argument :

    return $this->has_many('Comment', 'my_foreign_key');

Vous devez vous demander : _Si la propriété dynamique retourne la relation, à quoi bon utiliser les méthodes de relations ?_ Les méthodes de relations sont vraiment puissantes, et elles vous autorise à continuer de chaîner des méthodes de requêtes avant de récupérer la relation :

    Post::find(1)->comments()->order_by('votes', 'desc')->take(10)->get();

<a name="many-to-many"></a>
### Many-To-Many

Les relations `plusieurs vers plusieurs` sont les plus compliqués des trois. Mais ne vous inquiétez pas, nous allons le faire ! Par exemple, disons qu'un utilisateur a plusieurs rôles, et bien sûr, un rôle peut être attribué à plusieurs utilisateurs. Trois tables doivent être créées pour accomplir cette relation :

**users:**

    id    - INTEGER
    email - VARCHAR

**roles:**

    id   - INTEGER
    name - VARCHAR

**role_user:**

    id      - INTEGER
    user_id - INTEGER
    role_id - INTEGER

Les tables contiennent plusieurs enregistrements et sont donc au pluriel. La table de pivot utilisée par la méthode **has\_many\_and\_belongs\_to** est nommée en combinant le singulier du nom des deux modèles trié alphabétiquement et concaténé ensemble avec un underscore.

Maintenant vous êtes prêt à définir la relation dans vos modèles en utilisant la méthode **has\_many\_and\_belongs\_to** :

    class User extends Eloquent {

         public function roles()
         {
              return $this->has_many_and_belongs_to('Role');
         }

    }

Bien, retrouvons maintenant les rôles d'un utilisateur :

    $roles = User::find(1)->roles()->get();

Ou, comme d'habitude, avec la propriété dynamique roles :

    $roles = User::find(1)->roles;

Si votre nom de table ne suit pas la convention de nommage, passez le nom de la table en tant que second argument à la méthode **has\_many\_and\_belongs\_to** :

    class User extends Eloquent {

         public function roles()
         {
              return $this->has_many_and_belongs_to('Role', 'user_roles');
         }

    }

Par défaut, uniquement certains champs de la table pivot seront retournés (les deux champs **id** et les timestamps). Si votre table pivot contient des colonnes additionnelles, vous pouvez les récupérer également, en utilisant la méthode **with()** :

    class User extends Eloquent {

         public function roles()
         {
              return $this->has_many_and_belongs_to('Role', 'user_roles')->with('column');
         }

    }

<a name="inserting-related-models"></a>
## Insertion de modèles liés

Disons que vous ayez un modèle **Post** qui a plusieurs commentaires. Souvent vous voudrez insérer un nouveau commentaire pour un Post donné. Plutôt que de définir manuellement la clé étrangère **post_id** dans votre modèle, vous pouvez insérer votre commentaire depuis le modèle Post :

    $comment = new Comment(array('message' => 'A new comment.'));
    $post = Post::find(65);
    $comment = $post->comments()->insert($comment);

Lorsque vous insérez des modèles liés depuis le modèle parent, la clé étrangère sera automatiquement définie. Alors dans ce cas, la clé "post_id" sera automatiquement définie à "65" dans notre nouveau commentaire.

<a name="has-many-save"></a>
Lorsque vous travaillez avec des relations `has_many`, vous pouvez utiliser la méthode `save` pour insérer / mettre à jour des modèles :

    $comments = array(
        array('message' => 'A new comment.'),
        array('message' => 'A second comment.'),
    );

    $post = Post::find(1);

    $post->comments()->save($comments);

### Insertion de modèles liés (Many-To-Many)

C'est encore plus utile lorsque vous avez une relation `many-to-many`. Par exemple, imaginez un modèle **User** qui a plusieurs rôles. De la même manière, le modèle **Role** peut avoir plusieurs utilisateurs. Le table intermédiaire contient les colonnes "user_id" et "role_id". Maintenant, insérez un nouveau rôle à un utilisateur :

    $role = new Role(array('title' => 'Admin'));
    $user = User::find(1);
    $role = $user->roles()->insert($role);

Le rôle est maintenant créé dans la table "roles", et un enregistrement dans la table pivot est créé pour vous.

Cependant, dans la plupart des cas, vous souhaiterez uniquement insérer une relation, sans créer le rôle car il existe déjà. Utilisez alors la méthode `attach` :

    $user->roles()->attach($role_id);

Il est également possible d'attacher des données pour les colonnes de la table intermédiaire. Pour ce faire, ajoutez un tableau en tant que second paramètre à la méthode `attach` :

    $user->roles()->attach($role_id, array('expires' => $expires));

<a name="sync-method"></a>
Alternativement, vous pouvez utiliser la méthode `sync` qui accepte un tableau avec les ID à synchroniser dans la table intermédiaire. Après que cette opération soit effectuée, seuls les ID contenus dans le tableau seront dans la table intermédiaire.

    $user->roles()->sync(array(1, 2, 3));

<a name="intermediate-tables"></a>
## Travail avec les tables pivots

Comme vous le savez probablement, les relations many-to-many nécessitent la présence d'une table pivot. Eloquent vous facilite la maintenance de cette table. Par exemple, disons qu'un modèle **User** a plusieurs rôles, et que un modèle **Role** a plusieurs utilisateurs. La table pivot a des colonnes "user_id" et "role_id". Nous pouvons accéder à la table pivot pour la relation comme cela :

    $user = User::find(1);

    $pivot = $user->roles()->pivot();

Une fois que nous avons une instance de la table pivot, nous pouvons l'utiliser comme n'importe quel modèle Eloquent :

    foreach ($user->roles()->pivot()->get() as $row)
    {
        //
    }

Vous pouvez également accéder à une ligne de la table pivot associée à un enregistrement donné. Par exemple :

    $user = User::find(1);

    foreach ($user->roles as $role)
    {
        echo $role->pivot->created_at;
    }

Remarquez que chaque modèle **Role** que nous récupérons aura automatiquement un attribut **pivot**. Cet attribut contient un modèle qui représente la ligne de la table pivot associée à la relation en cours.

Pour supprimer toutes les relations d'un modèle donné, vous pouvez utiliser la méthode `delete` après avoir appelé la méthode de relation :

    $user = User::find(1);

    $user->roles()->delete();

Ceci ne supprime pas les rôles ! Cela supprime les relations entre l'utilisateur et ses rôles dans la table pivot.

<a name="eager"></a>
## Chargements liés

Les chargements liés existent pour éviter le problème des requêtes N + 1. Quel est le problème au juste ? Bien, disons que chaque livre appartient à un auteur. Nous décririons la relation comme ceci :

    class Book extends Eloquent {

         public function author()
         {
              return $this->belongs_to('Author');
         }

    }

Maintenant, examinons le code suivant :

    foreach (Book::all() as $book)
    {
         echo $book->author->name;
    }

Combien de requêtes seront exécutés ? Une requête sera exécutée pour récupérer tous les livres, mais ensuite, une requête sera exécuté pour chaque livre afin de récupérer l'auteur. Donc pour écrire le nom de l'auteur pour 25 livres, nous allons exécuté **26 requêtes**. Cela peut monter très haut...

Mais grâce au chargement lié, nous chargeront les auteurs avec la méthode **with**. Mentionnez simplement le **nom de la méthode de relation** que vous souhaitez chargé de manière liée :

    foreach (Book::with('author')->get() as $book)
    {
         echo $book->author->name;
    }

Dans cet exemple, **seulement deux requêtes seront exécutées**!

    SELECT * FROM "books"

    SELECT * FROM "authors" WHERE "id" IN (1, 2, 3, 4, 5, ...)

Évidement, l'utilisation des chargements liés augmentera énormément les performances de votre application. Dans cet exemple, le temps d'exécution du script est divisé par deux.

Besoin de charger plus d'une relation ? C'est facile :

    $books = Book::with(array('author', 'publisher'))->get();

> **Note:** Lorsque vous utilisez des chargements liés, l'appel à la méthode statique **with** doit toujours se faire au début de la requête.

Vous pouvez également faire du chargement lié imbriqué. Par exemple, disons que le modèle **Author** a une relation nommée "contacts". Nous pouvons charger de manière liée l'auteur d'un livre, et ses contacts :

    $books = Book::with(array('author', 'author.contacts'))->get();

Si vous liez souvent le même modèle, alors placez le dans un tableau, que vous attribuerez à la propriété **$includes** du modèle.

    class Book extends Eloquent {

         public $includes = array('author');

         public function author()
         {
              return $this->belongs_to('Author');
         }

    }

**$includes** prend les même arguments que la méthode **with**. Dans l'exemple suivant qui utilise le modèle ci-dessus, l'auteur sera chargé de manière liée.

    foreach (Book::all() as $book)
    {
         echo $book->author->name;
    }

> **Note:** L'utilisation de **with** écrasera le variable **$includes** du modèle.

<a name="constraining-eager-loads"></a>
## Ajout de contraintes au chargement lié

Parfois vous pourriez souhaiter faire un chargement lié sur une relation, mais en lui ajoutant une condition pour le chargement. C'est simple, et ça ressemble à cela :

    $users = User::with(array('posts' => function($query)
    {
        $query->where('title', 'like', '%first%');

    }))->get();

Dans cet exemple, nous chargeons de manière liée les posts d'un auteur, seulement si le titre du post contient le mot "first".

<a name="getter-and-setter-methods"></a>
## Getter & Setter

Les 'Setters' vous permettent de gérer l'assignement d'une valeur à un attribut grâce à une méthode personnalisée. Définissez un setter en créant une méthode qui aura le même nom que l'attribut, mais précédé par "set_".

    public function set_password($password)
    {
        $this->set_attribute('hashed_password', Hash::make($password));
    }

Appelez une méthode setter comme une propriété (sans parenthèses), en utilisant le nom de la méthode sans le "set_".

    $this->password = "my new password";

Les Getters sont très similaires. Ils peuvent être utilisés pour modifier un attribut avant qu'il ne soit retourné. Définissez un getter en créant une méthode qui aura le même nom que l'attribut, mais précédé par "get_"

    public function get_published_date()
    {
        return date('M j, Y', $this->get_attribute('published_at'));
    }

Appelez une méthode getter comme une propriété (sans parenthèses), en utilisant le nom de la méthode sans le "get_".

    echo $this->published_date;

<a name="mass-assignment"></a>
## Assignement de masse

L'assignement de masse est le fait de passer un tableau associatif à une méthode d'un modèle, qui remplira les attributs de ce dernier avec les valeurs du tableau. L'assignement de masse peut être fait en passant un tableau au constructeur :

    $user = new User(array(
        'username' => 'first last',
        'password' => 'disgaea'
    ));

    $user->save();

Ou, grâce à la méthode **fill** :

    $user = new User;

    $user->fill(array(
        'username' => 'first last',
        'password' => 'disgaea'
    ));

    $user->save();

Par défaut, tous les attributs seront remplis durant l'opération d'assignement de masse. Cependant, il est possible de créer un liste blanche des attributs qui sont autorisés. Si l'attribut `$accessible` est défini, alors aucun autre attribut que ceux présents dans le tableau ne seront liés durant l'assignement de masse.

Vous pouvez spécifier les attributs en assignant un tableau static dans **$accessible**. Chaque élément contient le nom d'un attribut autorisé.

    public static $accessible = array('email', 'password', 'name');

Alternativement, vous pouvez utiliser la méthode **accessible** depuis votre modèle :

    User::accessible(array('email', 'password', 'name'));

Sans paramètres, cette méthode retournera le contenu de la variable **$accessible**

> **Note:** La plus grande prudence doit être prises lors l'assignement d'entrée d'utilisateurs. En effet, des oublis techniques pourraient causer de gros problèmes de sécurité.

<a name="to-array"></a>
## Conversion d'un modèle en tableau

Lorsque que l'on construit une API avec JSON, vous allez devoir convertir vos modèles en tableau pour qu'ils puissent être sérialisés facilement.

#### Converti un modèle en tableau :

    return json_encode($user->to_array());

La méthode `to_array` va automatiquement attraper tous les attributs de votre modèle, et également des relations chargées.

Parfois, vous pourriez souhaiter ne pas mettre à disposition tous les attributs d'un modèle, comme des mots de passes... pour faire cela, un attribut `hidden` peut être défini dans votre modèle :

#### Exclu des attributs du tableau :

    class User extends Eloquent {

        public static $hidden = array('password');

    }

<a name="delete"></a>
## Suppression de modèle

Étant donné que Eloquent hérite de toutes les fonctionnalités du Fluent Query Builder, supprimer un modèle est un jeu d'enfant :

    $author->delete();

Notez cependant que cela ne supprimera pas les modèles liés (ex: tous les livres de l'auteur continuent d'exister), sauf si vous avez mis en place [des clés étrangères](/docs/3/database/schema#foreign-keys) et une suppression en cascade
