@extends('layouts.forums_sidebar')

@section('title', 'Forums - Sujets suivis - Laravel France')

@section('forums_content')

    <p style="text-align: right">
        @unless (Input::get('all'))
            <a href="?all=1"> Voir également les sujets sans nouveaux messages</a>
        @else
            <a href="{{ Request::url() }}"> Voir uniquement les sujets suivis non visités</a>
        @endunless
    </p>

    <ul class="Forums__TopicList">
        @each('my-forums._topic_in_list', $watchedTopics, 'watchedTopic')
        @unless($watchedTopics->count())
            <p><strong>
            @if(!Input::get('all') && $hasMore)
                Vous n'avez aucun sujet suivi non lu. <a href="?all=1">Voir tous les sujets suivis</a>
            @else
                Vous ne suivez aucun sujet.
            @endunless
            </strong></p>
        @endunless
    </ul>

@endsection