@extends('layouts.profile')


@section('title', 'Préférences des forums')


@section('content')
    <h2>Préférences des forums</h2>

    <form class="form" method="post">
        @csrf


        <fieldset>
            <legend>Affichage des sujets</legend>

                <p>
                    <strong>Lors de la navigation vers un sujet du forum, je souhaite que s'affiche :</strong>
                </p>

                @php
                   $veryFirst = !isset($preferences['see_last_message']) || $preferences['see_last_message'] == 0;
                @endphp

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="preference[see_last_message]" id="p1_0" value="0" @if($veryFirst) checked @endif>
                    <label class="form-check-label" for="p1_0">
                        Le tout premier message du sujet
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="preference[see_last_message]" id="p1_1" value="1" @unless($veryFirst) checked @endunless>
                    <label class="form-check-label" for="p1_1">
                        Le message posté le plus récemment
                    </label>
                </div>

        </fieldset>

        <fieldset>
            <legend>Alertes</legend>

            <p>
                <strong>Rappel : </strong>Votre adresse email est : {{ Auth::user()->email }}. <a href="{{ route('user.change-email') }}">Changer</a>
            </p>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="pa_1" name="preference[watch_created_topic]" @if(isset($preferences['watch_created_topic']) && $preferences['watch_created_topic']) checked @endif>
                <label class="form-check-label" for="pa_1">
                    Surveiller automatiquement les sujets que je crée.
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="pa_2" name="preference[watch_reply_topic]" @if(isset($preferences['watch_reply_topic']) && $preferences['watch_reply_topic']) checked @endif>
                <label class="form-check-label" for="pa_2">
                    Surveiller automatiquement les sujets auxquels je réponds.
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="pa_3" name="preference[watch_new_reply_send_email]" @if(isset($preferences['watch_new_reply_send_email']) && $preferences['watch_new_reply_send_email']) checked @endif>
                <label class="form-check-label" for="pa_3">
                    M'envoyer un email lorsqu'un nouveau message est posté sur un sujet que je surveille.
                </label>
            </div>
        </fieldset>

        <button class="btn btn-primary" type="submit">Enregistrer</button>
    </form>
@endsection
