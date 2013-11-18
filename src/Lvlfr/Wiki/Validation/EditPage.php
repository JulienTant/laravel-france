<?php

namespace Lvlfr\Wiki\Validation;

class EditPage extends \App\Services\Validator
{
    public function getRules()
    {
        return array(
            'content' => array('required', 'min:2'),
            'title' => array('required', 'min:2'),
        );
    }
}
