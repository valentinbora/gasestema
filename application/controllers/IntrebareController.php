<?php

class IntrebareController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $intrebari = Doctrine_Query::create()
            ->from("Intrebare")
            ->orderBy("added desc")
            ->execute();
        
        $this->view->intrebari = $intrebari;
    }

    public function adaugaAction()
    {
        if (empty($this->view->user)) {
            throw new Exception("You have to be logged in to post a new question.");
        }
        
        $form = new Gasestema_Form_Intrebare_Adauga;
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                Intrebare::addNew($form->getValues());
                $this->view->success = 1;
            } else {
                $form->populate($form->getValues());
            }
        }
        
        $this->view->form = $form;
    }
}



