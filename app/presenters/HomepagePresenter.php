<?php

namespace App\Presenters;

use App\Article;
use Nette,
    App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    public function renderDefault()
    {
        $dao = $this->EntityManager->getRepository(Article::getClassName());
        $this->template->articles = $dao->findAll();
    }

}
