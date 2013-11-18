<?php
namespace Lvlfr\Wiki\Entities;

use \Auth;

class Page extends \Eloquent
{
    protected $table = "wiki_pages";

    public static function boot()
    {
        Page::saved(function($page)
        {
            $version = 1;
            $versionDB = $page->versions()->orderBy('id', 'DESC')->first(array('version'));
            if ($versionDB != null) {
                $version = $versionDB->version +1;
            }

            $newVersion = new \Lvlfr\Wiki\Entities\Version();
            $newVersion->user_id = Auth::user()->id;
            $newVersion->version = $version;
            $newVersion->wiki_page_id = $page->id;
            $newVersion->content = $page->content;
            $newVersion->title = $page->title;
            $newVersion->save();
        });
    }

    public function versions()
    {
        return $this->hasMany('\Lvlfr\Wiki\Entities\Version', 'wiki_page_id')->orderBy('id', 'DESC');
    }

    public function __toString()
    {
        if (isset($this->content)) {
            return $this->content;
        }
        return '';
    }
}