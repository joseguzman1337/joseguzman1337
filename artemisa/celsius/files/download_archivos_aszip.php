<?
/**
 * Esta pagina permitirá hacer el download de los archivos pdf, en un solo archivo zip. 
 * Los administradores podrán bajarse el archivo,sin restricción alguna. (bajan todos los pdf del pedido en el zip) 
 * Para los usuarios comunes, descontará de la cuenta corriente el monto correspondiente
 * por el download.(bajan los pdf no descargados del pedido en el zip) 
 * @param string $id_pedido el id del pedido que se va a bajar
 */
 
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
$usuario = SessionHandler :: getUsuario();
$rol_usuario = SessionHandler :: getRolUsuario();

$pageName = "downloads"; 
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$directorio = Configuracion::getDirectorioUploads();
if (is_a($directorio, "File_Exception")){
    		return $directorio;
}
		
$archivos_pedido= $servicesFacade->getArchivosPedido($id_pedido);				
$nombre_archivos = array();

/*Administrador*/
if (!empty ($archivos_pedido)){
	
	foreach($archivos_pedido as $archivo_pedido){
		 if(($rol_usuario == ROL__ADMINISTADOR)or(($rol_usuario != ROL__ADMINISTADOR)and($archivo_pedido["Permitir_Download"] == 1))) {
		 		
		 		$nombre_archivos[]= $directorio.$archivo_pedido["nombre_archivo"];
		 		$filename = $archivo_pedido["nombre_archivo"];
		 		$pathCompleto = $directorio . "/" . $filename;
	     
		 		if (file_exists($pathCompleto)){
		 		
		 			if (($rol_usuario != ROL__ADMINISTADOR)and($archivo_pedido["Permitir_Download"] == 1)){
		 				$res = $servicesFacade->registrarDescargaArchivoPedido($archivo_pedido, $usuario["Id"], $rol_usuario);
		 				if (is_a($res, "Celsius_Exception")) {
		 					$mensaje_error = $Mensajes["error.registrarDescarga"];;
							$excepcion = $res;
							require "../common/mostrar_error.php";		 							 					
		 				}
		 			}
		 		}
		 		else{
		 			$mensaje_error= $Mensajes["error.archivoInexistente"];
		 			$excepcion = $res= new File_Exception($mensaje_error);
		 			require "../common/mostrar_error.php";
		 		}
		  
		 }
	}
	
	
	$nombreZipFile = $id_pedido.".zip";
	$resCreacionZip = FilesUtils::createZipFile($nombre_archivos,$directorio.$nombreZipFile);
	if ($resCreacionZip !== true){
		if(is_a($resCreacionZip, Celsius_Exception)){
			$mensaje_error= $Mensajes["error.archivoInexistente"];
		 	$excepcion = $resCreacionZip;
		 	require "../common/mostrar_error.php";
		}
		else
			return $resCreacionZip;	
	}
	
	$pathCompleto = $directorio.$nombreZipFile;
	$size = filesize($pathCompleto);
	header("Content-type: application/zip");
	header("Content-Disposition:attachment; filename= $nombreZipFile");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Accept-Ranges: bytes");
	header("Content-Length:$size");
	@ readfile($pathCompleto);
		
}
else 
{
	require "../layouts/top_layout_admin.php";
	?>
	<table bgcolor='#B7CFE1' align='center' width='70%' cellspacing=0>
	<tr height="40">
		<td bgcolor='#B7CFE1' valign='middle' align='center' colspan='2'>
			<font face='MS Sans Serif' size='1' color='#333399'>
				<? if (empty ($archivo)){
					//el archivo no existe
					echo $Mensajes["warning.archivosNoExisten"];
				}else{
					//el usuario ya bajo el archivo
					echo $Mensajes['err-1'];
				} ?>
				</font>
			</td>
		</tr>
	</table>
	<? require "../layouts/base_layout_admin.php"; 
}
?>