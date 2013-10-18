<?php

namespace Lvlfr\Forums\Controller;

use \Lvlfr\Forums\Models\Category;
use \View;

class HomeController extends \BaseController
{
    public function index()
    {
        $categories = Category::orderBy('order', 'asc')->get();


        return View::make('LvlfrForums::home', array(
            'categories' => $categories,
        ));
    }
}
