<?php
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
$idmenuopcion=$_GET['idmenuopcion'];
$idrol=$_GET['idrol'];
$estado=$_GET['estado'];


switch ($estado){
	case 'existe':
		$query="DELETE FROM permisorol WHERE idmenuopcion='$idmenuopcion' AND idrol='$idrol'";
		break;
	case 'noexiste':
		$query="INSERT INTO permisorol VALUES ('$idrol','$idmenuopcion')";
		break;
}
$operacion=$sala->query($query);
if($operacion){
	echo "OK";
}
else{
	echo "ERROR";
}

?>