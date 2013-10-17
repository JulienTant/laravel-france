# Pagination

## Au menu

- [Les bases](#the-basics)
- [Utilisation du Query Builder](#using-the-query-builder)
- [Ajout de paramètres aux liens de pagination](#appending-to-pagination-links)
- [Création d'un paginateur manuellement](#creating-paginators-manually)
- [Appliquer un style à la pagination](#pagination-styling)

<a name="the-basics"></a>
## Les bases

Le paginateur de Laravel est conçu pour réduire la charge de l'implémentation de la pagination.

<a name="using-the-query-builder"></a>
## Utilisation du Query Builder

Parcourons un exemple complet d'utilisation de la pagination en utilisant le [Fluent Query Builder](/docs/3/database/fluent):

#### Obtenir le résultat paginé d'une requête :

    $orders = DB::table('orders')->paginate($nb_par_page);

Vous pouvez également passer un tableau optionnel avec les colonnes de la table que vous souhaitez sélectionner dans votre requête :

    $orders = DB::table('orders')->paginate($nb_par_page, array('id', 'name', 'created_at'));

#### Affiche le résultat dans une vue :

    <?php foreach ($orders->results as $order): ?>
        <?php echo $order->id; ?>
    <?php endforeach; ?>

#### Génération des liens de pagination :

    <?php echo $orders->links(); ?>

la méthodes **links** va créer une liste de pages très plaisantes, qui pourrait ressembler à cela :

    Précédente 1 2 ... 24 25 26 27 28 29 30 ... 78 79 Suivante

Le paginateur va automatiquement déterminer sur quelle page vous vous trouvez, et mettre à jour le résultat et les liens.

Il est également possible d'avoir uniquement des liens "suivante" et "précédente" :

#### Génération de liens "Suivante" et "Précédente" :

    <?php echo $orders->previous().' '.$orders->next(); ?>

*Voir aussi:*

- *[Fluent Query Builder](/docs/3/database/fluent)*

<a name="appending-to-pagination-links"></a>
## Ajout de paramètres aux liens de pagination

Vous pouvez ajouter plusieurs éléments aux liens de pagination, telle que la colonne sur laquelle s'effectue le tri.

#### Ajout du critère de tri aux liens de pagination :

    <?php echo $orders->appends(array('sort' => 'votes'))->links();

Les URLs ressembleront alors à quelque chose comme ça :

    http://exemple.fr/something?page=2&sort=votes

<a name="creating-paginators-manually"></a>
## Création d'un paginateur manuellement

Vous pouvez créer une instance de la classe Paginator afin de gérer vous même une pagination, sans utiliser le Query Builder. Voici comment faire :

#### Creation d'un paginateur :

    $orders = Paginator::make($orders, $total, $nb_par_page);

<a name="pagination-styling"></a>
## Appliquer un style à la pagination

Tous les éléments peuvent être stylisé grâce aux classes. Voici un exemple de code HTML généré par la méthode links() :

    <div class="pagination">
        <ul>
            <li class="previous_page"><a href="foo">Précédente</a></li>

            <li><a href="foo">1</a></li>
            <li><a href="foo">2</a></li>

            <li class="dots disabled"><a href="#">...</a></li>

            <li><a href="foo">11</a></li>
            <li><a href="foo">12</a></li>

            <li class="active"><a href="#">13</li>

            <li><a href="foo">14</a></li>
            <li><a href="foo">15</a></li>

            <li class="dots disabled"><a href="#">...</a></li>

            <li><a href="foo">25</a></li>
            <li><a href="foo">26</a></li>

            <li class="next_page"><a href="foo">Suivante</a></li>
        </ul>
    </div>

Quand vous êtes sur la première page de résultat, le lien "Précédente" sera désactivé. A l'inverse, quand vous serez sur la dernière page, le lien "Suivante" sera désactivé. Cela se traduit par l'ajout de la classe "disabled". Voici le code HTML généré :

    <li class="disabled previous_page"><a href="#">Précédente</a></li>
