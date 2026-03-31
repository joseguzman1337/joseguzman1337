<?php
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
if($_POST['idmenuopcion']<>''){
	$query_actualiza="UPDATE menuopcion SET
	nombremenuopcion='".$_POST['nombremenuopcion']."',
	linkmenuopcion='".$_POST['linkmenuopcion']."',
	transaccionmenuopcion='".$_POST['transaccionmenuopcion']."'
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
	if($_POST['linkmenuopcion']==''){
		$codigotipomenuopcion=1;
	}
	else{
		$codigotipomenuopcion=2;
	}
	
	$query_inserta="insert into menuopcion
	(`nombremenuopcion`, `linkmenuopcion`, 
	`codigoestadomenuopcion`, 
	`nivelmenuopcion`, 
	`posicionmenuopcion`, 
	`codigogerarquiarol`, 
	`idpadremenuopcion`, 
	`framedestinomenuopcion`, 
	`transaccionmenuopcion`,
	`codigotipomenuopcion`
	)
	values
	('".iconv('UTF-8','UTF-8',$_POST['nombremenuopcion'])."', 
	'".iconv('UTF-8','UTF-8',$_POST['linkmenuopcion'])."', 
	'".iconv('UTF-8','UTF-8',$_POST['codigoestadomenuopcion'])."', 
	'".iconv('UTF-8','UTF-8',$_POST['nivelmenuopcion'])."', 
	'".iconv('UTF-8','UTF-8',$_POST['posicionmenuopcion'])."', 
	'".iconv('UTF-8','UTF-8',$_POST['codigogerarquiarol'])."', 
	'".iconv('UTF-8','UTF-8',$_POST['idpadremenuopcion'])."', 
	'".iconv('UTF-8','UTF-8',$_POST['framedestinomenuopcion'])."',
	'".iconv('UTF-8','UTF-8',$_POST['transaccionmenuopcion'])."',
	'$codigotipomenuopcion'
	)";
	$operacion_inserta=$sala->query($query_inserta);
	
	
	if($operacion_inserta){
		echo 'OK';
	}
	
	//$val=iconv('UTF-8','UTF-8',$val);
}
?>