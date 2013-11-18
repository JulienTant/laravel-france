<?php
namespace Lvlfr\Wiki\Entities;

class Page extends \Eloquent
{
    protected $table = "wiki_pages";

    public function __toString()
    {
        return $this->content;
    }
}