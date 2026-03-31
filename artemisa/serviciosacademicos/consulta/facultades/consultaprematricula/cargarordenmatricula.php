<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../../Connections/sala2.php');
session_start();
$_SESSION['codigoestudiante']=$_GET['codigo'];
//$_SESSION['codigoestudiante']="01170082 ";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=consultaordenmatricula.php'>";
?>