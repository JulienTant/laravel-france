<?php

namespace LaravelFrance\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use LaravelFrance\Exceptions\EmailAlreadyTaken;
use LaravelFrance\Exceptions\UsernameAlreadyTaken;
use LaravelFrance\Guards\EmailIsUnique;
use LaravelFrance\Guards\Guards;
use LaravelFrance\Guards\UsernameIsUnique;
use LaravelFrance\OAuth;
use LaravelFrance\User;
use Socialite;

class OAuthController extends Controller
{
    use Guards;

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        \Session::put('s_from', \URL::previous());
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param $provider
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function handleProviderCallback($provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();

        $oauth = OAuth::with('user')->$provider()->whereUid($provider == "google" ? $socialiteUser->getEmail() : $socialiteUser->getId())->first();
        if ($oauth) {
            return $this->login($oauth->user);
        }

        \DB::beginTransaction();
        $user = User::createFromSocialUser($provider, $socialiteUser);
        try {
            $this->guard([EmailIsUnique::class], ['email' => $user->email]);
        } catch (EmailAlreadyTaken $exception) {
            alert()->error(sprintf("Cette adresse email (%s) est déjà utilisée.\nMerci de vous connecter avec un autre provider,\n ou de contacter l'administrateur.", $exception->getEmail()),
                'Email déjà utilisée')->persistent('ok');

            return redirect()->route('topics.index');
        }

        $originalUserName = $user->username;
        $i = 1;
        do {
            try {
                $this->guard([UsernameIsUnique::class], ['username' => $user->username]);
                $continue = false;
            } catch (UsernameAlreadyTaken $exception) {
                $user->username = $originalUserName . $i++;
                $continue = true;
            }
        } while ($continue);

        $user->save();

        $oauth = OAuth::createFromSocialUser($provider, $socialiteUser);
        $user->oauth()->save($oauth);
        \DB::commit();

        return $this->login($user);
    }

    public function login(User $user)
    {
        alert()->success('Vous êtes maintenant connecté !', 'Bonjour, '.$user->username.' ! :)')->autoclose(3000);

        Auth::login($user, true);

        return \Redirect::to(\Session::pull('s_from', '/'));
    }
}
