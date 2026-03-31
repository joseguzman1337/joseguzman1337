<?php
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
if($_POST['idmenuopcion']<>''){
	$query_actualiza="UPDATE menuopcion SET
	nombremenuopcion='".$_POST['nombremenuopcion']."',
	linkmenuopcion='".$_POST['linkmenuopcion']."',
	codigotransaccionmenuopcion='".$_POST['codigotransaccionmenuopcion']."'
	WHERE idmenuopcion='".$_POST['idmenuopcion']."'
	";
	//$sala->debug=true;
	$operacion=$sala->query($query_actualiza);
	if($operacion){
		echo 'OK';
	}
}
else
{
	$query_inserta="insert into menuopcion
	(`nombremenuopcion`, `linkmenuopcion`, 
	`codigoestadomenuopcion`, 
	`nivelmenuopcion`, 
	`posicionmenuopcion`, 
	`codigogerarquiarol`, 
	`idpadremenuopcion`, 
	`framedestinomenuopcion`, 
	`transaccionmenuopcion`
	)
	values
	('".$_POST['nombremenuopcion']."', '".$_POST['linkmenuopcion']."', 
	'".$_POST['codigoestadomenuopcion']."', 
	'".$_POST['nivelmenuopcion']."', 
	'".$_POST['posicionmenuopcion']."', 
	'".$_POST['codigogerarquiarol']."', 
	'".$_POST['idpadremenuopcion']."', 
	'".$_POST['framedestinomenuopcion']."',
	'".$_POST['transaccionmenuopcion']."'
	)";
	$operacion_inserta=$sala->query($query_inserta);
	if($operacion_inserta){
		echo 'OK';
	}
}
?>