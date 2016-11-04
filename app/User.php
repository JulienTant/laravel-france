<?php

namespace LaravelFrance;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use LaravelFrance\Events\UserForumsPreferencesWasChanged;
use LaravelFrance\Events\UserGroupsWasChanged;
use LaravelFrance\Events\UserHasChangedHisAvatar;
use LaravelFrance\Events\UserHasChangedHisUsername;


/**
 * LaravelFrance\User
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $groups
 * @property string $forums_preferences
 * @property integer $nb_messages
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\LaravelFrance\OAuth[] $oauth
 * @property-read \Illuminate\Database\Eloquent\Collection|\LaravelFrance\ForumsWatch[] $watchedTopics
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereGroups($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereForumsPreferences($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereNbMessages($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\LaravelFrance\User whereUpdatedAt($value)
 * @mixin \Eloquent
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
        'forums_preferences' => 'array',
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
        $user->forums_preferences = [];

        return $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauth()
    {
        return $this->hasMany(OAuth::class);
    }

    public function watchedTopics()
    {
        return $this->hasMany(ForumsWatch::class);
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

    public function changeGroups($groups)
    {
        $this->groups = $groups;
        event(new UserGroupsWasChanged($this));
        $this->save();
    }

    public function changeForumsPreferences($preferences)
    {
        $this->forums_preferences = $preferences;
        event(new UserForumsPreferencesWasChanged($this));
        $this->save();
    }

    public function getForumsPreferencesItem($key)
    {
        if (!is_array($this->forums_preferences) || !array_key_exists($key, $this->forums_preferences)) {
            return null;
        }

        return $this->forums_preferences[$key];
    }


}
