@extends('layouts.forums_fullpage')

@section('top_forums')
    <div class="Forums_TopicHeader" style="background-color: {{ $chosenCategory->background_color }}; color: {{ $chosenCategory->font_color }};">
        <div class="Utility__Container">
            <a href="{{ route('forums.by-category', $chosenCategory->slug) }}">
                <h3 class="Forums__CategoryLabel">
                    {{ $chosenCategory->name }}
                </h3>
            </a>

            <h2 class="Forums__TopicHeader__Title {{ $topic->solved ? 'Forums__TopicHeader__Title--Solved' : '' }}">
                {{ $topic->title }}
            </h2>
        </div>
    </div>
@overwrite


@section('forums_content')

    <ul class="Forums__MessageList">
        @each('forums._message', $messages, 'message')
    </ul>

    @if($messages->hasPages())
        <div class="Forums__Paginator Forums__Paginator--Right">
            {!! $messages->render() !!}
        </div>
    @endif

    @can('forums.can_reply_to_topic', [$topic])
        <answer-topic topic="{{ $topic->id }}"></answer-topic>
    @else
        <p>Vous ne pouvez pas répondre à ce sujet.</p>
    @endcan

@endsection