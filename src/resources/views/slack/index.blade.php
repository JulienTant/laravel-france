@extends('layouts.general')

@section('title', 'Slack')

@section('main_content')

    <div class="container mt-5">
        <h2>Rejoignez nous !</h2>

        <small>
            <em>Vous avez déjà un compte Slack Laravel France ?</em>
            Vous pouvez nous rejoindre via le <a href="https://laravelfr.slack.com">chat en ligne</a></em>,
            ou en <a href="https://slack.com/downloads">téléchargeant le client Slack</a>.</small>

        <p>
            Slack fonctionne par invitation, pour recevoir votre invitation, veuillez remplir les champs ci-dessous.
            Aucune de ces informations ne sera sauvegardée sur les serveurs de Laravel France, elles seront utilisées
            uniquement pour l'inscription à Slack.
        </p>

        <form class="form" method="post">
            @csrf

            <div class="form-group">
                <label for="email">Email (obligatoire)</label>
                <input class="form-control" type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="first_name">Prénom</label>
                <input class="form-control" type="text" name="first_name" id="first_name">
            </div>
            <div class="form-group">
                <label for="last_name">Nom</label>
                <input class="form-control" type="text" name="last_name" id="last_name">
            </div>

            <button class="btn btn-primary" type="submit">Recevoir mon invitation</button>
        </form>
    </div>
@endsection
