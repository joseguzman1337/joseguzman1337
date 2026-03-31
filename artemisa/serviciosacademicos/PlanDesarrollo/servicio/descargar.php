<?php
  /**
 * @author Carlos Alberto Suarez Garrido <c.csuarez@sic.gov.co>
 * @copyright Subdireccion de Innovacion y Desarrollo Tecnologico
 * @package servicio
 */

	header ('Content-type: text/html; charset=utf-8');
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	ini_set('display_errors','On');
	
	
	session_start( );	

	include '../tools/includes.php';

	include '../servicio/funciones.php';
	
	//include '../control/ControlRol.php';
	include '../control/ControlRender.php';
	include '../control/ControlItem.php';
	include '../control/ControlPeriodo.php';
	include '../control/ControlLineaEstrategica.php';
	include '../control/ControlPrograma.php';
	include '../control/ControlProyecto.php';
	include '../control/ControlIndicador.php';
	include '../control/ControlMeta.php';
	include '../control/ControlTipoIndicador.php';
	include '../control/ControlProgramaProyecto.php';
	include '../control/ControlActividadMetaSecundaria.php';
	
	if($_POST){
			$keys_post = array_keys($_POST);
			foreach ($keys_post as $key_post) {
				$$key_post = strip_tags(trim($_POST[$key_post]));
			}
		}
		
	if($_GET){
	    $keys_get = array_keys($_GET); 
	    foreach ($keys_get as $key_get){ 
	        $$key_get = strip_tags(trim($_GET[$key_get])); 
	     } 
	}
	
	if( isset ( $_SESSION["datoSesion"] ) ){
		$user = $_SESSION["datoSesion"];
		$idPersona = $user[ 0 ];
		$luser = $user[ 1 ];
		$lrol = $user[3];
		$txtCodigoFacultad = $user[4];
		$persistencia = new Singleton( );
		$persistencia = $persistencia->unserializar( $user[ 5 ] );
		$persistencia->conectar( );
	}else{
		header("Location:error.php");
	}

	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header("Content-Type: application/force-download");
	header('Content-disposition: attachment; filename='. unserialize( urldecode( base64_decode( $_GET["bm9tYnJl"] ) ) ) );
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	
	
	$file = unserialize( urldecode( base64_decode( $_GET["dWJpY2FjaW9u"] ) ) );
	
	//echo $file;
	
	readfile($file);
	exit;
	
	
?>