<?php

namespace Lvlfr\Login\Controller\Admin;

use \Lvlfr\Documentation\Services\DocUpdaterInterface;
use \Input;
use \Str;
use \Session;
use \Redirect;
use \View;

class DocController extends \BaseController
{
    public function __construct(DocUpdaterInterface $updater)
    {
        $this->updater = $updater;
    }

    public function update()
    {
        return View::make('LvlfrLogin::admin.doc.update');
    }

    public function postUpdate()
    {
        $this->updater->performUpdate();
        return Redirect::back()->with('top_success', 'Documentation mise à jour');
    }
}
