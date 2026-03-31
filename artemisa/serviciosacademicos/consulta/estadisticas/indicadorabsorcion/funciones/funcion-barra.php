<?php
session_start();
include_once('../../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

function barra()
{
	echo "<div style='float:left;margin:10px 0px 0px 1px;width:5px;height:12px;background:white;color:white;'></div>";
    flush();
    ob_flush();
}
?>