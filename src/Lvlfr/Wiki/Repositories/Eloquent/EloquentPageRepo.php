<?php
namespace Lvlfr\Wiki\Repositories\Eloquent;

use Lvlfr\Wiki\Repositories\Page as BasePageRepo;

class EloquentPageRepo implements BasePageRepo {
    
    public function find($slug) {
        return \DB::table('wiki_page')->whereSlug($slug)->first()->content;
    }

}