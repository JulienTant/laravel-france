# Traduction & Localisation

## Au menu

- [Les bases](#the-basics)
- [Retrouver une ligne de langue](#get)
- [Utilisation de jokers](#replace)

<a name="the-basics"></a>
## Les bases

La localisation est le processus de traduction de votre application en différentes langues. La classe **Lang** fournit un mécanisme simple pour vous aider à organiser et à retrouver le texte de votre application multilingue.

Tous les fichiers de langue de votre application se trouvent dans le dossier **application/language**. Dans ce dossier, vous devrez créer un dossier pour chaque langue que votre application supportera. Par exemple, si votre application supporte l'anglais et le français, vous devrez créer un dossier **en** et un dossier **fr**.

Laravel est fourni avec une liste relativement bien fournie de dossiers de langues, pour le support des messages d'erreur.

Chaque dossier de langue peut contenir plusieurs fichiers de langue. Et dans chaque fichier se trouve un tableau de chaînes dans cette langue. En fait, les fichiers de langue ont la même structure que les fichier de configuration. Par exemple dans le dossier **application/language/fr**, vous pourriez créer un fichier **marketing.php** qui ressemblerait à cela :

#### Crée un fichier de langue :

	return array(

	     'welcome' => 'Bienvenue sur notre site !',

	);

Ensuite, vous créeriez un fichier **marketing.php** dans le dossier **application/language/en**. Il ressemblerait à cela :

	return array(

	     'welcome' => 'Welcome to our website!',

	);

Bien ! Maintenant vous êtes prêt à commencer à mettre en place vos dossiers et fichiers de langue, continuons à "localiser" !

<a name="get"></a>
## Retrouver une ligne de langue

#### Retourne une ligne de langue:

	echo Lang::line('marketing.welcome')->get();

#### Retourne une ligne de langue en utilisant l'helper "__" ( deux underscores ):

	echo __('marketing.welcome');

Remarquez comment le point est utiliser pour séparer "marketing" et "welcome". Le texte avant le point correspond au fichier de langue, tandis que le texte après le point correspond à une clé inscrite dans ce fichier.

Pour obtenir une ligne dans une langue précise, passez l'abbréviation de cette langue à la méthode `get` :

#### Retourne une ligne de langue dans une langue donnée :

	echo Lang::line('marketing.welcome')->get('en');

<a name="replace"></a>
## Utilisation de jokers

Maintenant, travaillons sur notre message de bienvenue. Ce dernier est très générique. Trop générique. Pourquoi ne pas placer le nom de l'utilisateur si ce dernier est connecté ? Pour ce faire, nous pouvons placer un joker dans notre ligne de langue. Les jokers sont précédés par le caractère ':' :

#### Crée une ligne de langage avec un joker :

	'welcome_connected' => 'Bienvenue sur notre site, :nom!'

#### Retourne une ligne de langue avec une valeur :

	echo Lang::line('marketing.welcome_connected', array('nom' => 'Julien'))->get();

#### Retourne une ligne de langue avec une valeur en utilisant "__":

	echo __('marketing.welcome', array('nom' => 'Julien'));
