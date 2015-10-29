@extends('layouts.profile')


@section('profile_content')

    <h2>Modifier mon avatar</h2>

    <p>
        <a href="http://laravel.fr">Laravel.fr</a> utilise le service <a target="_blank" href="http://fr.gravatar.com/">Gravatar</a> pour charger les avatars sur le forum.
    </p>

    <p>
        Pour obtenir l'avatar de votre choix, vous devez remplir une adresse email valide enregistrée sur le site de <a target="_blank" href="http://fr.gravatar.com/">Gravatar</a>,
        et ensuite renseignez ci dessous votre adresse email :
    </p>


    @if($errors->has())
        <ul class="Form__ErrorList">
            @foreach($errors->all() as $error)
                <li class="Form__ErrorList__Item">{{ $error }}</li>
            @endforeach
        </ul>
    @endif



    <div style="display: flex">
        <figure>
            <img src="http://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" />
            <figcaption>Avatar actuel</figcaption>
        </figure>

        {!! Form::model(Auth::user(), ['class' => 'Form', 'style' => 'flex: 1']) !!}
            <div class="Form__Row">
                {!! Form::label('email', 'Email', ['class' => 'Form__Row__Label']) !!}
                {!! Form::email('email', null, ['class' => 'Form__Row__Control']) !!}
            </div>

            <div class="Form__Row Form__Row--Buttons">
                <button type="submit" class="Button--Submit">Enregistrer</button>
            </div>
        {!! Form::close() !!}

    </div>

@endsection