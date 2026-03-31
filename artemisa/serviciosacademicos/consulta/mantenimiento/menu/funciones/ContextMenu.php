<?php
/**
* @package SPLIB
* @version $Id: ContextMenu.php,v 1.1 2007/04/28 21:05:31 Abraham Castro Exp $
*/
/**
* ContextMenu class
* <pre>
*    - Books
*    - Pets << You are here
*      - Cats
*      - Birds
*    - Software
* </pre>
* @access public
* @package SPLIB
*/
class ContextMenu extends Menu {
    /**
    * Stores the current location item
    * @access private
    * @var  object
    */
    var $current;

    /**
    * ContextMenu constructor
    * @param object database connection
    * @param string URL fragment
    * @access public
    */
    function ContextMenu (&$db,$location='') {
        Menu::Menu($db);
        $this->current=$this->locate($location);
        $this->build();
    }

    /**
    * Appends the children of the current location
    * @return void
    * @access private
    */
    function appendChildren () {
        $this->menu[]=new Marker('start');
        foreach ( $this->items as $item ) {
            if ( $item->parent_id() == $this->current->id() ) {
                $this->menu[]=$item;
            }
        }
        $check=end($this->menu);
        if ( $check->isStart() )
            array_pop($this->menu);
        else
            $this->menu[]=new Marker('end');
    }

    /**
    * Fetches one level of nodes level with the current location
    * and called appendChildren to add children of current node
    * @return void
    * @access private
    */
    function build () {
        foreach ( $this->items as $item ) {
            if ( $item->id() == $this->current->id() ) {
                $this->menu[]=$item;
                $this->appendChildren();
            } else if ( $item->parent_id() == $this->current->parent_id() ) {
                $this->menu[]=$item;
            }
        }
        reset ( $this->menu );
    }
}
?>