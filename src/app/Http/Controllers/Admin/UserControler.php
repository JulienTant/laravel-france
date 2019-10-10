<?php

namespace LaravelFrance\Http\Controllers\Admin;

use LaravelFrance\Http\Controllers\Controller;
use LaravelFrance\Http\Requests;
use LaravelFrance\User;

class UserControler extends Controller
{

    public function index()
    {
        $this->authorize('admin.can_manage_users');

        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function groups($userId)
    {
        $this->authorize('admin.can_manage_users');

        $user = User::findOrFail($userId);
        return view('admin.users.groups', compact('user'));
    }

    public function saveGroups(Requests\ChangeUserGroupsRequest $request, $userId)
    {
        $this->authorize('admin.can_manage_users');

        /** @var User $user */
        $user = User::findOrFail($userId);
        $user->changeGroups($request->groups);

        alert()->success('Les groups de '. $user->username .' ont été modifiés !');

        return \Redirect::back();
    }



}
