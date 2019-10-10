@extends('layouts.profile')


@section('profile_content')

    <h2>Gestion des groupes de <em>{{ $user->username }}</em></h2>


    <p>
        Groupes : {{ implode(', ', $user->groups) ?: '-' }}
    </p>


    {!! Form::open(['class' => 'Form']) !!}
        <div class="Form__Row">
            {!! Form::label('groups[]', 'Nouveaux groupes', ['class' => 'Form__Row__Label']) !!}
            {!! Form::select('groups[]', \LaravelFrance\Group::all(), $user->groups, ['multiple', 'class' => 'Form__Row__Control']) !!}
        </div>

        <div class="Form__Row Form__Row--Buttons">
            <button type="submit" class="Button--Submit">Enregistrer</button>
        </div>
    {!! Form::close() !!}

@endsection