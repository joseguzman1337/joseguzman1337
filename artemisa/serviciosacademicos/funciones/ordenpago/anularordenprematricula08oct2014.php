<?php
session_start();
$ruta="../";
require_once('claseordenpago.php');
require_once('Cimpresionescyc.php');
mysql_select_db($database_sala, $sala);

$orden = new Ordenpago($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo'], $_GET['numeroordenpago']);
require_once($_SESSION['path_live'].'consulta/interfacespeople/ordenesdepago/anularordenespagosala.php');
if($result['ERRNUM']!=0 || $result['ERRNUM']=='')
	echo "<script>alert('La orden numero '+".$_GET['numeroordenpago']."+' no pudo ser anulada. Por favor tome nota de este numero y contactese con la universidad para recibir ayuda en este proceso. Gracias.')</script>";
else
	$orden->anular_ordenpago();


if($_SESSION['modulosesion'] == "inscripcion" || $_SESSION['nombreprograma'] == "ingresopreinscripcion.php")
{
	$dir = "../../../aspirantes/enlineacentral.php?documentoingreso=".$_GET['documentoingreso']."&logincorrecto";
	//$dir = "../../consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=".$_GET['documentoingreso']."&logincorrecto";
}
else
{
	$dir = "../../consulta/prematricula/matriculaautomaticaordenmatricula.php";
}
//echo $dir;
//exit();
echo "<script language='javascript'>
	 window.opener.recargar('".$dir."');
	 window.opener.focus();
	 window.close();
	 </script>";
?>
