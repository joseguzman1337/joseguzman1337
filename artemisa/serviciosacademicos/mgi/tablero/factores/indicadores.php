<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

include_once('class/Factores_Class.php');
$C_Factores = new Factores();
$C_Factores->consultaIndicadores($_REQUEST["id"],$_REQUEST["tot"]);
$C_Factores->consultaIndicadoresDetalle($_REQUEST["id"]);
//$C_Factores->consultaIndicadoresDetalle($_REQUEST["id"]);
?>
