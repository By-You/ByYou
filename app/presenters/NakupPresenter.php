<?php

namespace App\Presenters;

use App\Article;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\form;



/**
 * Formular presenter.
 */


class NakupPresenter extends UI\Presenter
{

    protected function createComponentRegistrationForm()
    {


        $form = new UI\Form;
        $form->addText('jmeno', 'Jméno:')
            ->setRequired('Zadejte prosím jméno')
            ->addRule(FORM::MIN_LENGTH, 'Jméno musí mít alespoň %d znaky.', 2);
        $form->addText('prijmeni', 'Příjmení:')
            ->setRequired('Zadejte prosím příjmení')
            ->addRule(FORM::MIN_LENGTH, 'Příjmení musí mít alespoň %d znaky.', 2);
        $form->addText('email', 'E-mail:')
            ->addRule(FORM::EMAIL, 'Nezadali jste platnou E-mailovou adresu.');
        $form->addTextArea('note', 'Poznámka:')
            ->addRule(Form::MAX_LENGTH, 'Poznámka je příliš dlouhá', 10000);
        $form->addSubmit('objednat', 'Objednat');
        $form->addCheckbox('agree', 'Souhlasím s podmínkami')
            ->addRule(Form::EQUAL, 'Je potřeba souhlasit s podmínkami', TRUE);
        $form->addCheckbox('agree2', 'Chci obdržet novinky')
            ->setValue(TRUE);
        $form->onSuccess[] = array($this, 'registrationFormSucceeded');
        return $form;
    }

    // volá se po úspěšném odeslání formuláře
    public function registrationFormSucceeded(UI\Form $form, $values)
    {
        // ...
        $this->flashMessage('Zboží bylo úspěšně objednáno.');
        $this->redirect('Homepage:');
    }

}
