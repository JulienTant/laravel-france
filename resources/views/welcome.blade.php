<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>

        <header class="SiteHeader">
            <div class="SiteHeader__Inner">
                <h1 class="SiteHeader__Inner__SiteTitle">Laravel France</h1>

                <nav class="SiteHeader__Inner__Nav">
                    <ul class="SiteHeader__Inner__Nav__Links">
                        <li class="SiteHeader__Inner__Nav__Links__Link"><a href="#">Forums</a></li>
                        <li class="SiteHeader__Inner__Nav__Links__Link"><a href="#">Discussion</a></li>
                        <li class="SiteHeader__Inner__Nav__Links__Link"><a href="#">Mon compte</a></li>
                    </ul>
                </nav>

            </div>
        </header>

        <div class="Forums">
            <aside class="Forums__Sidebar">
                <a href="#" class="Button Button_NewTopic">Créer un sujet</a>

                <ul class="Forums__Sidebar__CategoriesList">
                    <li class="Forums__Sidebar__CategoriesList__Item Forums__Sidebar__CategoriesList__Item--All"><a href="#">Toutes les catégories</a></li>
                    <li class="Forums__Sidebar__CategoriesList__Item">
                        <a href="#">
                            <span class="Forums__Sidebar__CategoriesList__Item__Color" style="background-color: red"></span>
                            Catégorie X
                        </a>
                    </li>
                    <li class="Forums__Sidebar__CategoriesList__Item">
                        <a href="#">
                            <span class="Forums__Sidebar__CategoriesList__Item__Color" style="background-color: magenta"></span>
                            Catégorie X
                        </a>
                    </li>
                    <li class="Forums__Sidebar__CategoriesList__Item">
                        <a href="#">
                            <span class="Forums__Sidebar__CategoriesList__Item__Color" style="background-color: darkcyan"></span>
                            Catégorie X
                        </a>
                    </li>
                </ul>
            </aside>

            <section class="Forums__Content">

                <div class="Forums__Searchbar">
                    <input type="text" class="Forums__Searchbar__Field" placeholder="Rechercher" />
                </div>

                <ul class="Forums__TopicList">
                    @for($i=0; $i<10; $i++)
                    <li class="Forums__TopicList__Item">
                        <div class="Forums__TopicList__Item__Avatar">
                            <img src="//www.gravatar.com/avatar/{{ md5('julien@laravel.fr') }}?s=68" alt="Avatar de XXXX">
                        </div>

                        <div class="Forums__TopicList__Item__Content">
                            <h3 class="Forums__TopicList__Item__Subject">Subject Name {{ $i }}</h3>
                            <a class="Forums__CategoryLabel">Catégorie {{ $i }}</a>
                            <span class="Forums__TopicList__Item__Metas__Authoring">Dernier message : {{ str_random(rand(5, 10)) }} il y a {{ $i }} jours</span>
                            <p class="Forums__TopicList__Item__Excerpt">
                                {{ str_limit('We track all of our issues on GitHub, so it\'d be really great if you could save us the trouble and create an issue there instead of starting a new discussion on this forum. save us the trouble and create an issue there instead of starting a new discussion on this forum', 200) }}
                            </p>
                        </div>

                        <div class="Forums__TopicList__Item__NbReplies">
                            <p class="Forums__TopicList__Item__NbReplies__Count">
                                {{ ($i+1)*rand(1, 5) }}
                            </p>
                        </div>

                    </li>
                    @endfor
                </ul>
            </section>
        </div>

        <footer>
            Développement & maintenance : <a href="http://craftyx.fr">Craftyx</a>
        </footer>


    </body>
</html>
