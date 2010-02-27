<?php

class Gasestema_Form_Locatie_Adauga extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'adauga');
        
        $name = $this->createElement('text', 'name')
            ->setLabel('Name')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->setDecorators(
                array(
                    'Label',
                    'ViewHelper',
                    'Errors'
                )
            );
    
        $address = $this->createElement('text', 'address')
            ->setLabel('Address')
            ->addFilter('StringTrim')
            ->setDecorators(
                array(
                    'Label',
                    'ViewHelper',
                    'Errors'
                )
            );
            
        $link = $this->createElement('text', 'link')
            ->setLabel('Link')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->setDecorators(
                array(
                    'Label',
                    'ViewHelper',
                    'Errors'
                )
            );
            
        $lat = $this->createElement('hidden', 'lat')
            ->addFilter('StringTrim')
            ->setDecorators(
                array(
                    'Label',
                    'ViewHelper'
                )
            );
            
        $long = $this->createElement('hidden', 'long')
            ->addFilter('StringTrim')
            ->setDecorators(
                array(
                    'Label',
                    'ViewHelper'
                )
            );
            
        $contact = $this->createElement('text', 'contact')
            ->setLabel('Contact:')
            ->addFilter('StringTrim');
            
        $description = $this->createElement('textarea', 'description')
            ->setLabel('Description:')
            ->addFilter('StringTrim');
            
        $schedule = $this->createElement('text', 'schedule')
            ->setLabel('Description:')
            ->addFilter('StringTrim');
            
        $logo = $this->createElement('file', 'logo')
            ->setLabel('Logo:');
            
        $submit = $this->createElement('submit', 'submit')
            ->setLabel('Add')
            ->setDecorators(
                array(
                    'ViewHelper',
                    'Errors'
                )
            );
        
        $this->addElements(array($name, $address, $link, $lat, $long, $contact, $description, $schedule, $logo, $submit));
    }
}