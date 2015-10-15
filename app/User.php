<?php

namespace LaravelFrance;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Socialite\Contracts\User as SocialiteUser;


class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public static function createFromSocialUser($driver, SocialiteUser $socialiteUser)
    {
        $user = new self;

        $user->username = $socialiteUser->getNickname();
        $user->email = $socialiteUser->getEmail();
        if ($driver == "twitter") {
            $user->email = 'twitter_' . str_random('3') . time();
        }

        return $user;
    }

    public function oauth()
    {
        return $this->hasMany(OAuth::class);
    }


}
