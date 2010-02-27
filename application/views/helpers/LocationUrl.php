<?php

class Zend_View_Helper_LocationUrl extends Zend_View_Helper_Abstract
{
    public function locationUrl($location)
    {
        $title = preg_replace('/[^a-zA-Z0-9\-]*/', '', $location->nume);
        $title = preg_replace('/[\ ] +/', '-', $title);
        $title .= '-' . $location->id;
        
        return $this->view->baseUrl('/locatie/' . $title);
    }
}