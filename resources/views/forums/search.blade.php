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
            <li class="Forums__TopicList__Item">
                <a href="{{ route('forums.show-topic', [$topic->forumsCategory->slug, $topic->slug]) }}" class="Forums__TopicList__Item__Link">
                    <div class="Forums__TopicList__Item__Avatar">
                        <img src="//www.gravatar.com/avatar/{{ md5($topic->user->email) }}?s=68" alt="Avatar de XXXX">
                    </div>

                    <div class="Forums__TopicList__Item__Content">
                        <h3 class="Forums__TopicList__Item__Subject">{{ $topic->title }}</h3>
                        <span class="Forums__CategoryLabel" style="background-color: {{ $topic->forumsCategory->background_color }}; color: {{ $topic->forumsCategory->font_color }}">{{ $topic->forumsCategory->name }}</span>
                        <span class="Forums__TopicList__Item__Metas__Authoring">
                            Dernier message : {{ $topic->lastMessage->user->username }}
                            <span class="momentify" data-date="{{ $topic->lastMessage->created_at->format('Y-m-d H:i:s') }}"></span>
                        </span>
                        <p class="Forums__TopicList__Item__Excerpt">
                            {{ str_limit('We track all of our issues on GitHub, so it\'d be really great if you could save us the trouble and create an issue there instead of starting a new discussion on this forum. save us the trouble and create an issue there instead of starting a new discussion on this forum', 200) }}
                        </p>
                    </div>

                    <div class="Forums__TopicList__Item__NbReplies">
                        <p class="Forums__TopicList__Item__NbReplies__Count">
                            {{ $topic->forumsMessages()->count() }}
                        </p>
                    </div>
                </a>
            </li>
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