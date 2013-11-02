<?php
namespace Lvlfr\Login\Service;

use \Auth;
use \Lvlfr\Login\Model\User;
use Lvlfr\Login\Model\OAuth as OAuthModel;

class LoginService
{
    public function getUserInfos($provider, $providerName, $accessToken)
    {
        $model = array(
            'type' => $providerName,

            'uid' => '',
            'access_token' => $accessToken,
            'secret' => '',

            'email' => '',
            'username' => '',
        );

        $filled = false;
        if ($providerName == 'Google') {
            $filled = true;

            $result = json_decode($provider->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
            $model['uid'] = $result['id'];
            $model['email'] = $result['email'];
            $model['username'] = $result['name'];
        } elseif ($providerName == 'GitHub') {
            $filled = true;

            $result = json_decode($provider->request('user'), true);
            $model['uid'] = $result['id'];
            $model['email'] = $result['email'];
            $model['username'] = $result['login'];
        } elseif ($providerName == 'Twitter') {
            $filled = true;

            $result = json_decode($provider->request('account/verify_credentials.json'), true);
            $model['uid'] = $result['id_str'];
            $model['email'] = "fakeEmail_".$result['id_str']."@from_twitter.com";
            $model['username'] = $result['screen_name'];
        }

        return $filled ? $model : false;
    }


    public function login($userInfos)
    {
        $finalUser = null;

        // Guest ?
        if (Auth::guest()) {
            // --> Check if uid exist for given Provider, and login
            $authInfosInDb = OAuthModel::with('user')->where('uid', '=', $userInfos['uid'])->where('provider', '=', $userInfos['type'])->first();
            if ($authInfosInDb !== null) {
                $finalUser = $authInfosInDb->user;
            } else {
                // --> Or, create user, register provider, and login
                $user = new User();
                $user->username = $userInfos['username'];
                $user->email = $userInfos['email'];
                $user->save();

                $oAuth = new OAuthModel();
                $oAuth->provider = $userInfos['type'];
                $oAuth->uid = $userInfos['uid'];
                $oAuth->user_id = $user->id;
                $oAuth->save();

                $finalUser = $user;
            }
        }
        // Already logged in ?
        // --> Check if uid exist for given Provider for this user, and update
        // --> Register now provider for current user
        //
        Auth::login($finalUser);
    }
}
