<?php

/**
 *	Clase de auxiliar que provee un acceso transparente a la configuracion de la aplicacion.  
 */
class Configuracion {
	
	var $_instance;
	
 	function getInstance(){
 		/*
 		if (!isset(self::$_instance)){
 			self::$_instance = 
 		}
 		return self::$_instance;
 		*/
 		return new Configuracion();
 	}
 	
 	
 	
	/**
	 * @access private
	 */
	function Configuracion(){
	}
	
	function getIdCelsiusLocal() {
		return Configuracion::getParametro("id_celsius_local");
	}
	
	function getDirectorioTemporal() {
		$dt= Configuracion::getParametro("directorio_temporal");
		if((!is_dir($dt))||(!is_writable($dt))){
			$mensaje_error = "Error en el directorio temporal: No existe el mismo o no tiene los permisos necesarios";
			$file_ex= new File_Exception($mensaje_error);	
			return $file_ex;
		}	
		if ((substr($dt,-1)!="/") && (substr($dt,-1)!="\\"))
			$dt.="/";
		return $dt;
	}
	function getDirectorioUploads() {
		$du = Configuracion::getParametro("directorio_upload");
		if((!is_dir($du))||(!is_writable($du))){
			$mensaje_error = "Error en el directorio de uploads: No existe el mismo o no tiene los permisos necesarios";
			$file_ex= new File_Exception($mensaje_error);	
			return $file_ex;
		}	
		
		if ((substr($du,-1)!="/") && (substr($du,-1)!="\\"))
			$du.="/";
		
		return $du;
	}
	function getMailContacto() {
		return Configuracion::getParametro("mail_contacto");
	}
	function getTituloSitio() {
		return Configuracion::getParametro("titulo_sitio");
	}

	function isNTHabilitado() {
		return Configuracion::getParametro("nt_enabled") == 1;
	}
	
	/**
	 * Medida en segundos que dura una sesiï¿½n
	 */
	function getDuracionSesion() {
	   // Este IF deberia tener la ip local de cada lugar en donde se instala
		if (strncmp($_SERVER["REMOTE_ADDR"],"163.10.",7) == 0)
			return 18000;
		else 
			return 1800; 
	}
	
	function get_DB_Host() {
		return Configuracion::getProperty("DB_Host");
	}
	
	function get_DB_User() {
		return Configuracion::getProperty("DB_User");
	}
	
	function get_DB_Password() {
		return Configuracion::getProperty("DB_Password");
	}
	
	function get_DB_DatabaseName() {
		return Configuracion::getProperty("DB_DatabaseName");
	}

	function get_DB_Port() {
		return Configuracion::getProperty("DB_Port");
	}
	
	/* ********************************************************************/
	/* ********************* FUNCIONES AUXILIARES PRIVADAS ****************/
	/* ********************************************************************/
	
	function getSF() {
		
		global $servicesFacade;
		if (empty ($servicesFacade)) {
			require_once "ServicesFacade.php";
			$servicesFacade = ServicesFacade::getInstance();
		}
		
		return $servicesFacade;
	}

	/**
	 * @access private
	 */
	function getParametro($parametro) {
		$servicesFacade = Configuracion::getSF();
		if (is_a($servicesFacade, "Celsius_Exception"))
			return $servicesFacade;
		return $servicesFacade->getConfiguracion($parametro);
	}
	
	/**
	 * Devuelve el valor de la propiedad (del archivo de propiedades) con nombre $propertyName  
	 * @access private
	 */
	function getProperty($propertyName){
		$props = Configuracion::getProperties();
		return $props[$propertyName];
	}
	
	/**
	 * Devuelve las propiedades definidas en un archivo de configuracion.
	 * Una vez q se levantan, las propiedades son almacenadas en una variable static 
	 * para evitar recargarla cada vez q se invoca un metodo. EL metodo es rapido, tarda 3ms en una PIV
	 * @param bool $forceReload Indica si es necesario racargar el archivo nuevamente. Por default es false
	 * @return array properties Un arreglo con las propiedades que se levantaron del archivo de props
	 * @access private 
	 */
	function getProperties($forceReload = false){
		static $properties;
		
		if (empty($properties) || $forceReload){
				
			$wd = getcwd();
			chdir(dirname(__FILE__));
			$propertiesFileName = "parametros.properties.php";
			if (!file_exists($propertiesFileName)){
				//TODO Esto esta mal. manejar como se debe
				echo "<br>El archivo de propiedades '$propertiesFileName' no se encontro. Se utilizaran los valores por defecto.<br>";
				//se le asigna valores por default.
				$properties = array("DB_Host" => "localhost","DB_User" => "root","DB_Password" => "root","DB_DatabaseName" => "celsiusNT","DB_Port" => "3306");
			}else{
				$properties = require $propertiesFileName;
			}
			
		chdir($wd);
		}
		return $properties;
	}
	
	/*
	function getProperties($forceReload = false){
		static $properties;
		$wd = getcwd();
		chdir(dirname(__FILE__));
		if (empty($properties) || $forceReload){
			$propertiesFileName = "./parametros.properties";
			if (!file_exists($propertiesFileName)){
				//TODO Esto esta mal. manejar como se debe
				echo "<br>El archivo de propiedades '$propertiesFileName' no se encontro. Se utilizaran los valores por defecto.<br>";
				//se le asigna valores por default.
				$properties = array("DB_Host" => "localhost","DB_User" => "root","DB_Password" => "root","DB_DatabaseName" => "celsiusNT","DB_Port" => "3306");
			}else{
				$handle = fopen($propertiesFileName, "r");
				if ($handle === false)
					die("No se pudo abrir el archivo '$propertiesFileName'. Chequee los permisos del mismo.");
				$properties = Configuracion::loadPropertiesFromFile($handle);
			}
		}
		chdir($wd);
		return $properties;
	}
	
	*/
	/*
	 * Lee un archivo de propiedades. Se asume una propiedad por linea, 
	 * donde el nombre de la propiedad esta separado del valor de la misma 
	 * por el primer signo =. Los comentarios inician con el simbolo # 
	 * @param fp $propertiesFile El archivo de propiedades
	 * @return array Las propiedades leidas del archivo
	 * @access private
	 
	function loadPropertiesFromFile($propertiesFile) {
		$contents = '';
		while (!feof($propertiesFile)) 
			//podria usar file_get_contents, pero solo funciona a partir de php4.3
			$contents .= fread($propertiesFile, 8192);
			
		
		$properties = array();
		$lines = preg_split('/(\\r\\n|\\n|\\r)/', $contents); // DOS: \r\n	UNIX: \n	MAC: \r
		for ($i = 0; $i < count($lines); $i++) {// processa cada linea
			$line = $lines[$i];
			
			//saca los comentarios (comienzan con #)
			$line = preg_replace("/#.* /", "", $line);

			// la declaracion de la propiedad posee un signo igual
			if (strpos($line,"=") !== false) {
				$property = explode("=",$line,2);
				// el nombre de la propiedad es hasta el primer =; el resto el el valor de la misma
				$propertyName = trim($property[0]);
				if (!empty($propertyName)){
					//el nombre de la propiedad debe estar definido
					$properties[$propertyName]=trim($property[1]);
				}
			}
		}//del for
		
		return $properties;
	}
*/
		
	function getMaxFilesizeUpload(){
		return "10";
	}
	function getMaxFilesizePOST(){
		return "7";
	}
	function getMemoryLimit(){
		return "52";
	}
}

?>