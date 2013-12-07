<?php
namespace Lvlfr\PasteApi\Model;

use \Hashids;

class Paste extends \Eloquent
{

    function __construct() {
        parent::__construct();
        Paste::created(function($paste) {
            $paste->uniqid = Hashids::encrypt($paste->id);
            $paste->save();
        });
    }

}