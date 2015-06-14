<?php
namespace App\FrontModule;

use Nette,
    App\Model,
    App\Pages;

class HomepagePresenter extends BasePresenter
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    public function renderDefault()
    {
        $pages = $this->EntityManager->getRepository(Pages::getClassName());
        $page = $pages->find(1);
        $this->template->pages = $page->text;
    }
}