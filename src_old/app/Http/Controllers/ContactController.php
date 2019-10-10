<?php

namespace LaravelFrance\Http\Controllers;

use LaravelFrance\Http\Requests\ContactRequest;
use LaravelFrance\Jobs\SendContactEmail;

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
