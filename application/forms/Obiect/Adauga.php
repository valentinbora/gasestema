<?php

class Gasestema_Form_Obiect_Adauga extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'adauga')
            ->setAttrib('enctype', 'multipart/form-data');
        $nameValidator  = new Zend_Validate_Callback(array('Gasestema_Form_Obiect_Adauga','verifyName'));
		$nameValidator->setMessage('Name has to be unique. Try something more specific.');
        $name = $this->createElement('text', 'name')
            ->setLabel('Name')
			->addValidator($nameValidator)
            ->setRequired(true)
            ->addFilter('StringTrim');
			
        $description = $this->createElement('textarea', 'description')
            ->setLabel('Description')
            ->addFilter('StringTrim');

        $tags = $this->createElement('text', 'tags')
            ->setLabel('Tags')
            ->addFilter('StringTrim');
        $locatie = $this->createElement('text', 'locatie')
            ->setLabel('Location')
            ->addFilter('StringTrim');
        $locatieId = $this->createElement('hidden', 'locatie_id')
            
            ->addFilter('int');
						
        $submit = $this->createElement('submit', 'submit')
            ->setLabel('Add')
            ->setAttrib('class', 'location-submit')
            ->setDecorators(
                array(
                    'ViewHelper',
                    'Errors'
                )
            );			
            
        $this->addElements(array($name,$description, $tags,$locatie,$locatieId,$submit));
        
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
            array('Label', array('tag' => 'td')),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        ), array('name' ,'description','tags'));
    }
	
	public static function verifyName($name){

		return !((bool)Doctrine_Core::getTable('ObiectNume')->findOneByNume($name));
			
	}
		
	
}