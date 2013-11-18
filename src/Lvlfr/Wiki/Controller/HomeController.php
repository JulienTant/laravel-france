<?php

namespace Lvlfr\Wiki\Controller;

use Diff;
use \Config;
use \View;
use Lvlfr\Wiki\Repositories\Page;

class HomeController extends \BaseController
{
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function index($slug = null)
    {
        $default = Config::get('LvlfrWiki::wiki.default_page');
        $slug = $slug or $default; 

        $page = $this->page->find($slug);

        if(is_null($page)) {
            return \Redirect::action('\Lvlfr\Wiki\Controller\HomeController@index', array('slug' => $default));
        }

        return View::make('LvlfrWiki::page', array("slug" => $slug, "content" => $page));
    }

    public function edit($slug)
    {
        $page = $this->page->find($slug);

        return View::make('LvlfrWiki::edit', array("slug" => $slug, "content" => $page));
    }

}
