<?php

namespace Lvlfr\Forums\Validation;

class PostReplyValidator extends \App\Services\Validator
{
    public function getRules()
    {
        return array(
            'message_content' => array('required', 'min:2'),
        );
    }
}
