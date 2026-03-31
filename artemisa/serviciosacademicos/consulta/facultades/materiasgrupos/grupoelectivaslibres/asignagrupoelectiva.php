<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
$rutaado = ("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$objetobase = new BaseDeDatosGeneral($sala);
$tabla = "detallegrupomateria";
foreach ($_GET as $key => $value) {

    if (isset($value) &&
            $value != 0) {
        $fila["idgrupomateria"] = $_SESSION["grupoelectivas_idgrupomateria"];
        $fila["codigomateria"] = $key;
        $fila["codigoestado"] = "100";
    } else {
        $fila["idgrupomateria"] = $_SESSION["grupoelectivas_idgrupomateria"];
        $fila["codigomateria"] = $key;
        $fila["codigoestado"] = "200";
    }
}
$condicionactualiza = " codigomateria='" . $fila["codigomateria"] . "'" .
        " and iddetallegrupomateria in (select iddetallegrupomateria from grupomateria gm, detallegrupomateria dg
    where dg.idgrupomateria=gm.idgrupomateria
    and gm.codigotipogrupomateria ='100'
    and gm.codigoperiodo='" . $_SESSION["codigoperiodosesion"] . "'
    and dg.codigomateria='" . $fila["codigomateria"] . "'" . ")";
//echo "<pre>";
$objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
//echo "</pre>";
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
