<?php 
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 * @since enero  23, 2017
 */ 
$mensaje=null;
include('../../../kint/Kint.class.php');
if( isset( $_POST['oculto'] ) ){
		
	$txtDocumentoAnterior=htmlspecialchars( $_POST['txtDocumentoAnterior'] );
	$txtDocumentoNuevo=htmlspecialchars( $_POST['txtDocumentoNuevo'] );
	$cbmTipoDocumentoNuevo=trim( $_POST['cbmTipoDocumentoNuevo'] );
	$cbmTipoDocumentoAnterior=trim( $_POST['cbmTipoDocumentoAnterior'] );
	
	if( $cbmTipoDocumentoAnterior == -1 ){
		$mensaje="<script>document.getElementById('errorTipoDocumentoAntiguo').innerHTML='<strong><font color=red>Seleccione un tipo de documento</font></strong>'</script>";
		
	}elseif( $txtDocumentoAnterior == '' ){
		$mensaje="<script>document.getElementById('errordocumentoAnterior').innerHTML='<strong><font color=red>Ingrese número de documento antiguo</font></strong>'</script>";
		
	}elseif( $cbmTipoDocumentoNuevo == -1 ){
		$mensaje="<script>document.getElementById('errorTipoDocumentoNuevo').innerHTML='<strong><font color=red>Seleccione un tipo de documento</font></strong>'</script>";
		
	}elseif( $txtDocumentoNuevo=='' ){
		$mensaje="<script>document.getElementById('errordocumentoNuevo').innerHTML='<strong><font color=red>Ingrese número de documento nuevo</font></strong>'</script>";
	
	}else{
	ini_set('display_errors','On');

	session_start( );

	include '../tools/includes.php';
	include '../control/ControlEstudianteGeneral.php';
	include '../control/ControlEstudiante.php';
	include '../control/ControlEstudianteDocumento.php';
	include '../control/ControlOrdenPago.php';
	include '../control/ControlPrematricula.php';
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

	$controlEstudianteGeneral = new ControlEstudianteGeneral( $persistencia );
	$controlOrdenPago = new ControlOrdenPago( $persistencia );
	$controlPrematricula = new ControlPreMatricula( $persistencia );
	
	
	
	$estudianteGeneralA = $controlEstudianteGeneral->buscarIdentificacionEstudiante( $cbmTipoDocumentoAnterior,$txtDocumentoAnterior );
	$estudianteGeneralN = $controlEstudianteGeneral->buscarIdentificacionEstudiante( $cbmTipoDocumentoNuevo,$txtDocumentoNuevo );
	
	$arrayEstudianteA = $estudianteGeneralA->consultarIdEstudianteGeneral( $cbmTipoDocumentoAnterior,$txtDocumentoAnterior  );
	$arrayEstudianteN = $estudianteGeneralN->consultarIdEstudianteGeneral( $cbmTipoDocumentoNuevo,$txtDocumentoNuevo  );

	/**
	 * Consulta tamaño del 	array Estudiante antiguo
	 * @param array $arrayEstudianteA
	 * @access public
	 * @return int $tamañoArrayEstudianteA
	 */

	 $tamanoArrayEstudianteA = sizeof( $arrayEstudianteA );
	
	/**
	 * Consulta tamaño del 	array Estudiante nuevo
	 * @param array $arrayEstudianteN
	 * @access public
	 * @return int $tamañoArrayEstudianteN
	 */
	$tamanoArrayEstudianteN = sizeof( $arrayEstudianteN );
	
	if( $tamanoArrayEstudianteA>0 ){
		 foreach ( $arrayEstudianteA as $estudiantesGeneral ) {
			$idEstudianteGeneralAntiguo=$estudiantesGeneral->getIdEstudiante( );
			$estudiantesGeneral->getNombreEstudiante( ).' '.$estudiantesGeneral->getApellidoEstudiante( );			
		 }	

	}else{
		$mensaje="<script>alert('Tipo o numero de documento antiguo incorrecto')</script>";
		}
	
		if( $tamanoArrayEstudianteN>0 ){
			
		 foreach ( $arrayEstudianteN as $estudiantesGeneralN ) {
		 	
			$idEstudianteGeneralNuevo=$estudiantesGeneralN->getIdEstudiante();			
			$estudiantesGeneralN->getNombreEstudiante().' '.$estudiantesGeneralN->getApellidoEstudiante();
		 }	
		
	}else{
		$mensaje="<script>alert('Tipo o numero de documento nuevo incorrecto')</script>";
		}
		
	if( $tamanoArrayEstudianteA > 0 and $tamanoArrayEstudianteN > 0 ){
	
		$controlEstudiante = new ControlEstudiante( $persistencia );	
		$estudiante = $controlEstudiante->buscarEstudiante( $idEstudianteGeneralAntiguo , $idEstudianteGeneralAntiguo );
		$arrayEstudiante = $estudiante->buscarEstudiante( $idEstudianteGeneralAntiguo , $idEstudianteGeneralAntiguo);
		$arrayEstudianteacutal = $estudiante->buscarEstudianteActual( $idEstudianteGeneralNuevo, $idEstudianteGeneralAntiguo );
		
		foreach ( $arrayEstudiante as $estudiantes ) {
	     	
	     $codigoEstudiante = $estudiantes->getcodigoEstudiante( );					 
		 $estudiante = $controlEstudiante->actualizarIdEstudiante( $codigoEstudiante , $idEstudianteGeneralNuevo );
		 $actualizarEstudiante = $estudiante->actualizarIdEstudianteGeneral( $codigoEstudiante , $idEstudianteGeneralNuevo );
		
		}
		
		
		$controlEstudianteDocumento = new ControlEstudianteDocumento( $persistencia );
		
    	
    	$venceNuevo='2099-12-31';	
		$fecha = date('Y-m-j');
		$venceAntiguo= strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
		$venceAntiguo = date ( 'Y-m-j' , $venceAntiguo );
		
		$controlEstudianteDocumento->actualizarfechavencimientoId($venceAntiguo, $idEstudianteGeneralNuevo,$idEstudianteGeneralAntiguo );
							
		$estudianteDocumentoAntiguo=$controlEstudianteDocumento->actualizarfechavencimiento( $venceAntiguo , $cbmTipoDocumentoAnterior , $txtDocumentoAnterior , $idEstudianteGeneralAntiguo );
		$estudianteDocumentoNuevo=$controlEstudianteDocumento->actualizarfechavencimiento( $venceNuevo , $cbmTipoDocumentoNuevo , $txtDocumentoNuevo , $idEstudianteGeneralNuevo );
		
		$usuario= new ControlUsuario( $persistencia );		
		$usuario->actualizartipodocumento( $cbmTipoDocumentoAnterior, $txtDocumentoAnterior, $cbmTipoDocumentoNuevo, $txtDocumentoNuevo );
		
		
		
		
		foreach ( $arrayEstudianteacutal as $actual ) {
		 
		$codigoEstudianteAnterior = $actual->getcodigoEstudiante();	
		$codigoEstudianteNuevo = $actual->getCodigoMayor();
			
		$ordenPago = $controlOrdenPago->ActualizarCodigoEstudianteOrden( $codigoEstudianteNuevo , $codigoEstudianteAnterior );
		$ordenPago->ActualizarCodigoEstudiante( $codigoEstudianteNuevo , $codigoEstudianteAnterior );
				
		$preMatricula = $controlPrematricula->ActualizarCodigoEstudiantePreMatricula( $codigoEstudianteNuevo , $codigoEstudianteAnterior );
		$preMatricula->ActualizarCodigoEstudiante( $codigoEstudianteNuevo , $codigoEstudianteAnterior );
			
		}
			
		echo $mensaje="<script>alert('Estudiante actualizado')</script>";
		$mensaje="<script>window.location='home.php'</script>";
		
		}
		
	}
echo $mensaje;
}

?>