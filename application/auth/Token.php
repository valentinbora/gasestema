<?php

class Mykea_Auth_Token implements Zend_Auth_Adapter_Interface
{
    private $token;
    private $user;
    
    public function __construct($token)
    {
        $this->token = $token;
    }
    
    /** 
     * Zend_Auth hook
     */
    public function authenticate()
    {
        $this->user = Doctrine_Core::getTable('User')->findOneByToken($this->token);
        
        if ($this->user) {
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, (object)($this->user->toArray()), array());
        } else {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, (object)'', array());
        }
     }     
}
