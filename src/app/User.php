<?php

namespace LaravelFrance;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use LaravelFrance\Events\UserForumsPreferencesWasChanged;
use LaravelFrance\Events\UserGroupsWasChanged;
use LaravelFrance\Events\UserHasChangedHisAvatar;
use LaravelFrance\Events\UserHasChangedHisUsername;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
            $user->email = \Str::slug($user->username) . '@from_twitter';
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

    public function forumsMessages()
    {
        return $this->hasMany(ForumsMessage::class);
    }
}
