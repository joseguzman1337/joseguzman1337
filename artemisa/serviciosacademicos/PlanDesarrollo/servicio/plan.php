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
	
	session_start( );
	
	include '../tools/includes.php';
	
	//include '../control/ControlRol.php';
	include '../control/ControlItem.php';
	include '../control/ControlPeriodo.php';
	include '../control/ControlLineaEstrategica.php';
	
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
		$txtCodigoFacultad = $user[4];
		$persistencia = new Singleton( );
		$persistencia = $persistencia->unserializar( $user[ 5 ] );
		$persistencia->conectar( );
	}else{
		header("Location:error.php");
	}
	
	switch( $tipoOperacion ){
		case "consultarPlan":
			
			$filtro = "";
			
			if( $cmbLineaConsulta != -1 ){
				$filtro .= " AND FT.codigofacultad = ".$cmbLineaConsulta."";
			}
			
			if( $cmbProgramaConsultar != -1){
				$filtro .= " AND C.codigocarrera = ".$cmbProgramaConsultar."";
			}
			
			if( $cmbProyectoConsultar != -1 ){
				$filtro .= " AND F.CodigoPeriodo = ".$cmbProyectoConsultar."";
			}
			
			if( $cmbIndicadorConsultar != -1 ){
				$filtro .= " AND F.TipoGradoId = ".$cmbIndicadorConsultar."";
			}
			$txtIdPlan = 1;
			echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"1\" width=\"100%\">
					<thead>
						<tr>
							<th>No.</th>
							<th>Objetivo</th>
							<th>Meta Año</th>
							<th>Valor Año</th>
							<th>Avance</th>
							<th>Responsable</th>
							<th>Detalle</th>
						</tr>
					</thead>
					<tbody class=\"listaEstudiantes\">
						<tr>
							<td>1</td>
							<td>Aumentar en un 2% la tasa de permanencia anual</td>
							<td>2%</td>
							<td>0.5%</td>
							<td>25%</td>
							<td>Carlos Alberto Suárez Garrido</td>
							<td><img src=\"../css/images/page.png\" onClick=\"verPlan('".$txtIdPlan."')\" style=\"cursor: pointer;\" /></td>
						</tr>
						<tr>
							<td>2</td>
							<td>Aumeno del 5% de la permanencia por cohorte al cabo de los 5 años</td>
							<td>5%</td>
							<td>1%</td>
							<td>20%</td>
							<td>Mauricio Silvestre</td>
							<td><img src=\"../css/images/page.png\" onClick=\"verPlan('".$txtIdPlan."')\" style=\"cursor: pointer;\" /></td>
						</tr>
					</tbody>
				</table>";	
		
		break;
	}
	
?>