<?
/**
 * 
 */

	
if (empty($_includes)){
	$_includes = true;
	
	require_once "constants.php";
	
	if (get_magic_quotes_runtime() == 1)
		set_magic_quotes_runtime(0);
		
	require_once "var.inc.php";
	
	require_once "Configuracion.php";
	
	require_once "ServicesFacade.php";
	$servicesFacade = ServicesFacade::getInstance();
	
	if (is_a($servicesFacade,"Celsius_Exception")){
		$excepcion = $servicesFacade;
		require "mostrar_error.php";
	}
		
	require "SessionHandler.php";
	$IdiomaSitio = SessionHandler::getIdioma();
	
	$VectorIdioma = $servicesFacade->ObtenerVectorIdioma ($IdiomaSitio);
	
	require_once "TraduccionesUtils.php";

}

?>