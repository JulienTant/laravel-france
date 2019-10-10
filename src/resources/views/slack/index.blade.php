@extends('layouts.master')

@section('title', 'Slack - Laravel France')

@section('content')

    <div class="Utility__Container">

    <h2>Qu'est ce que Slack ?</h2>

    <p>
        Slack est un service de messagerie instantanée, qui s’articule autour de messages texte, mais aussi d’images, de vidéos et de sons, de code snippets...<br />
        Nous avons créé un Slack pour Laravel France, et nous souhaitons en faire une place d'échange et de convivialité pour tous les membres de la communauté Francophone qui souhaitent nous y rejoindre.
    </p>
    
    <h2>Rejoignez nous !</h2>
    
    <small>
        <em>Vous avez déjà un compte Slack Laravel France ?</em>
        Vous pouvez nous rejoindre via le <a href="https://laravelfr.slack.com">chat en ligne</a></em>,
        ou en <a href="https://slack.com/downloads">téléchargeant le client Slack</a>.</small>
    
    <p>
        Slack fonctionne par invitation, pour recevoir votre invitation, veuillez remplir les champs ci-dessous.
        Aucune de ces informations ne sera sauvegardée sur les serveurs de Laravel France, elles seront utilisées uniquement pour l'inscription à Slack.
    </p>

    {!! Form::open(['class' => 'Form'])  !!}

    <div class="Form__Row">
        <label class="Form__Row__Label" for="email">Email (obligatoire)</label>
        <input class="Form__Row__Control" type="email" name="email" id="email" />
    </div>

    <div class="Form__Row">
        <label class="Form__Row__Label" for="first_name">Prénom  (optionnel)</label>
        <input class="Form__Row__Control" type="first_name" name="first_name" id="first_name" />
    </div>

    <div class="Form__Row">
        <label class="Form__Row__Label" for="last_name">Nom  (optionnel)</label>
        <input class="Form__Row__Control" type="last_name" name="last_name" id="last_name" />
    </div>

        <div class="Form__Row Form__Row--Buttons">
            <button class="Button Button--Submit">Recevoir mon invitation</button>
        </div>



        {!! Form::close()  !!}


    </div>
@endsection