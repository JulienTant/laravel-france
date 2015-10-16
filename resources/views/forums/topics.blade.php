@extends('layouts.forums')

@section('forums_content')

    <div class="Forums__Searchbar">
        <form action="{{ route('forums.search') }}">
            @if($chosenCategory)
                <input type="hidden" name="c" value="{{ $chosenCategory ? $chosenCategory->slug : '' }}" />
            @endif
            <input type="text" class="Forums__Searchbar__Field" name="q" value="{{ Request::get('q') }}" placeholder="Rechercher{{ $chosenCategory ? ' dans ' . $chosenCategory->name : '' }}" />
        </form>
    </div>

    <ul class="Forums__TopicList">
        @foreach($topics as $topic)
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
                            <relative-date date="{{ $topic->lastMessage->created_at->format('Y-m-d H:i:s') }}"></relative-date>
                        </span>
                        <p class="Forums__TopicList__Item__Excerpt">
                            {{ str_limit($topic->firstMessage->markdown, 200) }}
                        </p>
                    </div>

                    <div class="Forums__TopicList__Item__NbReplies">
                        <p class="Forums__TopicList__Item__NbReplies__Count">
                            {{ $topic->nb_messages }}
                        </p>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>


    <div class="Forums__Paginator">
        {!! $topics->render() !!}
    </div>

@endsection