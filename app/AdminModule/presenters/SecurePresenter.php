<?php

namespace App\AdminModule;

use Nette,
	App\Model;

class SecurePresenter extends BasePresenter
{
	protected function startup()
	{

		parent::startup();
		$this->ensureLoggedIn();
	}

	public function ensureLoggedIn()
	{
		if ( ! $this->user->isLoggedIn()) {
			$this->redirect('Login:default');
		}
	}
}