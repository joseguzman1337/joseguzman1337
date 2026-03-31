<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
ini_set('track_errors','Off');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
error_reporting(0);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once('../matriculas/funciones/obtener_datos.php');
require_once('funciones/matriculadosSemestre.php');
require_once("../../../funciones/clases/motorv2/motor.php");



$codigomodalidadacademica=$_SESSION['codigomodalidadacademicainforme'];
$codigoperiodo=$_SESSION['codigoperiodoinforme'];

if($_SESSION['descriptor']<>$_GET['descriptor'] and !empty($_GET['descriptor'])){
	$_SESSION['descriptor']=$_GET['descriptor'];
}
if($_SESSION['codigocarrerainfdetalle']<>$_GET['codigocarrera'] and !empty($_GET['codigocarrera'])){
	$_SESSION['codigocarrerainfdetalle']=$_GET['codigocarrera'];
}

$codigocarrera=$_SESSION['codigocarrerainfdetalle'];
$semestre=$_SESSION['descriptor'];

$estadisticas = new matriculadosSemestre($codigoperiodo,$codigocarrera,$codigomodalidadacademica,'detalle',$sala);
$informe=$estadisticas->leerTotalMatriculadosDetalle($semestre);
$matriz = new matriz($informe,"Detalle de Informe de Matriculados Por Semestre",'detalle.php',"si","si",$_SESSION['link_origen'],'',false,'si','../../../');
$matriz->jsVarios();
$matriz->mostrarTitulo=true;
$matriz->botonRecargar=false;
$matriz->mostrar();
?>