<?php
session_start();
/*include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/

header('Content-Type: text/html; charset=UTF-8');

//var_dump($db);
if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

$id_Programa = $_GET['id_Programa'];
//var_dump($id_Programa);
$id_Docente = $_GET['id_Docente'];
//var_dump($id_Docente);
$Periodo = $_GET['Periodo'];
//var_dump($Periodo);
$tipoOperacion = $_GET['tipoOperacion'];
//var_dump($tipoOperacion);

$sqlSacarObservacion = "SELECT ObservacionDecanosId, Observacion
							FROM ObservacionDecanos
							WHERE DocenteId = $id_Docente AND CodigoPeriodo = $Periodo
							AND CodigoCarrera = $id_Programa
						AND CodigoEstado = 100
						ORDER BY CodigoCarrera";
						
$listarObservaciones = $db->Execute( $sqlSacarObservacion );

switch( $tipoOperacion ){
	
	case "listarObservaciones":					
	
	//var_dump($listarObservaciones);
	$i = 1;
	foreach( $listarObservaciones as $listarObservacion ){
		
		
		
		echo "<font size='4'>".$i++." ".$listarObservacion['Observacion']."</font>"."<br />";
		
		/*$sqlUpdateObservacion = "UPDATE 
								ObservacionDecanos SET CodigoEstado = 200
								WHERE ObservacionDecanosId = $id_Observacion
								AND DocenteId = $id_Docente
								AND CodigoPeriodo = $Periodo
								AND CodigoCarrera = $id_Programa";
		
		$actualizarEstadoObservacion = $db->Execute( $sqlUpdateObservacion );*/
		
		}
	
	break;
	
	case "actualizarObservaciones":
		
	foreach( $listarObservaciones as $listarObservacion ){
		
		$id_Observacion = $listarObservacion['ObservacionDecanosId'];
		
		$sqlUpdateObservacion = "UPDATE 
								ObservacionDecanos SET CodigoEstado = 200
								WHERE ObservacionDecanosId = $id_Observacion
								AND DocenteId = $id_Docente
								AND CodigoPeriodo = $Periodo
								AND CodigoCarrera = $id_Programa";
		
		$actualizarEstadoObservacion = $db->Execute( $sqlUpdateObservacion );
		
	}
	
	break;
		
		
}

	

?>
