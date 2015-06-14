<?php

namespace App\FrontModule;

use Nette,
    App\Model,
    App\Settings,
    Nette\Application\UI\Form,
    Nette\Mail\Message,
    Nette\Mail\SendmailMailer;

class KontaktPresenter extends BasePresenter
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    function createComponentEmailForm()
    {
        $form = new Form;
        $form->addText('name')
             ->setAttribute('id', 'name')
             ->setAttribute('class', 'text')
             ->addRule(Form::FILLED, 'Zadejte jméno');
        $form->addText('email')
            ->setAttribute('id', 'email')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte e-mailovou adresu')
            ->addRule(Form::EMAIL, 'E-mailová adresa není platná');
        $form->addTextarea('message')
            ->setAttribute('id', 'message')
            ->setAttribute('class', 'text')
            ->setAttribute('rows', '8')
            ->setAttribute('cols', '50')
            ->addRule(Form::FILLED, 'Zadejte text');
        $form->addSubmit('send')
            ->setAttribute('vale', 'Odeslat')
            ->setAttribute('class', 'sendit');
        $form->onSuccess[] = array($this, 'emailFormSucceeded');
        return $form;
    }

    public function emailFormSucceeded(Form $form, $values)
    {
        $settings = $this->EntityManager->getRepository(Settings::getClassName());
        $setting = $settings->find(1);

        $mail = new Message;
        $mail->setFrom($values['email'])
            ->addTo($setting->admin_email)
            ->setSubject('Zpráva z webu ByYou od '.$values['name'])
            ->setBody($values['message']);
        $mailer = new SendmailMailer;
        $mailer->send($mail);

        $this->redirect('Kontakt:odeslano');
    }
}