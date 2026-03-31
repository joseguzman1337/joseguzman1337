<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
//session_start();
$rutaado=("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
        $objetobase=new BaseDeDatosGeneral($sala);

       $tabla="encuestamateria";
       $fila["idencuesta"]=$_GET["idencuesta"];
       $fila["codigomateria"]=$_GET["codigomateria"];
       $condicion=" codigomateria='".$_GET["codigomateria"]."'";
$objetobase->insertar_fila_bd($tabla, $fila, 0, $condicion);


header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
// generate the output in XML format
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<data>';
echo "Guardado exitoso";
echo '</data>';
?>
