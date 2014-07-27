<?php
namespace Lvlfr\Login\Controller;

use \Auth;
use \BaseController;
use \Input;
use \OAuth;
use \Session;
use \Str;
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
        OAuth::setHttpClient('CurlClient');

        switch ($providerGoodName = ucfirst($provider)) {
            case 'Google':
            case 'GitHub':
                $retour = $this->loginToAuth2($providerGoodName);
                break;
        }
        return $retour;
    }

    public function loginToAuth2($provider)
    {
        // get data from input
        $code = Input::get('code');

        // get google service
        $OAuth2Service = OAuth::consumer($provider);

        // check if code is valid
        // if code is provided get user data and sign in
        if (!empty($code)) {

            // This was a callback request from google, get the token
            $token = $OAuth2Service->requestAccessToken($code);

            $isAlreadyConnected = Auth::check();
            // Send a request with it
            $infos = $this->loginService->getUserInfos($OAuth2Service, $provider, $token);
            $this->loginService->login($infos);

            if ($isAlreadyConnected) {
                Session::flash('top_success', 'Votre compte ' . $provider . ' est maintenant lié !');
            } else {
                Session::flash('top_success', 'Vous êtes maintenant connecté !');
            }


            $url = Session::get('prevUrl', action('Lvlfr\Website\Controller\HomeController@getIndex'));
            if (Str::contains($url, '/login/')) {
                $url = action('Lvlfr\Website\Controller\HomeController@getIndex');
            }

            return Redirect::intended(
                $url
            );

        } else {
            // get googleService authorization
            $url = $OAuth2Service->getAuthorizationUri();

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
