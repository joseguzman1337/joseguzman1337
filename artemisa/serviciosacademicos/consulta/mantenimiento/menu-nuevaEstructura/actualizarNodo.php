<?php
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
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
