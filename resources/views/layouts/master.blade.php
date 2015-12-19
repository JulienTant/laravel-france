<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Laravel France')</title>
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <li class="SiteHeader__Inner__Nav__Links__Link">
                    <a href="{{ route('slack') }}">
                        <i class="fa fa-slack"></i> Slack
                    </a>
                </li>
                <li class="SiteHeader__Inner__Nav__Links__Link"><a href="{{ route('contact') }}">Contact</a></li>
                <li class="SiteHeader__Inner__Nav__Links__Link">
                    @if(Auth::user())
                        <a href="#">Mon compte</a>
                        <ul class="SiteHeader__Inner__Nav__Links__Link__Sub">
                            <li class="SiteHeader__Inner__Nav__Links__Link__Sub__Link"><a href="{{ route('profile') }}">Mon compte</a></li>
                            <li class="SiteHeader__Inner__Nav__Links__Link__Sub__Link"><a href="{{ route('logout') }}">Déconnexion</a></li>
                        </ul>
                    @else
                        <a href="javascript:void()" @click="showLoginBox = true">Connexion</a>
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
            <p>
                Développement & maintenance : <a href="http://craftyx.fr">Craftyx</a>
            </p>

            <p>
                Rejoignez nous sur :
                <a href="https://github.com/JulienTant/laravel-france" title="Github"><i class="fa fa-github-alt"></i> Github</a> |
                <a href="{{ route('slack') }}" title="Slack"><i class="fa fa-slack"></i> Slack</a>
            </p>
        </div>
    </div>
</footer>


@if(!Auth::user())
    <login-box :show-modal.sync="showLoginBox"></login-box>
@endif
@include('vendor.sweet.alert')
</body>
<script src="/js/main.js"></script>
@if (App::environment() == "production")
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-37182814-1', 'auto');
    ga('send', 'pageview');

</script>
@endif
</html>
