<?php
namespace Lvlfr\Website\Controller;

use \BaseController;
use \View;
use \Input;
use \Mail;
use \Redirect;

class ContactController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function getIndex()
    {
        return View::make('LvlfrWebsite::contact.index');
    }

    public function postIndex()
    {
        $validator = new \Lvlfr\Website\Validation\ContactValidator(Input::all());

        if ($validator->passes()) {
            Mail::queue('LvlfrWebsite::contact.email_content', Input::all(), function($m) {
                $m->to('julien@laravel.fr', 'Julien Tant')->subject('Contact depuis Laravel.fr');
            });

            return Redirect::action('Lvlfr\Website\Controller\ContactController@getSuccess');
        }

        return Redirect::back()->withInput()->withErrors($validator->getErrors());
    }

    public function getSuccess()
    {
            return View::make('LvlfrWebsite::contact.success');
    }

}
