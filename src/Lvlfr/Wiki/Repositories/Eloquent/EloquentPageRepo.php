<?php
namespace Lvlfr\Wiki\Repositories\Eloquent;

use \Eloquent;
use Lvlfr\Wiki\Repositories\Page as BasePageRepo;
use Lvlfr\Wiki\Entities\Page as Page;

class EloquentPageRepo implements BasePageRepo {
    
    public function find($slug, $version = null) {
        $page = Page::whereSlug($slug)->first();
        if ($version != null) {
            $version = $page->versions()->whereVersion($version)->first();
            $page->title = $version->title;
            $page->content = $version->content;
        }

        return $page;
    }

    public function save($page) {
        $page->save();
        return $page;
    }

    public function all($orderBy = []) {
        $query = Page::query();

        foreach($orderBy as $colonne => $order) {
            $query->orderBy($colonne, $order);
        }

        return $query->get();
    }

    public function allWithLastVersion($orderBy = []) {
        $query = Page::with('lastVersion');

        foreach($orderBy as $colonne => $order) {
            $query->orderBy($colonne, $order);
        }

        return $query->get();
    }

}