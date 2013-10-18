@extends('base.layout')

@section('content')
<div class="container" id="error404">

    <h2>Vous avez l'air perdu ?</h2>

    <p>
        {{ $message }}
    </p>

    <a href="{{ route('home') }}">Retour à l'accueil</a>

</div>
@endsection
