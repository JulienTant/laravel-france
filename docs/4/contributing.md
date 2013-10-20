# Apporter sa contribution à Laravel

- [Introduction](#introduction)
- [Les requêtes Pull](#pull-requests)
- [Guide de développement](#coding-guidelines)

<a name="introduction"></a>
## Introduction

Laravel est un logiciel open source, ce qui signifie que tout un chacun peut contribuer à son développement et à son amélioration. Le code source de Laravel est actuellement disponible sur le site [Github](http://github.com), lequel fournit une méthode simple permettant de créer une branche du projet et d'intégrer vos contributions.

<a name="pull-requests"></a>
## Les requêtes Pull

Le développement de nouvelles fonctionnalités et les corrections d'anomalies nécessitent des requêtes `pull` différentes. Avant d'envoyer une requête `pull` pour une nouvelle fonctionnalité, vous devez créer un cas (menu `Issues` du site Github) et inclure le terme `[Proposal]` dans le titre. La proposition doit décrire la nouvelle fonctionnalité y compris des éléments d'implémentation. Après examen, la proposition sera acceptée ou rejetée. Une fois la proposition acceptée, une requête `pull` doit être créée pour implémenter la nouvelle fonctionnalité. Toute requête `pull` ne respectant pas ce protocole sera immédiatement close.

Dans le cas des corrections d'anomalies, des requêtes `pull` doivent être envoyées sans proposition préalable dans un cas Github. Si vous estimez détenir la solution en termes de correction d'une anomalie recensée sur le site Github, merci de joindre un commentaire détaillant la correction proposée.

### Les demandes de fonctionnalité

Si vous avez une idée de fonctionnalité que vous aimeriez voir être ajoutée à Laravel, créez un cas Github et incluez le terme `[Request]` dans le titre. Cette fonctionnalité sera analysée par une personne de l'équipe de développement.

<a name="coding-guidelines"></a>
## Guide de développement

Laravel adopte les standards de codage [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) et [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md). Les standards suivants doivent également être pris en compte :

- les namespace doivent être déclarés sur une même ligne de la même manière que `<?php`,
- l'ouverture `{` d'une classe doit être sur la même ligne que le nom de la classe,
- le nom d'une fonction et l'ouverture `{` du corps de la fonction doivent être sur deux lignes différentes,
- suffixer les noms d'interface avec `Interface` (`FooInterface`).
