<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forums - Laravel France</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

</head>
<body id="app">
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-5">
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
            <li class="nav-item">
                <a class="nav-link" href="/login">Se connecter</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/account">Mon compte</a>
            </li>
        </ul>
    </div>
</nav>

<main role="main" class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-4">
                <a href="/topics/create" class="btn btn-primary btn-block">Créer un sujet</a>
            </div>

            <ul class="category-list">
                @for($i=1;$i<=8;$i++)
                <li><span class="category-color" style="background-color: red"></span> Catégorie {{$i}}</li>
                @endfor
            </ul>
        </div>

        <div class="col-md-9">
            @for($i=0;$i<10;$i++)
                <div class="post">
                    <div class="row">
                        <div class="d-none d-md-block col-md-2">
                            <div class="m-auto avatar p-1">
                                <img src="//www.gravatar.com/avatar/5ed51887259d4c90e4ceb2dc4568084c?s=75" alt="{{ "Avatar de JulienTant" }}" data-toggle="tooltip" data-placement="top" title="JulienTant">
                                MySuperDuperLongNicknameLOL
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <h2><a href="/">Titre</a></h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto deleniti est et eum officia, voluptatem. Accusamus aliquam animi corporis deserunt ex impedit ipsa quia tenetur totam voluptatum! Atque, dolor quae!</p>
                        </div>
                        <div class="d-none d-md-block col-md-3">
                            <div class="category">
                                <span class="badge" style="background-color: red;">Le coin des artisans</span>

                            </div>
                            <div class="comments">
                                <i class="fa fa-comment-o"></i> 560
                            </div>
                            <div class="time">
                                <i class="fa fa-clock-o"></i> il y a 2 heures
                            </div>

                        </div>
                    </div>
                </div>
            @endfor
        </div>

    </div>
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
</body>
</html>
