<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

$query_inserta="insert into usuario  values
	('', 
	'".$_POST['usuario']."', 
	'".$_POST['numerodocumento']."', 
	'".$_POST['tipodocumento']."', 
	'".$_POST['apellidos']."', 
	'".$_POST['nombres']."', 
	'".$_POST['codigousuario']."', 
	'".$_POST['semestre']."', 
	'".$_POST['codigorol']."', 
	'".$_POST['fechainiciousuario']."', 
	'".$_POST['fechavencimientousuario']."', 
	'".$_POST['fecharegistrousuario']."', 
	'".$_POST['codigotipousuario']."', 
	'".$_POST['idusuariopadre']."'
	)";

$op=$sala->execute($query_inserta);
if($op){
	echo "OK";
}
else{
	echo "ERROR";
}
?>