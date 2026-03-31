<?php
header('Content-Type: text/html; charset=UTF-8');
$rutaado='../../funciones/adodb/';
require_once('../../Connections/salaado-pear.php');
switch ($_GET['caso']){
	case 'id':
		$query="SELECT linkmenuopcion, framedestinomenuopcion FROM menuopcion WHERE idmenuopcion='".$_GET['idmenuopcion']."'";
		break;
	case 'trans':
		$query="SELECT linkmenuopcion, framedestinomenuopcion FROM menuopcion WHERE transaccionmenuopcion='".$_GET['codigotransaccion']."'";
		break;
}
$op=$sala->execute($query);
if($op){
	echo $op->fields['linkmenuopcion'],"-",$op->fields['framedestinomenuopcion'];
}
?>