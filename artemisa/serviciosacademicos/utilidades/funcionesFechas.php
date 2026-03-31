<?php

function obtenerDiferenciaHorasFechas($fecha1,$fecha2=null){
	if($fecha2==null){
		$fecha2=date('Y-m-d H:i:s');
	}
	
	$hourdiff = round((strtotime($fecha2) - strtotime($fecha1))/3600, 1);
	
	return $hourdiff;
}
//calcula la cantidad de dias entre dos fechas.
function CalcularFechas_new($fecha_i,$fecha_f){
    
    $dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); 
    $dias   = floor($dias);		
    
    return $dias;
}//CalcularFechas_new
?>