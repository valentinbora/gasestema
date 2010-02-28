<?php

class Gasestema_Plugin_Gasestema extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer'); 
        $viewRenderer->view->user = Zend_Auth::getInstance()->getIdentity();
    }
}