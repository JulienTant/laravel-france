<?php

namespace Lvlfr\Forums\Controller;

use \Lvlfr\Forums\Models\Category;
use Lvlfr\Forums\Services\MarkAllAsRead;
use \View;

class HomeController extends \BaseController
{
    public function index()
    {
        $categories = Category::orderBy('order', 'asc')->get();


        return View::make('LvlfrForums::home', [
            'categories' => $categories,
        ]);
    }

    public function markAllAsRead()
    {
        \App::make(MarkAllAsRead::class)->forUser(\Auth::user());

        return \Redirect::action('\\'.self::class . '@index');
    }
}
