# Configuration de l'authentification

## Au menu

- [Les bases](#the-basics)
- [Le driver d'authentification](#driver)
- [Le champ de login](#username)
- [Modèle d'Table d'authentification](#model)
- [Table d'Table d'authentification](#table)

<a name="the-basics"></a>
## Les bases

La plupart des applications interactives permettent aux utilisateurs de se connecter et de se déconnecter. Laravel fournit une classe simple pour vous aider à valider les informations d'authentification de l'utilisateur et retrouver ses informations dans la base de donnée.

Pour commencer, regardons le fichier **application/config/auth.php**. La configuration de l'authentification contient quelques options basiques pour vous aider à commencer avec l'authentification.

<a name="driver"></a>
## Le driver de Table d'authentification

La table d'authentification de Laravel est basée sur des drivers, cela signifie que la responsabilité de retrouver l'utilisateur qui tente de se connecter est de la responsabilité de divers drivers. Deux sont inclus avec Laravel : Eloquent et Fluent, mais libre à vous d'écrire le vôtre si vous le souhaitez !

Le driver **Eloquent** utilise l'ORM Eloquent pour charger l'utilisateur de l'application, et est le driver par défaut dans Laravel. Le driver **Fluent** utilise *fluent query builder* pour charger les utilisateurs.

<a name="username"></a>
## Le champ de login

La seconde option dans le fichier de configuration détermine quel champ dans votre table en base de données doit être utilisé en tant que "login". Cela sera souvent un champs du type "email" ou "username" ou encore "login" dans votre table "users".

<a name="model"></a>
## Modèle de Table d'authentification

Si vous utilisez le driver **Eloquent**, cette option détermine quel modèle doit être utilisé pour charger les utilisateurs.

<a name="table"></a>
## Table de Table d'authentification

Lorsque vous utilisez le driver **Fluent**, cela détermine quelle table contient vos utilisateurs.