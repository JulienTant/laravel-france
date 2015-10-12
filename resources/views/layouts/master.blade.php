<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

<header class="SiteHeader">
    <div class="SiteHeader__Inner">
        <a href="/">
            <h1 class="SiteHeader__Inner__SiteTitle">Laravel France</h1>
        </a>

        <nav class="SiteHeader__Inner__Nav">
            <ul class="SiteHeader__Inner__Nav__Links">
                <li class="SiteHeader__Inner__Nav__Links__Link"><a href="{{ route('forums.index') }}">Forums</a></li>
                <li class="SiteHeader__Inner__Nav__Links__Link"><a href="{{ route('slack') }}">Discussion</a></li>
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
<script src="/js/app.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0/styles/default.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0/styles/solarized_dark.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

</html>
