<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        $form = new Gasestema_Form_User_Login;
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $values = $form->getValues();
                
                User::login($values['email'], $values['password']);
            }
        }
        
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        // action body
    }

    public function registerAction()
    {
        // action body
    }


}







