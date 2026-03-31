<?php
//session_cache_limiter('private');
//session_start();
error_reporting(0);
setlocale(LC_ALL,'es_ES');
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/fpdf/fpdf.php");
define('FPDF_FONTPATH','../../../../funciones/clases/fpdf/font/');
require_once("funciones/foliacion_automatica.php");
$_SESSION['MM_Username']='admintecnologia';
$foliacion=new foliacion_automatica($sala,$_GET['accion']);
?>
