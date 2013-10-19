@extends('base.layout')

@section('content')
<div class="container" id="login">
    <h2>Connexion</h2>

    <ul>
        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('Google'), true) }}">Google</a></li>
        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('twitter'), true) }}">Twitter</a></li>
        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('GitHub'), true) }}">Github</a></li>
    </ul>
</div>
@endsection