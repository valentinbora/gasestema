<?php

class Zend_View_Helper_LocationUrl extends Zend_View_Helper_Abstract
{
    public function locationUrl($location,$id = 0 )
    {
    	if( $id == 0 ) {
    		$nume = $location->nume;
			$id = $location->id;
    	}else {
    		//use id from param
			$nume= $location;
    	}
        $title = preg_replace('/[^a-zA-Z0-9\-]*/', '', $nume);
        $title = preg_replace('/[\ ] +/', '-', $title);
        $title .= '-' . $id;
        
        return $this->view->baseUrl('/locatie/' . $title);
    }
}