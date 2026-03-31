<?php 

	header ('Content-type: text/html; charset=utf-8');
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	ini_set('display_errors','On');
	set_time_limit(0);
	
	session_start( );
	


	include '../tools/includes.php';
	include '../control/ControlIncentivoAcademico.php';
	
		
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
	
	$controlIncentivo = new ControlIncentivoAcademico( $persistencia );
	

	
		


	switch ( $accion ) {
		case 'actualizar':

			 	$controlIncentivo->actualizarIncentivoRegistros( $txtNumeroActaIncentivoActualizar , $txtFechaActaIncentivoActualizar , $txtObservacionActualizar, $idRegistro ,$idPersona );

			break;
		
		case 'eliminar':
                    /**
                     *@modified Diego Rivera<riveradiego@unbosque.edu.co>
                     *Se añade varialbe idpersona a metodo acutalizarIncentivos
                     *@Since January 29,2019 
                     */
				$verIncentivo = $controlIncentivo->buscarIncentivoEstudiantes( $estudiante , $carrera , $incentivo );
				$id = $verIncentivo->getIdIncentivo( );
                                $controlIncentivo->actualizarIncentivos( $id ,$idPersona );

			break;
	}

?>

