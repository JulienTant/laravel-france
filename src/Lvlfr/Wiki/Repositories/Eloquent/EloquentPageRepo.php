<?php
namespace Lvlfr\Wiki\Repositories\Eloquent;

use Lvlfr\Wiki\Repositories\Page as BasePageRepo;
use Lvlfr\Wiki\Entities\Page as Page;

class EloquentPageRepo implements BasePageRepo {
    
    public function find($slug) {
        return Page::whereSlug($slug)->first();
    }

}