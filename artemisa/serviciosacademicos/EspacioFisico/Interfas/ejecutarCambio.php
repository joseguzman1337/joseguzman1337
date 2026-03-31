<?php

	include("../templates/template.php");
		
		$db = getBD();
        
       
include_once('CambioEstadoSolicitud_class.php');  $C_CambioEstadoSolicitud = new CambioEstadoSolicitud();   

$userid = '4186';
       
$C_CambioEstadoSolicitud->BuscarSolicitudes($db,$userid); 

?>