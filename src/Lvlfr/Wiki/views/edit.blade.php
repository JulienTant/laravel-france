@extends('base.layout')

@section('content')
<div class="container" id="wiki">
    
    @foreach($errors->all("<li>:message</li>") as $error)
        {{ $error }}
    @endforeach


    {{ Form::open() }}
        <div class="form-line">
            {{ Form::label('title', 'Title') }}
            <div class="form-item">
                {{ Form::text('title', Input::old('title') ?: $content->title) }}
            </div>
        </div>
        
        <div class="form-line">
            {{ Form::label('content', 'Contenu') }}
            <div class="form-item">
                {{ Form::textarea('content', Input::old('content') ?: $content) }}
            </div>
        </div>

        {{ Form::submit('Modifier')}}

    {{ Form::close()}}
</div>
@endsection
