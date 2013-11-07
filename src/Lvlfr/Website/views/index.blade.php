@extends('base.layout')

@section('content')
<div class="orangebox">
    <div class="container">
        <div class="col">
            <h2>En direct des forums</h2>
            <ul>
                @foreach($topics as $topic)
                <li><a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@moveToLast', array($topic->slug, $topic->id), true) }}">{{ $topic->title }}</a> <small>{{ diffForHumans($topic->updated_at); }}</small></li>
                @endforeach
            </ul>
        </div>
        <div class="col">
            <a class="download" href="http://docs.laraveldev.fr/4.0/quick">
                <i class="icon-rocket"></i> Démarrage rapide
            </a>
        </div>
    </div>
</div>

<div class="container" id="indexPage">
    <section>
        <h2>Un framework PHP élégant, puissant et robuste</h2>

        <p>
            Disponible aujourd'hui dans sa quatrième version, le framework Laravel créé par <a href="https://github.com/taylorotwell" target="_blank">Taylor Otwell</a> en 2011 remporte un franc succès grâce à des atouts qui le rendent unique. Depuis le début, l'objectif du framework est de rendre le développement fun à nouveau, en fournissant aux développeurs les outils dont ils ont besoin pour travailler efficacement sur leurs projets.
        </p>
    </section>

    {{-- TODO: Finish the page --}}
</div>
@stop
