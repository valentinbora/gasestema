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
                
                try {
                    User::login($values['email'], $values['password']);
                    $this->_redirect('/');
                } catch (Exception $e) {
                    $this->view->message = $this->view->translate($e->getMessage());
                }
            }
        }
        
        $this->view->form = $form;
    }
    
    public function loginAjaxAction()
    {
        Zend_Layout::getMvcInstance()->disableLayout();
        
        try {
            User::login($_POST['email'], $_POST['password']);
            echo 1;
        } catch (Exception $e) {
            echo 0;
        }
        
        die();
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }

    public function registerAction()
    {
        // action body
    }


}







