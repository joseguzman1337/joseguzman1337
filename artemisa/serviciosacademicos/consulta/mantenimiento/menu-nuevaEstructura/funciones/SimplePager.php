<?php
/**
* @package SPLIB
* $Id: SimplePager.php,v 1.1 2007/05/11 17:07:29 Abraham Castro Exp $
*/
/**
* SimplePager class
* Used to help calculate the number of pages in a database result set
* @access public
* @package SPLIB
*/
class SimplePager {
    /**
    * Total number of pages
    * @access private
    * @var int
    */
    var $totalPages;

    /**
    * The row MySQL should start it's select with
    * @access private
    * @var int
    */
    var $startRow;

    /**
    * SimplePager Constructor
    * @param int number of rows per page
    * @param int total number of rows available
    * @param int current page being viewed
    * @access public
    */
    function SimplePager($rowsPerPage,$numRows,$currentPage=1) {
        // Calculate the total number of pages
        $this->totalPages=ceil($numRows/$rowsPerPage);
        // Check that a valid page has been provided
        if ( $currentPage < 1 )
            $currentPage=1;
        else if ( $currentPage > $this->totalPages )
            $currentPage=$this->totalPages;
        // Calculate the row to start the select with
        $this->startRow=(($currentPage - 1) * $rowsPerPage);
    }

    /**
    * Returns the total number of pages available
    * @return int
    * @access public
    */
    function getTotalPages () {
        return $this->totalPages;
    }

    /**
    * Returns the row to start the select with
    * @return int
    * @access public
    */
    function getStartRow() {
        return $this->startRow;
    }
}
?>