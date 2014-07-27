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
            case 'Twitter':

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

            $this->determineFlashMessage($provider, $isAlreadyConnected);
            $url = $this->determineUrl();

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

    public function loginToAuth1($provider)
    {
        // get data from input
        // get data from input
        $token = Input::get('oauth_token');
        $verify = Input::get('oauth_verifier');

        // get twitter service
        $OAuth1Service = OAuth::consumer($provider);

        // check if code is valid
        // if code is provided get user data and sign in
        if (!empty($token) && !empty($verify)) {

            // This was a callback request from twitter, get the token
            $token = $OAuth1Service->requestAccessToken($token, $verify);

            // Send a request with it
            $isAlreadyConnected = Auth::check();
            // Send a request with it
            $infos = $this->loginService->getUserInfos($OAuth1Service, $provider, $token);
            $this->loginService->login($infos);

            $this->determineFlashMessage($provider, $isAlreadyConnected);
            $url = $this->determineUrl();

            return Redirect::intended(
                $url
            );

        } else {
            // get request token
            $reqToken = $OAuth1Service->requestRequestToken();

            // get Authorization Uri sending the request token
            $url = $OAuth1Service->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            // return to twitter login url
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

    /**
     * @param $provider
     * @param $isAlreadyConnected
     */
    private function determineFlashMessage($provider, $isAlreadyConnected)
    {
        if ($isAlreadyConnected) {
            Session::flash('top_success', 'Votre compte ' . $provider . ' est maintenant lié !');
        } else {
            Session::flash('top_success', 'Vous êtes maintenant connecté !');
        }
    }

    /**
     * @return string
     */
    private function determineUrl()
    {
        $url = Session::get('prevUrl', action('Lvlfr\Website\Controller\HomeController@getIndex'));
        if (Str::contains($url, '/login/')) {
            $url = action('Lvlfr\Website\Controller\HomeController@getIndex');
            return $url;
        }
        return $url;
    }
}
