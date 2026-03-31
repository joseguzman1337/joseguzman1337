<?
/**
 * 
 * @param string id_pantalla es el nombre, descripcion de la pantalla
 *  
 */

$pageName = "pantallas";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$pantalla = array ("Id" => $Id);

if (empty($id_pantalla)) {
	//es una creacion
	$res = $servicesFacade->agregarPantalla($pantalla);
	$id_pantalla = $pantalla["Id"];
}else{
	$res = $servicesFacade->modificarPantalla($pantalla,$id_pantalla);
}

if (is_a($res, "Celsius_Exception")) {
	//TODO mostrar_error
	var_dump($res);
	exit;
}

header("Location: listado_pantallas.php");
?>