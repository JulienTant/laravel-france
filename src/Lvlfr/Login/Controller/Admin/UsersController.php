<?php

namespace Lvlfr\Login\Controller\Admin;

use \Input;
use \Str;
use \Redirect;
use \Lvlfr\Login\Model\User;
use \Lvlfr\Login\Model\Group;
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

    public function details($id)
    {
        $user = User::find($id);


        return View::make('LvlfrLogin::admin.users.details', array(
            'user' => $user,
            'groups' => Group::all()
        ));
    }

    public function postDetails($id)
    {
        $user = User::find($id);

        if (strlen(Input::get('username'))) $user->username = trim(Input::get('username'));
        if (strlen(Input::get('email'))) $user->email = trim(Input::get('email'));
        $user->canUpdateWiki = (bool)Input::get('canUpdateWiki');
        $user->save();

        return Redirect::back()->with('top_success', 'Utilisateur mis à jour');
    }

    public function postGroups($id)
    {
        $user = User::find($id);
        $user->groups()->sync(Input::get('groups'));
        $user->save();

        return Redirect::back()->with('top_success', 'Groupes de l\'utilisateur mis à jour');
    }
}
