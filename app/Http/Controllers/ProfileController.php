<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Http\Request;

use LaravelFrance\Http\Requests;
use LaravelFrance\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function changeUsername()
    {
        return view('profile.change-username');
    }
}
