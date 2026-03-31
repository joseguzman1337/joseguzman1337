<?php
require_once "Celsius_Exception.php";
/*
 * 
 */
class DB_Exception extends Celsius_Exception{
	var $dbError;
	var $dbErrorNo;
	
	function DB_Exception($message,$dbError,$dbErrorNo){
		parent::Celsius_Exception($message);
		$this->dbError = $dbError;
		$this->dbErrorNo = $dbErrorNo;
	}
	
}
?>