<?php

namespace App\AdminModule;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    App\Pages;

class ContentPresenter extends SecurePresenter
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    public function renderDefault()
    {

    }

    public function actionMain()
    {
        $pages = $this->EntityManager->getRepository(Pages::getClassName());
        $page = $pages->find(1);
        $this->template->pages = $page->text;
        $this->template->pageId = $page->id;
    }

    public function actionAbout()
    {
        $pages = $this->EntityManager->getRepository(Pages::getClassName());
        $page = $pages->find(2);
        $this->template->pages = $page->text;
        $this->template->pageId = $page->id;
    }

    function createComponentEditForm()
    {
        $form = new Form;
        $form->addTextarea('content')
            ->setAttribute('id', 'input')
            ->setValue($this->template->pages);
        $form->addButton('send')
            ->setAttribute('value', 'Uložit')
            ->setAttribute('class', 'add')
            ->setAttribute('type', 'submit');
        $form->onSuccess[] = array($this, 'editFormSucceeded');
        return $form;
    }

    public function editFormSucceeded(Form $form, $values)
    {
        $pages = $this->EntityManager->getRepository(Pages::getClassName());

        $page = $pages->findOneBy(["id" => $this->template->pageId]);
        $page->text = $values['content'];

        $this->EntityManager->flush();
    }
}