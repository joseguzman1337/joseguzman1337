<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
@session_start(); 
$GLOBALS['codigo'];
session_register('codigo');
$GLOBALS['codigoperiodosesion'];
session_register('codigoperiodosesion');
$GLOBALS['nombreprograma'];
session_register('nombreprograma');

if($_GET['codigoestudiante'])
{
	$_SESSION['codigo'] = $_GET['codigoestudiante'];
	$_SESSION['codigoperiodosesion'] = $_GET['codigoperiodo'];
	$_SESSION['nombreprograma'] = "matriculaautomaticabusquedaestudiante.php";
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../matriculaautomatica.php?documentoingreso=".$_GET['documentoingreso']."'>";
	exit();
}
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../consultanotas.htm'>";
 

?>