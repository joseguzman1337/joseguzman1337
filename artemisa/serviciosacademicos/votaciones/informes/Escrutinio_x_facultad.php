<?php
session_start();
ini_set("display_errors", "0");
error_reporting(0);
unset($_SESSION['datos_pie']);
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/motorv2/motor.php");
require_once("../../funciones/clases/formulariov2/clase_formulario.php");
require_once("../funciones/obtenerDatos.php");
$escrutinio = new Votaciones(&$sala,false);
$escrutinio->asignarEscrutinios();
$votos=$escrutinio->retornaArrayConteoVotos_x_Carrera();
$matriz = new matriz($votos,"Participación en la Votación",'Escrutinio_x_facultad.php',"si","si","menu.php");
$matriz->jsVarios();
$matriz->mostrar();

?>