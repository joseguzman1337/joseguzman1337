<?php

/**
 * Clase encargada de comunicarse con el directorio. Actual como cliente WS.
 * Es el encargado de conseguir las actualizaciones del directorio local en base a los 
 * datos conseguidos desde el directorio.prebi.unlp.edu.ar.
 *  
 */
require_once ("../mappings/Mapper.php");
require_once ("../libs/nusoap.php");
require_once "../exceptions/WS_Exception.php";
require_once "../common/ServicesFacade.php";


ini_set("soap.wsdl_cache_enabled", "0");
define("path_wsdl_directorio","/soap-directorio/directorio.wsdl");

class ProxyDirectorio {
	var $soapClient;
	var $mapper;
	var $servicesFacade;
	
	
	
	/**
	 * 
	 */
	function getInstance($servicesFacade){
	//var_dump($servicesFacade);	
		$url_directorio = $servicesFacade->getConfiguracion("url_directorio");
		$wsdl_directorio = $url_directorio.(path_wsdl_directorio);
		$wsdl = & new wsdl($wsdl_directorio, false, false, false, false, 10, 20);
		$soapClient = new nusoap_client($wsdl, true, array (
			'encoding' => 'ISO-8859-1'
		));

		//valida error en la creacion del sc
		if (($error = $soapClient->getError()) !== FALSE) {
			return new WS_Exception("No se pudo crear el SoapClient con el directorio ($wsdl_directorio). Compruebe que la url del directorio sea correcta.",$error);
		}
		
		$soapClient = $soapClient->getProxy();
		//valida error en la creacion del proxy
		if (($error = $soapClient->getError()) !== FALSE) {
			return new WS_Exception("No se pudo crear el Proxy del SoapClient con el directorio ($wsdl_directorio). Compruebe que la url del directorio sea correcta.",$error);
		}
		
		$parametros=$servicesFacade->getParametros();
//		var_dump($parametros["id_celsius_local"],$parametros["password_directorio"]);
		$soapClient->setCredentials($parametros["id_celsius_local"],$parametros["password_directorio"]);
		
		$_instance = new ProxyDirectorio();
		$_instance->servicesFacade = $servicesFacade;
		$_instance->soapClient = $soapClient->getProxy();
		$_instance->mapper = new Mapper();
		return $_instance;
		
	}
	
	/**
	 * @access private
	 */
	function ProxyDirectorio() {
		
	}
	
	

	/**
	 * Actualiza el directorio local con los datos del direcotrio que fueron modificados a partir de la fecha indicada por el 
	 * campo ulttima_fecha_Actualizacion de la tabla parametros. 
	 * @return bool Indica si el proceso termino satisfactoriamente o no
	 * @throws WS_Exception si se produce algun error al invocar el metodo remoto
	 * @throws DB_Exception si se produce un error con la BDD
	 * @throws Celsius_Exception  en caso de generarse algun otro tipo de error
	 * @access public
	 */
	function updateDirectory() {
		$instanciaActual = $this->servicesFacade->getConfiguracion();

		$idInstanciaActual = $instanciaActual["id_celsius_local"];
		$ultActualizacion = strtotime($instanciaActual["ult_actualizacion_directorio"]);
		$soapClient = &$this->soapClient;
		

		$tablesUpdates = $soapClient->getDirectoryChanges($idInstanciaActual, $ultActualizacion);
		
$this->printDebug();
		if ($soapClient->fault) {
		    return new WS_Exception("La invocacion al metodo getDirectoryChanges del direcorio genero el siguiente error (SoapFault): ",$soapClient->getError());
		}elseif (($error = $soapClient->getError()) !== false){
			return new WS_Exception("La invocacion al metodo getDirectoryChanges del direcorio genero el siguiente error:", $error);
		}elseif (!is_array($tablesUpdates)){
			return new WS_Exception("La invocacion al metodo getDirectoryChanges  del direcorio genero el siguiente error: ","El resultado de la invocacion es de un tipo de datos inesperado (".gettype($tablesUpdates)."). con valor : ".var_export($tablesUpdates, true));
		}
				
		//genero el sql para ejecutar las actualizaciones en la BD local
		$updateSQL = $this->generateDirectoryUpdateSQL($tablesUpdates);
		
		//actualizo la BD local
		$res = $this->servicesFacade->ejecutarActualizacionDirectorio($updateSQL);
		if (is_a($res, "Celsius_Exception"))
			return $res;

		/*actualizo la fecha de la ultima actualizacion*/
		if (!empty($updateSQL)){		
			$nuevaFechaActualizacion = date("Y-m-d H:i:s");
			$res = $this->servicesFacade->modificarParametros(array ("ult_actualizacion_directorio" => $nuevaFechaActualizacion));
			if (is_a($res, "Celsius_Exception"))
				return $res;
		}

		return true;
	}

	/**
	 * Funcion que actualiza la informacion de la tablka parametros, en base a los datos 
	 * almacenados en el directorio
	 * @throws WS_Exception si se produce algun error al invocar el metodo remoto
	 * @throws DB_Exception si se produce un error con la BDD
	 * @throws Celsius_Exception  en caso de generarse algun otro tipo de error
	 * @access public
	 */
	function updateInformacionInstanciaLocal() {
		$sf = $this->servicesFacade;
		$instanciaActual = $sf->getConfiguracion();
		$idInstanciaActual = $instanciaActual["id_celsius_local"];
		$soapClient = $this->soapClient;
		
		$infoInstancia = $soapClient->getInformacionInstancia($idInstanciaActual);

		if ($soapClient->fault) {
		    return new WS_Exception("La invocacion al metodo getInformacionInstancia del direcorio genero el siguiente error (SoapFault): ",$soapClient->getError());
		}elseif (($error = $soapClient->getError()) !== false){
			return new WS_Exception("La invocacion al metodo getInformacionInstancia del direcorio genero el siguiente error:", $error);
		}elseif (!is_array($infoInstancia)){
			return new WS_Exception("La invocacion al metodo getInformacionInstancia  del direcorio genero el siguiente error: ","El resultado de la invocacion es de un tipo de datos inesperado (".gettype($infoInstancia)."). con valor : ".var_export($infoInstancia, true));
		}
		$datos_instancia = array_combine($infoInstancia[0], $infoInstancia[1]);
		

		//id_celsius_local ya se seteo en la instalacion
		$res = $this->servicesFacade->modificarParametros(array (
			"id_pais" => $datos_instancia["id_pais"],
			"id_institucion" => $datos_instancia["id_institucion"],
			"id_dependencia" => $datos_instancia["id_dependencia"],
			"id_unidad" => $datos_instancia["id_unidad"]
		));
		if (is_a($res, "Celsius_Exception"))
			return $res;
		
		return true;
	}

	/////////////////////////////////////////////////////////////////////////////
	//////////////////////// funciones auxilares ////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////

	/**
	 * Devuelve un script para actualizar la base de datos local con esos datos.							
	 * @param $tablesUpdates
	 * @return (Array) Una coleccion de estructuras. Cada estructura esta definida por el wsdl del servidor.
	 * @access private
	 */
	function generateDirectoryUpdateSQL($tablesUpdates) {
		$updateSQL = array ();
		if (is_array($tablesUpdates) && count($tablesUpdates) > 0) {
			for ($i = 0; $i < count($tablesUpdates); $i++) {
				$updateSQL = array_merge($updateSQL, $this->updateDirectoryTable($tablesUpdates[$i]));
			}
		}
		return $updateSQL;
	}

	function generateRecordUpdateSQL($tableName, $columnMappingsByIndex, $record) {
		//Se asume que el campo id esta en la posicion 0

		$fieldValues = array ();
		foreach ($columnMappingsByIndex as $localColumnName => $remoteColumnPosition) {
			//echo "remoteColumn=$localColumnName , remoteValue=".$record[$remoteColumnPosition]."<br>";
			$fieldValues[] = $localColumnName . "='" . $record[$remoteColumnPosition] . "'";
		}
		$fieldValues = implode(", ", $fieldValues);

		if ($tableName == "instituciones") {
			$sql = "INSERT INTO $tableName " . " SET Codigo='" . $record[0] . "', " . $fieldValues . " ON DUPLICATE KEY UPDATE " . $fieldValues . ";\n";
		} else {
			$sql = "INSERT INTO $tableName " . " SET id='" . $record[0] . "', " . $fieldValues . " ON DUPLICATE KEY UPDATE " . $fieldValues . ";\n";
		}
		return $sql;
	}

	function updateDirectoryTable($table) {
		$aux = array ();
		$remoteTableName = $table["tableName"];
		$tableStructure = (array) $table["tableStructure"];
		$records = (array) $table["tableData"];

		$columnMappings = $this->mapper->getRemoteToLocalTableColumnsMapping($remoteTableName);
		$columnMappingsByIndex = array ();

		foreach ($columnMappings as $remoteColumn => $localColumn) {
			$posCol = array_search($remoteColumn, $tableStructure);
			if ($posCol)
				$columnMappingsByIndex[$localColumn] = $posCol;
		}

		$localTableName = $this->mapper->getLocalTableName($remoteTableName);

		if (!empty ($records)) {
			if (count($records) > 1) {
				/*hay mas de un elemento para act. de la tabla*/
				for ($i = 0; $i < count($records); $i++) {
					if (!empty ($records[$i])) {
						$aux[] = $this->generateSQLInsert($localTableName, $columnMappingsByIndex, $records[$i]);
					}
				}
			} else {
				/*hay mas de un elemento para act. de la tabla*/
				if (!empty ($records)) {
					$aux[] = $this->generateSQLInsert($localTableName, $columnMappingsByIndex, $records);
				}
			}
		}
		return $aux;
	}

	function generateSQLInsert($tableName, $columnMappingsByIndex, $record) {
		/* Se asume que el campo id esta en la posicion 0 */

		$fieldValues = array ();
		foreach ($columnMappingsByIndex as $localColumnName => $remoteColumnPosition) {
			//echo "remoteColumn=$localColumnName , remoteValue=".$record[$remoteColumnPosition]."<br>";
			$fieldValues[] = $localColumnName . "='" . $record[$remoteColumnPosition] . "'";
		}

		if ($tableName != "instancias_celsius") {
			$fieldValues[] = "esCentralizado='1'";
		}

		$fieldValues = implode(", ", $fieldValues);

		if (strtolower($tableName) == "instituciones") {
			$sql = "INSERT INTO $tableName " . " SET Codigo='" . $record[0] . "', " . $fieldValues . " ON DUPLICATE KEY UPDATE " . $fieldValues . "\n";
		} else {
			$sql = "INSERT INTO $tableName " . " SET Id='" . $record[0] . "', " . $fieldValues . " ON DUPLICATE KEY UPDATE " . $fieldValues . "\n";
		}

		return $sql;
	}
	
	/**
	 * Funcion auxiliar interna que imprime informacion referente al mensaje soap enviado
	 * @access private
	 */
	function printDebug($printDebug = false){
		echo '<h2>Request</h2>';
		echo '<pre>' . htmlspecialchars($this->soapClient->request, ENT_QUOTES) . '</pre>';
		echo '<h2>Response</h2>';
		echo '<pre>' . htmlspecialchars($this->soapClient->response, ENT_QUOTES) . '</pre>';
		if ($printDebug){
			//Display the debug messages
			echo '<br/><h2>Debug</h2>';
			echo '<pre>' . htmlspecialchars($this->soapClient->debug_str, ENT_QUOTES) . '</pre>';
		}
	}
}
?>