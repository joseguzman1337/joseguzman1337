<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
session_regenerate_id();
require_once('../../Connections/sala2.php');
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once('../../funciones/clases/autenticacion/autenticacionTecnologia.php');
if(!empty($_GET['sel']) and $_SESSION['MM_Username']=='admintecnologia'){
	$autenticacionTecnologia = new autenticacionTecnologia($sala,$_GET['sel']);
}
else{
	exit();
}
?>