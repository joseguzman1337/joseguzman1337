<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
$rutaado='../../../funciones/adodb/';
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
if(isset($_GET['renameId']) && isset($_GET['newName']))	{

	$query_actualiza="UPDATE menuopcion SET nombremenuopcion='".$_GET['newName']."' WHERE idmenuopcion='".$_GET['renameId']."'";
	$operacion=$sala->query($query_actualiza);
	if($operacion){
		echo "OK";
	}
	else{
		echo "NOT OK";
	}
}
?>
