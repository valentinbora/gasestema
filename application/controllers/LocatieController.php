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
        
        $obiecte = Doctrine_Query::create()
            ->from('Obiect o')
            ->where('o.locatie = ?', $id)
            ->leftJoin('o.ObiectNume')
            ->execute();
            
        $this->view->locatie = $locatie;
        $this->view->obiecte = $obiecte;
    }

    public function adaugaAction()
    {
        if (empty($this->view->user)) {
            throw new Exception("You have to be logged in to post a new location.");
        }
        
        $form = new Gasestema_Form_Locatie_Adauga;
        
        if ($this->getRequest()->isPost()) {
            if (!count($form->getErrorMessages($_POST))) {
                $this->_processLocationAdd($form);
            }
        }
        
        $this->view->form = $form;
    }
    
    /**
     * Process location add form
     *
     * @param string $form 
     * 
     * @todo Receive logo file and process it
     * @return void
     * @author Valentin Bora
     */
    private function _processLocationAdd($form) {
        $values = $form->getValues();
        
        // Check for location info
        if (empty($values['address']) && empty($values['link']) && empty($values['lat'])) {
            $this->view->locationError = 1;
            return;
        }
    }

    public function __call($method, $params)
    {
        $this->_forward('index');
    }
}