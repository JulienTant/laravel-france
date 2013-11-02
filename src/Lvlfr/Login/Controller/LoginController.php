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
        $provider = ucfirst($provider);
        $validProviders = array('Google', 'Twitter', 'GitHub');

        if (in_array($provider, $validProviders)) {
            $oAuthService = OAuth::consumer($provider);

            try {
                $token = null;
                if ($provider == 'Twitter') {
                    if (Input::get('oauth_token') == "" || Input::get('oauth_verifier') == "") {
                        $oAuthService->getStorage()->clearAllTokens();
                        throw new \OAuth\Common\Storage\Exception\TokenNotFoundException('Login Twitter');
                    }
                    $token = $oAuthService->getStorage()->retrieveAccessToken('Twitter');
                    $token = $oAuthService->requestAccessToken(Input::get('oauth_token'), Input::get('oauth_verifier'), $token->getRequestTokenSecret());
                } else {
                    $token = $oAuthService->requestAccessToken(Input::get('code'));
                }
                $infos = $this->loginService->getUserInfos($oAuthService, $provider, $token);
                $this->loginService->login($infos);

                Session::flash('top_success', 'Vous êtes maintenant connecté !');
                return Redirect::intended(Session::get('prevUrl', action('Lvlfr\Website\Controller\HomeController@getIndex')));
            } catch (\OAuth\Common\Http\Exception\TokenResponseException $ex) {
                $url = $oAuthService->getAuthorizationUri();
                return Response::make()->header('Location', (string)$url);
            }  catch (\OAuth\Common\Storage\Exception\TokenNotFoundException $ex) {
                $token = $oAuthService->requestRequestToken();
                $url = $oAuthService->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
                return Response::make()->header('Location', (string)$url);
            } catch (\Exception $ex) {
                Session::flash('top_error', 'Un compte avec cet identifiant ou cette adresse email existe déjà. Peut-être vous êtes vous déjà connecté avec un autre fournisseur ?');
                return Redirect::intended(Session::get('prevUrl', action('Lvlfr\Website\Controller\HomeController@getIndex')));
            }
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
