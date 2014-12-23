<?php

namespace Lvlfr\Login\Controller;

use \Auth;
use \BaseController;
use \Input;
use Lvlfr\Forums\Models\Category as ForumCategory;
use Lvlfr\Forums\Models\Topic as ForumTopic;
use \Session;
use \Redirect;
use \Response;
use Lvlfr\Login\Model\User;
use Lvlfr\Login\Model\OAuth;
use \Validator;
use \View;

class ProfileController extends BaseController
{

    public function index()
    {
        return Redirect::action('Lvlfr\Login\Controller\ProfileController@avatar');
    }

    public function applications()
    {
        $onGoogle = $onGitHub = $onTwitter = false;

        $oauths = OAuth::whereUserId(Auth::user()->id)->get();
        foreach ($oauths as $oauth) {
            switch ($oauth->provider) {
                case 'Google':
                    $onGoogle = true;
                    break;

                case 'GitHub':
                    $onGitHub = true;
                    break;

                case 'Twitter':
                    $onTwitter = true;
                    break;
            }
        }

        return View::make('LvlfrLogin::profile.applications')
            ->with('onGoogle', $onGoogle)
            ->with('onGitHub', $onGitHub)
            ->with('onTwitter', $onTwitter);
    }

    public function pseudo()
    {
        return View::make('LvlfrLogin::profile.pseudo');
    }

    public function submitPseudo()
    {
        $pseudo = Input::get('pseudo');

        $user = User::whereUsername($pseudo)->first(['id']);
        if ($user != null && $user->id != Auth::user()->id) {
            return Response::make(json_encode(['message' => 'Le pseudo est déjà utilisé']), 400);
        } elseif ($user != null && $user->id == Auth::user()->id && $pseudo == Auth::user()->username) {
            return Response::make(json_encode(['message' => 'Ce pseudo est le votre']), 200);
        }

        $validator = Validator::make(['pseudo' => $pseudo], ['pseudo' => 'min:3|required']);
        if ($validator->fails()) {
            return Response::make(json_encode(['message' => 'Pseudo invalide (min: 3 caractères)']), 400);
        }

        $this->changeUsername($pseudo);

        return Response::make(json_encode(['message' => 'Pseudo mis à jour']), 200);

    }

    public function checkPseudo()
    {
        $pseudo = Input::get('pseudo');
        $user = User::whereUsername($pseudo)->first(['id']);

        if ($user != null && $user->id != Auth::user()->id) {
            return 'nok';
        } elseif ($user != null && $user->id == Auth::user()->id) {
            return 'ok';
        }

        $validator = Validator::make(['pseudo' => $pseudo], ['pseudo' => 'min:3|required']);
        if ($validator->fails()) {
            return 'nok';
        }
        return 'ok';
    }

    public function avatar()
    {
        return View::make('LvlfrLogin::profile.avatar');
    }

    public function submitAvatar()
    {
        $email = Input::get('email');

        $user = \Lvlfr\Login\Model\User::where('email', '=', $email)->first(['id']);

        if ($user != null && $user->id != Auth::user()->id) {
            return Response::make(json_encode(['message' => 'Adresse email déjà attribuée']), 400);
        } elseif ($user != null && $user->id == Auth::user()->id) {
            return Response::make(json_encode(['message' => 'Cette adresse email est déjà la votre']), 200);
        }

        $validator = Validator::make(['email' => $email], ['email' => 'email|required']);

        if ($validator->fails()) {
            return Response::make(json_encode(['message' => 'Adresse email invalide']), 400);
        }


        Auth::user()->email = trim($email);
        Auth::user()->save();
        return Response::make(json_encode(['message' => 'Adresse email mise à jour']), 200);
    }

    /**
     * @todo deserve it's own service
     * 
     * @param $pseudo
     * @return string
     */
    private function changeUsername($pseudo)
    {
        $trimedUsername = trim($pseudo);
        $loggedInUser = Auth::user();
        $loggedInUser->username = $trimedUsername;

        ForumTopic::where('lm_user_id', $loggedInUser->id)->update(['lm_user_name' => $trimedUsername]);
        ForumCategory::where('lm_user_id', $loggedInUser->id)->update(['lm_user_name' => $trimedUsername]);

        $loggedInUser->save();
        return $trimedUsername;
    }

}
