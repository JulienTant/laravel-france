<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Laravel France')</title>
    <meta id="token" name="token" value="{{ csrf_token() }}" />
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
                <li class="SiteHeader__Inner__Nav__Links__Link">
                    <i class="fa fa-slack"></i>
                    <a href="{{ route('slack') }}">Slack</a>
                </li>
                <li class="SiteHeader__Inner__Nav__Links__Link"><a href="{{ route('contact') }}">Contact</a></li>
                <li class="SiteHeader__Inner__Nav__Links__Link">
                    @if(Auth::user())
                        <a href="#">Mon compte</a>
                        <ul class="SiteHeader__Inner__Nav__Links__Link__Sub">
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
            Développement & maintenance : <a href="http://craftyx.fr">Craftyx</a>
        </div>
    </div>
</footer>


@if(!Auth::user())
    <login-box :show-modal.sync="showLoginBox"></login-box>
@endif
@include('vendor.sweet.alert')
</body>
<script src="/js/main.js"></script>
</html>
