<?php 
   function cambiaf_a_sap($fecha)
       { 
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); 
		$lafecha=$mifecha[1].$mifecha[2].$mifecha[3]; 
		return $lafecha; 
       } 
	 function cambiaf_a_sala($fecha)
       { 
		
		ereg( "([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $fecha, $mifecha); 
		$lafecha=$mifecha[1]."-".$mifecha[2]."-".$mifecha[3];		
		return $lafecha; 
       } 
  

?>