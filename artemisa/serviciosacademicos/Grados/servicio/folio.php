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
	
	ini_set('display_errors','Off');
	set_time_limit(0);
	
	session_start( );
	
	include "../../funciones/clases/fpdf/fpdf.php";
	//require_once("../../funciones/clases/fpdf/cellfit.php");
	define("FPDF_FONTPATH","../../funciones/clases/fpdf/font/");
	
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
	include '../control/ControlFuncionFolio.php';
	
	
	function fechaActual( ){
		$fechaActual = date("Y-m-d");
		$fechaActual = strtotime($fechaActual);
		return $fechaActual;
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
	
	$controlCarrera = new ControlCarrera( $persistencia );
	$array_registrograduadofolio = "";
	
	$controlFuncionFolio = new ControlFuncionFolio( $persistencia );
	
	switch( $tipoOperacion ){
		
		
		
		case "previsualizar":
			
			$registroGrados = $controlRegistroGrado->consultarRegistroGradoFolioCarrera( );
			/**
			 * Modificado la variable $luser se cambia por $idPsersona para enviar el codigo del
			 * usuario que hace la tarea
			 * @author Andres Ariza <arizaandres@unbosque.edu.co>
			 * @since Noviembre 1 2016
			*/
			$controlFuncionFolio->folioPDF($registroGrados, $idPersona, $controlRegistroGrado );
			
			
			
		break;
			
		case "generar":
			
			/**
			 * En caso de que sea Generar, se utiliza la misma funcion de previsualizar, 
			 * pero se le envia un parametro adicional en false (ultimo parametro) 
			 * para idenficar que no es previsualizacion
			 * @author Andres Ariza <arizaandres@unbosque.edu.co>
			 * @since Noviembre 1 2016
			*/
			$registroGrados = $controlRegistroGrado->consultarRegistroGradoFolioCarrera( );
			$controlFuncionFolio->folioPDF($registroGrados, $idPersona, $controlRegistroGrado, false );
		
		break;
		
		
	}
?>