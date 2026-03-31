<?php
/*
 *
 */
 //abstract
class Celsius_Exception{
	var $message;
	
	function Celsius_Exception($message){
		$this->message = $message;
	}
	
	function getMessage(){
		return $this->message;
	}
	
	/**
	 * Devuelve el mensaje en una sola linea con <br/> y con los caracteres especiales escapados
	 */
	function getSafeMessage(){
		require_once "../utils/StringUtils.php";
	return StringUtils::getSafeString($this->__toString());

	}
	
	function __toString(){
		return $this->message;
	}	
}
?>