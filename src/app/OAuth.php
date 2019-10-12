<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class OAuth extends Model
{
    protected $table = "oauth";

    public static function createFromSocialUser($driver, SocialiteUser $socialiteUser)
    {
        $oauth = new self;

        $oauth->provider = ucfirst($driver);
        $oauth->uid = $socialiteUser->getId();
        if ($driver == "google") {
            $oauth->uid = $socialiteUser->getEmail();
        }

        return $oauth;
    }


    public function scopeTwitter($query)
    {
        return $query->whereProvider('Twitter');
    }

    public function scopeGithub($query)
    {
        return $query->whereProvider('Github');
    }

    public function scopeGoogle($query)
    {
        return $query->whereProvider('Google');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
