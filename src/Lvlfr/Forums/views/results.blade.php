@extends('base.layout')

@section('title')
    Recherche : {{ $q }} - Forums Laravel France
@endsection

@section('content')
<div class="container" id="forums">

    <ul class="breadcrumb">
        <li><a title="Retour à la page d'accueil" href="{{ route('home') }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
        <li><a title="Accueil des forums" href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}">Forums</a> <span class="divider">/</span></li>
        <li>Recherche</li>
        @include('LvlfrForums::searchForm')
    </ul>


    <div class="row">
        <div class="span12">
            @if(count($topics))
            <table class="table table-striped mainTable">
                <thead>
                    <tr>
                        <th><strong>Résultat de la recherche : "{{ $q }}"</strong></th>
                        <th class="text-center">Messages</th>
                        <th class="text-center">Vues</th>
                        <th>Dernier message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topics as $topic)
                    <tr>
                        <td>
                            <strong>
                                <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@show', array($topic->slug, $topic->id), true) }}">
                                    {{ $topic->title }}
                                </a>
                            </strong><br>
                            <small>Par {{ $topic->user->username }} le {{ $topic->created_at->format('d/m/Y à H:i:s') }}</small>
                        </td>
                        <td class="text-center" width="127">{{ $topic->nb_messages }}</td>
                        <td class="text-center" width="127">{{ $topic->nb_views }}</td>
                        <td width="350">
                            @if($topic->lm_date)
                            <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@moveToLast', array($topic->slug, $topic->id), true) }}">
                                le {{ $topic->lm_date->format('d/m/Y à H:i:s') }}
                            </a><br />
                            <small>Par {{ $topic->lm_user_name }}</small>
                            @endif
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>



        <div class="legende">
            <strong>Légende :</strong>
            <p class="ico-read">
                <i class="icon-circle"></i> : Messages non lus<br>
                <i class="icon-circle-blank"></i> : Messages lus
            </p>
        </div>

        @else
            <h2>Aucun résultat pour la recherche</h2>
        @endif
    </div>
@endsection
