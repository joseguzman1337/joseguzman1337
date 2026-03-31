<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author stipmp
 */
class entitycontroller {
    
    private $calssobj=null;
    private $headers=null;
    private $entity=null;
//put your code here
     function __construct($entity,$headers="") {
            //$this->entity = substr($entity, 3);
            $this->calssobj = $this->object_to_array(new $this->entity);
            $this->headers = $headers;
            $this->header();
    }
    function header(){
        if(!is_array($this->headers)){
            foreach ($this->calssobj as $value => $key){
                   $headers[$value]= $value;
            }
            $this->headers = $headers;
        }
    }

    function  object_to_array($mixed) {
        if(is_object($mixed)) $mixed = (array) $mixed;
            if(is_array($mixed)) {
            $new = array();
            foreach($mixed as $key => $val) {
                $key = preg_replace("/^\\0(.*)\\0/","",$key);
                $new[$key] = $val;
            }
        }
        else $new = $mixed;
        return $new;
    }
    
    public function __destruct() {
        
    }
    
}
?>
