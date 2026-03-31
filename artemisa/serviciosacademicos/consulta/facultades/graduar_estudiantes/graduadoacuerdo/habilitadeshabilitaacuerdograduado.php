<?php 
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/sala_genericas/DatosGenerales.php");
require_once("../../../../funciones/sala_genericas/DatosGenerales.php");
define('FPDF_FONTPATH','../../../../funciones/clases/fpdf/font/');
require_once('../../../../funciones/clases/fpdf/fpdf.php');
require_once("../../../../funciones/sala_genericas/extensionfpdf.php");
//require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
$objetobase=new BaseDeDatosGeneral($sala);
$tabla="acuerdograduado";
if($_GET["habilita"]=="si")
$fila["codigoestado"]=100;
else
$fila["codigoestado"]=200;
$objetobase->actualizar_fila_bd($tabla,$fila,"codigoacuerdograduado",$_GET["codigoacuerdograduado"],'',0);
	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	// generate the output in XML format
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<data></data>';
?>