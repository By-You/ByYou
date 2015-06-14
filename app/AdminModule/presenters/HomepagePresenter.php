<?php

namespace App\AdminModule;

use Nette,
    App\Model;

class HomepagePresenter extends SecurePresenter
{
    public function actionOut()
    {
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné.');
        $this->redirect('Login:');
    }
}