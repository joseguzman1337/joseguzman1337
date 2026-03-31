<?php 
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package servicio
 * @since enero  23, 2017
 */ 
 
	include '../tools/includes.php';
	include '../control/ControlEstudianteGeneral.php';

	ini_set('display_errors','On');
	session_start( );

	if( isset ( $_SESSION["datoSesion"] ) ){
	
		$user = $_SESSION["datoSesion"];
		$idPersona = $user[ 0 ];
		$luser = $user[ 1 ];
		$lrol = $user[3];
		$persistencia = new Singleton( );
		$persistencia = $persistencia->unserializar( $user[ 4 ] );
		$persistencia->conectar( );
	
	}else{
		header( "Location:error.php" );
	}
 
	$accion = $_POST["accion"];
	
	$tipoDocumento = $_POST["tipoDocumento"];
	$numeroDocumento = $_POST["numeroDocumento"];
	
		$controlEstudianteGeneral = new ControlEstudianteGeneral( $persistencia );
		$estudianteGeneral = $controlEstudianteGeneral->buscarIdentificacionEstudiante( $tipoDocumento, $numeroDocumento );
		$arrayEstudiante=$estudianteGeneral->consultarIdEstudianteGeneral( $tipoDocumento, $numeroDocumento );

		$tamañoArrayEstudiante = sizeof( $arrayEstudiante );
		
	if( $accion=="anterior" ){
		if( $tamañoArrayEstudiante == 0 ){
			echo "<strong><font color=red>Tipo  o número de documento incorrecto</font></strong>";
		}else{
		 foreach ( $arrayEstudiante as $estudiantesGeneral ) {
			$estudiantesGeneral->getIdEstudiante();
			$estudiantesGeneral->getNombreEstudiante().' '.$estudiantesGeneral->getApellidoEstudiante();
		 }	
		 echo '<strong>Nombre:'.$estudiantesGeneral->getNombreEstudiante().' '.$estudiantesGeneral->getApellidoEstudiante().'</strong>';
		}
	}elseif( $accion=="nuevo" ){
		if( $tamañoArrayEstudiante == 0 ){
			
			echo "<strong><font color=red>Tipo  o número de documento incorrecto</font></strong>";
		}else{
			
		 foreach ( $arrayEstudiante as $estudiantesGeneral ) {
					
				$estudiantesGeneral->getIdEstudiante();
				$estudiantesGeneral->getNombreEstudiante().' '.$estudiantesGeneral->getApellidoEstudiante();
			 }	
		 echo '<strong>Nombre:'.$estudiantesGeneral->getNombreEstudiante().' '.$estudiantesGeneral->getApellidoEstudiante().'</strong>';
		}
	}

?>