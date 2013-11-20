<?php
namespace Lvlfr\Wiki\Validation;

use \Config;
use \Str;
use \Illuminate\Validation\Validator;

class WikiValidator extends Validator {

    public function validatecheckSlug($attribute, $value, $parameters)
    {
        $value = Str::slug($value, '_');
        return !in_array($value, Config::get('LvlfrWiki::wiki.forbidden_slug'));
    }

}
