<?php

class Gasestema_Auth_Database implements Zend_Auth_Adapter_Interface
{
    private $email;
    private $password;
    private $user;
    
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
    
    /** 
     * Zend_Auth hook
     */
    public function authenticate()
    {
        $this->user = Doctrine_Core::getTable('User')->findOneByEmailAndPassword($this->email, $this->password);
        
        if ($this->user) {
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->user, array());
        } else {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, (object)'', array());
        }
     }     
}
