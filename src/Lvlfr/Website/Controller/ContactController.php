<?php
namespace Lvlfr\Website\Controller;

use \BaseController;
use \View;
use \Input;
use \Mail;
use \Redirect;

class ContactController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
    }

    public function getIndex()
    {
        return View::make('LvlfrWebsite::contact.index');
    }

    public function postIndex()
    {
        $fields = Input::all();

        $fields['honey_pot'] = $fields['email'];
        $fields['email'] = $fields['phone'];
        unset($fields['phone']);

        $honeyPostPass = $this->checkHoneyPot($fields['honey_pot']);


        $validator = new \Lvlfr\Website\Validation\ContactValidator($fields);


        if ($validator->passes() && $honeyPostPass) {
            Mail::queue(
                'LvlfrWebsite::contact.email_content',
                $fields,
                function ($m) {
                    $m->to('julien@laravel.fr', 'Julien Tant')->subject('Contact depuis Laravel.fr');
                }
            );

            return Redirect::action('Lvlfr\Website\Controller\ContactController@getSuccess');
        }

        return Redirect::back()->withInput()->withErrors($validator->getErrors());
    }

    public function getSuccess()
    {
        return View::make('LvlfrWebsite::contact.success');
    }

    private function checkHoneyPot($honePot)
    {
        return strlen($honePot === 0);
    }

}
