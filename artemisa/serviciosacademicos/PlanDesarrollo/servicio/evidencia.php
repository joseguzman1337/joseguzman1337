<?php
    /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package servicio
   */
	
	require_once ('../../../kint/Kint.class.php');
  
  	header ('Content-type: text/html; charset=utf-8');
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	ini_set('display_errors','On');
	
	session_start( );
	
	include '../tools/includes.php';
	
	//include '../control/ControlRol.php';
	include '../control/ControlItem.php';
	include '../control/ControlPeriodo.php';
	include '../control/ControlLineaEstrategica.php';
	include '../control/ControlPlanProgramaLinea.php';
	include '../control/ControlPrograma.php';
	include '../control/ControlProyecto.php';
	include '../control/ControlProgramaProyecto.php';
	include '../control/ControlIndicador.php';
	include '../control/ControlTipoIndicador.php';
	include '../control/ControlMeta.php';
	include '../control/ControlActividadMetaSecundaria.php';
	
	if($_POST){
		$keys_post = array_keys($_POST);
		foreach ($keys_post as $key_post) {
			if( is_array($_POST[$key_post]) ){
				$$key_post = $_POST[$key_post];
			}else{
				$$key_post = strip_tags(trim($_POST[$key_post]));
			}
			$variables->$key_post = strip_tags(trim($_POST[$key_post]));
		}
	}
	
	if($_GET){
	    $keys_get = array_keys($_GET); 
	    foreach ($keys_get as $key_get){
	    	if( is_array($_GET[$key_get]) ){ 
	        	$$key_get = $_GET[$key_get]; 
			}else{
				$$key_post = strip_tags(trim($_GET[$key_get]));
			}
			$variables->$key_get = strip_tags(trim($_GET[$key_get]));
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
	
	$controlActividadMetaSecundaria = new ControlActividadMetaSecundaria( $persistencia );
	$controlMeta = new ControlMeta( $persistencia );
	$cuenta = count($_FILES);
	
	//var_dump( $_FILES );
	$txtAvanceSupervisor = 0;
	$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
	$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
	$target_dir = "../evidencia/".$txtIdMetaPrincipal."/".$txtIdMetaSecundaria."/";
	$fileTypes = array('doc', 'docx', 'txt', 'xlsx', 'xls' , 'pdf');
	$imprime = "";
	if( $cuenta != 0 and $cuenta < 11 ){
		for( $i = 0; $i < $cuenta ; $i++ ){		
			
			$fileName = str_replace($no_permitidas, $permitidas , basename($_FILES["fileToUpload".$i]["name"]));
			$uploadOk = 1;
			$fileParts = pathinfo($_FILES["fileToUpload".$i]["name"]);
			$extension = ".".$fileParts["extension"];
			$fileName = "Anexo".$extension;
			$target_file = $target_dir . $fileName;
			
			// Check if image file is a actual image or fake image
			
			if($_POST["tipoOperacion"] == "submit") {
			    $check = $fileParts["extension"];
				if (in_array(strtolower($check), $fileTypes)){
			        $uploadOk = 1;
			    } else {
			        $uploadOk = 0;
			    }
			}
			
			// Check if file already eists
			if (file_exists($target_file)) {
			    //echo "Disculpa, el archivo ya existe,";
			    $uploadOk = 0;
			    $imprime = "-1";
			}
			// Check file size
			if ($_FILES["fileToUpload".$i]["size"] > 5000000) {
			    //echo "Disculpa, el archivo es demasiado pesado,";
			    $uploadOk = 0;
				 $imprime = "-2";
			}
			// Allow certain file formats
			if( $fileParts["extension"] != "pdf" && $uploadOk == 0  ) {
			   // echo "Solo se permiten archivos pdf,";
			    $uploadOk = 0;
				$imprime = "-3";
			}
			// Check if $uploadOk is set to 0 by an error
			if ( $uploadOk == 0) {
			    //echo " el archivo no fue cargado.";
			// if everything is ok, try to upload file
			} else {
				if( !file_exists($target_dir) ){
						mkdir(str_replace('//','/',$target_dir), 0754, true);
					}
			    if (move_uploaded_file($_FILES["fileToUpload".$i]["tmp_name"], $target_file)) {
			        $imprime = "1";
			    } else {
			        echo "Ocurrió un error cargando el archivo.";
			    }
			}
			
		}
		if( $imprime == 1 ){
			$existe = $controlActividadMetaSecundaria->existeActividadMeta( $txtIdMetaSecundaria );
			if( $existe != 1 ){
				$controlActividadMetaSecundaria->crearActividadMetaSecundaria($txtIdMetaSecundaria, $txtNombreActividad, $txtFechaActividad, $idPersona);
				$controlMeta->actualizaAvanceMetaSecundaria( $txtAvancePropuesto, $txtAvanceSupervisor, $idPersona, $txtIdMetaSecundaria );
			}else{
				$controlActividadMetaSecundaria->actualizarActividad( $txtNombreActividad, $txtFechaActividad, $idPersona, $txtIdMetaSecundaria, $txtIdMetaSecundaria );
				$controlMeta->actualizaAvanceMetaSecundaria( $txtAvancePropuesto, $txtAvanceSupervisor, $idPersona, $txtIdMetaSecundaria );
			}
			echo $imprime;
		}else{
			echo $imprime;	
		}
		
	}else{
		$existe = $controlActividadMetaSecundaria->existeActividadMeta( $txtIdMetaSecundaria );
		if( $existe != 1 ){
			$controlActividadMetaSecundaria->crearActividadMetaSecundaria($txtIdMetaSecundaria, $txtNombreActividad, $txtFechaActividad, $idPersona);
			$controlMeta->actualizaAvanceMetaSecundaria( $txtAvancePropuesto, $txtAvanceSupervisor, $idPersona, $txtIdMetaSecundaria );
		}else{
			$controlActividadMetaSecundaria->actualizarActividad( $txtNombreActividad, $txtFechaActividad, $idPersona, $txtIdMetaSecundaria );
			$controlMeta->actualizaAvanceMetaSecundaria( $txtAvancePropuesto, $txtAvanceSupervisor, $idPersona, $txtIdMetaSecundaria );
			
		}
		echo "1";
	}
?>