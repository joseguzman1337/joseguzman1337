<?php
  /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
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
	set_time_limit(0);
	
	//session_start( );
	
	include '../lib/nuSoap5/nusoap.php';
	
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
	include '../control/ControlDeudaPeople.php';
	
	require_once "../../consulta/interfacespeople/conexionpeople.php";
	require_once "../../consulta/interfacespeople/reporteCaidaPeople.php";
	
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
	
	$persistencia = new Singleton( );
	$persistencia->conectar( );
	
	
	$controlClienteWebService = new ControlClienteWebService( $persistencia );
	
	//echo $controlClienteWebService->verificarDeudaPeopleCron( );
	$controlCarrera = new ControlCarrera( $persistencia );
	
	$controlDeudaPeople = new ControlDeudaPeople( $persistencia );
	
	$cuentaDeuda = $controlDeudaPeople->contarDeudaPeople( );
	
	if( $cuentaDeuda != 0 ){
		$controlDeudaPeople->eliminarDeudaPeople( );
	}
		
		
	$carreras = $controlCarrera->consultarCarreraNotificar( );
	foreach( $carreras as $carrera ){
		
		$txtCodigoCarrera = $carrera->getCodigoCarrera( );
		$txtCodigoCentroBeneficio = $carrera->getCodigoBeneficio( );
		
		/*$txtCodigoCarrera = 124;*/
		/*$txtCodigoCentroBeneficio = "IS000290";*/
		
		$controlClienteWebService->verificarDeudaPeopleCron( $txtCodigoCarrera, $txtCodigoCentroBeneficio );
	//	$controlClienteWebService->verificarDeudaPeopleCron( $txtCodigoCarrera, "AD900000" );
	}
	
	
?>
