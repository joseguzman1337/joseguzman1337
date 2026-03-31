<?php
/**
* @package SPLIB
* @version $Id: FullTree.php,v 1.1 2007/05/11 17:07:29 Abraham Castro Exp $
*/
/**
*  FullTree clas
* <pre>
*  Home
*    - About
*    - Contact
*  Products
*    - Pets
*      - Cats
*      - Birds
*    - Books
*  Etc
* </pre>
* @access public
* @package SPLIB
*/
class FullTree extends Menu {
    /**
    * Stores the current location item
    * @access private
    * @var  object
    */
    var $current;

    /**
    * FullTree constructor
    * @param object database connection
    * @param string URL fragment
    * @access public
    */
    function FullTree (&$db,$location='',$usuario,$administrador=false) {
        Menu::Menu($db,$usuario,$administrador);
        $this->current=$this->locate($location);
        $this->build();
    }

    /**
    * Resursive function that adds any children to the
    * current node
    * @param object instance of MenuItem
    * @return void
    * @access private
    */
   /* function appendChildren ($treeItem) {
        foreach ( $this->items as $item ) {
            if ( $treeItem->id() == $item->parent_id() ) {
                $this->menu[]=new Marker('start');
                if ( $item->id() == $this->current->id() )
                    $item->setCurrent();
                $this->menu[]=$item;
                $this->appendChildren($item);
                $check=end($this->menu);
                if ( $check->isStart() )
                    array_pop($this->menu);
                else
                    $this->menu[]=new Marker('end');
            }
        }
    }

    /**
    * Starts construction, building the root elements
    * @return void
    * @access private
    */
    /*function build () {
        foreach ( $this->items as $item ) {
            if ( $item->isRoot() ) {
                if ( $item->id() == $this->current->id() )
                    $item->setCurrent();
                $this->menu[]=$item;
                $this->appendChildren($item);
            }
        }
        reset ( $this->menu );
    }*/
    
    function appendChildren (& $treeItem) { 
        $isFirstChild = true; 
         
        foreach (array_keys($this->items) as $key ) { 
            $item =& $this->items[$key]; 
             
            if ( $treeItem->id() == $item->parent_id() ) { 
                 
                $item->level = $treeItem->level + 1; 
                 
                if($isFirstChild) { 
                    // only if it's the first child do we want the start marker 
                     
                    $this->menu[] =& new Marker('start', $this); 
                    $isFirstChild = false; 
                }else { 
                    // it's not the first child, we don't want the end marker 
                    array_pop($this->menu); 
                } 
                 
                $this->menu[] =& $item; 
                $this->appendChildren($item); 
                 
                $check=end($this->menu); 
             
                if ( $check->isStart() ){ 
                    array_pop($this->menu); 
                }else{ 
                    $this->menu[] =& new Marker('end', $this); 
                } 
            } 
        } 
         
    } 

    /** 
    * Starts construction, building the root elements 
    * @return void 
    * @access private 
    */ 
    function build () { 
        foreach (array_keys($this->items) as $key ) { 
            $item =& $this->items[$key]; 
             
            if ( $item->id() == $this->current->id() ){ 
                $item->setCurrent(); 
            } 
             
            if ( $item->isRoot() ) { 
                $item->level = 0; 
                $this->menu[] = $item; 
                $this->appendChildren($item); 
            } 
        } 
        reset ( $this->menu ); 
    } 

 
    
}
?>