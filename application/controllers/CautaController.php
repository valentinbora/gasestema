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
			if (Zend_Auth::getInstance()->hasIdentity()) {
				$listaLocalitati[] = Zend_Auth::getInstance()->getIdentity()->Localitate->id;
			}
			
		}
		return $listaLocalitati;
	}
	protected function _cautaObiecteFullText($searchQuery){
		$where = 'MATCH(nume,descriere) AGAINST ("'.stripslashes($searchQuery).'"IN BOOLEAN MODE)';
		$q = Doctrine_Query::create()->select('o.id,('.$where.') r')
	    ->from('ObiectNume o')->where($where);
		
		$numeObiecte = $q->execute();
		
		$ListaObiecte = array();
		foreach($numeObiecte as $numeObiect) {
			// $ListaObiecte[]=array('id'=>$numeObiect->id,
			// 					   'relevance'=>$numeObiect->r);
			$ListaObiecte[] = $numeObiect->id;
	    }
		
		return $ListaObiecte;	
		
	}
	protected function _cautaTagsFullText($searchQuery){
		$where = 'MATCH(nume) AGAINST("'.stripslashes($searchQuery).'"IN BOOLEAN MODE)';
		$q = Doctrine_Query::create()->select('t.id,('.$where.') r')
	    ->from('Tag t')->where($where);
		
		$tags = $q->execute();
		//dd($tags->toArray());
		$listaTags = array();
		foreach($tags as $tag) {
			 $listaTags[]=array('id'=>$tag->id,	
			 					'relevance' =>$tag->r); 
			 	
			
	    }
		
		return $listaTags;	
		
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
	
		
		//print_r($this->_cautaTagsFullText($searchQuery));
		
		$q = Doctrine_Query::create()->from('Obiect o')->where('o.nume in ("'.implode('","',$ListaObiecte).'")');
		if (count($listaLocalitati)>0){
			
			$q->andWhere('o.localitate in ("'.implode('","',$listaLocalitati).'")');
		}
		$obiecte = $q;
		
	    $this->view->searchQuery = $searchQuery;
		
		
		$this->view->paginator = new Zend_Paginator(
			new Gasestema_Paginator_Adapter($obiecte));

		$this->view->paginator->setCurrentPageNumber($pageNumber)
		    ->setItemCountPerPage($perPage);
	}
}

