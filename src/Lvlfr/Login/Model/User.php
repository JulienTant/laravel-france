<?php
namespace Lvlfr\Login\Model;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;
use Exception;

class User extends Eloquent implements UserInterface, RemindableInterface
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getAvatarUrl()
    {
        return 'http://www.gravatar.com/avatar/' . md5($this->email);
    }

    public function newForumMessage()
    {
        $this->nb_messages++;
        $this->save();
    }

    public function groups()
    {
        return $this->belongsToMany('Lvlfr\Login\Model\Group')->withTimestamps();
    }

    public function isSuperAdmin()
    {
        return $this->groups->contains(1);
    }

    public function hasRole($role)
    {
        if (!is_int($role)) {
            $role = Group::whereName($role)->first();
            if ($role === null) {
                throw new Exception("Group not found");
            }
        }

        return $this->groups->contains($role) || $this->isSuperAdmin();
    }
}
