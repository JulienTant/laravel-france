<?php
namespace Lvlfr\Website\Controller;

use \BaseController;
use \View;

class HomeController extends BaseController {

    public function getIndex()
    {
        $topics = \Lvlfr\Forums\Models\Topic::orderBy('updated_at', 'desc')->take(5)->get();

        return View::make(
            'LvlfrWebsite::index',
            array(
                'topics' => $topics
                )
            );
    }
}
