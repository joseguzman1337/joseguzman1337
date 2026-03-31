<?php
/**
 * @author Carlos Alberto Suarez Garrido <c.csuarez@sic.gov.co>
 * @copyright Subdireccion de Innovacion y Desarrollo Tecnologico
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
	include '../control/ControlRegistroGrado.php';
	include '../control/ControlFolioTemporal.php';
	
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
	
	function mes( $fecha ){
		$fecha = strtotime($fecha);
		$mes = date("F",($fecha));
		if($mes == "January"){
			$mes = "Enero";
		}
		if($mes == "February"){
			$mes = "Febrero";	
		}
		if($mes == "March"){
			$mes = "Marzo";
		}
		if($mes == "April"){
			$mes = "Abril";
		}
		if($mes == "May"){
			$mes = "Mayo";
		}
		if($mes == "June"){
			$mes = "Junio";
		}
		if($mes == "July"){
			$mes = "Julio";
		}
		if($mes == "August"){
			$mes = "Agosto";
		}
		if($mes == "September"){
			$mes = "Septiembre";
		}
		if($mes == "October"){
			$mes = "Octubre";
		}
		if($mes == "November"){
			$mes = "Noviembre";
		}
		if($mes == "December"){
			$mes = "Diciembre";
		}
		
		return $mes;
		
	} 
	
	$controlRegistroGrado = new ControlRegistroGrado( $persistencia );
	$controlFolioTemporal = new ControlFolioTemporal( $persistencia );
	$controlEstudiante = new ControlEstudiante( $persistencia );
	$controlCarrera = new ControlCarrera($persistencia);
	switch ($tipoOperacion) {	
	
	case "exportar":
		
	header("Content-type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: filename=ficheroExcel.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	if( $txtCodigoReferencia == 1 ||  $txtCodigoReferencia == 2 ){		
		
		$filtro = "";
			
		if( $cmbFacultadTReporte != -1 ){
			$filtro .= " AND FT.codigofacultad = ".$cmbFacultadTReporte."";
		}
		
		/*if( $cmbCarreraTReporte != -1){
			$filtro .= " AND C.codigocarrera = ".$cmbCarreraTReporte."";
		}*/
		
		if( $cmbCarreraTReporte != -1 ){
			
			if( $cmbCarreraTReporte == 'pregrados' ) {
				
				$filtro .= " AND C.codigomodalidadacademica = 200"; 
				
			} else if ( $cmbCarreraTReporte == 'posgrados' ) {
					
				$filtro .= " AND C.codigomodalidadacademica = 300";
				
			} else {
		
				$filtro .= " AND C.codigocarrera = ".$cmbCarreraTReporte."";
			}
		}
		
		
		
		if( $cmbPeriodoTReporte != -1 ){
			$filtro .= " AND F.CodigoPeriodo = ".$cmbPeriodoTReporte."";
		}
		
		/*
		 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
		 * Cuando llega a exportar el excel no estaba tomando el cuenta el tipo de grado, esto estaba ocacionando que se imprimieran mas estudiantes de los registrados
		 * @since  January 12, 2017
		*/
		if( $cmbTipoGradoTReporte != -1 ){
			$filtro .= " AND F.TipoGradoId = ".$cmbTipoGradoTReporte."";
		}
		/* Fin Modificación */
		
		$registroGrados = $controlRegistroGrado->consultarCeremoniaEgresados( $filtro );
		$i = 1;
		if( count($registroGrados) != 0 ){ ?>
		 <?php
                        /**
                        *@modified Diego Rivera<riveradiego@unbosque.edu.co>
                        *Se añade columna trabajos de grado
                        *@since May 20,2019
                        */
			echo "
			
			<div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
				<table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"0\"  >
					<thead>
						<tr >
							<th style=\"width: 5%;\" >No</th>
							<th>Universidad</th>
							<th>Sede</th>
							<th>".utf8_decode("Título")."</th>
							<th>Tipo de Documento</th>
							<th>Numero de Documento</th>
							<th>Nombres Graduado</th>
							<th>Apellidos Graduado</th>
							<th>Fecha Grado</th>
                            <th>Trabajo de Grado</th>
							<th>Tipo Incentivo</th>
							<th>Incentivo</th>
							<th>".utf8_decode("Número")." Registro</th>
							<th>".utf8_decode("Número")." Acta</th>
							<th>".utf8_decode("Número")." Acuerdo</th> 
							<th>".utf8_decode("Número")." Diploma</th>
							<th>Folio</th>
						</tr>
					</thead>
				<tbody class=\"listaEstudiantes\">";
				foreach( $registroGrados as $registroGrado ){
					
					$estadoIncentivo = $registroGrado->getIncentivoAcademico( )->getEstadoIncentivo( );
					
					if( $estadoIncentivo == 100 or $estadoIncentivo == '' ) {
					
							$folioTemporal = $controlFolioTemporal->buscarFolioTemporal( $registroGrado->getIdRegistroGrado( ) );
							
							echo "<tr>";
							echo "<td align=\"center\">". $i++ . "</td>";
							echo "<td>UNIVERSIDAD EL BOSQUE</td>";
							echo "<td>".utf8_decode("BOGOTÁ")."</td>";
							echo "<td>". utf8_decode($registroGrado->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getTituloProfesion( )->getNombreTitulo( ))."</td>";
							echo "<td>". $registroGrado->getEstudiante( )->getTipoDocumento( )->getIniciales( ) ."</td>";
							echo "<td>". $registroGrado->getEstudiante( )->getNumeroDocumento( ) ."</td>";
							echo "<td>". utf8_decode($registroGrado->getEstudiante( )->getNombreEstudiante( )) ."</td>";
							echo "<td>". utf8_decode($registroGrado->getEstudiante( )->getApellidoEstudiante( )) ."</td>";
							echo "<td>". date( "Y-m-d", strtotime( $registroGrado->getActaAcuerdo( )->getFechaAcuerdo( ) ) )."</td>";
							echo "<td>". utf8_decode($registroGrado->getTrabjoGrado()) ."</td>";

							echo "<td>". utf8_decode( $registroGrado->getIncentivoAcademico( )->getNombreIncentivo( )) ."</td>";

							echo "<td>". utf8_decode( $registroGrado->getIncentivoAcademico( )->getObservacionIncentivo( )) ."</td>";
							echo "<td>". $registroGrado->getIdRegistroGrado( ) ."</td>";
							echo "<td>". $registroGrado->getActaAcuerdo( )->getNumeroActaConsejoDirectivo( ). "</td>";
							echo "<td>". $registroGrado->getActaAcuerdo( )->getNumeroAcuerdo( ). "</td>";
							
							echo "<td>". $registroGrado->getNumeroDiploma( ) ."</td>";
							echo "<td>". $folioTemporal->getNumeroFolio( ) ."</td>";
							echo "</tr>";
					}
				}
			echo "</tbody>";
			echo "</table>";
			echo "<br />";
		echo "</div>";
			}
		
		}

	if( $txtCodigoReferencia == 3 ){
		$filtro = "";
		$filtroSubConsulta = "";
			
		if( $cmbFacultadTReporte != -1 ){
			$filtro .= " AND FT.codigofacultad = ".$cmbFacultadTReporte."";
			$filtroSubConsulta .=  " AND FT.codigofacultad = ".$cmbFacultadTReporte."";
		}
		
		if( $cmbCarreraTReporte != -1){
			$filtro .= " AND C.codigocarrera = ".$cmbCarreraTReporte."";
		}
		
		if( $cmbPeriodoTReporte != -1 ){
			$filtro .= " AND F.CodigoPeriodo = ".$cmbPeriodoTReporte."";
			$filtroSubConsulta .= " AND F.CodigoPeriodo = ".$cmbPeriodoTReporte."";
		}
		
		if( $cmbTipoGradoTReporte != -1 ){
			$filtro .= " AND F.TipoGradoId = ".$cmbTipoGradoTReporte."";
			$filtroSubConsulta .= " AND F.TipoGradoId = ".$cmbTipoGradoTReporte."";
		}
		
		$registroGrados = $controlRegistroGrado->consultarNumeroGraduados( $filtro , $filtroSubConsulta  );
		$i = 1;
		if( count($registroGrados) != 0 ){ ?>
			<script src="../js/MainTipoReporte.js"></script>
		 <?php 
			echo "
			<div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
				<table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"0\"  >
					<thead>
						<tr >
							<th style=\"width: 5%;\" >No</th>
							<th style=\"width: 45%;\">Nombre Carrera</th>
							<th>Mujeres</th>
							<th>Hombres</th>
							<th>Total Estudiantes</th>
						</tr>
					</thead>
				<tbody class=\"listaEstudiantes\">";
				foreach( $registroGrados as $registroGrado ){
					
					if( $registroGrado->getconteoGradosMujer( ) == '' ) {
					
							$mujer = 0;
					
						} else {
							
							$mujer = $registroGrado->getconteoGradosMujer( );
						}
						
						if ( $registroGrado->getconteoGradosHombre( ) == '' ) {
							
							 $hombre = 0;
							
						} else {
							
							$hombre = $registroGrado->getconteoGradosHombre( );
						}
					
					echo "<tr>";
					echo "<td align=\"center\">". $i++ . "</td>";
					echo "<td>". utf8_decode($registroGrado->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getNombreCarrera( )) ."</td>";
					echo "<td>". $mujer ."</td>";
					echo "<td>". $hombre ."</td>";
					echo "<td>". $registroGrado->getIdRegistroGrado( )."</td>";
					echo "</tr>";
				}
			echo "</tbody>";
			echo "</table>";
			echo "<br />";
		echo "</div>";
			}
	}
		
	if( $txtCodigoReferencia == 4 ){
			
			$filtro = "";
			
		if( $cmbFacultadTReporte != -1 ){
			$filtro .= " AND FT.codigofacultad = ".$cmbFacultadTReporte."";
		}
		
		if( $cmbCarreraTReporte != -1){
			$filtro .= " AND C.codigocarrera = ".$cmbCarreraTReporte."";
		}
		
		if( $cmbPeriodoTReporte != -1 ){
			$filtro .= " AND F.CodigoPeriodo = ".$cmbPeriodoTReporte."";
		}
		
		if( $cmbTipoGradoTReporte != -1 ){
			$filtro .= " AND F.TipoGradoId = ".$cmbTipoGradoTReporte."";
		}
		
		
		/*$error = $controlEstudiante->validar($cmbFacultadTMando, $cmbCarreraTMando, $cmbPeriodoTMando);
		if( $error == ""){*/
		$registroGrados = $controlRegistroGrado->consultarCeremoniaEgresados( $filtro );
		$txtFechaGrado = $registroGrados[0]->getActaAcuerdo( )->getFechaGrado( )->getIdFechaGrado( );
		
		$controlActaAcuerdo = new ControlActaAcuerdo( $persistencia );
		$actaAcuerdos = $controlActaAcuerdo->consultarActaAcuerdosPeriodo($txtFechaGrado, $cmbPeriodoTReporte);
		
		
		
		$i = 1;
		$cuentaAcuerdo = 0;
		$cuentaAcuerdo2 = 0;
		$cuentaAcuerdo3 = 0;
		
		$fechaHoy = date("Y-m-d");
		$anioHoy = date( "Y", strtotime($fechaHoy));
		$diaHoy = date( "d", strtotime($fechaHoy));
		$mesHoy = mes($fechaHoy);
		if( count($registroGrados) != 0 ){ ?>
			<script src="../js/MainTipoReporte.js"></script>
		 <?php 
			echo "
			<div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
			<br />
				<table width=\"100%\" border=\"0\">
				  <tr>
				    <td>Fecha de Grado: "; if( count( $actaAcuerdos ) > 1 ){
				    	foreach( $actaAcuerdos as $actaAcuerdo ){
				    		$anioGrado = date( "Y", strtotime($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo( )));
							$diaGrado = date( "d", strtotime($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo( )));
				    		$mes = mes($actaAcuerdos[$cuentaAcuerdo]->getFechaAcuerdo( ));
				    		echo $mes." ".$diaGrado." "."de"." ".$anioGrado." ";
							$cuentaAcuerdo = $cuentaAcuerdo + 1;
				    	}
				    }else{
				    	$anioGrado = date( "Y", strtotime($actaAcuerdos[0]->getFechaAcuerdo( )));
						$diaGrado = date( "d", strtotime($actaAcuerdos[0]->getFechaAcuerdo( )));
			    		$mes = mes($actaAcuerdos[0]->getFechaAcuerdo( ));
				    	echo $mes." ".$diaGrado." "."de"." ".$anioGrado." ";
				    } echo "</td>
				    <td>Acuerdo: "; if( count( $actaAcuerdos ) > 1 ){
				    	foreach( $actaAcuerdos as $actaAcuerdo ){
				    		echo $actaAcuerdos[$cuentaAcuerdo2]->getNumeroAcuerdo( )." ";
							$cuentaAcuerdo2 = $cuentaAcuerdo2 + 1;
				    	}
				    }else{
				    	echo $actaAcuerdos[0]->getNumeroAcuerdo( );
				    } echo "</td>
				    <td>Acta: "; if( count( $actaAcuerdos ) > 1 ){
				    	foreach( $actaAcuerdos as $actaAcuerdo ){
				    		echo $actaAcuerdos[$cuentaAcuerdo3]->getNumeroActaConsejoDirectivo( )." ";
							$cuentaAcuerdo3 = $cuentaAcuerdo3 + 1;
				    	}
				    }else{
				    	echo $actaAcuerdos[0]->getNumeroActaConsejoDirectivo( );
				    } echo "</td>
				    <td>Fecha: ".$mesHoy." ".$diaHoy." de ".$anioHoy."</td>
				  </tr>
				</table>
			<br />
				<table width=\"100%\" id=\"estudianteCeremoniaEgresados\" border=\"0\" style=\"text-align:center\">
				  <thead>
				  	<tr>
				    	<th>Reg.</th>
				        <th>Apellidos y Nombres</th>
				        <th>Documento de Identidad</th>
				        <th>Programa</th>
				        <th>Título Otorgado</th>
				        <th>Diploma</th>
				        <th>Folio</th>
				    </tr>
				  </thead>
				  <tbody>";
					  foreach( $registroGrados as $registroGrado ){
					  	
							$folioTemporal = $controlFolioTemporal->buscarFolioTemporal( $registroGrado->getIdRegistroGrado( ) );
						
							echo "<tr>";
							echo "<td align=\"center\">". $registroGrado->getIdRegistroGrado( ) ."</td>";
							echo "<td>". $registroGrado->getEstudiante( )->getApellidoEstudiante( )." ".$registroGrado->getEstudiante( )->getNombreEstudiante( ) ."</td>";
							echo "<td>". utf8_decode( $registroGrado->getEstudiante( )->getNumeroDocumento( ) )."</td>";
							echo "<td>". utf8_decode( $registroGrado->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getNombreCarrera( ) ) ."</td>";
							echo "<td>". utf8_decode( $registroGrado->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getTituloProfesion( )->getNombreTitulo( ) ) ."</td>";
							echo "<td>". $registroGrado->getNumeroDiploma( ) ."</td>";
							echo "<td>". $folioTemporal->getNumeroFolio( ) . "</td>";
							echo "</tr>";
						}
				 	echo "</tbody>";
				 	echo "</table>";
				echo "<br />";
			echo "</div>";
			}	

		}

		if( $txtCodigoReferencia == 7){

				$filtro = "";
				
			if( $cmbFacultadTReporte != -1 ){
				$filtro .= " AND FT.codigofacultad = ".$cmbFacultadTReporte."";
			}
					
			if( $cmbCarreraTReporte != -1 ){
				
				if( $cmbCarreraTReporte == 'pregrados' ) {
					
					$filtro .= " AND C.codigomodalidadacademica = 200"; 
					
				} else if ( $cmbCarreraTReporte == 'posgrados' ) {
						
					$filtro .= " AND C.codigomodalidadacademica = 300";
					
				} else {
			
					$filtro .= " AND C.codigocarrera = ".$cmbCarreraTReporte."";
				}
			}
			
			if( $cmbPeriodoTReporte != -1 ){
				$filtro .= " AND F.CodigoPeriodo = ".$cmbPeriodoTReporte."";
			}
			
			if( $cmbTipoGradoTReporte != -1 ){
				$filtro .= " AND F.TipoGradoId = ".$cmbTipoGradoTReporte."";
			}

			$registroGrados = $controlRegistroGrado->consultarIndexacion( $filtro );
			
			//FUncion para identificar ruta de archivos y verificar si existen el sus respectivas carpetas 
			function archivo( $codigo , $identificaRuta ){

						$validador = "";

						if( $identificaRuta == "Diplomas" ) {
								$ruta="../documentos/Diplomas/DP_".$codigo.".pdf";	

						} else if( $identificaRuta == "Acta de Grado" ) {
									$ruta="../documentos/Acta de Grado/AG_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Incentivo" ) {
									$ruta="../documentos/Incentivo/IA_".$codigo.".pdf";
							
						} else if( $identificaRuta == "Mencion de Honor" ) {
									$ruta="../documentos/Mencion de Honor/MH_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Mencion Meritoria" ) {
									$ruta="../documentos/Mencion Meritoria/MM_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Grado de Honor" ) {
									$ruta="../documentos/Grado de Honor/GH_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Cum Laude" ) {
									$ruta="../documentos/Cum Laude/CL_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Mangna Cum Laude" ) {
									$ruta="../documentos/Mangna Cum Laude/MC_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Suma Cum Laude" ) {
									$ruta="../documentos/Suma Cum Laude/SC_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Laureada" ) {
									$ruta="../documentos/Laureada/LA_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Certificados Cal" ) {
									$ruta="../documentos/Certificados Cal/CN_".$codigo.".pdf";
									
						} else if( $identificaRuta == "Enfasis" ) {
									$ruta="../documentos/Enfasis/EN_".$codigo.".pdf";
						}else{
							$ruta = "";
						}

						if ( file_exists( $ruta ) ){
								$validador ="x"; 			
						} else{

							$validador="";
						}

						return $validador;

				}

					echo "
					<div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
						<table id=\"estudianteCeremoniaEgresados\" width=\"100%\" border=\"0\"  >
							<thead>
								<tr>
									<th style=\"width: 5%;\" >No</th>
									<th>".utf8_decode('Código')."</th>
									<th>Documento</th>
									<th>".utf8_decode('Número')."</th>
									<th>Nombre</th>
									<th>Carrera</th>
									<th>Periodo</th>
									<th>Tipo Programa</th>
									<th>Tipo de grado</th>
									<th>Diploma</th>
									<th>Acta de grado</th>
									<th>Certificado de notas</th>
									<th>".utf8_decode('Mención de Honor')."</th>
									<th>".utf8_decode('Mención Meritoria')."</th>
									<th>Grado de Honor</th>
									<th>Cum Laude</th>
									<th>Mangna Cum Laude</th> 
									<th>Suma Cum Laude</th>
									<th>Laureada</th>
									<th>".utf8_decode('Énfasis')."</th>
								</tr>
							</thead>
						<tbody class=\"listaEstudiantes\">";
						$i=1;
						$contadorDP = 0;
						$contadorAG = 0;
						$contadorCN = 0;
						$contadorMH = 0;
						$contadorMM = 0;
						$contadorGH = 0;
						$contadorCL = 0;
						$contadorMC = 0;
						$contadorSC = 0;
						$contadorLA = 0;
						$contadorEN = 0;

						foreach( $registroGrados as $registroGrado ){

							$dp = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Diplomas' );   
							$ag =  archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Acta de Grado' );   
							$cn = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Certificados Cal' );   
							$mh = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Mencion de Honor' );   
							$mm = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Mencion Meritoria' );   
							$gh = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Grado de Honor' );   
							$cl = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Cum Laude' );   
							$mc = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Mangna Cum Laude' );   
							$sc = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Suma Cum Laude' );   
							$la = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Laureada' );   
							$en = archivo( $registroGrado->getEstudiante( )->getCodigoEstudiante( ), 'Enfasis' );   

							if( $dp != "" ){
								$contadorDP = $contadorDP +1; 
							}

							if( $ag != "" ){
								$contadorAG = $contadorAG +1; 
							}

							if( $cn != "" ){
								$contadorCN = $contadorCN +1; 
							}

							if( $mh != "" ){
								$contadorMH = $contadorMH +1; 
							}

							if( $mm != "" ){
								$contadorMM = $contadorMM +1; 
							}

							if( $gh != "" ){
								$contadorGH = $contadorGH +1; 
							}

							if( $cl != "" ){
								$contadorCL = $contadorCL +1; 
							}

							if( $mc != "" ){
								$contadorMC = $contadorMC +1; 
							}

							if( $sc != "" ){
								$contadorSC = $contadorSC +1; 
							}

							if( $la != "" ){
								$contadorLA = $contadorLA +1; 
							}

							if( $en != "" ){
								$contadorEN = $contadorEN +1; 
							}


							echo "<tr align='center'>
										<td>$i</td>
										<td>" .$registroGrado->getEstudiante( )->getCodigoEstudiante( ). "</td>
										<td>" .$registroGrado->getEstudiante( )->getTipoDocumento( )->getIniciales( ). "</td>
										<td>" .$registroGrado->getEstudiante( )->getNumeroDocumento( ). "</td>
										<td>" .$registroGrado->getEstudiante( )->getApellidoEstudiante( )." ".$registroGrado->getEstudiante( )->getNombreEstudiante( ). "</td>
										<td>" .$registroGrado->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getNombreCarrera( ) . "</td>
										<td>" .$registroGrado->getActaAcuerdo( )->getFechaGrado( )->getPeriodo( ) . "</td>
										<td>" .substr($registroGrado->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getModalidadAcademica( )->getNombreModalidadAcademica( ),12) ."</td>
										<td>" .$registroGrado->getActaAcuerdo( )->getFechaGrado( )->getTipoGrado( )->getNombreTipoGrado( ). "</td>
										<td>" .$dp. "</td>
										<td>" .$ag. "</td>
										<td>" .$cn. "</td>
										<td>" .$mh. "</td>
										<td>" .$mm. "</td>
										<td>" .$gh. "</td>
										<td>" .$cl. "</td>
										<td>" .$mc. "</td>
										<td>" .$sc. "</td>
										<td>" .$la. "</td>
										<td>" .$en. "</td>
									</tr>";
									$i++;
							}			
								$i = $i - 1;
									
							echo "<tr>
									<td colspan='20'></td>										
								  </tr>
								<tr>
									<td colspan='8' align='right'></td>
									<td></td>
									<th>Diploma</th>
									<th>Acta de grado</th>
									<th>Certificado de notas</th>
									<th>".utf8_decode('Mención de Honor')."</th>
									<th>".utf8_decode('Mención Meritoria')."</th>
									<th>Grado de Honor</th>
									<th>Cum Laude</th>
									<th>Mangna Cum Laude</th> 
									<th>Suma Cum Laude</th>
									<th>Laureada</th>
									<th>".utf8_decode('Énfasis')."</th>											
								  </tr>	

								  <tr>
									<td colspan='8' align='right'>Total registros</td>
									<td >$i</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								  </tr>	

								  <tr>
									<td colspan='8' align='right'>Total archivos</td>
									<td></td>
									<td>$contadorDP</td>
									<td>$contadorAG</td>
									<td>$contadorCN</td>
									<td>$contadorMH</td>
									<td>$contadorMM</td>
									<td>$contadorGH</td>
									<td>$contadorCL</td>
									<td>$contadorMC</td>
									<td>$contadorSC</td>
									<td>$contadorLA</td>
									<td>$contadorEN</td>										
								  </tr>
								  <tr>
									<td colspan='8' align='right'>Diferencia</td>
									<td></td>
									<td>".($i-$contadorDP)."</td>
									<td>".($i-$contadorAG)."</td>
									<td>".($i-$contadorCN)."</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>									
								  </tr>";

								  	
					echo '</tbody></table>';

		}

	if( $txtCodigoReferencia == 9){
			$filtro = "";
         $filtro .= " AND FT.codigofacultad = " . $cmbFacultadTReporte . "";
         $filtro .= " AND C.codigocarrera = " . $cmbCarreraTReporte . "";
         $filtro .= " AND F.CodigoPeriodo = " . $cmbPeriodoTReporte . "";
         $filtro .= " AND F.TipoGradoId = " . $cmbTipoGradoTReporte . "";

        $registroGrados = $controlRegistroGrado->consultarColegioPsicologia($filtro);

        if (count($registroGrados) == 0) {
            echo 0;
        } else {
            ?>
            <script src="../js/MainTipoReporte.js"></script>
            <?php
             
        echo "
            <table width=\"100%\" id=\"estudianteCeremoniaEgresados\" border=\"0\" style=\"text-align:center\">
                          <thead>
                                <tr>
                                <th>Numero de Documento</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Primer Nombre</th>
                                <th>Segundo Nombre</th>
                                <th>Cod Snies Institucion</th>
                                <th>Nombre Institucion</th>
                                <th>Nombre Firma Acta</th>
                                <th>Cod Snies Programa</th>
                                <th>Fecha_Grado</th>
                                <th>Acta_Grado</th>
                                <th>Libro_Grado</th>
                                <th>Folio_Acta</th>
                                <th>Numero_Diploma</th>
                                <th>Registro_Diploma</th>
                                <th>Fecha_Confirmacion</th>
                            </tr>
                          </thead>
                          <tbody>";

                foreach ($registroGrados as $registroGrado) {

                    $folioTemporal = $controlFolioTemporal->buscarFolioTemporal($registroGrado->getIdRegistroGrado());
                    $snies= $controlCarrera ->Snies($registroGrado->getActaAcuerdo()->getFechaGrado()->getCarrera()->getCodigoCarrera());
                    $apellidosEstudiante = $registroGrado->getEstudiante()->getApellidoEstudiante();
                    $nombresEstudiante = $registroGrado->getEstudiante()->getNombreEstudiante();
                    $arrayApellido =  explode(' ', $apellidosEstudiante);
                    $countApellidos =count($arrayApellido);
                    $arrayNombre= explode(' ', $nombresEstudiante);
                    $countNombres =count($arrayNombre);

                    echo "<tr>";
                    echo "<td>" . $registroGrado->getEstudiante()->getNumeroDocumento() . "</td>";
                    echo "<td>" . $arrayApellido[0]  . "</td>";
                    if($countApellidos >1) {
                    	echo "<td>" .  $arrayApellido[1]  . "</td>";
                    }else{
                    	echo "<td>" . "". "</td>";
                    }
                    echo "<td>" .  $arrayNombre[0] . "</td>";

                    if($countNombres > 1){
                    	echo "<td>". $arrayNombre[1]  ."</td>";
                    }else{
                    	echo "<td>" . "". "</td>";
                    }
                    echo "<td>" . "1729" . "</td>";
                    echo "<td>" . "UNIVERSIDAD EL BOSQUE" . "</td>";
                    echo "<td>" . utf8_decode("María Clara Rangel Galvis;Cristina Matiz Mejia") . "</td>";
                    echo "<td>" . $snies->getCodigoCarrera()."</td>";
                    echo "<td>" . date("Y-m-d", strtotime($registroGrado->getActaAcuerdo()->getFechaAcuerdo())) . "</td>";
                    echo "<td>" . $registroGrado->getActaAcuerdo()->getNumeroActaConsejoDirectivo(). "</td>";
                    echo "<td>" . "" . "</td>";
                    echo "<td>" . $folioTemporal->getNumeroFolio() . "</td>";
                    echo "<td>" . $registroGrado->getNumeroDiploma() . "</td>";
                    echo "<td>" . $registroGrado->getIdRegistroGrado() . "</td>";
                    echo "<td>" . date("Y-m-d") . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<br />";
        }

	}
	break;
	}	
?>