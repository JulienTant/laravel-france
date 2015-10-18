@extends('layouts.forums_fullpage')

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

                    <div class="Forums__MessageList__Message__Side">
                        <div class="Forums__MessageList__Message__Side__Avatar">
                            <img src="//www.gravatar.com/avatar/{{ md5($message->user->email) }}?s=75" alt="Avatar de {{ $message->user->username }}">
                        </div>

                        <div class="Forums__MessageList__Message__Side__UserInfos">
                            <dl>
                                <dt class="Forums__MessageList__Message__Side__UserInfos__Label">Membre depuis :</dt>
                                <dd class="Forums__MessageList__Message__Side__UserInfos__Info">{{ $message->user->created_at->format('d/m/Y') }}</dd>
                                <dt class="Forums__MessageList__Message__Side__UserInfos__Label">Messages :</dt>
                                <dd class="Forums__MessageList__Message__Side__UserInfos__Info">{{ $message->user->nb_messages }}</dd>
                            </dl>
                        </div>

                    </div>

                    <div class="Forums__MessageList__Message__Content">
                        <span class="Forums__MessageList_Message__Content__Authoring">

                            <span class="Forums__MessageList_Message__Content__Authoring--Author">{{ $message->user->username }}</span>
                            <a href="#message-{{$message->id}}" name="message-{{$message->id}}" id="message-{{$message->id}}"><relative-date date="{{ $message->created_at->format('Y-m-d H:i:s') }}" /></a>
                        </span>
                        <div class="Forums__MessageList__Message__Content__Html">
                            @markdown($message->markdown)
                        </div>
                    </div>
                </li>
        @endforeach
    </ul>

    @if($messages->hasPages())
        <div class="Forums__Paginator">
            {!! $messages->render() !!}
        </div>
    @endif

    @can('forums.can_reply_to_topic', [$topic])
        <answer-topic topic="{{ $topic->id }}"></answer-topic>
    @else
        <p>Vous ne pouvez pas répondre à ce sujet.</p>
    @endcan

@endsection