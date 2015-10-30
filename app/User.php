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
use LaravelFrance\Events\UserHasChangedHisAvatar;
use LaravelFrance\Events\UserHasChangedHisUsername;


/**
 * LaravelFrance\User
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $nb_messages
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|OAuth[] $oauth
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereNbMessages($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereUpdatedAt($value)
 * @property string $groups
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereGroups($value)
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string $birthdate
 * @property string $city
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereBirthdate($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereDeletedAt($value)
 */
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

    /**
     * The attributes that needs cast
     *
     * @var array
     */
    protected $casts = [
        'groups' => 'array',
    ];



    /**
     * @param $driver
     * @param SocialiteUser $socialiteUser
     * @return User
     */
    public static function createFromSocialUser($driver, SocialiteUser $socialiteUser)
    {
        $user = new self;

        $user->username = preg_replace('/\s+/', '', $socialiteUser->getNickname() ?: $socialiteUser->getName());

        $user->email = $socialiteUser->getEmail();
        if ($driver == "twitter") {
            $user->email = 'twitter_' . str_random('3') . time();
        }

        $user->groups = [];

        return $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauth()
    {
        return $this->hasMany(OAuth::class);
    }

    /**
     * @return $this
     */
    public function incrementNbMessages()
    {
        $this->nb_messages++;
        return $this;
    }

    public function decrementNbMessages()
    {
        $this->nb_messages--;
        return $this;
    }

    public function changeUsername($username)
    {
        $oldUsername = $this->username;
        $this->username = $username;
        event(new UserHasChangedHisUsername($this, $oldUsername, $username));
        $this->save();
    }

    public function changeEmail($email)
    {
        $this->email = $email;
        event(new UserHasChangedHisAvatar($this));
        $this->save();

    }
}
