<?php
/**
* @package SPLIB
* @version $Id: ChildNodes.php,v 1.1 2007/05/11 17:07:29 Abraham Castro Exp $
*/
/**
*  ChildNodes class
* <pre>
*    - Pets << You are here (not displayed)
*      - Cats
*      - Birds
* </pre>
* @access public
* @package SPLIB
*/
class ChildNodes extends Menu {
    /**
    * Stores the current location item
    * @access private
    * @var object
    */
    var $current;

    /**
    * ChildNodes constructor
    * @param object database connection
    * @param string URL fragment
    * @access public
    */
    function ChildNodes (&$db,$location='') {
        Menu::Menu($db);
        $this->current=$this->locate($location);
        $this->build();
    }

    /**
    * Fetches one level of child nodes beneath the current location
    * @return void
    * @access private
    */
    function build () {
        foreach ( $this->items as $item ) {
            if ( $item->parent_id() == $this->current->id() ) {
                $this->menu[]=$item;
            }
        }
        reset ( $this->menu );
    }
}
?>