<?php
require_once "../libs/nusoap.php";
require_once "../common/ServicesFacade.php";
require_once "../exceptions/WS_Exception.php";
ini_set("soap.wsdl_cache_enabled", "0");


///////////////////////////////////////////////////////////////////
/////////////////// CODIGO DE AUTENTICACION ///////////////////////
///////////////////////////////////////////////////////////////////

require_once "../common/authentication.php";
$servicesFacade = ServicesFacade::getInstance();
$getPasswordFunction = create_function('$parametros','return $parametros["password_directorio"];');
$getUserCallback = array($servicesFacade, 'getParametros');
authenticate_digest($getUserCallback,$getPasswordFunction);

///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////


function echoes($entrada) {
	if (empty ($entrada))
		return new soap_fault("Client", "", "El campo entrada no puede esta vacio");
	return $entrada;
}

function vaciarColaEventosNT() {
	$servicesFacade = ServicesFacade :: getInstance();
	$eventos_enviados = $servicesFacade->vaciarColaEventosNT();
	if (is_a($eventos_enviados, "Celsius_Exception"))
		return new soap_fault("Server", "ServicesFacade", $eventos_enviados->getMessage());

	return $eventos_enviados;
}

function ejecutarQuery($sqlQuery) {
	//valido los parametros
	if (empty($sqlQuery) || !is_string($sqlQuery))
		return new soap_fault("Client", "","El campo sqlQuery no puede esta vacio");
	
	//valido que la consulta sea solo de lectura
	$deniedClauses = array("insert","update" ,"delete", "drop", "alter", "truncate", "create");
	foreach($deniedClauses as $clause){
		if (stripos($sqlQuery, $clause) !== FALSE)
			return new soap_fault("Client", "","La sentencia ingresada es de modificacion. \nSentencia: '$consultaSQL'\n y  contiene la clausula $clause");
	}
	
	//ejecuta la consulta
	$servicesFacade = ServicesFacade :: getInstance();
	$res = $servicesFacade->ejecutarSQL($sqlQuery);
	if (is_a($res, "Celsius_Exception"))
		return new soap_fault("Server", "ServicesFacade", $eventos_enviados->getMessage());
	
	return $res;
	
}
$s = new soap_server();
$s->register("echoes");
$s->register("vaciarColaEventosNT");
$s->register("ejecutarQuery");

if (isset ($HTTP_RAW_POST_DATA))
	$HTTP_RAW_POST_DATA = "";
$s->service($HTTP_RAW_POST_DATA);
?>