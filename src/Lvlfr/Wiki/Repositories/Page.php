<?php
namespace Lvlfr\Wiki\Repositories;

interface Page {
    public function find($slug);
}