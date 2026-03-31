<?php 
session_start();
include_once('../../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

function edad($fecha)
{
	list ($ano,$dia, $mes) = explode ('-', $fecha);
	$fecha = mktime (0,0,0,$mes,$dia,$ano);
	$fecha = time() - $fecha;
	$anos = round ($fecha/ (365*24*60*60));
	//$meses = $fecha - $anos * (365*24*60*60);
	//$meses = round($meses/ (30*24*60*60));
	return $anos;
}

echo(edad("1979-08-21"));
?> 
   

 
