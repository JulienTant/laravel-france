@extends('layouts.forums')

@section('forums_content')

    <div class="Forums__Searchbar">
        <form action="{{ route('forums.search') }}">
            <input type="hidden" name="c" value="{{ Request::get('c') }}" />
            <input type="text" class="Forums__Searchbar__Field" name="q" value="{{ Request::get('q') }}" placeholder="Rechercher" />
        </form>
    </div>

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