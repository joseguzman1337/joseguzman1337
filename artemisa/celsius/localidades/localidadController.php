<?
$pageName = "localidades";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
global $IdiomaSitio;

$localidad = array ("Nombre" => $Nombre,"Codigo_Pais" => $Codigo_pais);
if (empty ($idLocalidad)) {
	$res = $idLocalidad = $servicesFacade->agregarLocalidad($localidad);
} else {
	$localidad["Id"] = $idLocalidad;
	$res = $servicesFacade->modificarLocalidad($localidad);
}
if (is_a($res, "Celsius_Exception")) {
	$mensaje_error= $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}
header('Location:mostrarLocalidad.php?idLocalidad=' . $idLocalidad);
?>