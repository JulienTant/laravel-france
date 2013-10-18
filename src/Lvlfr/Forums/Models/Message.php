<?php
namespace Lvlfr\Forums\Models;

class Message extends \Eloquent
{
    protected $table = 'forum_messages';

    public function user()
    {
        return $this->belongsTo('\User', 'user_id');
    }
}
