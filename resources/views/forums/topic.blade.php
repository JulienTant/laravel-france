@extends('layouts.forums')

@section('top_forums')
    <div class="Forums_TopicHeader" style="background-color: {{ $chosenCategory->background_color }}; color: {{ $chosenCategory->font_color }};">
        <div class="Utility__Container">
            <a href="{{ route('forums.by-category', $chosenCategory->slug) }}">
                <h3 class="Forums__CategoryLabel">
                    {{ $chosenCategory->name }}
                </h3>
            </a>

            <h2>
                {{ $topic->title }}
            </h2>
        </div>
    </div>
@overwrite


@section('forums_content')

<ul class="Forums__MessageList">
    @foreach($messages as $message)
        <li class="Forums__MessageList__Message">

            <div class="Forums__MessageList__Message__Avatar">
                <img src="//www.gravatar.com/avatar/{{ md5($message->user->email) }}?s=68" alt="Avatar de {{ $message->user->username }}">
            </div>

            <div class="Forums__MessageList__Message__Content">
                <span class="Forums__MessageList_Message__Content__Authoring">
                    <span class="Forums__MessageList_Message__Content__Authoring--Author">{{ $message->user->username }}</span>
                    <relative-date date="{{ $message->created_at->format('Y-m-d H:i:s') }}" />
                </span>
                <div class="Forums__MessageList__Message__Content__Html">
                    @markdown($message->markdown)
                </div>
            </div>
        </li>
    @endforeach
</ul>


<div class="Forums__Paginator">
    {!! $messages->render() !!}
    </div>

@endsection