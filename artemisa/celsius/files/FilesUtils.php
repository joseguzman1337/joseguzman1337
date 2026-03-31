<?
require_once "../exceptions/File_Exception.php";

class FilesUtils {
	/**
	 * 
	 */
	function createZipFile($source_files, $destination_file, $extensiones_validas = "") {

		$createZip = new createZip;
		$createZip->addDirectory("/");
		
		foreach ($source_files as $arch) { //obtengo cada uno de los archivos y los meto en el zip junto a su nombre

			$posPunto = strrpos($arch, ".");
			if ($posPunto !== false) 
				$extension = substr($arch, $posPunto);
			else
				$extension = ""; 
			
			
			if (empty ($extensiones_validas) || ((stripos($extensiones_validas, $extension) !== FALSE) && !empty($extension))) {
				$handle = @fopen($arch, "rb");
				if ($handle === false){
					//Logger::log($error_message);
					return new File_Exception("Se ha producido un error al intentar abrir el archivo '$arch'. Contactese con el administrador del sistema.");

				}
				$contents = @fread($handle, filesize($arch));
				
				if ($contents === false){
					//Logger::log($error_message);
					return new File_Exception("Se ha producido un error al intentar leer del archivo '$arch'. Contactese con el administrador del sistema.");
				}
				fclose($handle);
				$createZip->addFile($contents, $arch);
				
			}
		}
		
		$fd = @fopen ($destination_file, "wb");
		if ($fd == FALSE){
			return new Application_Exception("No se pudo abrir el archivo '$destination_file' para escritura. Compruebe que tenga los permisos correspondientes.");
		}
		$out = fwrite ($fd, $createZip -> getZippedfile());
		if ($out == false){
			return new Application_Exception("No se pudo escribir el contenido del archivo zip en  '$destination_file'. ");
		}
		fclose ($fd);
		return true;	
		
	}

	/**
	 * Busca que el MimeType del archivo indicado como parametro este dentro de los conocidos.
	 * Si no es asi devuelve 0.
	 */
	function checkMimeType($file) {
		$tipos = array (
			"application/x-gzip-compressed" => 1,
			"application/x-zip-compressed" => 1,
			"application/x-tar" => 1,
			"text/plain" => 2,
			"text/html" => 3,
			"image/bmp" => 4,
			"image/gif" => 4,
			"image/jpeg" => 4,
			"image/pjpeg" => 4,
			"application/pdf" => 7,
			"application/msword" => 8,
			"application/csv" => 9,
			"application/x-msexcel" => 9,
			"application/x-mspowerpoint" => 10
		);

		foreach ($tipos as $tipo => $valor) {
			if ($tipo == $file['type'])
				return $valor;
		}
		return 0;
	}

	/**
	 * Mueve un archivo subido al servidor a la carpeta $destination_dir bajo el nombre indicado
	 * en $filename. Si $filename no se especifica entonces se utilizara el nombre del archivo 
	 * en la maquina del cliente.
	 * @return array result. En caso de exito se devolvera un array con los sig campos 
	 * 		0 => nombre real del archivo creado en el directorio $destination_dir
	 * 		1 => mimeType del archivo subido
	 * 		2 => tamaño del archivo
	 * @throws File_Exception En caso de producirse algun error. 
	 */
	function upload_file($file, $destination_dir, $filename = "") {
		
		if (!is_dir($destination_dir))
			return new File_Exception("El directorio '$destination_dir' no es un directorio valido");

		if ($file['error'] != 0) { //UPLOAD_ERR_OK == 0
			switch ($file['error']) {
				case 1 : //UPLOAD_ERR_INI_SIZE
					$error_message = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
					break;
				case 2 : //UPLOAD_ERR_FORM_SIZE
					$error_message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
					break;
				case 3 : //UPLOAD_ERR_PARTIAL
					$error_message = "The uploaded file was only partially uploaded. ";
					break;
				case 4 : //UPLOAD_ERR_NO_FILE
					$error_message = "No file was uploaded. ";
					break;
				case 6 : //UPLOAD_ERR_NO_TMP_DIR
					$error_message = "Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.";
					break;
				case 7 : //UPLOAD_ERR_CANT_WRITE
					$error_message = "Failed to write file to disk. Introduced in PHP 5.1.0. ";
					break;
				case 8 : //UPLOAD_ERR_EXTENSION
					$error_message = "File upload stopped by extension. Introduced in PHP 5.2.0.";
					break;
				default :
					$error_message = "An unknown error (ErrNo " . $file['error'] . ") has ocurred with the uploaded file";
			}
			return new File_Exception("Se produjo el siguiente error: '" . $error_message . "'");
		}

		$location = $file['tmp_name'];
		$size = $file['size'];
		$mimeType = $file['type'];
		if (empty ($filename)) {
			if (!empty ($file['name']))
				$filename = $file['name'];
			else
				$filename = $location;
		}

		if (is_uploaded_file($location) && ($size != 0)) {
			if (move_uploaded_file($location, $destination_dir . $filename))
				return array (
					$filename,
					$mimeType,
					$size
				);
			else
				return new File_Exception("El archivo no pudo ser movido en el servidor por algun motivo");
		}

		return new File_Exception("El archivo no pudo ser almacenado en el servidor por algun motivo");

	}

	/**
	 * Indica si el vector enviado como parametro tiene algun archivo.
	 */
	function containsFiles($files_vector) {
		
		if (is_array($files_vector))
			foreach ($files_vector as $file_field_name => $file) {
				if (is_array($file) && !empty ($file['size']))
					return true;
			}
		return false;
	}
	
	/**
	 * Devuelve todos los nombres de archivos existentes en el directorio $base_dir que coincidan con la expresion regular $regexp 
	 */
	function getFilesNamed($base_dir, $regexp){
		$cwd = getcwd();
		
		if (chdir($base_dir)){
			$filenames = glob($regexp);
			chdir($cwd);
		}else
			$filenames = array();
		return $filenames;
	}
	
	function checkSlashes($path){
		if (basename($path.'a') == basename($path))
			return $path.DIRECTORY_SEPARATOR;
		else
			return $path;
	}
	
	function borrarArchivos($base_dir, $filesnames){
		$base_dir = FilesUtils::checkSlashes($base_dir);
		foreach($filesnames as $filename){
			$resDeletion = unlink($base_dir.$filename);
		}
	}
	
	function leerArchivoCompleto($fileName){
		if (!file_exists($fileName)) {
	        return new File_Exception("El archivo ($outputFileName) no existe");
	    }
		
		if (!$handle = fopen($fileName, 'rb')) {
	        return new File_Exception("No se puede abrir el archivo ($outputFileName)");
	    }
	    
		$file_content = fread($handle,filesize($fileName));
		if ($file_content === false)
			return new File_Exception("No se pudo leer el contenido del archivo ($outputFileName)");
			
		fclose($handle);
		return $file_content; 
	}
	
	function escribirArchivoCompleto($outputFileName, $file_contents){
		
		if (!$handle = fopen($outputFileName, 'wb')) {
	        return new File_Exception("No se puede abrir el archivo ($outputFileName)");
	    }
		if (fwrite( $handle, $file_contents) === false)
			return new File_Exception("Se produjo un error al tratar de escribir los datos en el archivo ($outputFileName)");
			
  		fclose( $handle );
		return true; 
	}
	 
	
	
}
?>