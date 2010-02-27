<?php

class Zend_View_Helper_ObjectUrl extends Zend_View_Helper_Abstract
{
    public function objectUrl($object)
    {
        $title = preg_replace('/[^a-zA-Z0-9\-]*/', '', $object->ObiectNume->nume);
        $title = preg_replace('/[\ ] +/', '-', $title);
        $title .= '-' . $object->id;
        
        return $this->view->baseUrl('/obiect/' . $title);
    }
}