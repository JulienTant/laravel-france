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


@yield('content')

<footer>
    Développement & maintenance : <a href="http://craftyx.fr">Craftyx</a>
</footer>


</body>
</html>
