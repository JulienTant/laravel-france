<?php
namespace Lvlfr\Login\Controller;

use \Auth;
use \BaseController;
use \Input;
use \OAuth;
use \Session;
use \Redirect;
use \Response;
use \View;

class LoginController extends BaseController
{
    public function __construct()
    {
        $this->loginService = new \Lvlfr\Login\Service\LoginService;
    }

    public function index()
    {
        return \View::make('LvlfrLogin::login');
    }

    public function login($provider = 'Google')
    {
        $retour = null;
        switch (ucfirst($provider)) {
            case 'Google':
                $retour = $this->loginToGoogle();
                break;
        }
        return $retour;
    }

    public function loginToGoogle()
    {
        $provider = 'Google';

        // get data from input
        $code = Input::get('code');

        // get google service
        $googleService = OAuth::consumer($provider);

        // check if code is valid
        // if code is provided get user data and sign in
        if (!empty($code)) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken($code);

            $isAlreadyConnected = Auth::check();

            // Send a request with it
            $infos = $this->loginService->getUserInfos($googleService, $provider, $token);
            $this->loginService->login($infos);

            if ($isAlreadyConnected) {
                Session::flash('top_success', 'Votre compte ' . $provider . ' est maintenant lié !');
            } else {
                Session::flash('top_success', 'Vous êtes maintenant connecté !');
            }
            return Redirect::intended(
                Session::get('prevUrl', action('Lvlfr\Website\Controller\HomeController@getIndex'))
            );

        } else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::to((string)$url);
        }

    }

    public function logout()
    {
        Auth::logout();
        return Redirect::intended(Session::get('prevUrl', action('Lvlfr\Website\Controller\HomeController@getIndex')));
    }

    public function check()
    {
        return json_encode(\Auth::check());
    }
}
