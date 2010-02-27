<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Obiect', 'doctrine');

/**
 * BaseObiect
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $nume
 * @property integer $localitate
 * @property integer $locatie
 * @property integer $user
 * @property integer $adaugat
 * @property string $descriere
 * @property Localitate $Localitate
 * @property Locatie $Locatie
 * @property User $User
 * @property Doctrine_Collection $TagObiect
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseObiect extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('obiect');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('nume', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('localitate', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('locatie', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('user', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('adaugat', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('descriere', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Localitate', array(
             'local' => 'localitate',
             'foreign' => 'id'));

        $this->hasOne('Locatie', array(
             'local' => 'locatie',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'user',
             'foreign' => 'id'));

        $this->hasMany('TagObiect', array(
             'local' => 'id',
             'foreign' => 'obiect'));
    }
}