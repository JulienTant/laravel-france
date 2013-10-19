<?php

namespace Lvlfr\Forums\Validation;

class NewTopicValidator extends \App\Services\Validator
{
    public function getRules()
    {
        return array(
            'topic_title' => array('required', 'min:2'),
            'topic_content' => array('required', 'min:30'),
        );
    }
}
