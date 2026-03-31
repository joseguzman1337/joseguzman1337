<?php
session_start();
ini_set('memory_limit', '256M');
ini_set('max_execution_time','6400000');

if (empty($_SESSION['MM_Username']))
{
	echo "<h1>Usted no está autorizado para ver esta página</h1>";
//	exit();
}
//$_SESSION['MM_Username']='dirsecgeneral';
//print_r($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/motorv2/motor.php");
require_once("../funciones/obtener_datos.php");
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<?php
$datos = new datos_registro_graduados($sala,false);
$datos->obtener_carreras($_SESSION['codigomodalidadacademica'],$_SESSION['codigocarrera']);

$array_egresados=$datos->obtener_egresados_archivos_antiguos();

if(is_array($array_egresados))
{
	$_SESSION['array_egresados']=$array_egresados;
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tabla_registros_antiguos_lista.php'>";
}
else
{
	echo "<script language='javascript'>alert('No hay datos para mostrar')</script>";
	echo "<script language='javascript'>history.go(-2)</script>";
}
?>
