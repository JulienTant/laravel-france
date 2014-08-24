@extends('base.layout')

@section('content')
<div class="container" id="error404">

    <h2>Woops.... :(</h2>

    <p>
        Pas de chance, vous êtes tombé sur un bug. L'info est transmise, soyez sûr que le problème sera corrigé au plus v!te !
    </p>

    <a href="{{ route('home') }}">Retour à l'accueil</a>

</div>
@endsection
