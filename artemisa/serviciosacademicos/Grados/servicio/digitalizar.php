<?php
   header ('Content-type: text/html; charset=utf-8');
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	ini_set('display_errors','On');
	
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
	include '../control/ControlDocumentoDigital.php';
	include '../servicio/funciones.php';

	
	
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
	
	
	switch( $tipoOperacionDigitalizar ){
		
		case "consultarDigitalizar":
		/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
		 *Se añade validacion con el fin de indentificar si se consulta por carrera especifica o por todos los programas de pregrado o posgrado 
		 *Since augoust 15,2017 
		 * */
		$filtroDigitalizar = "";

		if( $cmbCarreraDigitalizar != -1 ) {

			if( $cmbCarreraDigitalizar == "pregrados" ) {

					$filtroDigitalizar .= " C.codigomodalidadacademica = 200 and C.codigofacultad =".$cmbFacultadDigitalizar."";
				
			} else if ( $cmbCarreraDigitalizar == "posgrados" ) {
					
					$filtroDigitalizar .= " C.codigomodalidadacademica = 300 and C.codigofacultad =".$cmbFacultadDigitalizar."";
					
			} else {
	
				$filtroDigitalizar .= " C.codigocarrera = ".$cmbCarreraDigitalizar."";
			}
		}
		
		if( $cmbPeriodoDigitalizar != -1 ){
			$filtroDigitalizar .= " AND F.CodigoPeriodo = ".$cmbPeriodoDigitalizar."";
		}
		
		if( $cmbTipoGradoDigitalizar != -1 ){
			$filtroDigitalizar .= " AND F.TipoGradoId = ".$cmbTipoGradoDigitalizar."";
		}
		
	
		$filtroDigitalizar .= " LIMIT ".$inicio."," . $limite;
		
		$estudianteGrados = $controlRegistroGrado->consultarRegistroGradoDigitalizar( $filtroDigitalizar );
		
		//echo "<pre>";print_r( $estudianteGrados );
		$inicio = $inicio + 1;
		
		$i = $inicio;
		if( count($estudianteGrados) != 0 ){ ?>
		<script src="../js/MainDigitalizar.js"></script>
		<?php 
			echo "
			<div style=\"width: 100%; top: 0px; height: 100%px; border: 1px; border-style: solid groove; border-radius: 4px; border-color: #aaaaaa;\">
				<div style=\"width: 98%; margin: 10px; top: 0px; height: 100%;\">
				<br />
				<div id=\"estudiantesDigitalizar\" class=\"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix\" align=\"right\" style=\"width: 100%; margin-right: 20px;\" ><label style=\"margin-right: 20px;\">Buscar: <input id=\"estudiantesBuscarDigitalizar\" type=\"text\"></label></div>
				<input type=\"hidden\" id=\"txtFechaGrado\" name=\"txtFechaGrado\" value=\"".$estudianteGrados[0]->getActaAcuerdo( )->getFechaGrado( )->getIdFechaGrado( )."\" />
				<input type=\"hidden\" id=\"txtIdUsuario\" name=\"txtIdUsuario\" value=\"".$idPersona."\" />
				<br />
				<table id=\"estudianteDigital\" width=\"100%\" border=\"0\"  >
					<thead>
						<tr >
							<th style=\"width: 5%;\" >No</th>
							<th style=\"width: 30%;\">Estudiante</th>
							<th style=\"width: 15%;\" >Tipo Documento</th>
							<th style=\"width: 15%;\" >Numero de Documento</th>
							<th style=\"width: 15%;\" >Codigo Esutidante</th>
							<th>Ver Documentos</th>
						</tr>
					</thead>
				<tbody class=\"listaEstudiantes\">";
				foreach( $estudianteGrados as $estudianteGrado ){
					$ruta = "../documentos/digital/".$estudianteGrado->getActaAcuerdo( )->getFechaGrado( )->getIdFechaGrado( )."/".$estudianteGrado->getEstudiante( )->getCodigoEstudiante( )."/*.pdf";
					//$url = "../documentos/digital/".$estudianteGrado->getActaAcuerdo( )->getFechaGrado( )->getIdFechaGrado( )."/".$estudianteGrado->getEstudiante( )->getCodigoEstudiante( )."/";
					echo "<tr>";
					echo "<td align=\"center\">". $i++ . "</td>";
					echo "<td><span style=\"margin-left: 10px;\">". $estudianteGrado->getEstudiante( )->getNombreEstudiante( ) ."</span></td>";
					echo "<td align=\"center\">".$estudianteGrado->getTipoDocumento( )->getDescripcion( )."</td>";
					echo "<td align=\"center\">".$estudianteGrado->getEstudianteGeneral( )->getNumeroDocumento( )."</td>";
					echo "<td align=\"center\">".$estudianteGrado->getEstudiante( )->getCodigoEstudiante( )."</td>";
				
					
					/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
					 *Se oculta opcion de carga de archivos
					 *Since June 14, 2017 
					 */
					
					/*  echo "<td><div style=\"margin-left: 40px;\"><div id=\"listaArchivos".$estudianteGrado->getEstudiante( )->getCodigoEstudiante( )."\" class=\"listaArchivo\"><input type=\"hidden\" id=\"txtCodigoEstudiante".$estudianteGrado->getEstudiante( )->getCodigoEstudiante( )."\" class=\"txtCodigoEstudiante\" value=\"".$estudianteGrado->getEstudiante( )->getCodigoEstudiante( )."\" /></div>
						<div style=\"color:#EEEEEE;\" ><input type=\"file\" id=\"txtIdSubirArchivo".$estudianteGrado->getEstudiante( )->getCodigoEstudiante( )."\" name=\"txtIdSubirArchivo".$estudianteGrado->getEstudiante( )->getCodigoEstudiante( )."\" class=\"txtIdSubirArchivo\" multiple=\"multiple\" ></div>
        				<a href=\"javascript:$('.txtIdSubirArchivo').uploadifive('upload')\" class=\"linkCancelar\" style=\"color:#EEEEEE;\" >Guardar</a></div></td>";
					*/
					
					//fin modifidicion
					
					echo "<td align=\"center\">";
					
					/*modified DIego Rivera <riveradiego@unbosque.edu.co>
					 *Se realiza llamado a funcion verificarArchivos con el fin de verificar si existen documentos asociados al estudiante 
					 *se reemplaza metodo
					 	if( count(glob($ruta)) > 0 )
						echo ""."<input type=\"button\" class=\"pdf\" name=\"brnPdf-" . $estudianteGrado->getEstudiante( )->getCodigoEstudiante( ) . "\" id=\"btn-" . $estudianteGrado->getEstudiante( )->getCodigoEstudiante( ) . "\"  title=\"Ver Documento Radicado\" onClick=\"verPDF( '" . $estudianteGrado->getEstudiante( )->getCodigoEstudiante( ) ."' , '" . $estudianteGrado->getActaAcuerdo( )->getFechaGrado( )->getIdFechaGrado( ) ."' )\" value=\"\" style=\"background:url(../css/images/documento.png) no-repeat; border:none; width:30px; height:30px; cursor: pointer;\" >";
						echo "</td>";
						echo "</tr>";
						 *Since July 12 , 2017 
					 */
					
					$verificacionArchivos = verificarArchivos( $estudianteGrado->getEstudiante( )->getCodigoEstudiante( ) );
					 
					 if(  $verificacionArchivos > 0 ) {
					 		
					 	echo ""."<input type=\"button\" class=\"pdf\" name=\"brnPdf-" . $estudianteGrado->getEstudiante( )->getCodigoEstudiante( ) . "\" id=\"btn-" . $estudianteGrado->getEstudiante( )->getCodigoEstudiante( ) . "\"  title=\"Ver Documento Radicado\" onClick=\"verPDF( '" . $estudianteGrado->getEstudiante( )->getCodigoEstudiante( ) ."' , '" . $estudianteGrado->getActaAcuerdo( )->getFechaGrado( )->getIdFechaGrado( ) ."' )\" value=\"\" style=\"background:url(../css/images/documento.png) no-repeat; border:none; width:30px; height:30px; cursor: pointer;\" >";
						echo "</td>";
						
					 }
					 //fin modificacion
							
					echo "</tr>";
				}
			echo "</tbody>";
			echo "</table>";
			echo "<br />";
			echo "</div>";
		echo "</div>";
		
    	}else{
    		?>
		
			<?php
			
		}
		break;
		case "crearPaginador":
			
			$filtroDigitalizar = "";
		
		/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
		 *Se añade validacion con el fin de indentificar si se consulta por carrera especifica o por todos los programas de pregrado o posgrado para construir la paginacion 
		 *Since augoust 15,2017 
		 * */
		
		
			/*if( $cmbCarreraDigitalizar != -1){
				$filtroDigitalizar .= " C.codigocarrera = ".$cmbCarreraDigitalizar."";
			}
			*/
			
			
			if( $cmbCarreraDigitalizar != -1 ) {

			if( $cmbCarreraDigitalizar == "pregrados" ) {

					$filtroDigitalizar .= " C.codigomodalidadacademica = 200 and C.codigofacultad =".$cmbFacultadDigitalizar."";
				
			} else if ( $cmbCarreraDigitalizar == "posgrados" ) {
					
					$filtroDigitalizar .= " C.codigomodalidadacademica = 300 and C.codigofacultad =".$cmbFacultadDigitalizar."";
					
			} else {
	
				$filtroDigitalizar .= " C.codigocarrera = ".$cmbCarreraDigitalizar."";
			}
		}
			
			
			
			if( $cmbPeriodoDigitalizar != -1 ){
				$filtroDigitalizar .= " AND F.CodigoPeriodo = ".$cmbPeriodoDigitalizar."";
			}
			
			if( $cmbTipoGradoDigitalizar != -1 ){
				$filtroDigitalizar .= " AND F.TipoGradoId = ".$cmbTipoGradoDigitalizar."";
			}
			
			$paginas = $controlRegistroGrado->totalRegistroGrado( $filtroDigitalizar );
			if( $paginas != 0 ){
			$totalInicio = 0;
			$totalFinal = 0; 
			
			$residuo = $paginas % $cantidadFinal;
			
			$i = 0;
			
			$limite = ( $paginas - $residuo ) / $cantidadFinal;
			?>
			<ul id="pagination-digg">
			<?php 
			
			if( $paginas > $cantidadFinal ){
				?>
				<li class="previous-off">Paginador &raquo;</li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php for ( $i = 0; $i < $limite  ; $i++ ) { 
					echo "<li class=\"next\"><a onclick=\"consultar( '". ( ( $i * $cantidadFinal ) ) ."' , '" . $cantidadFinal ."'  )\">". ( $i + 1 ) ."</a></li>";
				}
				if( $residuo > 0 )
					echo "<li class=\"next\"><a onclick=\"consultar( '". ( ( $i * $cantidadFinal ) ) ."' , '" . $cantidadFinal . "'  )\">". ( $i + 1 ) ."</a></li>";
			}else
				echo "<li class=\"next\"><a onclick=\"consultar( '". 0 ."' , '" . $cantidadFinal . "'  )\">". 1 ."</a></li>"; 
				echo "<br>";
				/*echo "Paginas: " .($limite + 1);
				echo "<br>";
				echo "Total de Registros: " .$paginas ;*/
			?></ul>
			<?php
			}else{
				echo "0";
			}
			
		break;
		
		case "guardarDigitalizar":
			
			$ruta = $txtRutaDocumento."/*.pdf";
			if( count(glob($ruta)) == 1 ){
				$controlDocumentoDigital = new ControlDocumentoDigital( $persistencia );
				$controlDocumentoDigital->crearDocumentoDigital( $txtCodigoEstudiante, $txtRutaDocumento, $txtIdUsuario);
			}
			
		break;
		
		
	}
?>