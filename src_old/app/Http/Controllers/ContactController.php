<?php

namespace LaravelFranceOld\Http\Controllers;

use LaravelFranceOld\Http\Requests\ContactRequest;
use LaravelFranceOld\Jobs\SendContactEmail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(ContactRequest $request)
    {
        $this->dispatch(new SendContactEmail($request->all()));

        return redirect()->route('contact.sent');
    }

    public function sent()
    {
        return view('contact.sent');
    }
}
