<?php
/*
 * 
 */
$pageName = "mail.plantilla2";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);


if (empty($Denominacion) ||  empty($Texto)){
	//los datos estan incompletos, que los vuelva a cargar
	require "agregarOModificarPMail.php";
	exit;
}

if (empty($Denominacion))
	$Denominacion= "";
	
$plantilla=array();
$plantilla['Denominacion']=$Denominacion;
$plantilla['Cuando_Usa']=$Cuando_Usa;
$plantilla['Texto']=$Texto;
	
if (empty($id_plantilla)){   
    $res = $id_plantilla = $servicesFacade->agregarPlantilla($plantilla);	
}else{
    $plantilla['Id']=$id_plantilla;
    $res = $servicesFacade->modificarPlantilla($plantilla);	
} 
if (is_a($res, "Celsius_Exception")){
	$mensaje_error = $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}
header("Location: mostrar_plantilla.php?id_plantilla=".$id_plantilla);
?>