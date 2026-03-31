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
	
	switch( $tipoOperacion ){
		
		case "guardarObservacion":
			$controlActividadMetaSecundaria = new ControlActividadMetaSecundaria( $persistencia );
			$controlMeta = new ControlMeta( $persistencia );
			if( $txtIdTipoIndicador != 1 ){
				$controlActividadMetaSecundaria->actualizarObservacionActividad( $txtObservacionSupervisor, $idPersona, $txtIdActividadMetaSecundaria );
				if( $txtAvanceSupervisor != "" ){
					$controlMeta->actualizaAvanceMetaSecundaria( $txtAvancePropuesto, $txtAvanceSupervisor, $idPersona, $txtIdMetaSecundaria );
				}else{
					echo "Por favor ingrese un valor de avance";
				}
			}else{
				$controlActividadMetaSecundaria->actualizarObservacionActividad( $txtObservacionSupervisor, $idPersona, $txtIdActividadMetaSecundaria );
			}
		break;
	}
?>