<?php

namespace App\AdminModule;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    App\Products;

class ProductsPresenter extends SecurePresenter
{
    /**
     * @persistent
     * @var int
     */
    public $id;

    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    public function renderDefault()
    {

    }

    public function actionList()
    {
        $products = $this->EntityManager->getRepository(Products::getClassName());
        $product = $products->findAll();
        $this->template->products = $product;
    }

    public function actionDelete()
    {
        $id = $this->getParameter('id');
        $products = $this->EntityManager->getRepository(Products::getClassName());
        $product = $products->find($id);
        $this->EntityManager->remove($product);
        $this->EntityManager->flush();

        $this->redirect('Products:list');
    }

    public function actionEdit()
    {
        $id = $this->getParameter('id');
        $products = $this->EntityManager->getRepository(Products::getClassName());
        $product = $products->find($id);
        $this->template->product = $product;
    }

    function createComponentProductForm()
    {
        $default = '1';

        if ($this->getAction() == 'edit') {
            $id = $this->getParameter('id');
            $products = $this->EntityManager->getRepository(Products::getClassName());
            $product = $products->find($id);
            if ($product->velikost == 0) {
                $default = '0';
            }
        }

        $velikost = array(
            '1' => 'Určuje se',
            '0' => 'Neurčuje se',
        );

        $form = new Form;
        $form->addText('name')
            ->addRule(Form::FILLED, 'Musíte zadat název!');
        $form->addText('price')
            ->addRule(Form::FILLED, 'Musíte zadat cenu!')
            ->addRule(Form::FLOAT, 'Cena musí být číslo!')
            ->addRule(Form::RANGE, "Cena musí být kladné číslo!", array(0, null));
        $form->addRadioList('velikost', 'cc', $velikost)
            ->getSeparatorPrototype()->setName(NULL);
        $form['velikost']->setDefaultValue($default);

        if ($this->getAction() == 'add') {
            $form->addUpload('img', '')
                ->addRule(Form::FILLED, 'Musíte zvolit obrázek!')
                ->addRule(Form::IMAGE, 'Obrázek musí být JPEG, PNG nebo GIF.');
        }

        $form->addSubmit('send');
        $form->onSuccess[] = array($this, 'productFormSucceeded');
        return $form;
    }

    public function productFormSucceeded(Form $form, $values)
    {
        if ($this->getAction() == 'edit') {
            $products = $this->EntityManager->getRepository(Products::getClassName());

            $product = $products->findOneBy(["id" => $this->getParameter('id')]);
            $product->nazev = $values['name'];
            $product->cena = $values['price'];
            $product->velikost = $values['velikost'];

            $this->EntityManager->flush();
        }
        elseif ($this->getAction() == 'add') {
            $product = new Products;
            $product->nazev = $values['name'];
            $product->cena = $values['price'];
            $product->velikost = $values['velikost'];
            $this->EntityManager->persist($product);
            $this->EntityManager->flush();
            $productID = $product->getId();

            move_uploaded_file($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] .'/www/images/products/'.$productID.'.jpg');
        }

        $this->redirect('Products:list');
    }
}