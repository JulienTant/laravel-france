<?php
namespace Lvlfr\Wiki\Repositories\MySQL;

use Lvlfr\Wiki\Repositories\Page as BasePageRepo;

class MySQLPageRepo implements BasePageRepo {
    
    public function find($slug) {
        return \DB::table('wiki_page')->whereSlug($slug)->first()->content;
    }

}