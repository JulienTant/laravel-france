@extends('base.layout')

@section('content')
<div class="container" id="forums">

    <ul class="breadcrumb">
        <li><a title="Retour à la page d'accueil" href="{{ route('home') }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
        <li><a title="Accueil des forums" href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}"> Forums</a> <span class="divider">/</span></li>
        <li><a title="{{ $topic->category->title }}" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@index', array($topic->category->slug, $topic->category->id), true) }}"> {{ $topic->category->title }}</a> <span class="divider">/</span></li>
        <li><a title="{{ $topic->title }}" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@show', array($topic->slug, $topic->id), true) }}"> {{ $topic->title }}</a> <span class="divider">/</span></li>
        <li>Répondre au sujet</li>
    </ul>


    <div id="new_topic_form_container">


        {{ Form::open(
            array(
                'url' => action('\Lvlfr\Forums\Controller\TopicsController@postReply', array('slug' => $topic->slug, 'topicId' => $topic->id)),
                'id'=>'new_reply_form',
                'class'=>'form',
            )
        ) }}

            <div class="control-group @if($errors->has('message_content'))error@endif">
                <div class="controls">
                {{ Form::textarea('message_content', Input::old('message_content', $cite), array('class'=>'span12')) }}
                {{ $errors->first('message_content', '<span class="help-inline">Veuillez insérer un message</span>') }}
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                {{ Form::submit('Envoyer',array('class'=>'btn btn-primary')) }}
                </div>
            </div>

        {{ Form::close() }}
    </div>
</div>
@endsection