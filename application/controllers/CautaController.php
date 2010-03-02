<?php 
class CautaController extends Zend_Controller_Action {
    //private $searchType = "IN NATURAL LANGUAGE MODE";
      private $searchType = "";
    //private $searchType = "IN BOOLEAN MODE";
    //private $searchType = "IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION";
    //private $searchType = "WITH QUERY EXPANSION";
    private $perPage = 10;
    
    public function init() {
        /* Initialize action controller here */
    }
    
    /*
     *
     * cauta orase in cuvintele de cautare
     *
     */
    protected function _parseLocalitate($words) {
    
        $q = Doctrine_Query::create()
					->select('l.id')
					->from('Localitate l')
					->where('l.name in ("'.implode('","', $words).'")');
        
        $localitati = $q->execute();
        
        // localitati gasite in cautare
        $listaLocalitati = array();
        
        foreach ($localitati as $localitate) {
            $listaLocalitati[] = $localitate->id;
        }
        if (count($localitati) == 0) {
            if (Zend_Auth::getInstance()->hasIdentity()) {
                $listaLocalitati[] = Zend_Auth::getInstance()->getIdentity()->Localitate->id;
            }
            
        }
        return $listaLocalitati;
    }
    protected function _cautaObiecteFullText($searchQuery) {
        $where = 'MATCH(nume,descriere) AGAINST ("'.stripslashes($searchQuery).'"'.$this->searchType.')';
        $q = Doctrine_Query::create()
				->select('o.id,('.$where.') r')
				->from('ObiectNume o')
				->where($where);
				
        //print $q->getSqlQuery();
        $numeObiecte = $q->execute();
        
        $ListaObiecte = array();
        foreach ($numeObiecte as $numeObiect) {
            $ListaObiecte[] = array('id'=>$numeObiect->id, 'relevance'=>$numeObiect->r);
        }
        
        return $ListaObiecte;
        
    }
    protected function _cautaTagsFullText($searchQuery) {
        $where = 'MATCH(nume) AGAINST("'.stripslashes($searchQuery).'"'.$this->searchType.')';
        $q = Doctrine_Query::create()
					->select('t.id,('.$where.') r')
					->from('Tag t')
					->where($where);
        
        $tags = $q->execute();
        //dd($tags->toArray());
        $listaNumeDupaTags = array();
        foreach ($tags as $tag) {
        
            foreach ($tag->TagObiect as $tagObject) {
                $listaNumeDupaTags[] = array('id'=>$tagObject->Obiect->nume, 'relevance'=>$tag->r);
            }
        }
        
        return $listaNumeDupaTags;
        
    }
    
    public function indexAction() {
    	
        $diacriticeRaw=array("\xc4\x82","\xc4\x83","\xc3\x82","\xc3\xa2","\xc3\x8e","\xc3\xae","\xc8\x98","\xc8\x99","\xc8\x9a","\xc8\x9b");
		$diacriticeTransliterate = array('A','a','A','a','I','i',"S","s","T","t");
		
		
		$searchQuery = trim($this->getRequest()->getParam('q'));
        $pageNumber = (int) $this->getRequest()->getParam('page');
		
		//transliteratie
		$searchQuery = str_replace($diacriticeRaw, $diacriticeTransliterate, $searchQuery);
		// comasat spatii, transliteratie si sanitizare
		$searchQuery = preg_replace('/\\s+/', " ", $searchQuery);//comasam spatiile
		$searchQuery = str_replace("\\","",$searchQuery);
		$searchQuery = preg_replace('/[^a-zA-z0-9-+ ]*/', "", $searchQuery);//sanitizam
		
		
        $words = preg_split('/(\s|,)/', $searchQuery);
		//dd($words);
	         
        // get info
        $listaLocalitati = $this->_parseLocalitate($words);
        $ListaObiecte = $this->_cautaObiecteFullText($searchQuery);
        $listaNumeObiecteDupaTags = $this->_cautaTagsFullText($searchQuery);

        
        // compute relevance
        $listaNume = array();
        
        $max = 0;
        
        foreach ($ListaObiecte as $obiect) {
            $listaNume[$obiect['id']] = (float) $obiect['relevance'];
            
            if ($listaNume[$obiect['id']] > $max) {
                $max = $listaNume[$obiect['id']];
            }
            
        }
        $pondereTags = 0.5;
        foreach ($listaNumeObiecteDupaTags as $obiect) {
            if (isset($listaNume[$obiect['id']])) {
                $listaNume[$obiect['id']] += $pondereTags * (float) $obiect['relevance'];
            } else {
                $listaNume[$obiect['id']] = $pondereTags * (float) $obiect['relevance'];
            }
            
            if ($listaNume[$obiect['id']] > $max) {
                $max = $listaNume[$obiect['id']];
            }
        }
        
        // normalize relevance

        
        $listaNumeNormalizata = array();
        foreach ($listaNume as $id=>$obiect) {
            $listaNumeNormalizata[$id] = floor($obiect / $max * 100);
            
        }
        asort($listaNume);
        #print_r($listaNume);
        $listaIdNume = array_keys($listaNumeNormalizata);
        $q = Doctrine_Query::create()
					->select('o.localitate,o.locatie')
					->from('Obiect o')
					->where('o.nume in ("'.implode('","', $listaIdNume).'")')
					->orderBy('FIELD(nume,"'.implode('","', $listaIdNume).'")');
					
        //print $q->getSqlQuery();
        if (count($listaLocalitati) > 0) {
        
            $q->andWhere('o.localitate in ("'.implode('","', $listaLocalitati).'")');
        }
        $obiecte = $q;
        
        if ($pageNumber == 0)
            $pageNumber = 1;
        $this->view->searchWords = $words;
        $this->view->searchQuery = $searchQuery;
        $this->view->listaRelevante = $listaNumeNormalizata;
        $this->view->perPage = $this->perPage;
        $this->view->pageNumber = $pageNumber;
        $this->view->paginator = new Zend_Paginator( new Gasestema_Paginator_Adapter($obiecte));
        
		
        $this->view->paginator->setCurrentPageNumber($pageNumber)->setItemCountPerPage($this->perPage);
		
		$localitatiUnice =array();
		$locatiiUnice =array();
		foreach ($this->view->paginator as $obiect){
			if (!isset($localitatiUnice[$obiect->localitate])){
				$localitatiUnice[$obiect->localitate] = array('name' => $obiect->Localitate->name,'nr'=>1); 
			}else{
				$localitatiUnice[$obiect->localitate]['nr']+=1;
			}
			if (!isset($locatiiUnice[$obiect->locatie])){
				$locatiiUnice[$obiect->locatie] = array('name' => $obiect->Locatie->nume,'nr'=>1); 
			}else {
				$locatiiUnice[$obiect->locatie]['nr']+=1;
			}
		}
		
		$this->view->localitatiUnice = $localitatiUnice;
		$this->view->locatiiUnice = $locatiiUnice;
		
		
    }
}

