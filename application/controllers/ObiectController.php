<?php

class ObiectController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $obiect = $this->getRequest()->getParam('action');
        $id = explode("-", $obiect);
        $id = end($id);
        
        $obiect = Doctrine_Core::getTable('Obiect')->findOneById($id);
        
        $this->view->obiect = $obiect;
    }

    public function __call($method, $params)
    {
        $this->_forward('index');
    }
}

