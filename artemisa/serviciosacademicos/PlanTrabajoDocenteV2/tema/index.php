<?php
session_start();
/*include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/

header("Location:../index.php");
?>