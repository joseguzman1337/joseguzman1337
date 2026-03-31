<?php
session_start();
$rutaado=("../serviciosacademicos/funciones/adodb/");

//require_once("../../../Connections/salaado-pear.php");
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once("../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
        $objetobase=new BaseDeDatosGeneral($snies_conexion);

       $tabla="curso";
       $fila["curso_code"]=$_GET["curso_code"];
       $fila["nbc_code"]=$_GET["nbc_code"];
       $condicion=" curso_code='".$_GET["curso_code"]."'";
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