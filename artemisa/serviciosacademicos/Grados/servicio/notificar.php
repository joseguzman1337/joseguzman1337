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

	require_once '../lib/pdf/dompdf/dompdf_config.inc.php';
	
	include '../lib/phpMail/class.phpmailer.php';
	include '../lib/phpMail/class.smtp.php';

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
	
	$persistencia = new Singleton( );
	$persistencia->conectar( );
	
	$controlClienteCorreo = new ControlClienteCorreo( $persistencia );
	$controlCarrera = new ControlCarrera( $persistencia );
	$controlEstudiante = new ControlEstudiante( $persistencia );
	$controlDocumentacion = new ControlDocumentacion( $persistencia );
	
	
	$carreras = $controlCarrera->consultarCarreraNotificar( );
	$estudiantes = $controlEstudiante->consultarEstudianteGraduarse( );
	
	
	switch( $tipoOperacion ){
		
		case "estudiantesGraduarse":
	
			if( count( $estudiantes ) != 0 ){
				$i = 1;		
				foreach( $estudiantes as $estudiante ){
					
					if( $estudiante->getUsuarioEstudiante( )->getUser( ) != "" ){
						$emailEstudiante = $estudiante->getUsuarioEstudiante( )->getUser( )."@unbosque.edu.co";
						$nombreEstudiante = $estudiante->getNombreEstudiante( );
						$nombreFacultad = $estudiante->getFechaGrado( )->getCarrera( )->getFacultad( )->getNombreFacultad( );
						$fechaGrado = $estudiante->getFechaGrado( )->getFechaGraduacion( );
						$fechaMaxima = $estudiante->getFechaGrado( )->getFechaMaxima( );
						$controlClienteCorreo->enviarNotificacionEstudiante( $emailEstudiante, $nombreEstudiante, $nombreFacultad, $fechaGrado, $fechaMaxima );
					}
				}
			}
		break;
	
		case "notificarFacultad": 
		
			if(count( $carreras ) != 0 ){
				$j = 1;
				foreach( $carreras as $carrera ){
					if( $carrera->getCodigoCarrera( ) != "" ){
						$codigoCarrera = $carrera->getCodigoCarrera( );
						$codigoFacultad = $carrera->getFacultad( )->getCodigoFacultad( );
						$controlClienteCorreo->enviarNotificacionPrograma( $codigoFacultad, $codigoCarrera );
					}
				}
			}
			
		break;
	
		case "estudiantesSemestre":
			
			$estudianteIngles = $controlEstudiante->consultarEstudiantesNotificarIngles( );
	
			if(count( $estudianteIngles ) != 0 ){
				$k = 1;
				foreach( $estudianteIngles as $estudianteIngle ){
					if( $estudianteIngle->getUsuarioEstudiante( )->getUser( ) != "" ){
						
						$txtCodigoCarrera = $estudianteIngle->getFechaGrado( )->getCarrera( )->getCodigoCarrera( );
						$txtCodigoEstudiante = $estudianteIngle->getCodigoEstudiante( );
						$emailEstudiante = $estudianteIngle->getUsuarioEstudiante( )->getUser( )."@unbosque.edu.co";
						$nombreEstudiante = $estudianteIngle->getNombreEstudiante( );
						$nombreFacultad = $estudianteIngle->getFechaGrado( )->getCarrera( )->getFacultad( )->getNombreFacultad( );
						
						$documentoIngles = $controlDocumentacion->buscarDocIngles( $txtCodigoEstudiante, $txtCodigoCarrera );
						
						if( $documentoIngles->getIdDocumentacion( ) == "" ){
							$controlClienteCorreo->enviarNotificacionEstudianteSemestre( $emailEstudiante, $nombreEstudiante, $nombreFacultad );
						}
					}		
				}
			}
			
		break;
	
	}
	
?>