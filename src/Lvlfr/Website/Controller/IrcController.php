<?php
namespace Lvlfr\Website\Controller;

use \Auth;
use \BaseController;
use \View;

class IrcController extends BaseController
{
    public function getIndex()
    {
        return View::make(
            'LvlfrWebsite::irc',
            array(
                'username' => (Auth::guest() ? 'laraveler_fr' . rand(100, 999) : Auth::user()->username)
            )
        );
    }

}
