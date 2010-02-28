<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        Zend_Layout::getMvcInstance()->setLayout('home');
    }

    public function indexAction()
    {
        // action body
		$this->view->searchQuery = "";
    }


}

