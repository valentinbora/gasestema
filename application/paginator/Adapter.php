<?php
/**
 * Paginator adapter for the use of Zend_Paginator with Doctrine_Query
 * 
 * @author Bart Huttinga
 */
class Gasestema_Paginator_Adapter extends Zend_Paginator_Adapter_DbSelect
{
    /**
     * Constructor.
     *
     * @param Doctrine_Query $select The select query
     */
    public function __construct(Doctrine_Query $select)
    {
        $this->_select = $select;
        
        // Set default paginator options
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_Paginator::setDefaultItemCountPerPage(8);

Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
        
    }

    /**
     * Sets the total row count, either directly or through a supplied query.
     *
     * @param  Doctrine_Query|integer $totalRowCount Total row count integer or query
     * @return Mykea_Class_Paginator_Adapter $this
     * @throws Zend_Paginator_Exception
     */
    public function setRowCount($rowCount)
    {
        if ($rowCount instanceof Doctrine_Query) {
        	$this->_rowCount = $rowCount->count();
        } else if (is_integer($rowCount)) {
            $this->_rowCount = $rowCount;
        } else {
            throw new Zend_Paginator_Exception('Invalid row count');
        }
        return $this;
    }

    /**
     * Returns an array of items for a page.
     *
     * @param  integer $offset Page offset
     * @param  integer $itemCountPerPage Number of items per page
     * @return Doctrine_Collection result set
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $this->_select
        	->offset($offset)
        	->limit($itemCountPerPage);

        return $this->_select->execute();
    }

    /**
     * Get the COUNT select object for the provided query
     *
     * @return Doctrine_Query
     */
    public function getCountSelect()
    {
        if ($this->_countSelect !== null) {
            return $this->_countSelect;
        }
        
        return $this->_select->count();
    }
}