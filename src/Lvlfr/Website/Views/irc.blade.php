@extends('base.layout')

@section('content')
<div class="container" id="ircPage">

    <h2>Discuter sur le channel IRC #laravel.fr@feenode</h2>

    <p>
        Vous pouvez nous rejoindre sur le channel IRC #laravel.fr du serveur irc.freenode.net. Si vous n'avez pas de client IRC, vous pouvez chatter avec nous directement depuis votre navigateur :
    </p>

    <iframe src="https://kiwiirc.com/client/irc.freenode.net/?nick=laraver{{ rand(100, 999)}}&theme=basic#laravel.fr" style="border:0; width:100%; height:450px;"></iframe>
</div>
@stop
