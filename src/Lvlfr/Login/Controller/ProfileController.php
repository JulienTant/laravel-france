<?php
namespace Lvlfr\Login\Controller;

use \Auth;
use \BaseController;
use \Input;
use \OAuth;
use \Session;
use \Redirect;
use \Response;
use \View;


class ProfileController extends BaseController
{
    public function index()
    {
        return 'ok';
    }
}
