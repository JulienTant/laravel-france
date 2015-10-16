<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="@yield('page_class')" id="app">

<header class="SiteHeader">
    <div class="SiteHeader__Inner">
        <a href="/">
            <h1 class="SiteHeader__Inner__SiteTitle">Laravel France</h1>
        </a>

        <nav class="SiteHeader__Inner__Nav">
            <ul class="SiteHeader__Inner__Nav__Links">
                <li class="SiteHeader__Inner__Nav__Links__Link"><a href="{{ route('forums.index') }}">Forums</a></li>
                <li class="SiteHeader__Inner__Nav__Links__Link"><a href="{{ route('slack') }}">Discussion</a></li>
                <li class="SiteHeader__Inner__Nav__Links__Link"><a href="{{ route('contact') }}">Contact</a></li>
                <li class="SiteHeader__Inner__Nav__Links__Link">
                    @if(Auth::user())
                        <a href="#">Mon compte</a>
                        <ul class="SiteHeader__Inner__Nav__Links__Link__Sub">
                            <li class="SiteHeader__Inner__Nav__Links__Link__Sub__Link"><a href="{{ route('logout') }}">Déconnexion</a></li>
                        </ul>
                    @else
                        <a href="#">Connexion</a>
                        <ul class="SiteHeader__Inner__Nav__Links__Link__Sub">
                            <li class="SiteHeader__Inner__Nav__Links__Link__Sub__Link"><a href="{{ route('socialite.login', ['google']) }}">Google</a></li>
                            <li class="SiteHeader__Inner__Nav__Links__Link__Sub__Link"><a href="{{ route('socialite.login', ['github']) }}">Github</a></li>
                            <li class="SiteHeader__Inner__Nav__Links__Link__Sub__Link"><a href="{{ route('socialite.login', ['twitter']) }}">Twitter</a></li>
                        </ul>
                    @endif
                </li>
            </ul>
        </nav>

    </div>
</header>


@yield('content')

<footer class="SiteFooter">
    <div class="Utility__Container">
        <div class="SiteFooter__Inner">
            Développement & maintenance : <a href="http://craftyx.fr">Craftyx</a>
        </div>
    </div>
</footer>

@include('vendor.sweet.alert')
</body>
<script src="/js/main.js"></script>
</html>
