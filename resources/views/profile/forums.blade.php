@extends('layouts.profile')


@section('profile_content')
    <h2>Préférences des forums</h2>

    {!! Form::model(Auth::user(), ['class' => 'Form']) !!}

    @if($errors->has())
        <ul class="Form__ErrorList">
            @foreach($errors->all() as $error)
                <li class="Form__ErrorList__Item">{{ $error }}</li>
            @endforeach
        </ul>
    @endif


    <fieldset class="Form__Fieldset">
        <legend class="Form__Fieldset__Legend">Affichage des sujets</legend>

        <div class="Form__Row">

            <p>
                <strong>Lors de la navigation vers un sujet du forum, je souhaite que s'affiche :</strong>
            </p>

            <label class="Form__Row__Label Form__Row__Label--Radio">
                {!! Form::radio('preference[see_last_message]', 0, !isset($preferences['see_last_message']) || $preferences['see_last_message'] == 0, ['class' => 'Form__Row__Control']) !!}
                Le tout premier message du sujet
            </label>

            <label class="Form__Row__Label Form__Row__Label--Radio">
                {!! Form::radio('preference[see_last_message]', 1, isset($preferences['see_last_message']) && $preferences['see_last_message'], ['class' => 'Form__Row__Control']) !!}
                Le message posté le plus récemment
            </label>
        </div>
    </fieldset>

    <fieldset class="Form__Fieldset">
        <legend class="Form__Fieldset__Legend">Alertes</legend>

        <p>
            <strong>Rappel : </strong>Votre adresse email est : {{ Auth::user()->email }}. <a href="{{ route('profile.change-avatar') }}">Changer</a>
        </p>

        <div class="Form__Row">
            <label class="Form__Row__Label">
                {!! Form::checkbox('preference[watch_created_topic]', 1, isset($preferences['watch_created_topic']) && $preferences['watch_created_topic'], ['class' => 'Form__Row__Control']) !!}
                Surveiller automatiquement les sujets que je crée.
            </label>
        </div>

        <div class="Form__Row">
            <label class="Form__Row__Label">
                {!! Form::checkbox('preference[watch_reply_topic]', 1, isset($preferences['watch_reply_topic']) && $preferences['watch_reply_topic'], ['class' => 'Form__Row__Control']) !!}
                Surveiller automatiquement les sujets auxquels je réponds.
            </label>
        </div>

        <div class="Form__Row">
            <label class="Form__Row__Label">
                {!! Form::checkbox('preference[watch_new_reply_send_email]', 1, isset($preferences['watch_new_reply_send_email']) && $preferences['watch_new_reply_send_email'], ['class' => 'Form__Row__Control']) !!}
                M'envoyer un email lorsqu'un nouveau message est posté sur un sujet que je surveille
            </label>
        </div>
    </fieldset>

    <div class="Form__Row Form__Row--Buttons">
        <button type="submit" class="Button--Submit">Enregistrer</button>
    </div>

    {!! Form::close() !!}
@endsection