@extends('base.layout')

@section('content')
<div class="container" id="forums">

    <ul class="breadcrumb">
        <li><a title="Retour à la page d'accueil" href="{{ route('home') }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
        <li><a title="Accueil des forums" href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}"> Forums</a> <span class="divider">/</span></li>
        <li><a title="{{ $category->title }}" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@index', array($category->slug, $category->id), true) }}"> {{ $category->title }}</a> <span class="divider">/</span></li>
        <li>@if($topic->sticky)<i class="icon-flag"></i> @endif {{ $topic->title }}</li>
    </ul>

    <div class="pagination">
        {{ $messages->links() }}
    </div>
    <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@newReply', array($topic->slug, $topic->id)) }}">Répondre</a>

    <ul id="forum-message-list">
        <?php $i = 0; ?>
        @foreach($messages as $message)
        <a name="message{{ $message->id }}" id="message{{ $message->id }}"></a>
        <li class="forum-message @if($i % 2) odd @else even @endif">
            <div class="user-infos">
                <img src="{{ $message->user->getAvatarUrl() }}" class="img-polaroid">
                <strong>{{ $message->user->username }}</strong><br />
                Inscrit le {{ $message->user->created_at->format('d/m/Y') }}<br />
                Messages : {{ $message->user->nb_messages }}
            </div>
            <div class="forum-text-zone">
                <small class="forum-message-date">
                    <a href="{{ URL::full() }}#message{{ $message->id }}">Posté le {{ $message->created_at->format('d/m/Y à H:i:s') }}
                    @if($message->created_at != $message->updated_at)
                        , mis à jour le {{ $message->updated_at->format('d/m/Y à H:i:s') }}
                    @endif</a>
                </small>
                <div class="forum-text">
                    {{ $message->html }}
                </div>
                <div class="forum-text-tools">
                        <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@newReply', array('slug' => $topic->slug, 'topicId' => $topic->id, 'quote' => $message->id)) }}">Citer</a>
                </div>
            </div>
        </li>
        <?php $i++; ?>
        @endforeach
    </ul>

    <div class="pagination">
        {{ $messages->links() }}
    </div>
    <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@newReply', array($topic->slug, $topic->id)) }}">Répondre</a>

</div>
@endsection
