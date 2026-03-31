<?php 
   /**
   * @author Diego Rivera <riveradiego@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
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
	include '../control/controlAvancesIndicadorPlanDesarrollo.php';
	include '../control/ControlMeta.php';
	
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
	
   $controlAvancesIndicadorPlanDesarrollo = new controlAvancesIndicadorPlanDesarrollo( $persistencia );

   $controlMetaSecundaria = new  ControlMeta( $persistencia );
  
   $cuenta = count($_FILES);		
   $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
   $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
   $target_dir = "../evidencia/";
   $fileTypes = array('doc', 'docx', 'txt', 'xlsx', 'xls' , 'pdf');
   $imprime = "";
   $imprime=$cuenta;
   
   if( $cuenta != 0 ){
   	$numeradorArchivo=date("YmdHis").'_';
	   	for( $i = 0; $i < $cuenta ; $i++ ){
	   		
	   		$fileName = $numeradorArchivo.str_replace($no_permitidas, $permitidas , basename($_FILES["fileToUpload".$i]["name"]));
			$uploadOk = 1;
			$fileParts = pathinfo($_FILES["fileToUpload".$i]["name"]);
			$target_file = $target_dir . $fileName;
			
				if($_POST["tipoOperacion"] == "submitActualizar") {
				   	 $check = $fileParts["extension"];
						if (in_array(strtolower($check), $fileTypes)){
					        $uploadOk = 1;
					    } else {
					        $uploadOk = 0;
							$imprime ='-3';
					    }
				}
				
				if ($_FILES["fileToUpload".$i]["size"] > 10000000) {
				    $uploadOk = 0;
					 $imprime = "-2";
				}
						
				
				if ( $uploadOk == 0) {
				
					} else {
			
				 		 if (move_uploaded_file($_FILES["fileToUpload".$i]["tmp_name"], $target_file)) {
				 		 	  
				 		 	unlink($target_dir.$archivo);
							$controlAvancesIndicadorPlanDesarrollo->actualizarEvidenciaAvance( $idAvance , $actividad , $avancePropuesto , $fileName , $fechaActividad );
						   	$archivo=$fileName;	
						   
						   	$imprime = "1_".$archivo;
		 					
						    } else {
						    	
					 	    	   echo "0";
					  		}
					}
				}		
  	} else {
  	//$imprime=$idMetaPrincipal;
	  	$controlAvancesIndicadorPlanDesarrollo->actualizarEvidenciaAvance( $idAvance , $actividad , $avancePropuesto , $archivo , $fechaActividad );
	  	$imprime="1_".$archivo;
	
  }
	
echo $imprime;
?>