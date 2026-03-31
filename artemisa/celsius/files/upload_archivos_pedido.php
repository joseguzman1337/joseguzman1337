<?
/**
 * Este archivo posee funciones "generales" para trabajar con archivosde pedidos
 */

global $servicesFacade;

//Estas variables GLOBALES almacenan el nombre y la extension del archivo con el que se esta trabajando.
$nombre_archivo_subido = ''; 
$extension_archivo_subido = ''; 

//esta constante contiene el directorio donde se almacenan los archivos
define("DIRECTORIO", Configuracion::getDirectorioUploads());
if (is_a("DIRECTORIO", "File_Exception")){
    		return "DIRECTORIO";
    	 }

/**
 * Toma el nombre completo de un archivo $nombreArchivo y guarda 
 * el nombre y la extension en las variables globales $nombre_archivo_subido y
 * $extension_archivo_subido 
 */ 
function obtenerDetalleArchivo($nombreArchivo){
	global $nombre_archivo_subido;
	global $extension_archivo_subido;
	
	$inicio_extension = strpos($nombreArchivo, '.');

	if ($inicio_extension!== false) {
		$extension_archivo_subido = substr($nombreArchivo, $inicio_extension +1, strlen($nombreArchivo) - 1);
		$nombre_archivo_subido = substr($nombreArchivo, 0, $inicio_extension);
	} else {
		$nombre_archivo_subido = $nombreArchivo;
		$extension_archivo_subido = '';
	}
}

/**
 * Busca el archivo $nombreArchivo en el directorio DIRECTORIO. 
 * El $nombreArchivo puede incluir la extension del archivo, pero no es necesario
 * Retorna
 * 		1 si el archivo existe y es pdf
 * 		2 si existe y es arb
 * 		3 si existe ese nombre pero no es formato arb ni pdf(no deberia suceder)
 * 		0 en caso que no exista el archivo
 */
function buscarArchivoFisico($nombreArchivo) {
	
	global $nombre_archivo_subido;
	global $extension_archivo_subido;
	
	obtenerDetalleArchivo($nombreArchivo);
		
	$retorno = 0;

	if ($extension_archivo_subido == ''){ //solo se ingreso el nombre del archivo
		if (file_exists(DIRECTORIO . "/" . $nombre_archivo_subido . '.pdf'))
			return 1;
		if (file_exists(DIRECTORIO . "/" . $nombre_archivo_subido . '.arv'))
			return 2;
		return 0;
	} else {//se ingreso un nombre de archivo completo (con extension)
		if (!file_exists(DIRECTORIO . "/" . $nombreArchivo))
			return 0;
		if (strcasecmp($extension_archivo_subido, 'pdf') == 0)
			return 1;
		if (strcasecmp($extension_archivo_subido, 'arv') == 0)
			return 2;
		return 3;
	}
}

/** 
 * Busca el archivo $nombreArchivo en el directorio DIRECTORIO.
 * Si $nombreArchivo solo posee el nombre sin la extension, busca primero pdfs y luego arv 
 * (con ese orden de prioridad).
 * En caso de encontrarlo, genera una nueva tupla con: 
 * 		Fecha_Upload con la fecha y hora actual
 * 		Permitir_Download con el valor de la variable parametro $downloadPermitido
 * 		codigo_pedido con el valor del parametro $idPedido
 * 		nombre_archivo con $nombreArchivo
 * Una vez que se ha cargado la tabla archivos_pedidos, se incrementa en la tabla pedidos
 * la cantidad de archivos que tiene ese pedido.
 * Al finalizar, la funcion retorna el codigo de archivo generado, o 0 si no se genero ningun registro.
 */
function asociarPedidoAArchivo($id_pedido, $nombreArchivo, $downloadPermitido = 1) {
	global $nombre_archivo_subido, $extension_archivo_subido;
	global $servicesFacade;
		
	$tipoArchivo = buscarArchivoFisico($nombreArchivo);
		
	$nombre_completo = $nombre_archivo_subido . "." . $extension_archivo_subido;
		
	if ($tipoArchivo != 0) {
		$archivos_pedido = $servicesFacade->getAllObjects("archivos_pedidos", array("codigo_pedido" => $id_pedido, "nombre_archivo" => $nombre_completo));
		if (count($archivos_pedido) != 0){
			//El pedido (sin importar si es actual o historial) ya estaba cargado para ese archivo. 
			return 0;
		}
		
		$archivo_pedido_nuevo = array();
		$archivo_pedido_nuevo["Fecha_Upload"]= date("Y-m-d H:i:s");
		$archivo_pedido_nuevo["nombre_archivo"]= $nombre_completo;
		$archivo_pedido_nuevo["codigo_pedido"]= $id_pedido;
		$archivo_pedido_nuevo["Permitir_Download"]= (int)$downloadPermitido;
		
		$codigo_archivo = $servicesFacade->agregarArchivoPedido($archivo_pedido_nuevo);
		if (is_a($codigo_archivo, "Celsius_Exception"))
			return $codigo_archivo;
				
		if ($tipoArchivo == 1){ //solo los pdfs suman archivos
			$res = $servicesFacade->incrementarArchivosPedido($id_pedido);
			if (is_a($res, "Celsius_Exception"))
				return $res;
		}
		return $codigo_archivo;
	} else { //el archivo no fue encontrado
		return new File_Exception("El archivo '$nombreArchivo' no fue encontrado");
	}
}

/**
 * toma el file que recibe como parametro, sube y asocia todos los archivos con el pedido cuyo Id es $id_pedido
 * @access public
 */
function subirArchivoYAsociarAPedido($file, $id_pedido, $sufijo){
	
	if ($file['size'] != 0) {
		$destino = Configuracion::getDirectorioUploads();
		if (is_a($destino, "File_Exception")){
    		$mensaje_error = $destino->getMessage();
			$excepcion = $destino;
			require "../common/mostrar_error.php";
    	 }
		
		$nombre = $id_pedido ."_".$sufijo. ".pdf";
		$archivo_subido = FilesUtils::upload_file($file,$destino,$nombre);
				
		if (is_a($archivo_subido,"Celsius_Exception"))
			return $archivo_subido;
		else
			return asociarPedidoAArchivo($id_pedido, $archivo_subido[0]);
	}
	return true;
}
?>