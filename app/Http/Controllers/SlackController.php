<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Http\Request;
use LaravelFrance\Http\Requests;
use LaravelFrance\Http\Controllers\Controller;
use LaravelFrance\Jobs\SendSlackInvitation;

class SlackController extends Controller
{
    public function index()
    {


        return view('slack.index');
    }

    public function invite(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $this->dispatch(
            new SendSlackInvitation(
                $request->email,
                $request->only(['first_name', 'last_name'])
            )
        );

        return view('slack.index');
    }
}
