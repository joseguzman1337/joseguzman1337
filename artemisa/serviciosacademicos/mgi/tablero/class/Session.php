<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author proyecto_mgi_cp
 */
class Session{
    public $session = array();
    private static $instance = NULL;
    
    public function __construct() {
       if(isset($_SESSION) && count($_SESSION)>0){
         foreach ($_SESSION as $llave => $valor){
             $this->session[$llave]=$valor;
        }        
       }
     }
     
     public static function getInstance() {
	if(!isset(self::$instance)) {
	  self::$instance = new Session();
	}
	return self::$instance;
    }
     
     public function recoverSession() {
         $this->session = unserialize(urldecode($_REQUEST["sala"]));
         foreach ($this->session as $llave => $valor){
             $_SESSION[$llave]=$valor;
        }
     }
     
     public function __destruct() {
         
     }
}

?>
