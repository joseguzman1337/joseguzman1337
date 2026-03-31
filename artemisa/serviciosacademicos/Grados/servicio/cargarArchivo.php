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
	
	include '../control/ControlCarrera.php';
	include '../control/ControlItem.php';
	include '../control/ControlPeriodo.php';
	include '../control/ControlFacultad.php';
	include '../control/ControlTipoDocumento.php';
	include '../control/ControlContacto.php';
	include '../control/ControlEstudiante.php';
	include '../control/ControlTrabajoGrado.php';
	include '../control/ControlConcepto.php';
	include '../control/ControlDocumentacion.php';
	include '../control/ControlFechaGrado.php';
	include '../control/ControlPazySalvoEstudiante.php';
	include '../control/ControlPreMatricula.php';
	include '../control/ControlClienteWebService.php';
	include '../control/ControlCarreraPeople.php';
	include '../control/ControlActaAcuerdo.php';
	include '../control/ControlIncentivoAcademico.php';
	include '../control/ControlClienteCorreo.php';
	
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
		$persistencia = new Singleton( );
		$persistencia = $persistencia->unserializar( $user[ 4 ] );
		$persistencia->conectar( );
	}else{
		header("Location:error.php");
	}
	
	

	$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
	$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
	
	
	if( !empty($_FILES) ){
	
		$txtFechaGrado = $_POST["txtFechaGrado"];
		
		$target_dir = "../documentos/actas/".$txtFechaGrado."/";
		$fileName = str_replace($no_permitidas, $permitidas , basename($_FILES["fileToUpload"]["name"]));
		$uploadOk = 1;
		$fileParts = pathinfo($_FILES["fileToUpload"]["name"]);
		/*$extension = ".".$fileParts["extension"];
		$fileName = "Anexo".$extension;*/
		$target_file = $target_dir . $fileName;
		
		// Check if image file is a actual image or fake image
		
		if($_POST["tipoOperacion"] == "submit") {
		    $check = $fileParts["extension"];
		    if( $check == "pdf") {
		        $uploadOk = 1;
		    } else {
		        $uploadOk = 0;
		    }
		}
		
		// Check if file already eists
		if (file_exists($target_file)) {
		    //echo "Disculpa, el archivo ya existe,";
		    $uploadOk = 0;
		    echo "-1";
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 5000000) {
		    //echo "Disculpa, el archivo es demasiado pesado,";
		    $uploadOk = 0;
			echo "-2";
		}
		// Allow certain file formats
		if( $fileParts["extension"] != "pdf" && $uploadOk == 0  ) {
		   // echo "Solo se permiten archivos pdf,";
		    $uploadOk = 0;
			echo "-3";
		}
		// Check if $uploadOk is set to 0 by an error
		if ( $uploadOk == 0) {
		    //echo " el archivo no fue cargado.";
		// if everything is ok, try to upload file
		} else {
			if( !file_exists($target_dir) ){
					mkdir(str_replace('//','/',$target_dir), 0754, true);
				}
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "1";
		    } else {
		        echo "Ocurrió un error cargando el archivo.";
		    }
		}
	
	}else{
		echo "0";
	}

?>