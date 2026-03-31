<?php
/**
* @package SPLIB
* @version $Id: CollapsingTree.php,v 1.1 2007/04/28 21:05:31 Abraham Castro Exp $
*/
/**
* CollapsingTree class
* <pre>
*  Home
*    - About
*    - Contact
*  Products
*  Etc
* </pre>
* @access public
* @package SPLIB
*/
class CollapsingTree extends Menu {
    /**
    * All parent nodes from the current location
    * @access private
    * @var array
    */
    var $parents;

    /**
    * The children of the select parents
    * @access private
    * @var array
    */
    var $children;

    /**
    * CollapsingTree constructor
    * @param object database connection
    * @param string URL fragment
    * @access public
    */
    function CollapsingTree (&$db,$location='') {
        Menu::Menu($db);
        $treeItem=$this->locate($location);
        $this->parents=array($treeItem->name()=>$treeItem);
        $this->getParents($treeItem);
        $this->getChildren();
        $this->build();
    }

    /**
    * Resursive function that fetches all parents
    * above the current location
    * @param object instance of MenuItem
    * @return void
    * @access private
    */
    function getParents($treeItem) {
        foreach ( $this->items as $item ) {
            if ($treeItem->parent_id() == $item->id()) {
                $this->parents[$item->name()]=$item;
                $this->getParents($item);
            }
        }
    }

    /**
    * Gets the children of each selected parent
    * @return void
    * @access private
    */
    function getChildren() {
        foreach ( $this->parents as $parent ) {
            $this->children[$parent->name()]=array();
            foreach ( $this->items as $item ) {
                if ( $item->parent_id() == $parent->id() ) {
                    $this->children[$parent->name()][]=$item;
                }
            }
        }
    }

    /**
    * Resursive function that adds any children to the
    * current node
    * @param object instance of MenuItem
    * @return void
    * @access private
    */
    function appendChildren ($item) {
        if (array_key_exists($item->name(),$this->parents)) {
            $this->menu[]=new Marker('start');
            foreach ( $this->children[$item->name()] as $child ) {
                $this->menu[]=$child;
                $this->appendChildren($child);
            }
            $check=end($this->menu);
            if ( $check->isStart() )
                array_pop($this->menu);
            else
                $this->menu[]=new Marker('end');
        }
    }

    /**
    * Starts construction, building the root elements
    * @return void
    * @access private
    */
    function build () {
        foreach ( $this->items as $item ) {
            if ( $item->isRoot() ) {
                $this->menu[]=$item;
                $this->appendChildren($item);
            }
        }
        reset ( $this->menu );
    }
}
?>