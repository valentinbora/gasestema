<?php

class Gasestema_Form_User_Login extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'login');
        
        $email = $this->createElement('text', 'email')
            ->setLabel('Email')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
            
        $password = $this->createElement('password', 'password')
            ->setLabel('Password')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
            
        $submit = $this->createElement('submit', 'submit')
            ->setLabel('Login');
        
        $this->addElements(array($email, $password, $submit));
    }
}