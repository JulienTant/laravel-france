<?php
namespace Lvlfr\Website\Controller;

use \BaseController;
use \View;

class IrcController extends BaseController {

    public function getIndex()
    {
        return View::make('LvlfrWebsite::irc');
    }

}
