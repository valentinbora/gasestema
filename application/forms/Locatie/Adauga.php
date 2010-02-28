<?php

class Gasestema_Form_Locatie_Adauga extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'adauga')
            ->setAttrib('enctype', 'multipart/form-data');
        
        $name = $this->createElement('text', 'name')
            ->setLabel('Name')
            ->setRequired(true)
            ->addFilter('StringTrim');

        $address = $this->createElement('text', 'address')
            ->setLabel('Address')
            ->addFilter('StringTrim');
            
        $link = $this->createElement('text', 'link')
            ->setLabel('Web link')
            ->addFilter('StringTrim');
            
        $lat = $this->createElement('hidden', 'lat')
            ->addFilter('StringTrim');
            
        $long = $this->createElement('hidden', 'long')
            ->addFilter('StringTrim');
            
        $contact = $this->createElement('text', 'contact')
            ->setLabel('Contact info')
            ->addFilter('StringTrim');
            
        $description = $this->createElement('textarea', 'description')
            ->setLabel('Description')
            ->addFilter('StringTrim');
            
        $schedule = $this->createElement('text', 'schedule')
            ->setLabel('Schedule')
            ->addFilter('StringTrim');
            
        $logo = $this->createElement('file', 'logo')
            ->setLabel('Logo:')
            ->addFilter('Rename', '/tmp')
            ->addValidator('Size', false, 102400);
                    
        $submit = $this->createElement('submit', 'submit')
            ->setLabel('Add')
            ->setAttrib('class', 'location-submit')
            ->setDecorators(
                array(
                    'ViewHelper',
                    'Errors'
                )
            );
        
        $this->addElements(array($name, $address, $link, $lat, $long, $contact, $description, $schedule, $logo, $submit));
        
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
            array('Label', array('tag' => 'td')),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        ), array('name', 'address', 'link', 'contact', 'description', 'schedule'));
    }
}