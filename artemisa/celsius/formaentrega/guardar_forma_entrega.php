<?php
/**
 *
 */
$pageName ="formas_entrega";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$forma_entrega = array();

if (!empty($nombre))
	$forma_entrega["nombre"] =$nombre; 
	
if (!empty($recibo) && $recibo=="ON")
	$recibo=1;
else
	$recibo = 0;
$forma_entrega["recibo"] =$recibo;  
	
if (!empty($descripcion))
	$forma_entrega["descripcion"] =$descripcion;

//es una creacion
if (empty($id_forma_entrega)){
	$res = $id_forma_entrega = $servicesFacade->agregarFormaDeEntrega($forma_entrega);
}else{	//es una modificacion
	$forma_entrega["id"]=$id_forma_entrega;
	$res = $servicesFacade->modificarFormaDeEntrega($forma_entrega);
}

if (is_a($res, "Celsius_Exception")){
	$mensaje_error= $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}

header("Location: mostrar_forma_entrega.php?id_forma_entrega=".$id_forma_entrega);
?>