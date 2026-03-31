<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package interfaz
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
	
	//include '../control/ControlRol.php';
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
	include '../control/ControlPazySalvoEstudiante.php';
	
	
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
	
	$controlConcepto = new ControlConcepto( $persistencia );
	
	$detalleOtros = $controlConcepto->consultarOtros( $txtCodigoEstudiante, $txtCodigoPeriodo );
	$i = 1;
	if(count($detalleOtros) != 0 ){
		
		echo "Las siguientes son las ordenes de pago que el estudiante tiene pendientes por pagar:"."<br /><br />";
		
		echo "<div style=\"overflow: auto; width: 100%; top: 0px; height: 100%px\">
			<br />
			<table border=\"1\" id=\"ordenPago\" cellpadding=\"0\" cellspacing=\"0\" class=\"display\" >
				<thead>
					<tr >
						<th>No</th>
						<th>Número de Orden</th>
						<th>Nombre del Concepto</th>
						<th>Fecha Orden</th>
						<th>Estado</th>
						<th>Total</th>
					</tr>
				</thead>
			<tbody class=\"listaRadicaciones\" >";
			foreach( $detalleOtros as $detalleOtro ){
				
				$txtNumeroOrdenPago = $detalleOtro->getOrdenPago( )->getNumeroOrden( );
				
				$ordenesPagos = $controlConcepto->consultarConceptoOrdenPago($txtNumeroOrdenPago);
				
				
				echo "<tr>";
				echo "<td>". $i++ . "</td>";
				echo "<td>". $detalleOtro->getOrdenPago( )->getNumeroOrden( ) ."</td>";
				echo "<td>";
					foreach( $ordenesPagos as $ordenPago ){
						echo $ordenPago->getNombreConcepto( )." "."-"." "."$".number_format($ordenPago->getOrdenPago( )->getDetalleOrdenPago( )->getValorConcepto( ),0, '', '.')."<br />";
					} 
				echo "</td>";
				echo "<td>". $detalleOtro->getOrdenPago( )->getFechaOrden( ) ."</td>";
				echo "<td>". $detalleOtro->getOrdenPago( )->getEstadoOrden( ) ."</td>";
				echo "<td>". "$".number_format($detalleOtro->getOrdenPago( )->getDetalleOrdenPago( )->getValorConcepto( ),0, '', '.') ."</td>";
				
			}
			echo "</tbody>";
			echo "</table><br />";
			echo "</div>";
	}else{
		echo "El estudiante no presenta ordenes de pago."."<br /><br /><br />";
	}

	$controlPazySalvo = new ControlPazySalvoEstudiante( $persistencia );
	
	$detallePazySalvos = $controlPazySalvo->consultarPazySalvo( $txtCodigoEstudiante, $txtCodigoPeriodo );
	
	
	if(count($detallePazySalvos) != 0 ){
		echo "<div style=\"overflow: auto; width: 100%; top: 0px; height: 100%px\">
			<br />
			<table border=\"1\" id=\"otrosConceptos\" cellpadding=\"0\" cellspacing=\"0\" class=\"display\" >
				<thead>
					<tr >
						<th>No</th>
						<th>Descripción</th>
						<th>Nombre</th>
						<th>Fecha Paz y Salvo</th>
						<th>Fecha Vencimiento</th>
					</tr>
				</thead>
			<tbody class=\"listaRadicaciones\" >";
		foreach( $detallePazySalvos as $detallePazySalvo ){
			echo "<tr>";
			echo "<td>". $i++ . "</td>";
			echo "<td>". $detallePazySalvo->getDescripcionPazySalvo( ) ."</td>";
			echo "<td>". $detallePazySalvo->getPazySalvo( )->getCarrera( )->getNombreCarrera( ) ."</td>";
			echo "<td>". $detallePazySalvo->getFechaPazySalvo( ) ."</td>";
			echo "<td>". $detallePazySalvo->getFechaVencimientoPazySalvo( ) ."</td>";
		}
			echo "</tbody>";
			echo "</table><br />";
			echo "</div>";
	}else{
		echo "El estudiante no tiene pendientes en su paz y salvo"."<br />";
	}

?>