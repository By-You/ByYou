<?php

namespace App\AdminModule;


use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    protected function startup()
    {
        parent::startup();
        $this->template->date = date("d.m.Y");
        $this->template->time = date("H:i");
    }
}



