<?php
namespace Lvlfr\PasteApi\Controller;

use \Input;

class PasteController extends \BaseController {

    public function store()
    {
        $paste = new \Lvlfr\PasteApi\Model\Paste;
        $paste->code = Input::get('code');
        $paste->save();

        return $paste->toJson();
    }

    public function show($uniqid)
    {
        return \Lvlfr\PasteApi\Model\Paste::whereUniqid($uniqid)->first()->toJson();
    }

}