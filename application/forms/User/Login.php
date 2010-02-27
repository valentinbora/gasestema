<?php

class Gasestema_Form_User_Login extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'login');
        
        $this->setDecorators(
            array(
                'FormElements',
                array('HtmlTag', array('tag' => 'ul')),
                'Form',
            )
        );
        
        $email = $this->createElement('text', 'email')
            ->setLabel('Email')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator('EmailAddress')
            ->setDecorators(
                array(
                    'Label',
                    'ViewHelper',
                    'Errors',
                    array('HtmlTag', array('tag' => 'li'))
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
                    'Errors',
                    array('HtmlTag', array('tag' => 'li'))
                )
            );;
            
        $submit = $this->createElement('submit', 'submit')
            ->setLabel('Login')
            ->setDecorators(
                array(
                    'ViewHelper',
                    'Errors',
                    array('HtmlTag', array('tag' => 'li'))
                )
            );
        
        $this->addElements(array($email, $password, $submit));
    }
}