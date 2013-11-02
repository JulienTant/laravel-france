<?php

namespace Lvlfr\Login\Controller;

use \Auth;
use \BaseController;
use \Input;
use \OAuth;
use \Session;
use \Redirect;
use \Response;
use Lvlfr\Login\Model\User;
use \Validator;
use \View;

class ProfileController extends BaseController
{

    public function index()
    {
        return Redirect::action('Lvlfr\Login\Controller\ProfileController@avatar');
    }

    public function pseudo()
    {
        return View::make('LvlfrLogin::profile.pseudo');
    }

    public function submitPseudo()
    {
        $pseudo = Input::get('pseudo');

        $user = User::whereUsername($pseudo)->first(array('id'));
        if ($user != null && $user->id != Auth::user()->id) return Response::make(json_encode(array('message' => 'Le pseudo est déjà utilisé')), 400);
        elseif ($user != null && $user->id == Auth::user()->id) return Response::make(json_encode(array('message' => 'Ce pseudo est le votre')), 200);

        $validator = Validator::make(array('pseudo' => $pseudo), array('pseudo' => 'min:3|required'));
        if ($validator->fails()) return Response::make(json_encode(array('message' => 'Pseudo invalide (min: 3 caractères)')), 400);

        Auth::user()->username = trim($pseudo);
        Auth::user()->save();
        return Response::make(json_encode(array('message' => 'Pseudo mis à jour')), 200);

    }
    
    public function checkPseudo()
    {
        $pseudo = Input::get('pseudo');
        $user = User::whereUsername($pseudo)->first(array('id'));

        if ($user != null && $user->id != Auth::user()->id) return 'nok';
        elseif ($user != null && $user->id == Auth::user()->id) return 'ok';

        $validator = Validator::make(array('pseudo' => $pseudo), array('pseudo' => 'min:3|required'));
        if ($validator->fails()) return 'nok';
        return 'ok';
    }

    public function avatar()
    {
        return View::make('LvlfrLogin::profile.avatar');
    }

    public function submitAvatar()
    {
        $email = Input::get('email');

        $user = \Lvlfr\Login\Model\User::where('email', '=', $email)->first(array('id'));

        if ($user != null && $user->id != Auth::user()->id) {
            return Response::make(json_encode(array('message' => 'Adresse email déjà attribuée')), 400);
        } elseif ($user != null && $user->id == Auth::user()->id) {
            return Response::make(json_encode(array('message' => 'Cette adresse email est déjà la votre')), 200);
        }

        $validator = Validator::make(array('email' => $email), array('email' => 'email|required'));

        if ($validator->fails()) {
            return Response::make(json_encode(array('message' => 'Adresse email invalide')), 400);
        }


        Auth::user()->email = trim($email);
        Auth::user()->save();
        return Response::make(json_encode(array('message' => 'Adresse email mise à jour')), 200);
    }

}
