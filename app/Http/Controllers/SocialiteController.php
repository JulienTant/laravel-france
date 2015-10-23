<?php

namespace LaravelFrance\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\Factory as Socialite;
use LaravelFrance\Exceptions\EmailAlreadyTaken;
use LaravelFrance\Exceptions\UsernameAlreadyTaken;
use LaravelFrance\Guards\EmailIsUnique;
use LaravelFrance\Guards\Guards;
use LaravelFrance\Guards\UsernameIsUnique;
use LaravelFrance\Http\Requests;
use LaravelFrance\OAuth;
use LaravelFrance\User;

class SocialiteController extends Controller
{
    use Guards;

    /**
     * @var Socialite
     */
    private $socialite;

    /**
     * @var Guard
     */
    private $auth;

    function __construct(Socialite $socialite, Guard $auth)
    {
        $this->socialite = $socialite;
        $this->auth = $auth;
    }


    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($driver)
    {
        $this->buildConfig($driver);

        return $this->socialite->driver($driver)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($driver)
    {
        $this->buildConfig($driver);
        $socialiteUser = $this->socialite->driver($driver)->user();

        /** @var OAuth $oauth */
        $oauth = OAuth::with('user')->$driver()->whereUid($driver == "google" ? $socialiteUser->getEmail() : $socialiteUser->getId())->first();
        if ($oauth) {
            return $this->login($oauth->user);
        }

        $user = User::createFromSocialUser($driver, $socialiteUser);


        try {
            $this->guard([EmailIsUnique::class], ['email' => $user->email]);
        } catch (EmailAlreadyTaken $exception) {
            alert()->error(sprintf("Cette adresse email (%s) est déjà utilisée.\nMerci de vous connecter avec un autre provider,\n ou de contacter l'administrateur.", $exception->getEmail()),
                'Email déjà utilisée')->persistent('ok');

            return redirect()->route('forums.index');
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

        $oauth = OAuth::createFromSocialUser($driver, $socialiteUser);
        $user->oauth()->save($oauth);

        return $this->login($user);
    }

    private function buildConfig($driver)
    {
        config([
            'services.' . $driver . '.redirect' => route('socialite.callback', [$driver])
        ]);
    }

    private function login(Authenticatable $user)
    {
        alert()->success('Vous êtes maintenant connécté !', 'Hoi, '.$user->username.' ! :)')->autoclose(3000);

        $this->auth->login($user, true);

        return redirect()->route('forums.index');
    }

    public function logout()
    {
        $this->auth->logout();

        alert()->info('Vous êtes maintenant déconnécté !', 'À bientôt !')->autoclose(3000);


        return redirect()->back();
    }

}
