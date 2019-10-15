<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - Laravel France</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

</head>
<body id="app">
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Laravel France</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Forums</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/slack"><i class="fa fa-slack"></i> Slack</a>
            </li>
            @if(Auth::guest())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="login_dd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Se connecter
                </a>
                <div class="dropdown-menu" aria-labelledby="login_dd">
                    <a class="dropdown-item" href="{{ route('oauth.to', ['google']) }}">Google</a>
                    <a class="dropdown-item" href="{{ route('oauth.to', ['github']) }}">Github</a>
                    <a class="dropdown-item" href="{{ route('oauth.to', ['twitter']) }}">Twitter</a>
                </div>
            </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="account_dd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mon compte
                    </a>
                    <div class="dropdown-menu" aria-labelledby="account_dd">
                        <a class="dropdown-item" href="{{ route('user.index') }}">Mon compte</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('user.logout') }}">Déconnexion</a>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>

<main role="main">
    @yield('main_content')
</main>

<footer class="bg-dark mt-3 text-center text-white">

    <p>
        Développement & maintenance : <a href="http://craftyx.fr">Craftyx</a>
    </p>

    <p>
        Rejoignez nous sur :
        <a href="https://github.com/JulienTant/laravel-france" title="Github"><i class="fa fa-github-alt"></i> Github</a> |
        <a href="https://laravel.fr/slack" title="Slack"><i class="fa fa-slack"></i> Slack</a>
    </p>
</footer>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-37182814-1', 'auto');
    ga('send', 'pageview');
</script>
@include('sweet::alert')
</body>
</html>
