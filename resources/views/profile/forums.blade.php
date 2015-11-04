@extends('layouts.profile')


@section('profile_content')
    <h2>Préférences des forums</h2>

    <p>Vous trouverez ici une série de préférences liées aux forumf :</p>

    {!! Form::model(Auth::user(), ['class' => 'Form']) !!}

    @if($errors->has())
        <ul class="Form__ErrorList">
            @foreach($errors->all() as $error)
                <li class="Form__ErrorList__Item">{{ $error }}</li>
            @endforeach
        </ul>
    @endif


    <div class="Form__Row">
        <label class="Form__Row__Label">
            {!! Form::checkbox('preference[see_last_message]', 1, isset($preferences['see_last_message']) && $preferences['see_last_message'], ['class' => 'Form__Row__Control']) !!}
            Voir le dernier message lors du clic sur un topic depuis la liste des sujets
        </label>
    </div>

    <div class="Form__Row Form__Row--Buttons">
        <button type="submit" class="Button--Submit">Enregistrer</button>
    </div>

    {!! Form::close() !!}
@endsection