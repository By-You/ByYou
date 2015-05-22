<?php

namespace App\AdminModule;

use Nette,
    App\Model;
use App\Login;

class DoctrinePresenter extends SecurePresenter
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    public function renderDefault()
    {
        $dao = $this->EntityManager->getRepository(Login::getClassName());
        $this->template->articles = $dao->findAll();

        //$article = new Article();
        //$article->title = "The Tigger Movie";

        //$entityManager->persist($article);
        //$entityManager->flush();
    }
}