<?php
namespace Lvlfr\Wiki\Repositories\File;

use Lvlfr\Wiki\Repositories\Page as BasePageRepo;
use \Str;

class FilePageRepo implements BasePageRepo {
    
    public function find($slug) {
        $slug = Str::slug($slug);

        $current = __DIR__ . '/../../content/' . $slug . '/current';
        if(file_exists($current)) {
            return file_get_contents($current);
        }
        return null;
    }

}