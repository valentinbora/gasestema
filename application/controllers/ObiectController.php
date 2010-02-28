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
	
    public function adaugaAction()
    {
       	if (empty($this->view->user)) {
            throw new Exception("You have to be logged in to post a new location.");
        }
        
        $form = new Gasestema_Form_Obiect_Adauga;
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $this->_processObiectAdd($form);
            } else {
               // dd($form->getErrors());
            }
        }
        
        $this->view->form = $form; 
    }	
	
	private function _processObiectAdd($form) {
        $values = $form->getValues();
        
        
		
		print_r($values);
		
		
    }

    public function __call($method, $params)
    {
        $this->_forward('index');
    }
}

