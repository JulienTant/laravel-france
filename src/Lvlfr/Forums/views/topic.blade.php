@extends('base.layout')

@section('title')
    {{ $topic->title }} - Forums Laravel France
@endsection



@section('content')
<div class="container" id="forums">

    <ul class="breadcrumb">
        <li><a title="Retour à la page d'accueil" href="{{ route('home') }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
        <li><a title="Accueil des forums" href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}"> Forums</a> <span class="divider">/</span></li>
        <li><a title="{{ $category->title }}" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@index', array($category->slug, $category->id), true) }}"> {{ $category->title }}</a> <span class="divider">/</span></li>
        <li>@if($topic->sticky)<i class="icon-flag"></i> @endif {{ $topic->title }}</li>
    </ul>


    <div class="right-btn-group">
        <a class="btn-reply" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@newReply', array($topic->slug, $topic->id)) }}"><i class="icon-reply"></i> Répondre</a>
    </div>
    <div class="pagination">
        {{ $messages->links() }}
    </div>

    <div class="clear-sep"></div>

    <ul id="forum-message-list">
        <?php $i = 0; ?>
        @foreach($messages as $message)
        <a name="message{{ $message->id }}" id="message{{ $message->id }}"></a>
        <li class="forum-message @if($i % 2) odd @else even @endif @if($message->solveTopic) solve @endif">
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
                        (màj le {{ $message->updated_at->format('d/m/Y à H:i') }})
                    @endif</a>
                    @if($message->editable())
                    - <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@editMessage', array($topic->slug, $topic->id, $message->id)) }}">Editer</a>
                    @endif
                    @if($message->solveTopic)
                     - <i class="icon-ok"></i> Ce message répond à la question de l'auteur
                    @endif
                </small>
                <div class="forum-text " data-post-id="{{$message->id}}">
                    {{ $message->html }}
                </div>
                <ul class="forum-text-tools">
                    @if($i > 0 && !$topic->solved && $topic->user_id === \Auth::user()->id)
                        <li>{{ Form::open(['action' => '\Lvlfr\Forums\Controller\TopicsController@solve']) }}
                            {{ Form::hidden('topic', $topic->id) }}
                            {{ Form::hidden('message', $message->id) }}
                            <button><i class="icon-ok"></i> Ce message répond à ma question</button>
                        {{ Form::close() }}</li>
                    @endif
                    <li><a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@newReply', array('slug' => $topic->slug, 'topicId' => $topic->id, 'quote' => $message->id)) }}">Citer</a></li>
                </ul>
            </div>
        </li>
        <?php $i++; ?>
        @endforeach
    </ul>

    <div class="clear-sep"></div>

    <div class="right-btn-group">
        <a class="btn-reply" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@newReply', array($topic->slug, $topic->id)) }}"><i class="icon-reply"></i> Répondre</a>
    </div>
    <div class="pagination">
        {{ $messages->links() }}
    </div>

</div>
@endsection