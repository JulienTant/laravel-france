<?php

namespace Lvlfr\Website\Validation;

class ContactValidator extends \App\Services\Validator
{

    public function getRules()
    {
        return [
            'name' => ['required', 'min:2'],
            'email' => ['required', 'email'],
            'subject' => ['min:3'],
            'mailContent' => ['required', 'min:30'],
        ];
    }
}
