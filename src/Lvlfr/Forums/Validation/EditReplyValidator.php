<?php

namespace Lvlfr\Forums\Validation;

class EditReplyValidator extends \App\Services\Validator
{
    public function getRules()
    {
        return array(
            'message_content' => array('required', 'min:2'),
            'title' => array('min:2'),
        );
    }
}
