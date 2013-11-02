@extends('base.layout')

@section('content')
<div class="container" id="forums">

    <ul class="breadcrumb">
        <li><a title="Retour à la page d'accueil" href="{{ route('home') }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
        <li><a title="Accueil des forums" href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}"> Forums</a> <span class="divider">/</span></li>
        <li><a title="{{ $category->title }}" href="{{ action('\Lvlfr\Forums\Controller\TopicsController@index', array($category->slug, $category->id), true) }}"> {{ $category->title }}</a> <span class="divider">/</span></li>
        <li>Nouveau sujet</li>
    </ul>


    <h2>Nouveau sujet</h2>

    <div id="new_topic_form_container">


        {{ Form::open(
            array(
                'url' => action('\Lvlfr\Forums\Controller\TopicsController@postNew', array('slug' => $category->slug, 'categoryId' => $category->id)),
                'id'=>'new_topic_form',
                'class'=>'form',
            )
        ) }}

        <div class="control-group @if($errors->has('topic_title'))error@endif">
            <div class="controls">
                {{ Form::text('topic_title', Input::old('topic_title', null), array('placeholder'=>'Veuillez insérer un titre', 'class'=>'span12', "autofocus"=>"autofocus")) }}
                {{ $errors->first('topic_title', '<span class="help-inline">Veuillez insérer un titre</span>') }}
            </div>
        </div>

        <div class="control-group @if($errors->has('topic_content'))error@endif" style="margin-top:20px">
            <div class="controls">
                {{ Form::textarea('topic_content', Input::old('topic_content', null), array('class'=>'span12')) }}
                {{ $errors->first('topic_content', '<span class="help-inline">Veuillez insérer un message</span>') }}
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