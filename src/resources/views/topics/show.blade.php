@extends('layouts.general')

@section('title', $topic->title)


@section('main_content')
    <div class="category-banner" style="background-color: {{ $chosenCategory->background_color }}; color: {{ $chosenCategory->font_color }}">
        <div class="container">
            <a href="{{ route('topics.by-category', $chosenCategory->slug) }}">
                @include('topics._badge', ['category' => $chosenCategory, 'reverse' => true])
            </a>

            <h2 class="topic-title {{ $topic->solved ? 'topic-title-solved' : '' }}">
                {{ $topic->title }}
            </h2>

            @if(Auth::check())
                <toggle-watch-topic topic-id="{{ (int)$topic->id }}" />
            @endif
        </div>
    </div>


    <div class="container">
        <div class="message-list mt-5">
            @foreach($messages as $message)
                @include('topics._message', ['topic' => $topic, 'category' => $chosenCategory, 'message' => $message])
            @endforeach
        </div>

        @if($messages->hasPages())
            <div >
                {!! $messages->render() !!}
            </div>
        @endif

        @can('forums.can_reply_to_topic', [$topic])
            @include('topics._answer', ['topic' => $topic, 'category' => $chosenCategory])
        @else
            <p>Vous ne pouvez pas répondre à ce sujet.</p>
        @endcan
    </div>
@endsection
