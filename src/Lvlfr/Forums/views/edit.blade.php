@extends('base.layout')

@section('content')
<div class="container" id="forums">

    <ul class="breadcrumb">
        <li><a title="Retour à la page d'accueil" href="{{ route('home') }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
        <li><a title="Accueil des forums" href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}"> Forums</a> <span class="divider">/</span></li>
        <li><a title="{{ $topic->category->title }}" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@index', array($topic->category->slug, $topic->category->id), true) }}"> {{ $topic->category->title }}</a> <span class="divider">/</span></li>
        <li><a title="{{ $topic->title }}" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@show', array($topic->slug, $topic->id), true) }}"> {{ $topic->title }}</a> <span class="divider">/</span></li>
        <li>Editer un message</li>
    </ul>


    <h2>Editer un message</h2>

    <div id="edit_message_form_container">


        {{ Form::open(
            array(
                'url' => action('\Lvlfr\Forums\Controller\TopicsController@postEditMessage', array('slug' => $topic->slug, 'topicId' => $topic->id, 'messageId' => $message->id)),
                'id'=>'edit_msg_form',
                'class'=>'form',
            )
        ) }}

            @if($message->firstOfTopic())
                <div class="control-group @if($errors->has('title'))error@endif">
                    <div class="controls">
                    {{ Form::text('title', Input::old('title', $topic->title), array('class'=>'span12')) }}
                    {{ $errors->first('title', '<span class="help-inline">Veuillez insérer un titre</span>') }}
                    </div>
                </div>
            @endif

            <div class="control-group @if($errors->has('message_content'))error@endif" style="margin-top:20px">
                <div class="controls">
                {{ Form::textarea('message_content', Input::old('message_content', $message->bbcode), array('class'=>'span12')) }}
                {{ $errors->first('message_content', '<span class="help-inline">Veuillez insérer un message</span>') }}
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                {{ Form::submit('Envoyer',array('class'=>'btn btn-valider')) }}
                </div>
            </div>

        {{ Form::close() }}
    </div>
</div>
@endsection
