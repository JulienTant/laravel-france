<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Http\Request;
use LaravelFrance\Http\Requests\InviteSlackRequest;
use LaravelFrance\Jobs\Slack\SendInvitation;

class SlackController extends Controller
{
    public function index()
    {
        return view('slack.index');
    }

    public function invite(InviteSlackRequest $request)
    {
      $this->dispatch(
            new SendInvitation(
                $request->email,
                $request->only(['first_name', 'last_name'])
            )
        );

        alert('Vous allez recevoir votre invitation par email dans quelques instants. A bientôt sur Slack !', 'Invitation envoyée !')->persistent('Fermer');

        return \Redirect::to('/');
    }
}
