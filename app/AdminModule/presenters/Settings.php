<?php

namespace App\AdminModule;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    App\Settings;

class SettingsPresenter extends SecurePresenter
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    public function renderDefault()
    {
        $settings = $this->EntityManager->getRepository(Settings::getClassName());
        $setting = $settings->find(1);
        $this->template->settings = $setting;
    }

    function createComponentSettingsForm()
    {
        $form = new Form;
        $form->addText('oldpass')
            ->addRule(Form::FILLED, 'Musíte zadat heslo!');
        $form->addText('npass1');
        $form->addText('npass2')
            ->addRule(Form::EQUAL, 'Zadaná nová hesla se neshodují!', $form['npass1']);
        $form->addText('email')
            ->addRule(Form::FILLED, 'Musíte zadat email!')
            ->addRule(Form::EMAIL, 'Zadaný email nemá validní tvar!');
        $form->addSubmit('send');
        $form->onSuccess[] = array($this, 'settingsFormSucceeded');
        return $form;
    }

    public function settingsFormSucceeded(Form $form, $values)
    {
        $settings = $this->EntityManager->getRepository(Settings::getClassName());
        $setting = $settings->find(1);

        if ($setting->admin_pass == md5($values['oldpass'])) {
            if($values['npass1'] != '') {
                $setting->admin_pass = md5($values['npass1']);
            }
            $setting->admin_email = $values['email'];
            $this->EntityManager->flush();
        }
        else {
            $form->addError('Špatně zadané aktuální heslo!');
        }
    }
}