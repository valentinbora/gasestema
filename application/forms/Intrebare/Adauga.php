<?php

class Gasestema_Form_Intrebare_Adauga extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'adauga');
        
        $question = $this->createElement('textarea', 'question')
            ->setLabel('Question')
            ->setRequired(true)
            ->addFilter('StringTrim');

        $location = $this->createElement('text', 'location')
            ->setLabel('Location')
            ->addFilter('StringTrim');
            
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $location->setValue(ucfirst($user->Localitate->name));
        }
            
        $submit = $this->createElement('submit', 'submit')
            ->setLabel('Ask')
            ->setAttrib('class', 'location-submit')
            ->setDecorators(
                array(
                    'ViewHelper',
                    'Errors'
                )
            );
        
        $this->addElements(array($question, $location, $submit));
        
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
            array('Label', array('tag' => 'td')),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        ), array('question', 'location'));
    }
}