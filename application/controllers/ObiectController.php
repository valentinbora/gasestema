<?php

class ObiectController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $obiect = $this->getRequest()->getParam('action');
        $id = explode("-", $obiect);
        $id = end($id);
        
        $obiect = Doctrine_Core::getTable('Obiect')->findOneById($id);
        
        $this->view->obiect = $obiect;
    }
	
    public function adaugaAction()
    {
       	if (empty($this->view->user)) {
            throw new Exception("You have to be logged in to post a new location.");
        }
        
        $form = new Gasestema_Form_Obiect_Adauga;
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $this->_processObiectAdd($form);
            } else {
               // dd($form->getErrors());
            }
        }
        
        $this->view->form = $form; 
    }	
	
	private function _processObiectAdd($form) {
        $values = $form->getValues();
        
        $name = $values["name"];
		$descriere = $values["description"];
		
		$locatie = $values["locatie"];
		$rawLocatieId = $values["locatie_id"];
		
		$tagsRaw = split(",",$values["tags"]);

		$localitateId = $this->view->user->Localitate->id;//oras
		
		$tags = array();
		foreach($tagsRaw as $tag){
			$tags[] = trim($tag);
		}
		$locatieId = $this->_verifyLocatie($rawLocatieId,$locatie);
		$numeId = $this->_insertObiectNume($name,$descriere);
		
		$obiect = new Obiect;
		$obiect->nume = $numeId;
		$obiect->localitate = $localitateId;//oras
		$obiect->locatie = $locatieId;
		$obiect->user = $this->view->user->id;
		$obiect->adaugat = time();
		$obiect->save();
		
		$objectId = $obiect->id;
		$this->_insertTags($objectId,$tags);
				
    }
	
	private function _verifyLocatie($id,$name){
		//verifi the location
		return 2;
	}
	private function _insertObiectNume($nume,$descriere){
		/* search for name and return id, if not insert and return id */
		$result = Doctrine_Core::getTable('ObiectNume')->findOneByNumeAndDescriere($nume,$descriere);
		if ($result){
			return $result->id; 
		}else {
			$obiectNume = new ObiectNume;
			$obiectNume->nume = $nume;
			$obiectNume->descriere = $descriere;
			$obiectNume->save();
			
			return $obiectNume->id;
			
		}
		
		
	}
	private function _insertTagObiect($obiectId,$tagId){
		
		$tagObiectObj = new TagObiect;
		$tagObiectObj->obiect = $obiectId;
		$tagObiectObj->tag = $tagId;
		$tagObiectObj->save();
		
	}
	private function _insertTags($objectId,$tags){
		
		/*
		 * search for tags in Tags table then link them to tags_object
		 */
		$tagObj = Doctrine_Core::getTable('Tag');
		
		foreach($tags as $tag){
			$result = $tagObj->findOneByNume($tag);
			if ($result->id) {
				$this->_insertTagObiect($objectId,$result->id);
			}else {
				$newTagObj = new Tag;
				$newTagObj->nume = $tag;
				$newTagObj->save();
				
				$this->_insertTagObiect($objectId,$newTagObj->id);
			}
		}
		
	}
	

    public function __call($method, $params)
    {
        $this->_forward('index');
    }
}

