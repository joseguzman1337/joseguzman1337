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
   
   /*modified Diego Rivera <riveradiego@unbosque.edu.co>
    * se añade controlactividadmetasecundiria para acutalizar avances de la meta secundaria
    * since 21-03-2017
    */
   
   $controlMetaSecundaria = new  ControlMeta( $persistencia );
   //fin modificacion
  
   $cuenta = count($_FILES);		
   $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
   $permitidas= array    ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
   $target_dir = "../evidencia/";
   $fileTypes =array('doc', 'docx', 'txt', 'xlsx', 'xls' , 'pdf');
   $imprime = "";
   
   
   /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
    *se añade a la validacion $cuenta != 0   la cantidad permitidad de archivos $cuenta < 11   
    *Since April 10,2017
    */

   if( $cuenta != 0  and $cuenta < 11){
   
   //fin modificacion
   	 $numeradorArchivo=date("YmdHis").'_';
   		for( $i = 0; $i < $cuenta ; $i++ ){
   		
	   		$fileName = $numeradorArchivo.str_replace($no_permitidas, $permitidas , basename($_FILES["fileToUpload".$i]["name"]));
			$uploadOk = 1;
			$fileParts = pathinfo($_FILES["fileToUpload".$i]["name"]);
			$target_file = $target_dir . $fileName;
		
			if($_POST["tipoOperacion"] == "submit") {
			  	  $check = $fileParts["extension"];
					
					if (in_array(strtolower($check), $fileTypes)){
				        $uploadOk = 1;
				    } else {
				        $uploadOk = 0;
						$imprime ='-3';
				    }
			}
			
			if ($_FILES["fileToUpload".$i]["size"] > 10000000) {
			    //echo "Disculpa, el archivo es demasiado pesado,";
			    $uploadOk = 0;
				$imprime = "-2";
			}
					
			
			
			if ( $uploadOk == 0) {
				
				
			}else {
		
		 		 if (move_uploaded_file($_FILES["fileToUpload".$i]["tmp_name"], $target_file)) {
			    
				  	  $controlAvancesIndicadorPlanDesarrollo ->crearAvanceIndicador( $txtIndicadorPlanDesarrolloId , $txtNombreActividad , $txtAvancePropuesto , $txtFechaActividad , $idPersona , $fileName );
  	        	  
				    /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
				    *se deja solo el control para insertar el avance del indicador debido a que los avances a la meta secundaria y primaria se hacen efectivos cuando se apruebe el avance
				    *Since March 27,2017 
				    */
				   
				  
				    /*modified Diego Rivera <riveradiego@unbosque.edu.co>
    				* se agrega control para  acutalizae avances de la meta secundaria 
					* variable $txtIndicadorPlanDesarrolloId hace referencia al id de la meta secundaria
				    * since 21-03-2017
				    */
				  //  $controlMetaSecundaria->actualizaAvanceMetaSecundaria($txtAvancePropuesto, 0 , $idPersona, $txtIndicadorPlanDesarrolloId);
				    //fin modificacion
				    
				   
				   
				    /*$metasAsociadas = $controlMetaSecundaria->verSecundarias( $idMetaPrincipal );
						$valorAvanceReal = 0;
						foreach ($metasAsociadas as $mSecundarias){
							$alcanceSecundaria = $mSecundarias->getValorMetaSecundaria( );
							$avanceSecundaria = $mSecundarias->getAvanceResponsableMetaSecundaria( );
							
							if( $avanceSecundaria > $alcanceSecundaria ){
								$avanceSecundaria = $alcanceSecundaria;
							}
							$valorAvanceReal = $valorAvanceReal + $avanceSecundaria;
						}*/
					/*modified Diego Rivera <riveradiego@unbosque.edu.co>
    				* se agrega control para  acutalizar avances de la meta principal 
					* variable int $valorAvanceReal , $idMetaPrincipal
				    * since 21-03-2017
				    */
					/*$controlMetaSecundaria->actualizarAvanceMetaPrincipal( $valorAvanceReal , $idMetaPrincipal );
				    //$imprime = "1";
 					$imprime=$valorAvanceReal;
 					*/
 					$imprime = "1";
 					//fin modificacoin 27-03-2017
				    } else {
			 	     $imprime = "1";
			  		  	}
				}
			
				
			}		
  	}else {
  		//$imprime=$idMetaPrincipal;
  		$imprime='0';
	
  }

echo $imprime;
?>