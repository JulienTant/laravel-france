<?php
namespace Lvlfr\Wiki\Entities;

class Version extends \Eloquent
{
    protected $table = "wiki_versions";

    public function page()
    {
        return $this->belongsTo('\Lvlfr\Wiki\Entities\Page', 'wiki_page_id');
    }

    public function User()
    {
        return $this->belongsTo('\Lvlfr\Login\Model\User', 'user_id');
    }
}