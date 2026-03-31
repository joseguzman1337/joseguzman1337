<?php
/**
* @package SPLIB
* @version $Id: BreadCrumb.php,v 1.1 2007/05/11 17:07:29 Abraham Castro Exp $
*/
/**
* BreadCrumb class
* <pre>
*     You > Are > Here
* </pre>
* @access public
* @package SPLIB
*/
class BreadCrumb extends Menu {
    /**
    * BreadCrumb constructor
    * @param object database connection
    * @param string URL fragment
    * @access public
    */
    function BreadCrumb (& $db,$location='') {
        Menu::Menu($db);
        $breadCrumb=$this->locate($location);
        $this->menu[]=$breadCrumb;
        $this->build($breadCrumb);
    }

    /**
    * Resursive function that constructs the breadcrumb menu
    * @param object instance of MenuItem
    * @access private
    * @return void
    */
    function build ($breadCrumb) {
        foreach ( $this->items as $item ) {
            if ( $breadCrumb->parent_id() == $item->id() ) {
                array_unshift($this->menu,$item);
                $this->build($item);
            }
        }
        reset ( $this->menu );
    }
}
?>