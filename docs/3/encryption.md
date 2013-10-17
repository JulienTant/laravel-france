# Chiffrement

## Au menu

- [Les bases](#the-basics)
- [Chiffrage d'une chaîne](#encrypt)
- [Decrypting A String](#decrypt)

<a name="the-basics"></a>
## Les bases

La classe **Crypter** de Laravel fournit une interface simple pour gérer du chiffrement sécurisé. Par défaut, la classe Crypter fournit la possibilité de chiffrer et déchiffrer des données avec AES-256 grâce à l'extension PHP mcrypt.

> **Note:** N'oubliez pas d'installer l'extension mcrypt sur votre serveur.

<a name="encrypt"></a>
## Chiffrage d'une chaîne

#### Chiffre une chaîne donnée :

	$encrypted = Crypter::encrypt($value);

<a name="decrypt"></a>
## Déchiffrage d'une chaîne

#### Déchiffre une chaîne donnée:

	$decrypted = Crypter::decrypt($encrypted);

> **Note:** Il est important de noter que cette méthode ne peut déchiffrer que des chaînes qui ont été chiffrées avec **votre** application key.
