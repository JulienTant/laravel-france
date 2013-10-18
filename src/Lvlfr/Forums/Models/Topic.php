<?php
namespace Lvlfr\Forums\Models;

class Topic extends \Eloquent
{
    protected $table = 'forum_topics';

    public function category()
    {
        return $this->belongsTo('Lvlfr\Forums\Models\Category', 'forum_category_id');
    }

    public function user()
    {
        return $this->belongsTo('\User', 'user_id');
    }
}
