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
$getPasswordFunction = create_function('$instancia','return $instancia["password"];');
$getUserCallback = array($servicesFacade, 'getInstancia_Celsius');

authenticate_digest($getUserCallback,$getPasswordFunction);

///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////


function crearPedido_OrigenRemoto($id_instancia_remota, $cols, $values){

	//valido los parametros
	if (empty($cols) || !is_array($cols))
		return new soap_fault("Client", "","El campo cols no puede esta vacio");
	if (empty($values) || !is_array($values))
		return new soap_fault("Client", "","El campo values no puede esta vacio");
		
	$servicesFacade = ServicesFacade::getInstance();
	$datosPedidoRemoto=array_combine($cols,$values);
	
	$idPedido = $servicesFacade->crearPedido_OrigenRemoto($id_instancia_remota,$datosPedidoRemoto);
	if (is_a($idPedido,"Celsius_Exception"))
      return new soap_fault("Server", "ServicesFacade",$idPedido->getMessage());
      
    return $idPedido;
}
 
function generarEvento_OrigenRemoto($id_instancia_remota,$idPedido,$cols,$values, $rol, $attach_file_b64){
	
	//valido los parametros
	if (empty($idPedido) || !is_string($idPedido))
		return new soap_fault("Client", "","El campo Id_Pedido no puede esta vacio");
		
	//$attach_file = base64_decode($attach_file_b64);
	$servicesFacade = ServicesFacade::getInstance();
	$eventoNuevo=array_combine($cols,$values);

	$res=$servicesFacade->generarEvento_OrigenRemoto($id_instancia_remota, $idPedido,$eventoNuevo,$rol,$attach_file_b64);
    if (is_a($res,"Celsius_Exception"))
      return new soap_fault("Server", "ServicesFacade",$res->getMessage());    	
    
    return $res;
}

function cancelarEvento_OrigenRemoto($id_instancia_remota,$id_pedido_remoto,$codigo_evento_nt){
	
	//valido los parametros
	if (empty($id_pedido_remoto) || !is_string($id_pedido_remoto))
		return new soap_fault("Client", "","El campo id_pedido_remoto no puede esta vacio");
	if (empty($codigo_evento_nt) || !is_int($codigo_evento_nt))
		return new soap_fault("Client", "","El campo codigo_evento_nt no puede esta vacio");
		
	$servicesFacade = ServicesFacade::getInstance();
	$res=$servicesFacade->cancelarEvento_OrigenRemoto($id_instancia_remota, $id_pedido_remoto, $codigo_evento_nt);
    if (is_a($res,"Celsius_Exception"))
      return new soap_fault("Server", "ServicesFacade",$res->getMessage());
      
    return $res;
}

function getEventosOrigenRemoto($id_instancia_remota,$id_pedido){
	//valido los parametros
	if (empty($id_pedido) || !is_string($id_pedido))
		return new soap_fault("Client", "","El campo id_pedido no puede esta vacio");
		
	$servicesFacade = ServicesFacade::getInstance();
	$res=$servicesFacade->getEventosOrigenRemoto($id_pedido);
    if (is_a($res,"Celsius_Exception"))
      return new soap_fault("Server", "ServicesFacade",$res->getMessage());
      
    return $res;
}


$s = new soap_server();
$s->register("crearPedido_OrigenRemoto");
$s->register("generarEvento_OrigenRemoto");
$s->register("cancelarEvento_OrigenRemoto");
$s->register("getEventosOrigenRemoto");

if (!isset($HTTP_RAW_POST_DATA))
	$HTTP_RAW_POST_DATA = '';	
$s->service($HTTP_RAW_POST_DATA);

?>