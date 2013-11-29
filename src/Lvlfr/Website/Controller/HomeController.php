<?php
namespace Lvlfr\Website\Controller;

use \BaseController;
use \View;

class HomeController extends BaseController {

    public function getIndex()
    {
        $topics = \Lvlfr\Forums\Models\Topic::orderBy('lm_date', 'desc')->take(3)->get();

        return View::make(
            'LvlfrWebsite::index',
            array(
                'topics' => $topics
                )
            );
    }
}
