@extends('layouts.email')

@section('content')
    <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
        <br>

        <div class="title" style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#374550">
            Nouvelle réponse
        </div>
        <br>

        <div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
            Un nouveau message a été publié sur le sujet <strong>{{ $topic_subject }}</strong> par <em>{{ $author }}</em>.
            <br />
            <br />
            <a href="{{ route('messages.show', [$message_id]) }}">Voir le sujet</a>
            <br><br>
            <small>Vous recevez cet email car vous êtes abonné à un sujet et que vous avez activé la notification par email dans vos préférences.</small>
            <br />
            <br />
        </div>

    </td>
@endsection
