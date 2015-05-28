<?php

namespace App\AdminModule;

use Nette,
	Nette\Application\UI,
	App\Model;

class LoginPresenter extends BasePresenter
{
	/** @var string */
	protected $successRedirect = NULL;

	/** @var string */
	protected $successRedirectUrl = NULL;

	/** @persistent */
	public $backlink;


	/** @return Form */
	protected function createComponentRegistrationForm()
	{
		$form = new UI\Form;
		$form->addText('username', 'Jméno:')
			->setRequired('Zadejte prosím jméno');
		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte prosím heslo');
		$form->addSubmit('login', 'Login');
		$form->onSuccess[] = array($this, 'registrationFormSucceeded');
		return $form;
	}


	/**
	* @param Form $form
	* @return void
	* @throws Nette\Security\AuthenticationException
	*/
	public function registrationFormSucceeded($form)
	{
		$values = $form->getValues();
		//try {
			$this->user->login($values->username, $values->password);
			$this->onLoggedIn();

			/*if ($this->presenter->isAjax()) {
				$this->presenter->sendJson(array('forceRedirect' => ($this->backlink ?: $this->presenter->link('this'))));
			} elseif ($this->backlink) {
				$this->presenter->restoreRequest($this->backlink);
				$this->presenter->redirectUrl($this->backlink);
			}

			if ($this->successRedirectUrl) {
				$this->presenter->redirectUrl($this->successRedirectUrl, 301);
			}

			if ($this->successRedirect) {
				$this->presenter->redirect($this->successRedirect);
			}
		}
		catch (Nette\Security\AuthenticationException $e) {

			if ($this->presenter->isAjax()) {
				$this->invalidateControl('loginFormSnippet');
			} elseif ($values['redirect']) {
				$this->presenter->redirect('UID|userLogin', array($this->getUniqueId() . '-error' => $e->getMessage()));
			}

			$form->addError($e->getMessage()); // add error directly to template
		}*/
	}

	/**
	 * @param string $redirect
	 */
	public function setRedirect($redirect)
	{
		$this->successRedirect = $redirect;
	}


	/**
	 * @param string $url
	 *//*
	public function setRedirectUrl($url)
	{
		$this->successRedirectUrl = $url;
	}
*/
}


