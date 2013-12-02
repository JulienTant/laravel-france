@extends('LvlfrLogin::profile.layout')

@section('title')
    Applications - Laravel France
@endsection

@section('profile_content')
<h1>Applications</h1>

    @if(!$onGoogle || !$onTwitter || !$onGitHub)
        <h2>Vous pouvez lier votre compte avec :</h2>
        <ul class="login-list">
            @if(!$onGoogle)
            <li>
                <a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('Google'), true) }}"><i class="icon-google-plus"></i> Google</a>
            </li>
            @endif
            @if(!$onTwitter)
            <li>
                <a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('Twitter'), true) }}"><i class="icon-twitter"></i> Twitter</a>
            </li>
            @endif
            @if(!$onGitHub)
            <li>
                <a href="{{ action('Lvlfr\Login\Controller\LoginController@login', array('GitHub'), true) }}"><i class="icon-github"></i> GitHub</a>
            </li>
            @endif
        </ul>
    @endif

    <h2 style="clear:both">Vous avez déjà lié votre compte avec :</h2>
    <ul class="login-list">
        @if($onGoogle)
        <li>
            <i class="icon-google-plus"></i> Google <i class="icon-ok-sign" style="color: green;"></i>
        </li>
        @endif
        @if($onTwitter)
        <li>
            <i class="icon-twitter"></i> Twitter <i class="icon-ok-sign" style="color: green;"></i>
        </li>
        @endif
        @if($onGitHub)
        <li>
            <i class="icon-github"></i> GitHub <i class="icon-ok-sign" style="color: green;"></i>
        @endif
    </li>
    </ul>

@endsection

