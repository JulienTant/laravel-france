<?php

namespace App\Services;

abstract class Validator {

    protected $attr;
    protected $errors;

    public function __construct($attributes) {
        $this->attr = $attributes;
    }

    public function passes()
    {
        $validation = \Validator::make($this->attr, $this->getRules());

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public abstract function getRules();
}
