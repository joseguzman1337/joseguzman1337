<?php
  /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package servicio
   */
  
  
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
	include '../control/ControlActaGrado.php';
	include '../control/ControlRegistroGrado.php';
	include '../control/ControlDirectivo.php';
	include '../control/ControlIncentivoAcademico.php';
	include '../control/ControlDocumentoGrado.php';
	
	function unserializeForm($str) {
    	$strArray = explode("&", $str);
	    foreach($strArray as $item) {
	        $array = explode("=", $item);
	        $returndata[] = $array[1];
	    }
	    return $returndata;
	}	
	
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
	
	$controlRegistroGrado = new ControlRegistroGrado( $persistencia );
	$controlIncentivoAcademico = new ControlIncentivoAcademico( $persistencia );
	$controlDocumentoGrado = new ControlDocumentoGrado( $persistencia ); 
	
	$registroGrados = $controlRegistroGrado->consultarRegistroGrado( $txtFechaGrado, $txtCodigoCarrera );
	
	$txtDirectivos = unserializeForm($ckFirmas);
	
	
	
	foreach( $registroGrados as $registroGrado ){
		
		$txtCodigoEstudiante = $registroGrado->getEstudiante( )->getCodigoEstudiante( );
		$incentivoEstudiante = $controlIncentivoAcademico->buscarIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera );
		$txtIdRegistroGrado = $registroGrado->getIdRegistroGrado( );
		foreach( $txtDirectivos as $txtDirectivo ){
			$txtIdDirectivo = $txtDirectivo;
			$txtCodigoTipoDocumentoGrado = $cmbTipoDocumentoGrado;
				if( $txtCodigoTipoDocumentoGrado == 3 ){
					if( count( $incentivoEstudiante->getIdIncentivo( ) ) != 0 ){
						if( $incentivoEstudiante->getIdIncentivo( ) != "" ){
							$txtCodigoIncentivo = $incentivoEstudiante->getCodigoIncentivo( );
							$txtIdIncentivo = $incentivoEstudiante->getIdIncentivo( );
							$controlDocumentoGrado->crearFirmaDocumentoGrado($txtIdRegistroGrado, $txtIdIncentivo, $txtIdDirectivo, $txtCodigoTipoDocumentoGrado, $txtCodigoIncentivo);
						}
					}
				}else{
					$txtCodigoIncentivo = 1;
					$txtIdIncentivo = 1;
					$controlDocumentoGrado->crearFirmaDocumentoGrado($txtIdRegistroGrado, $txtIdIncentivo, $txtIdDirectivo, $txtCodigoTipoDocumentoGrado, $txtCodigoIncentivo);
				}	
			
		}
		
	}
	
?>