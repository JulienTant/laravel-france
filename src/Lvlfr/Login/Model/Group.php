<?php
namespace Lvlfr\Login\Model;

use Eloquent;

class Group extends Eloquent
{
    public function users()
    {
        return $this->belongsToMany("Lvlfr\Login\Model\User")->withTimestamps();
    }
}
