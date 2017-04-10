@extends('layouts.forums_sidebar')

@section('title', 'Recherche - Laravel France')

@section('forums_content')

    <ul class="Forums__TopicList">
        @forelse($topics as $topic)
            @include('forums._topic_in_list', ['topic' => $topic])
        @empty
            <li class="Forums__TopicList__Item">
                <h3>Aucun résultat trouvé {{ Request::get('c') ? 'dans cette catégorie': '' }}</h3>

                <p>
                    <a href="{{ route('forums.index') }}">Retour à l'index</a>
                    @if (Request::get('c'))
                        | <a href="{{ route('forums.search', ['q' => Request::get('q')]) }}">Essayer dans toutes les catégories</a>
                    @endif
                </p>
            </li>
        @endforelse
    </ul>

@endsection