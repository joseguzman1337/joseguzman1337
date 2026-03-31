<?

/**
 * Clase auxiliar que contiene funciones para manejo de strings
 */
class StringUtils{
	
	function StringUtils(){
		die("Esta clase no se instancia!!!!");
	}
	
	/**
	 * Devuelve un boolean q indica si el string enviado como parametro es una cadena simple, sin caracteres especiales ni acentuados 
	 */
	function is_simple_string($string){
		return $string == remove_special_chars($string);
	}
	
	/**
	 * Reemplaza los caracteres acentuados de un string con los caracteres q correspondan sin el acento
	 */
	function replace_accents($string) {
	   $string = htmlentities($string);
	   $string = preg_replace ('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil|ring);/', '$1', $string);
	   return html_entity_decode($string);
	}
	
	/**
	 * Remueve todos los caracteres especiales, y caracteres acentuados de un string
	 */
	function remove_special_chars($string) {
	   return preg_replace ('/[^a-zA-Z0-9]/', '', $string);
	}
	
	function isValidURL_WSDL($url) {
		return preg_match('|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?.wsdl$|i', $url);
	}
	
	/**
	 * Esta funcion recibe un path absoluto a un directorio y valida:
	 * 	si esta bien formada
	 * 	si el directorio existe
	 * 	si es modificable
	 * Si el path especificado pasa la prueba se devuelve el mismo path con las 
	 * barras acomodadas (\-->/) y una barra al final.
	 * @throws File_Exception en caso de que el path sea erroneo
	 */
	function parseAndValidateDirectory($dirname) {
		if (empty($dirname) || !is_string($dirname)){
			return new File_Exception("La ruta del directorio no es un string o es nula");
		}
		//podria usarse la constante PATH_SEPARATOR o DIRECTORY_SEPARATOR pero no tiene sentido ya que directamente se usa /
		$dirname = stripslashes($dirname);

		$dirname = preg_replace("/([\\\\\/]+)/","/",$dirname);
		
		if (substr($dirname, -1, 1) !== "/")
			$dirname .= "/";
		$primerCaracter = substr($dirname,0,1);
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
			//windows
			if (strtolower($primerCaracter) === strtoupper($primerCaracter)){
				//no es una letra
				return new File_Exception("La ruta del directorio debe comenzar con una letra");
			}
			if (substr($dirname, 1, 1) !== ":"){
				//tiene :
				return new File_Exception("La ruta del directorio debe poser el caracter ':' luego de la letra de unidad");
			}
		}else{
			//es linux u otro SO
			if ($primerCaracter!== "/"){
				//no es una /
				return new File_Exception("La ruta del directorio debe comenzar con una /");
			}
		}
		
		if (!is_dir($dirname)){
			return new File_Exception("El directorio especificado no existe");
		}
		if (!is_writable($dirname)){
			return new File_Exception("El directorio especificado no puede ser escrito por la aplicacion. Chequee que los permisos sobre el directorio sean correctos.");
		}
		return $dirname;
	}
	
	/**
	 * Devuelve el mensaje en una sola linea con <br/> y con los caracteres especiales escapados
	 */
	function getSafeString($message, $format="script"){
		if ($format == "html")
			return StringUtils::getSafeStringForHTML($message);
		else
			return StringUtils::getSafeStringForScript($message);
	}
	
	
	function getSafeStringForHTML($message){
		return htmlspecialchars(addslashes(str_replace(array("\r\n", "\r", "\n"), "<br/>", $message)));
	}
	function getSafeStringForScript($message){
		return (str_replace(array("\r\n", "\r", "\n"), '\n', addslashes($message)));
	}
	
	function convert_AbbrNotation_to_AbbrNotation($val, $destNotation) {
	    $val = StringUtils::convert_bytesAbbrNotation_to_fullBytes($val);
	    $destNotation = strtolower($destNotation);
	    switch($destNotation) {
	        case 'g':
	            $val /= 1024;
	        case 'm':
	            $val /= 1024;
	        case 'k':
	            $val /= 1024;
	    }
	    return $val;
	}
	
	
	function convert_bytesAbbrNotation_to_fullBytes($val) {
	    $val = trim($val);
	    $ultimo = strtolower($val{strlen($val)-1});
	    switch($ultimo) {
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }
	
	    return $val;
	}
		
	
}

?>