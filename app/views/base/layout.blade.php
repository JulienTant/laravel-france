<!DOCTYPE html>
<html>
<head>
    <title>
        @section('title')
        Bienvenue sur Laravel France
        @stop
    </title>

    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/prettify.css">
    @yield('add_css')
</head>
<body class="@yield('page_class') preload">

    @if(Session::has('top_error'))
    <div class="top_msg top_error">
        {{ Session::get('top_error') }}
        <?php Session::forget('top_error'); ?>
    </div>
    @endif

    @if(Session::has('top_success'))
    <div class="top_msg top_success">
        {{ Session::get('top_success') }}
        <?php Session::forget('top_success'); ?>
    </div>
    @endif

    <header>
        <nav>
            <h1 class="title">
                <a href="{{ Config::get('app.url') }}"><img src="/img/laravel_logo.png" alt="Laravel logo"> Laravel France</a>
            </h1>
            <ul class="menu">
                <li @if(str_is('*docs.*', Request::root()))class='active'@endif><a href="{{ action('\Lvlfr\Documentation\Controller\DocumentationController@showDocs') }}"><i class="icon-book"></i> Documentation</a></li>

                <li @if(Request::is('*irc') || str_is('*forums.*', Request::root()))class='active'@endif>
                    <a href="#"><i class="icon-group"></i> Communauté</a>
                    <ul>
                        <li><a href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}">Forums</a></li>
                        <li @if(Request::is('*irc/index'))class='active'@endif><a href="{{ action('Lvlfr\Website\Controller\IrcController@getIndex', null, true) }}">IRC</a></li>
                    </ul>
                </li>
                <li @if(Request::is('contact*'))class='active'@endif><a href="{{ action('Lvlfr\Website\Controller\ContactController@getIndex', null, true) }}"><i class="icon-envelope"></i> Contact</a></li>
                @if(Auth::check())
                    <li class="account">
                        <a href="{{ action('Lvlfr\Login\Controller\ProfileController@index') }}"><i class="icon-user"></i> {{ Auth::user()->username }}</a>
                        <ul>
                            <li><a href="{{ action('Lvlfr\Login\Controller\ProfileController@index') }}">Profil</a></li>
                            <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@logout', null, true) }}">Déconnexion</a></li>
                        </ul>
                    </li>
                @else
                    <li class="account">
                        <a href="#"><i class="icon-user"></i> Connexion</a>
                        <ul>
                            <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('Google'), true) }}">Google</a></li>
                            <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('twitter'), true) }}">Twitter</a></li>
                            <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('GitHub'), true) }}">Github</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </header>

    <div id="page">
        @yield('content')
    </div><!--/.container-->
    
    <footer>
        @yield('footer')
    </footer>
</body>
</html>

<script src="/js/modernizr.js"></script>
<script src="/js/jquery-2.0.3.min.js"></script>
<script src="/js/app.js"></script>
<script src="/js/prettify/prettify.js"></script>
<script>$("pre").addClass('prettyprint');</script>
<script>prettyPrint();</script>

@yield('add_js')