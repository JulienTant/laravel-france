<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance;


use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Contracts\User as SocialiteUser;

/**
 * LaravelFrance\OAuth
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $provider
 * @property string $uid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth whereProvider($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth twitter()
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth github()
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\OAuth google()
 */
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