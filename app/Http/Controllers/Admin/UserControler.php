<?php

namespace LaravelFrance\Http\Controllers\Admin;

use Illuminate\Http\Request;

use LaravelFrance\Http\Requests;
use LaravelFrance\Http\Controllers\Controller;
use LaravelFrance\User;

class UserControler extends Controller
{

    function __construct()
    {
        $this->authorize('admin.can_manage_users');
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function groups($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.users.groups', compact('user'));
    }

    public function saveGroups(Requests\ChangeUserGroupsRequest $request, $userId)
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        $user->changeGroups($request->groups);

        alert()->success('Les groups de '. $user->username .' ont été modifiés !');

        return \Redirect::back();
    }



}
