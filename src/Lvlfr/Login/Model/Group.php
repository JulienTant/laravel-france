<?php
namespace Lvlfr\Login\Model;

class Group extends Eloquent
{
    public function users()
    {
        return $this->belongsToMany("Lvlfr\Login\Model\User")->withTimestamps();
    }
}
