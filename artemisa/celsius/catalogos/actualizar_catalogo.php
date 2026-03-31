<?

/*
 * IdCatalogo int 
 *  */
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

if (empty ($IdCatalogo)) {
	$catalogo = array (
		"Nombre" => $Nombre,
		"Link" => $Link,
		"observaciones" => $observaciones,
		"numero" => $numero
	);
	$res = $servicesFacade->agregarCatalogo($catalogo);
	$IdCatalogo = $res;
} else {
	$catalogo = array (
		"Id" => $IdCatalogo,
		"Nombre" => $Nombre,
		"Link" => $Link,
		"observaciones" => $observaciones,
		"numero" => $numero
	);
	$res = $servicesFacade->modificarCatalogo($catalogo);
}

if (is_a($res, "Celsius_Exception")) {
	return $res;
}

header('Location:mostrarCatalogo.php?IdCatalogo=' . $IdCatalogo);
?>