<?php

namespace LaravelFrance\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use LaravelFrance\Http\Requests\ChangeEmailRequest;
use LaravelFrance\Http\Requests\ChangeUserForumsPreferencesRequest;
use LaravelFrance\Http\Requests\ChangeUsernameRequest;
use LaravelFrance\User;

class UserController extends Controller
{
    public function index()
    {
        return redirect()->route('user.forums-preferences');
    }

    public function changeUsername()
    {
        return view('users.change-username');
    }

    public function postChangeUsername(ChangeUsernameRequest $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->changeUsername($request->username);

        alert()->success("Votre pseudo est maintenant : {$request->username}", 'Félicitation !')->autoclose(3000);

        return back();
    }

    public function changeEmail()
    {
        return view('users.change-email');
    }

    public function postChangeEmail(ChangeEmailRequest $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->changeEmail($request->email);

        alert()->success("Vous venez de changer d'email ! :)", 'Félicitation !')->autoclose(3000);

        return back();
    }

    public function forumsPreferences(Request $request)
    {
        $preferences = $request->user()->forums_preferences?: [];

        return view('users.forums', compact('preferences'));
    }

    public function postForumsPreferences(ChangeUserForumsPreferencesRequest $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->changeForumsPreferences($request->preference);

        alert()->success("Vos nouvelles préférences sont maintenant à jour !", 'Préférences mises à jour')->autoclose(3000);

        return back();
    }


    public function logout()
    {
        Auth::logout();

        return back(302, [], '/');
    }
}
