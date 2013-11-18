<?php
namespace Lvlfr\Wiki\Repositories;

interface Page {
    public function find($slug, $version = null);
    public function save($page);
}