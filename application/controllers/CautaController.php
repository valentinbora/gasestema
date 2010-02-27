<?php

class CautaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
	
	/*
	 * 
	 * cauta orase in cuvintele de cautare
	 * 
	 */
	protected function _parseLocalitate($words){
		
		$q = Doctrine_Query::create()->select('l.id')
	    ->from('Localitate l')->where('l.name in ("'.implode('","',$words).'")');
		
		$localitati = $q->execute();
		
		// localitati gasite in cautare
		$listaLocalitati = array();
		
		foreach($localitati as $localitate) {
			$listaLocalitati[] = $localitate->id;	
	    }
		if (count($localitati)==0) {
			if ((int)Zend_Auth::getInstance()->getIdentity()->Localitate->id>0){
				$listaLocalitati[] = Zend_Auth::getInstance()->getIdentity()->Localitate->id;
			}
			
		}
		return $listaLocalitati;
	}
	protected function _cautaObiecteFullText($searchQuery){
		$q = Doctrine_Query::create()->select('o.id')
	    ->from('ObiectNume o')->where('MATCH(nume) AGAINST ("'.stripslashes($searchQuery).'"IN BOOLEAN MODE)');
		
		$numeObiecte = $q->execute();
		
		$ListaObiecte = array();
		foreach($numeObiecte as $numeObiect) {
			 $ListaObiecte[]=$numeObiect->id;
	    }
		
		return $ListaObiecte;	
		
	}
    public function indexAction()
    {
		
		 
		$perPage = 10;
		$searchQuery = $this->getRequest()->getParam('q');
		$pageNumber = (int)$this->getRequest()->getParam('page');
		$words = preg_split('/(\s)/', $searchQuery);
		
		$this->view->searchWords = $words;

		$listaLocalitati = $this->_parseLocalitate($words);
		
		$ListaObiecte = $this->_cautaObiecteFullText($searchQuery);
		//($ListaObiecte);
		
		$q = Doctrine_Query::create()->from('Obiect o')->where('o.nume in ("'.implode('","',$ListaObiecte).'")');
		if (count($listaLocalitati)>0){
			
			$q->andWhere('o.localitate in ("'.implode('","',$listaLocalitati).'")');
		}
		$obiecte = $q->execute();
		
		
		$this->view->searchQuery = $searchQuery;
		$this->view->obiecte = $obiecte;

		
	}


}

