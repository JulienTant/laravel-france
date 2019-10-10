@extends('layouts.profile')


@section('profile_content')
    <h2>Modifier mon pseudo</h2>

    <p>Vous pouvez choisir un nouveau pseudo si vous le souhaitez :</p>

    {!! Form::model(Auth::user(), ['class' => 'Form']) !!}

    @if($errors->has())
        <ul class="Form__ErrorList">
            @foreach($errors->all() as $error)
                <li class="Form__ErrorList__Item">{{ $error }}</li>
            @endforeach
        </ul>
    @endif


    <div class="Form__Row">
        {!! Form::label('username', 'Pseudo', ['class' => 'Form__Row__Label']) !!}
        {!! Form::text('username', null, ['class' => 'Form__Row__Control']) !!}
    </div>

    <div class="Form__Row Form__Row--Buttons">
        <button type="submit" class="Button--Submit">Enregistrer</button>
    </div>

    {!! Form::close() !!}
@endsection