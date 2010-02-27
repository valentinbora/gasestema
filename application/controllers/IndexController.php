<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function indexAction()
    {
        // action body
		$this->view->searchQuery = "";
    }


}

