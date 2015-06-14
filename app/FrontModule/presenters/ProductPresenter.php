<?php

namespace App\FrontModule;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    App\Products,
    App\Settings,
    Nette\Mail\Message,
    Nette\Mail\SendmailMailer;

class ProductPresenter extends BasePresenter
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    /** @persistent */
    public $backlink = '';

    public function renderDefault()
    {
        $products = $this->EntityManager->getRepository(Products::getClassName());
        $this->template->products = $products->findAll();
    }

    public function renderPotvrzeni()
    {
        $products = $this->EntityManager->getRepository(Products::getClassName());
        $id = $this->getParameter('id');
        if (!empty($id)) {
            $product = $products->find($this->getParameter('id'));
            $this->template->product = $product;
            $this->template->pocet = $this->getParameter('pocet');
            $this->template->velikost = $this->getParameter('velikost');
        }
        else {
            $this->template->product = false;
        }
    }

    function createComponentPotvrzeniForm()
    {
        $countries = array(
            'CZ' => 'Česká Republika',
            'SK' => 'Slovensko',
        );

        $form = new Form;
        $form->addHidden('nazev');
        $form->addHidden('kusu');
        $form->addHidden('velikost');
        $form->addHidden('cena');
        $form->addSubmit('send')
            ->setAttribute('class', 'productbutt');
        $form->addText('email')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte e-mailovou adresu')
            ->addRule(Form::EMAIL, 'E-mailová adresa není platná');
        $form->addText('jmeno')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte jméno');
        $form->addText('prijmeni')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte příjmení');
        $form->addSelect('stat', 'Stát:', $countries)
            ->setPrompt('Zvolte stát')
            ->addRule(Form::FILLED, 'Zvolte stát');
        $form->addText('ulice')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte ulici');
        $form->addText('mesto')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte Město');
        $form->addText('psc')
            ->setAttribute('class', 'text')
            ->addRule(Form::FILLED, 'Zadejte PSČ');
        $form->onSuccess[] = array($this, 'potvrzeniFormSucceeded');
        return $form;
    }

    public function potvrzeniFormSucceeded(Form $form, $values)
    {
        $settings = $this->EntityManager->getRepository(Settings::getClassName());
        $setting = $settings->find(1);

        $mail = new Message;
        $mail->setFrom($setting->admin_email)
            ->addTo($setting->admin_email)
            ->addTo($values['email'])
            ->setSubject('Informace o objednávce na webu ByYou')
            ->setHtmlBody('<h1>Objednávka '.$values['nazev'].'</h1>
            <strong>Velikost:</strong> '.$values['velikost'].'<br>
            <strong>Počet:</strong> '.$values['kusu'].'<br>
            <strong>Celková cena:</strong> '.$values['cena'].' Kč<br>
            <h2>Kontaktní údaje:</h2>
            <strong>Jméno:</strong> '.$values['jmeno'].'<br>
            <strong>Příjmení:</strong> '.$values['prijmeni'].'<br>
            <strong>E-Mail:</strong> '.$values['email'].'<br>
            <strong>Stát:</strong> '.$values['stat'].'<br>
            <strong>Ulice a č. p.:</strong> '.$values['ulice'].'<br>
            <strong>Město:</strong> '.$values['mesto'].'<br>
            <strong>PSČ:</strong> '.$values['psc'].'<br>
            <hr><br><strong>Děkujeme za Vaši objedávku. Ozveme se Vám brzo!</strong>
            ');
        $mailer = new SendmailMailer;
        $mailer->send($mail);

        $this->redirect('Product:objednano');
    }

    function createComponentProductForm()
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('kusu')
            ->addRule(Form::FILLED, 'Musíte zadat počet kusů!')
            ->addRule(Form::INTEGER, 'Počet kusů musí být celé číslo!')
            ->addRule(Form::RANGE, "Počet kusů musí být kladné číslo!", array(0, null));
        $form->addText('velikost')
            ->addRule(Form::FILLED, 'Musíte zadat velikost!');
        $form->addSubmit('send')
            ->setAttribute('value', 'Koupit')
            ->setAttribute('class', 'productbutt');
        $form->onSuccess[] = array($this, 'productFormSucceeded');
        return $form;
    }

    public function productFormSucceeded(Form $form, $values)
    {
        $this->redirect('Product:potvrzeni', array('id' => $values['id'], 'pocet' => $values['kusu'], 'velikost' => $values['velikost']));
    }
}