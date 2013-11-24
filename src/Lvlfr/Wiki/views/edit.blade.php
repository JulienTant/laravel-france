@extends('base.layout')

@section('title')
    @if(!$content->id || Auth::user()->hasRole('Wiki'))
        Création d'un article - Wiki Laravel France
    @else
        Edition d'un article - Wiki Laravel France
    @endif
@endsection

@section('content')
<div class="container" id="wiki">
    
    @if(count($errors))
        <ul class="errors">
        @foreach($errors->all("<li class='error'>:message</li>") as $error)
            {{ $error }}
        @endforeach
        </ul>
    @endif


    {{ Form::open() }}
        <div class="form-line">
            {{ Form::label('title', 'Title') }}
            <div class="form-item">
                {{ Form::text('title', Input::old('title') ?: $content->title) }}
            </div>
        </div>

        @if(!$content->id || Auth::user()->hasRole('Wiki'))
        <div class="form-line">
            {{ Form::label('slug', 'Slug') }}
            <div class="form-item">
                {{ Form::text('slug', Input::old('slug', Input::get('slug')) ?: $content->slug) }}
            </div>
        </div>
        @endif
        <div class="form-line">
            {{ Form::label('content', 'Contenu') }}
            <div class="form-item">
                {{ Form::textarea('content', Input::old('content') ?: $content) }}
            </div>
        </div>

        {{ Form::submit('Valider')}}

    {{ Form::close()}}
</div>
@endsection
