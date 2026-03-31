<?php
require_once "Celsius_Exception.php";
/*
 * 
 */
class WS_Exception extends Celsius_Exception{
	var $error_detail;
	
	function WS_Exception($context_message, $error_detail){
		parent::Celsius_Exception($context_message);
		$this->error_detail = $error_detail;
	}

	function __toString(){
		return $this->message.': '.$this->error_detail;
	}
	
}
?>