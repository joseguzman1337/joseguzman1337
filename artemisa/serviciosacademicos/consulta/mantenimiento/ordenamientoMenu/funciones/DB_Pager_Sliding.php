<?php
/**
* @package SPLIB
* @version $Id: DB_Pager_Sliding.php,v 1.1 2007/05/16 14:50:55 Abraham Castro Exp $
*/
/**
 * DB_Pager_Sliding - extends PEAR::Pager_Sliding
 * Provides an API to help build query result pagers
 * @access public
 * @package SPLIB
 */
class DB_Pager_Sliding extends Pager_Sliding {
    /**
    * DB_Pager_Sliding constructor
    * @param array params for parent
    * @access public
    */
    function DB_Pager_Sliding ($params) {
        parent::Pager_Sliding($params);
    }

    /**
    * Returns the number of rows per page
    * @access public
    * @return int
    */
    function getRowsPerPage () {
        return $this->_perPage;
    }

    /**
    * The row number to start a SELECT from
    * @access public
    * @return int 
    */
    function getStartRow () {
        if ( $this->_currentPage == 0 )
            return $this->_perPage;
        else
            return ( ($this->_currentPage - 1) * $this->_perPage );
    }
}
?>