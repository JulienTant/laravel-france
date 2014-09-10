@extends('base.layout')

@section('title')
    Contact - Laravel France
@endsection

@section('content')
<div class="container">
    <h2>Contact</h2>

    <div class="alert alert-info">
        <i class="icon-info-sign"></i> Si vous cherchez de l'aide pour Laravel, nous vous invitons à consulter les forums. <strong>Aucune aide ne sera apportée par e-mail.</strong> <br>Merci de votre compréhension.
    </div>

    {{ Form::open(array('action' => 'Lvlfr\Website\Controller\ContactController@postIndex')) }}

        <div class="form-line">
            {{ Form::label('name', 'Nom* :')}}
            <div class="form-item">
                {{ Form::text('name', Input::old('name')) }}
                @if ($errors->has('name'))
                <span class="error">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>

        <div class="form-line">
            {{ Form::label('phone', 'Email* :')}}
            <div class="form-item">
                {{ Form::text('phone', Input::old('phone')) }}
                @if ($errors->has('phone'))
                <span class="error">{{ $errors->first('phone') }}</span>
                @endif
            </div>
        </div>

        <div class="form-line emailLine">
            {{ Form::label('email', 'Email* :')}}
            <div class="form-item">
                {{ Form::text('email', Input::old('email')) }}
                @if ($errors->has('email'))
                <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>

        <div class="form-line">
            {{ Form::label('subject', 'Sujet :')}}
            <div class="form-item">
                {{ Form::text('subject', Input::old('subject')) }}
                @if ($errors->has('subject'))
                <span class="error">{{ $errors->first('subject') }}</span>
                @endif
            </div>
        </div>

        <div class="form-line">
            {{ Form::label('mailContent', 'Message* :')}}
            <div class="form-item">
                {{ Form::textarea('mailContent', Input::old('mailContent')) }}
                @if ($errors->has('mailContent'))
                <span class="error">{{ $errors->first('mailContent') }}</span>
                @endif
            </div>
        </div>

        <div class="form-line">
            <div class="form-item">
                {{ Form::submit('Valider', array(
                    'class' => 'btn-orange'
                )) }}
            </div>
        </div>

    {{ Form::close() }}
</div>

@stop

@section('add_js')
<script>
$(document).ready(function() {
    $('.emailLine').hide();
});
</script>
@endsection
