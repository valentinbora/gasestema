<?php

class Gasestema_Form_User_Login extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'login');
        
        $this->removeDecorator('DtDd');
        
        $email = $this->createElement('text', 'email')
            ->setLabel('Email')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setDecorators(
                array(
                    'Label',
                    'ViewHelper',
                    'Errors'
                )
            );
            
        $password = $this->createElement('password', 'password')
            ->setLabel('Password')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setDecorators(
                array(
                    'Label',
                    'ViewHelper',
                    'Errors'
                )
            );;
            
        $submit = $this->createElement('submit', 'submit')
            ->setLabel('Login')
            ->setDecorators(
                array(
                    'ViewHelper',
                    'Errors'
                )
            );;
        
        $this->addElements(array($email, $password, $submit));
    }
}