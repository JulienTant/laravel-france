<?php
namespace Lvlfr\Forums\Models;

class View extends \Eloquent
{
    protected $table = 'forum_views';
    protected $fillable = array('topic_id', 'category_id', 'user_id');
}
