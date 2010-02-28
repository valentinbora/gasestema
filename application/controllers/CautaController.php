<?php

class CautaController extends Zend_Controller_Action
{
	//private $searchType = "IN NATURAL LANGUAGE MODE";
	private $searchType = "IN BOOLEAN MODE";
	//private $searchType = "IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION";
	//private $searchType = "WITH QUERY EXPANSION";

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
		$where = 'MATCH(nume,descriere) AGAINST ("'.stripslashes($searchQuery).'"'.$this->searchType.')';
		$q = Doctrine_Query::create()->select('o.id,('.$where.') r')
	    ->from('ObiectNume o')->where($where);
		
		$numeObiecte = $q->execute();
		
		$ListaObiecte = array();
		foreach($numeObiecte as $numeObiect) {
			 $ListaObiecte[]=array('id'=>$numeObiect->id,
			 					   'relevance'=>$numeObiect->r);
			//$ListaObiecte[] = $numeObiect->id;
	    }
		
		return $ListaObiecte;	
		
	}
	protected function _cautaTagsFullText($searchQuery){
		$where = 'MATCH(nume) AGAINST("'.stripslashes($searchQuery).'"'.$this->searchType.')';
		$q = Doctrine_Query::create()->select('t.id,('.$where.') r')
	    ->from('Tag t')->where($where);
		
		$tags = $q->execute();
		//dd($tags->toArray());
		$listaNumeDupaTags = array();
		foreach($tags as $tag) {
			 	
			foreach($tag->TagObiect as $tagObject){
				 //print $tagObject->Obiect->nume.'<br/>';	
				 $listaNumeDupaTags[]=array('id'=>$tagObject->Obiect->nume,	
				 					'relevance' =>$tag->r); 
			}
	    }
		
		return $listaNumeDupaTags;	
		
	}
	
    public function indexAction()
    {
		 
		$perPage = 10;
		$searchQuery = $this->getRequest()->getParam('q');
		$pageNumber = (int)$this->getRequest()->getParam('page');
		$words = preg_split('/(\s)/', $searchQuery);
		
		
		// get info
		$listaLocalitati = $this->_parseLocalitate($words);
		$ListaObiecte = $this->_cautaObiecteFullText($searchQuery);
		$listaNumeObiecteDupaTags =  $this->_cautaTagsFullText($searchQuery);
		
		
		// compute relevance
		$listaNume = array();

		$max = 0;
		
		foreach($ListaObiecte as $obiect){
			$listaNume[$obiect['id']] = (float)$obiect['relevance'];

			if ($listaNume[$obiect['id']] > $max){
				$max =  $listaNume[$obiect['id']];
			}
 
		}

		foreach($listaNumeObiecteDupaTags as $obiect){
			if (isset($listaNume[$obiect['id']])){
				$listaNume[$obiect['id']] += (float)$obiect['relevance'];
			}else {
				$listaNume[$obiect['id']] = (float)$obiect['relevance'];
			}
			
			if ($listaNume[$obiect['id']] > $max){
				$max =  $listaNume[$obiect['id']];
			}
		}
		// normalize relevance
		
		
		$listaNumeNormalizata = array();
		foreach($listaNume as $id=>$obiect){
			$listaNumeNormalizata[$id]=(int)($obiect/$max*100);

		}
		asort($listaNume);
		
		$listaIdNume = array_keys($listaNumeNormalizata);
		$q = Doctrine_Query::create()->from('Obiect o')->where('o.nume in ("'.implode('","',$listaIdNume).'")');
		if (count($listaLocalitati)>0){
			
			$q->andWhere('o.localitate in ("'.implode('","',$listaLocalitati).'")');
		}
		$obiecte = $q;
		
		
		$this->view->searchWords = $words;
	    $this->view->searchQuery = $searchQuery;
		$this->view->listaRelevante = $listaNumeNormalizata; 
		
		
		$this->view->paginator = new Zend_Paginator(
			new Gasestema_Paginator_Adapter($obiecte));

		$this->view->paginator->setCurrentPageNumber($pageNumber)
		    ->setItemCountPerPage($perPage);
	}
}

