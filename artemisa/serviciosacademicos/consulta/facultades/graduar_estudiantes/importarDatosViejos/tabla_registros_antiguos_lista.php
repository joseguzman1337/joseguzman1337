<?php
session_start();
$_SESSION['nombreprograma'] = "matriculaautomaticabusquedaestudiante.php";
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
if(isset($_SESSION['array_egresados']) and !empty($_SESSION['array_egresados']))
{
	$informe = new matriz($_SESSION['array_egresados'],"Egresados","tabla_registros_antiguos_lista.php","si","si","menu.php","registros_antiguos_lista.php",true,"si","../../../../");
	$informe->jsVarios();
	$informe->agregarllave_drilldown('codigoestudiante','tabla_registros_antiguos_lista.php','../../../prematricula/loginpru.php','registros','codigoestudiante',"codigofacultad=10&programausadopor=facultad",'codigoestudiante','estudiante','','','');
	
	$informe->mostrar();
}
else
{
	echo "<h1>Error, no existen datos para mostrar, o se ha perdido la sesión</h1>";
	exit();
}
?>
