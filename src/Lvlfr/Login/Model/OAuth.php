<?php
namespace Lvlfr\Login\Model;

class OAuth extends \Eloquent
{
    protected $table = 'oauth';

    public function user()
    {
        return $this->belongsTo('Lvlfr\Login\Model\User');
    }
}
