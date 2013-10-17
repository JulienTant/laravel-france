<?php

namespace Lvlfr\Website\Validation;

class ContactValidator extends \App\Services\Validator {

    public function getRules() {
        return array(
            'name' => array('required', 'min:2'),
            'email' => array('required', 'email'),
            'subject' => array('min:3'),
            'mailContent' => array('required', 'min:30'),
        );
    }
}
