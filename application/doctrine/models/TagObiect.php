<?php

/**
 * TagObiect
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class TagObiect extends BaseTagObiect
{
    public function setUp()
    {
        $this->hasOne('Obiect', array(
             'local' => 'obiect',
             'foreign' => 'id'));
             
        $this->hasOne('Tag', array(
              'local' => 'tag',
              'foreign' => 'id'));
        
        parent::setUp();
    }
}