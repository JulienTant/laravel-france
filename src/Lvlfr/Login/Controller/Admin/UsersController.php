<?php

namespace Lvlfr\Login\Controller\Admin;

use \Input;
use \Str;
use \Redirect;
use \Lvlfr\Login\Model\User;
use \View;

class UsersController extends \BaseController
{
    public function lists()
    {
        $users = User::orderBy('id', 'asc')->get();


        return View::make('LvlfrLogin::admin.users.list', array(
            'users' => $users,
        ));
    }
}
