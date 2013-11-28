@extends('LvlfrLogin::profile.layout')

@section('title')
    Mettre à jour la doc - Laravel France
@endsection

@section('profile_content')
    <h1>Mettre à jour la doc</h1>

    {{ Form::open() }}

    <p>
        Pour forcer la mise à jour de la documentation, veuillez cliquer sur le bouton suivant :
    </p>
    {{ Form::submit('Forcer') }}

    {{ Form::close() }}    
@endsection

