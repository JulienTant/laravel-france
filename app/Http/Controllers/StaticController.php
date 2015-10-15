<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Http\Request;
use LaravelFrance\Http\Requests;
use LaravelFrance\Http\Controllers\Controller;

class StaticController extends Controller
{
    public function slack()
    {
        return view('slack.index');
    }
}
