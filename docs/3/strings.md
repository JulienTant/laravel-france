# Travailler sur des chaînes de caractères

## Au menu

- [Gestion de la casse](#capitalization)
- [Limite de mots & des caractères](#limits)
- [Génération de chaîne aléatoires](#random)
- [Singulier & pluriel](#singular-and-plural)
- [Slugs](#slugs)

<a name="capitalization"></a>
## Gestion de la casse

La classe **Str** fournit des raccourcis intelligents vers des fonctions PHP, afin de faciliter la mise en majuscule, minuscule, et en mode "titre" ( première lettres de chaque mot en majuscule ). Ces méthodes sont plus intelligentes que les fonctions [strtoupper](http://php.net/manual/fr/function.strtoupper.php), [strtolower](http://php.net/manual/fr/function.strtolower.php), et [ucwords](http://php.net/manual/fr/function.ucwords.php) car ils gèrent l'UTF-8 si l'extension [multi-byte string](http://php.net/manual/fr/book.mbstring.php) PHP est installée. Pour les utiliser, passez juste une chaîne aux méthodes :

	echo Str::lower('Je suis une chaîne.');
    // je suis une chaîne.

	echo Str::upper('Je suis une chaîne.');
    // JE SUIS UNE CHAÎNE.

	echo Str::title('Je suis une chaîne.');
    // Je Suis Une Chaîne.

<a name="limits"></a>
## Limite de mots & des caractères

#### Limite le nombre de caractères dans un chaîne :

    echo Str::limit("Lorem ipsum dolor sit amet", 10);
    // Lorem ipsu...

    echo Str::limit_exact("Lorem ipsum dolor sit amet", 10);
    // Lorem i...

> **Note** : cette méthode reçoit un troisième argument, qui est une fin personnalisée. La valeur par défaut est "...". La différence entre limit et limit_exact est que `limit($string,10)` fera au total 13 caractères (avec les ...), tandis que `limit_exact($string, 10)` n'en fera que 10.

#### Limite le nombre de mots dans un chaîne : 

    echo Str::words("Lorem ipsum dolor sit amet", 3);
    // Lorem ipsum dolor...

<a name="random"></a>
## Génération de chaînes aléatoires

#### Génère une chaîne alpha-numérique :

	echo Str::random(32);

#### Génère une chaîne avec uniquement des lettres :

	echo Str::random(32, 'alpha');

<a name="singular-and-plural"></a>
## Singulier & pluriel

La classe String est capable de transformer vos chaînes du singulier vers le pluriel, et vice versa.

#### Obtient le pluriel d'un mot :

	echo Str::plural('user');
    // users

#### Obtient le singulier d'un mot :

	echo Str::singular('users');
    // user

#### Obtient le pluriel d'un mot si le second argument est plus grand que "un" :

	echo Str::plural('comment', count($comments));

<a name="slugs"></a>
## Slugs

#### Génération d'un slug :

	return Str::slug('My First Blog Post!');
    // my-first-blog-post

#### Génération d'un slug en utilisant un séparateur donné :

	return Str::slug('My First Blog Post!', '_');
    // my_first_blog_post

