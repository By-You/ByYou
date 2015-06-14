<?php

namespace App\AdminModule;

use Nette,
    Nette\Application\UI\Form,
    App\Settings;

class LoginPresenter extends BasePresenter
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    protected function startup()
    {

        parent::startup();
        if ($this->user->isLoggedIn()) {
            $this->redirect('Homepage:');
        }
    }

    function createComponentLoginForm()
    {
        $form = new Form;
        $form->addText('login')
            ->setAttribute('id', 'login')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte jméno');
        $form->addPassword('pass')
            ->setAttribute('id', 'pass')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte heslo');
        $form->addSubmit('send')
            ->setAttribute('value', 'Přihlásit')
            ->setAttribute('class', 'ok');
        $form->onSuccess[] = array($this, 'loginFormSucceeded');
        return $form;
    }

    public function loginFormSucceeded(Form $form, $values)
    {
        $settings = $this->EntityManager->getRepository(Settings::getClassName());
        $setting = $settings->find(1);

        if ($setting->admin_login == $values['login'] and $setting->admin_pass == md5($values['pass'])) {
            $this->getUser()->login($setting->admin_login, $setting->admin_pass);
            $this->redirect('Homepage:');
        }
        else {
            $form->addError('Špatně zadaný login nebo heslo!');
        }
    }

}


