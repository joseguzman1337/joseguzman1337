<?php
/**
* @package SPLIB
* @version $Id: HTMLTable.php,v 1.1 2007/05/11 17:07:29 Abraham Castro Exp $
*/
/**
 * HTMLTable - used to demonstrate
 * Provides an API to help build query result pagers
 * @access public
  *@package SPLIB
 */
class HTMLTable {
    /**
    * Instance of a class implementing the simple fetch() Iterator
    * @access private
    * @var object
    */
    var $collection;

    /**
    * Prefix to append to HTML ID attributes (for use with CSS)
    * @access private
    * @var string
    */
    var $idPre;

    /**
    * The HTML for the table
    * @access private
    * @var string
    */
    var $table;

    /**
    * DB_Pager_Sliding constructor
    * @param object instance of Class implementing fetch() Iterator
    * @param string prefix to add to HTML ID attributes
    * @access public
    */
    function HTMLTable (& $collection,$idPre='') {
        $this->collection = & $collection;
        $this->idPre = $idPre;
        $this->table="<table id=\"".$idPre."Table\">\n";
    }

    /**
    * Adds the column heading(s)
    * @param mixed string or array for column heading(s)
    * @access public
    * @return void
    */
    function addHeadings($headings) {
        $this->table.="  <tr id=\"".$this->idPre."HeaderRow\">\n";
        if ( is_array($headings) ) {
            foreach ( $headings as $heading ) {
                $this->table.="    <th id=\"".$this->idPre."HeaderCol\">".
                    $heading."</th>\n";
            }
        } else {
            $this->table.="    <th id=\"".$this->idPre."HeaderCol\">".
                $headings."</th>\n";
        }
        $this->table.="  </tr>\n";
    }

    /**
    * Builds the rows of the table
    * @access private
    * @return void
    */
    function buildRows() {
        $alt = '1';
        while ( $row = $this->collection->fetch() ) {
            $this->table.="  <tr id=\"".$this->idPre."Row".$alt."\">\n";
            if ( is_array($row) ) {
                foreach ( $row as $col ) {
                    $this->table.="    <td id=\"".$this->idPre."Col\">".
                        $col."</td>\n";
                }
            } else {
                $this->table.="    <td id=\"".$this->idPre."Col\">".
                    $row."</td>\n";
            }
            $this->table.="  </tr>\n";
            $alt = ( $alt == 1 ) ? 2 : 1;
        }

    }

    /**
    * Returns the table
    * @access public
    * @return string
    */
    function render() {
        $this->buildRows();
        return $this->table . "</table>\n";
    }
}
?>