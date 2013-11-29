@extends('base.layout')

@section('title')
    Connexion - Laravel France
@endsection

@section('content')
<div class="container" id="login">
    <h2>Connexion</h2>

    <ul class="login-list">
        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('Google'), true) }}"><i class="icon-google-plus"></i> Google</a></li>
        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('twitter'), true) }}"><i class="icon-twitter"></i> Twitter</a></li>
        <li><a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('GitHub'), true) }}"><i class="icon-github-alt"></i> Github</a></li>
    </ul>
</div>
@endsection