<?php
require_once "DB_Exception.php";
/*
 * 
 */
class DuplicateKey_Exception extends DB_Exception{
	
	function DuplicateKey_Exception($message,$dbError,$dbErrorNo){
		parent::Celsius_Exception($message,$dbError,$dbErrorNo);
	}
	
}
?>