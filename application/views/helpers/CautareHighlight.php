<?php

class Zend_View_Helper_CautareHighlight extends Zend_View_Helper_Abstract
{
    public function cautareHighlight($words,$text)
    {
        $title = preg_replace('/[^a-zA-Z0-9\-]*/', '', $location->nume);
        $title = preg_replace('/[\ ] +/', '-', $title);
        $title .= '-' . $location->id;
        
        #return $this->view->baseUrl('/locatie/' . $title);
        foreach($words as $word){
        	$text = str_ireplace($word, "<em>".$word."</em>", $text);	
        }
         
        return $text;
    }
}