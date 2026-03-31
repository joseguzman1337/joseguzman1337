<?php
require_once "../exceptions/WS_Exception.php";
require_once "../libs/nusoap.php";
require_once "../libs/class.zip.php";
ini_set("soap.wsdl_cache_enabled", "0");

define( 'path_wsdl_celsius', "soap-celsius/celsius-celsius.wsdl" );

class CelsiusSOAPClient {
	var $servicesFacade;
	var $datosInstanciaLocal;
	var $pool;
	 

	function CelsiusSOAPClient($servicesFacade) {
		$this->servicesFacade = $servicesFacade;
		$this->idInstanciaLocal = $servicesFacade->getConfiguracion("id_celsius_local");
		$this->pool = array ();
	}

	function getClient($id_instancia_remota) {
		$pool = $this->pool;

		if (!array_key_exists($id_instancia_remota, $pool)) {

			$instancia = $this->servicesFacade->getInstancia_Celsius($id_instancia_remota);
			$wsdl_instancia_remota = ltrim($instancia["sitio_web"],'/').'/'. path_wsdl_celsius;

			$wsdl = & new wsdl($wsdl_instancia_remota, false, false, false, false, 10, 20);
			$sc = new nusoap_client($wsdl, true);

			//valida error en la creacion del sc
			if (($error = $sc->getError()) !== FALSE) {
				//$this->printDebug($sc,true);
				return new WS_Exception("No se pudo crear el SoapClient con la instancia $id_instancia_remota",$error);
			} 
			$sc = $sc->getProxy();
			//valida error en la creacion del proxy
			if (($error = $sc->getError()) !== FALSE) {
				return new WS_Exception("No se pudo crear el Proxy al SoapClient de la instancia $id_instancia_remota",$error);
			}
			$sc->setCredentials($this->idInstanciaLocal,$instancia["password"]);
			
			//guarda en el proxy los datos de acceso
			//$sc->setCookie("id_instancia_celsius", $id_instancia_remota);
			//$sc->setCookie("id_instancia_celsius", $this->idInstanciaLocal);
			//$sc->setCookie("passMD5", md5($instancia["password"]));
			
			//salva el cliente soap creado en el pool
			$pool[$id_instancia_remota] = $sc;

			$this->pool = $pool;
		}

		return $pool[$id_instancia_remota];
	}

	function crearPedido_DestinoRemoto($id_instancia_remota, $pedidoLocal) {
	
		$soapClient = $this->getClient($id_instancia_remota);
		
		if (is_a($soapClient, "Celsius_Exception"))
			return $soapClient;
		
		$cols = array_keys($pedidoLocal);
		$values = array_values($pedidoLocal);
				
		$idPedidoRemoto = $soapClient->crearPedido_OrigenRemoto($this->idInstanciaLocal, $cols, $values);
        //$this->printDebug($soapClient);        
        return $this->revisarResultado("crearPedido_DestinoRemoto", $id_instancia_remota,$idPedidoRemoto,"string", $soapClient);

	}
	
	function cancelarEvento_DestinoRemoto($id_instancia_remota, $id_pedido_local, $codigo_evento_nt) {

		$soapClient = $this->getClient($id_instancia_remota);
		if (is_a($soapClient, "Celsius_Exception"))
			return $soapClient;

		$result = $soapClient->cancelarEvento_OrigenRemoto($this->idInstanciaLocal, $id_pedido_local, $codigo_evento_nt);

		return $this->revisarResultado("cancelarEvento_DestinoRemoto", $id_instancia_remota,$result,"boolean", $soapClient);
	}

	function generarEvento_DestinoRemoto($id_instancia_remota, $idPedido, $eventoNuevo, $miRol, $attach_file_contents) {

		$soapClient = $this->getClient($id_instancia_remota);
		//var_dump($soapClient);
		if (is_a($soapClient, "Celsius_Exception"))
			return $soapClient;

		$cols = array_keys($eventoNuevo);
		$values = array_values($eventoNuevo);
		$suRol = $this->switchRol($miRol);

		$result = $soapClient->generarEvento_OrigenRemoto($this->idInstanciaLocal, $idPedido, $cols, $values, $suRol, chunk_split(base64_encode($attach_file_contents)));

		return $this->revisarResultado("generarEvento_DestinoRemoto", $id_instancia_remota,$result,"boolean", $soapClient);
	}

	function getEventosDestinoRemoto($id_instancia_remota, $id_pedido) {
		$soapClient = $this->getClient($id_instancia_remota);
		if (is_a($soapClient, "Celsius_Exception"))
			return $soapClient;
			
		$result = $soapClient->getEventosOrigenRemoto($id_instancia_remota, $id_pedido);

		return $this->revisarResultado("getEventosDestinoRemoto", $id_instancia_remota,$result,"array", $soapClient);
	}

	///////////////////////////////////////////////////////////////////////
	//////////////////////// funciones auxiliares /////////////////////////
	///////////////////////////////////////////////////////////////////////
	
	function switchRol($rol) {
		if ($rol == "creador")
			return "proveedor";
		elseif ($rol == "proveedor") return "creador";
	}
	
	
	/**
	 * Esta funcion chequea que no se hayan producido soapFaults en la invocacion a un metodo, o errores de otro tipo.
	 * En caso de error devuelve una WS_Exception, caso contrario devuelve la variable resultado recibida como parametro.
	 *  
	 * @param string $tipo_dato_esperado. "boolean", "integer", "double", "string", "array", "object", "resource", "NULL" , "unknown type"
	 */
	function revisarResultado($nombre_metodo_invocado,$id_instancia_remota, $resultado, $tipo_dato_esperado, $soapClient){
		if ($soapClient->fault) {
		    return new WS_Exception("La invocacion al metodo $nombre_metodo_invocado de la instancia '$id_instancia_remota' genero el siguiente error (SoapFault): ",$soapClient->getError());
		}elseif (($error = $soapClient->getError()) !== false){
			return new WS_Exception("La invocacion al metodo $nombre_metodo_invocado de la instancia '$id_instancia_remota' genero el siguiente error:", var_export($soapClient->getError(),true));
		}elseif (gettype($resultado) != $tipo_dato_esperado){
			return new WS_Exception("La invocacion al metodo $nombre_metodo_invocado de la instancia '$id_instancia_remota' genro el siguiente error: ","El resultado de la invocacion es de un tipo de datos inesperado (".gettype($resultado)."). con valor : ".var_export($resultado, true));
		}
		return $resultado;
	}

	/**
	 * Funcion auxiliar que imprime en la salida el request y el response Soap.
	 * Opcionalmente imprime el debug generado por nusoap
	 * @access private
	 */
	function printDebug($soapClient, $printDebug = false) {
		print "<pre>\n";
		print "Request :\n" . htmlspecialchars($soapClient->request) . "\n";
		print "Response:\n" . htmlspecialchars($soapClient->response) . "\n";
		if ($printDebug)
			print $soapClient->getDebug();
		print "</pre>";
		
	}
	
}
?>