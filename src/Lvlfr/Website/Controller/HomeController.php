<?php
namespace Lvlfr\Website\Controller;

use \BaseController;
use \View;

class HomeController extends BaseController {

    public function getIndex()
    {
        return View::make('LvlfrWebsite::index');
    }

}
