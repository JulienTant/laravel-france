<?php

namespace Lvlfr\Login\Controller\Admin;

use \Lvlfr\Forums\Models\Category;
use \Input;
use \Str;
use \Redirect;
use \View;

class ForumsController extends \BaseController
{
    public function categories()
    {
        $categories = Category::orderBy('order', 'asc')->get();


        return View::make('LvlfrLogin::admin.forums.categories', array(
            'categories' => $categories,
        ));
    }
    
    public function categoriesPost()
    {
        $category = Category::find(Input::get('id'));
        if($category === null) {
            $category = new Category;
        }
        

        if (trim(Input::get('title')) != '') {
            $category->title = Input::get('title');
            $category->slug = Str::slug(Input::get('title'));
            $category->order = Input::get('order');
            $category->desc = Input::get('desc');
            $category->save();
        }

        return Redirect::action('Lvlfr\Login\Controller\Admin\ForumsController@categories');
    }
}
