<?php

namespace App\Presenters;

use App\Article;
use Nette;


/**
 * Formular presenter.
 */
class FormularPresenter extends BasePresenter
{
    protected function createComponentRegistrationForm()
    {
        $form = new UI\Form;
        $form->addText('name', 'Jméno:');
        $form->addPassword('password', 'Heslo:');
        $form->addSubmit('login', 'Registrovat');
        $form->onSuccess[] = array($this, 'registrationFormSucceeded');
        return $form;
    }

    // volá se po úspěšném odeslání formuláře
    public function registrationFormSucceeded(UI\Form $form, $values)
    {
        // ...
        $this->flashMessage('Byl jste úspěšně registrován.');
        $this->redirect('Homepage:');
    }

}
