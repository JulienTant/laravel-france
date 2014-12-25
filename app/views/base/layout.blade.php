<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/app.css?v=20141225">
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
                <li class="toggle"><a href="javascript:void(0);"><i class="icon-reorder"></i> Menu</a></li>
                <li @if(str_is('*forums.*', Request::root()))class='active'@endif><a href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}">Forums</a></li>
                <li @if(str_is('*docs.*', Request::root()))class='active'@endif><a href="{{ action('\Lvlfr\Documentation\Controller\DocumentationController@showDocs') }}">Documentation</a></li>
                <li @if(str_is('*wiki.*', Request::root()))class='active'@endif><a href="{{ action('\Lvlfr\Wiki\Controller\HomeController@index', null, true) }}">Wiki</a></li>
                <li @if(Request::is('*irc/index'))class='active'@endif><a href="{{ action('Lvlfr\Website\Controller\IrcController@getIndex', null, true) }}">IRC</a></li>

                <li @if(Request::is('contact*'))class='active'@endif><a href="{{ action('Lvlfr\Website\Controller\ContactController@getIndex', null, true) }}"> Contact</a></li>
            </ul>
            <ul class="menu menu-account">
                <li class="account">
                @if(Auth::check())
                    <a href="{{ action('Lvlfr\Login\Controller\ProfileController@index') }}"><i class="icon-user"></i> {{ Auth::user()->username }}</a>
                    <ul>
                        <li><a href="{{ action('Lvlfr\Login\Controller\ProfileController@index') }}">Profil</a></li>
                        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@logout', null, true) }}">Déconnexion</a></li>
                    </ul>
                </li>
                @else
                    <a href="#"><i class="icon-user"></i> Connexion</a>
                    <ul>
                        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('Google'), true) }}">Google</a></li>
                        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('twitter'), true) }}">Twitter</a></li>
                        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('GitHub'), true) }}">Github</a></li>
                    </ul>
                @endif
                </li>
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

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-37182814-1', 'auto');
    ga('send', 'pageview');
</script>

@yield('add_js')