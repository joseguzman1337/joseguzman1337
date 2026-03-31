<?php
require_once "Celsius_Exception.php";
/*
 * 
 */
class Application_Exception extends Celsius_Exception{
	
	function Application_Exception($message){
		parent::Celsius_Exception($message);
	}
	
}
?>