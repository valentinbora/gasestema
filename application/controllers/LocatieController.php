<?php

class LocatieController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function indexAction()
    {
        $locatie = $this->getRequest()->getParam('action');
        $id = explode("-", $locatie);
        $id = end($id);
        
        $locatie = Doctrine_Core::getTable('Locatie')->findOneById($id);
        $this->view->locatie = $locatie;
    }

    public function adaugaAction()
    {
        $form = new Gasestema_Form_Locatie_Adauga;
        
        $this->view->form = $form;
    }

    public function __call($method, $params)
    {
        $this->_forward('index');
    }
}