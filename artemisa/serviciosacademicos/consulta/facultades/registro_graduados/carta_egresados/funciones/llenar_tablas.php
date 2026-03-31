<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$rutaado=("../../../../../funciones/adodb/");
require_once('../../../../../Connections/salaado-pear.php');
/**
 * Este script llena las tablas relacionadas, pazysalvoegresado, detallepazysalvoegresado
 */
//$sala->debug=true;
$query_carrera="SELECT c.codigocarrera FROM carrera c WHERE c.codigocarrera <> 10 ORDER BY c.codigocarrera";
$operacion=$sala->query($query_carrera);
$fecha=date('Y-m-d');
$row_operacion=$operacion->fetchRow();
do
{
	$array_carrera[]=$row_operacion;
}
while ($row_operacion=$operacion->fetchRow());

foreach ($array_carrera as $llave => $valor)
{
	$query_inserta="INSERT INTO pazysalvoegresado values('','$fecha','".$valor['codigocarrera']."','2006-01-01','2999-12-31','1','123')";
	$inserta=$sala->query($query_inserta);
	$idpazysalvoegresado=$sala->Insert_ID();
	$query_selecciona_detalle="SELECT * from detallepazysalvoegresado WHERE idpazysalvoegresado=1";
	$operacion_selecciona_detalle=$sala->query($query_selecciona_detalle);
	$row_operacion_selecciona_detalle=$operacion_selecciona_detalle->fetchRow();
	do
	{
		$query_inserta_detalle="INSERT INTO detallepazysalvoegresado VALUES('','$idpazysalvoegresado','".$row_operacion_selecciona_detalle['idtipodetallepazysalvoegresado']."','".$row_operacion_selecciona_detalle['textodetallepazysalvoegresado']."','".$row_operacion_selecciona_detalle['codigoestado']."','".$row_operacion_selecciona_detalle['ubicacionpaginadetallepazysalvoegresado']."')";
		echo $query_inserta_detalle,"<br><br>";
		//desactivado $operacion_inserta_detalle=$sala->query($query_inserta_detalle);
	}
	while ($row_operacion_selecciona_detalle=$operacion_selecciona_detalle->fetchRow());
}



?>