@extends('base.layout')

@section('content')
<div class="container" id="forums">

    <ul class="breadcrumb">
        <li><a title="Retour à la page d'accueil" href="{{ route('home') }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
        <li>Forums - Accueil</li>
    </ul>

    <div class="row">
        <div class="span12">
            @if(count($categories))
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="3"><strong>Forums</strong></th>
                        <th class="text-center">Sujets</th>
                        <th class="text-center">Messages</th>
                        <th>Dernier message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td style="padding:0" width="1"><div style="min-height:78px"></div></td>
                        <td class="ico-read" width="37"><i class="icon-circle-blank"></i></td>
                        <td>
                            <strong>
                                <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@index', array($category->slug, $category->id), true) }}">{{ $category->title }}</a>
                            </strong><br/>
                            {{ $category->desc }}
                        </td>
                        <td class="text-center" width="127">{{ $category->nb_topics }}</td>
                        <td class="text-center" width="127">{{ $category->nb_posts }}</td>
                        <td width="350">
                            @if($category->lm_topic_name)
                            <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@moveToLast', array($category->lm_topic_slug, $category->lm_topic_id), true) }}">
                                    {{ $category->lm_topic_name }}<br>
                                    {{ $category->lm_date }}
                            </a><br/>
                            <small>Par {{ $category->lm_user_name }}</small>
                            @else
                                Aucun sujet pour le moment
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                <strong>Légende :</strong>
                <p class="ico-read">
                    <i class="icon-circle"></i> : Messages non lus<br>
                    <i class="icon-circle-blank"></i> : Messages lus
                </p>
            </div>
            @else
                <h2>Aucune catégorie à afficher</h2>
            @endif
        </div>
    </div>
</div>
@endsection
