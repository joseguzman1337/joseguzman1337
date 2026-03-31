<?php
//session_start();
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

$_SESSION['codigo'] = $_GET['codigoestudiante'];
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../ordenpagovarias/ordenpagovarias.php'>";
?>