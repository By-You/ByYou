<?php

namespace App\AdminModule;

use Nette,
    Nette\Application\UI,
    App\Model;

class LoginPresenter extends BasePresenter
{
    protected function createComponentRegistrationForm()
    {
        $form = new UI\Form;
        $form->addText('name', 'Jméno:')
            ->setRequired('Zadejte prosím jméno');
        $form->addPassword('password', 'Heslo:')
            ->setRequired('Zadejte prosím heslo');
        $form->addSubmit('login', 'Login');
        $form->onSuccess[] = array($this, 'registrationFormSucceeded');
        return $form;
    }

    // volá se po úspěšném odeslání formuláře
    public function registrationFormSucceeded(UI\Form $form, $values)
    {
        // ...
        $this->flashMessage('Byl jste úspěšně registrován.');
        $this->redirect('Homepage:default');
    }
}


