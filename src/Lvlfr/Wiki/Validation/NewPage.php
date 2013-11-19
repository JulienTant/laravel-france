<?php

namespace Lvlfr\Wiki\Validation;

class NewPage extends \App\Services\Validator
{
    public function getRules()
    {
        return array(
            'title' => array('required', 'min:2', 'checkSlug', 'unique:wiki_pages,slug'),
            'content' => array('required', 'min:2'),
        );
    }
}
