
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
	 

	session_start( );
	
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
	include '../control/ControlEstudianteDocumento.php';
	include '../control/ControlDocumentoPeople.php';
	include '../control/ControlGeneroPeople.php';
	include '../control/ControlLocalidad.php';
	
	//require_once "../../../nusoap/lib/nusoap.php";
	require_once "../../consulta/interfacespeople/conexionpeople.php";
	require_once "../../consulta/interfacespeople/reporteCaidaPeople.php";
	require_once("../../../kint/Kint.class.php");
	@error_reporting(0); // NOT FOR PRODUCTION SERVERS!
	@ini_set('display_errors', '0'); // NOT FOR PRODUCTION SERVERS!
	//d($_REQUEST);
	
	
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
	
	$controlEstudiante = new ControlEstudiante( $persistencia );
	//$tipoOperacion = 'consultar';
	//d($tipoOperacion);
	switch ($tipoOperacion) {
		
		case "consultar":
	   
	   	if( $cmbCarreraTMando == 'pregrados' ||  $cmbCarreraTMando == 'posgrados' ) {
			
			echo "2";
			
		} else {
		
		$ControlCarrera = new ControlCarrera( $persistencia );
		$carrera = $ControlCarrera->buscarCarrera($cmbCarreraTMando);
		$codigoModalidadAcademica = $carrera->getModalidadAcademica()->getCodigoModalidadAcademica();

		$filtro = "";
		$estudianteSeleccionados = array( );
			
		if( $cmbFacultadTMando != -1 ){
			$filtro .= " AND F.codigofacultad = ".$cmbFacultadTMando."";
		}
		
		
		/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
		 *Se añade valicion la cual permite consultar por todos los programas de pregrado y posgrado 
		 *Since august 15,2017
		 */
		
		if( $cmbCarreraTMando != -1 and  $cmbCarreraTMando != 'pregrados' and $cmbCarreraTMando != 'posgrados' ){
			$filtro .= " AND C.codigocarrera = ".$cmbCarreraTMando."";
		}
		
		else if ( $cmbCarreraTMando == 'pregrados' ) {
				$filtro .= " AND C.codigomodalidadacademica = 200 ";	
							
		} else if ( $cmbCarreraTMando == 'posgrados' ) {
				$filtro .= " AND C.codigomodalidadacademica = 300 ";				
		}
		
		
		if( $cmbPeriodoTMando != -1 ){
			/*
			 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
			 * Se agrega una escepcion para que  cuando sea facultad de Bioetica y postgrado la validacion tenga condiciones diferentes
			 * @since  Febrero 14 2017
			*/ 
			//$filtro .= " AND  FG.CodigoPeriodo = ".$cmbPeriodoTMando." AND PR.codigoperiodo <= ".$cmbPeriodoTMando;
			$filtro .= " AND  FG.CodigoPeriodo = ".$cmbPeriodoTMando." AND (PR.codigoperiodo <= ".$cmbPeriodoTMando;
			if($cmbFacultadTMando == 115 && $codigoModalidadAcademica==300){
				$filtro .= " OR 1";
			}
			$filtro .= ")";
			/* FIN MODIFICACION */
		}
		
		if( $cmbTipoGrado != -1 ){
			$filtro .= " AND FG.TipoGradoId = ".$cmbTipoGrado."";
		}
		
		
		/*$error = $controlEstudiante->validar($cmbFacultadTMando, $cmbCarreraTMando, $cmbPeriodoTMando);
		if( $error == ""){*/
		$estudiantes = $controlEstudiante->consultarEstudiantesUltimoSemestre( $filtro, $codigoModalidadAcademica );
		$i = 1;
		if( count($estudiantes) != 0 ){?>
		<script src="../js/MainTableroMando.js"></script>
		<?php 
		
		$controlActaAcuerdo = new ControlActaAcuerdo( $persistencia );
		$controlUsuario = new ControlUsuario( $persistencia );
			
		$fechaActual = date("Y-m-d");
		$txtFechaMaxima = date( "Y-m-d", strtotime($estudiantes[0]->getFechaGrado( )->getFechaMaxima( ) ) );
		$txtFechaGrado = $estudiantes[0]->getFechaGrado( )->getIdFechaGrado( );
		
		$existeActa = $controlActaAcuerdo->buscarActaAcuerdo($txtFechaGrado, $cmbCarreraTMando);
		$existeAcuerdo = $controlActaAcuerdo->existeAcuerdo( $txtFechaGrado, $cmbCarreraTMando );
		$existeSecretaria = $controlUsuario->existeSecretaria( $txtIdRol, $txtUsuario );
		
		$existeAnexo = "../documentos/actas/".$txtFechaGrado."/";
		
		//$txtItems = "";	
		if( $txtFechaMaxima != null ){
		
				//if( $fechaActual > $txtFechaMaxima ){
					
				echo "
				<div id=\"dvActas\" align=\"right\" style=\"font-size: 1.1em;\">
				<form id=\"formGenerarActa\" method=\"post\" action=\"../servicio/pdf.php\">";?>
				<input type="hidden" id="tipoOperacion" name="tipoOperacion" value="generarExportarAF" />
				<input type="hidden" id="txtTipoGrado" name="txtTipoGrado" value="<?php echo $estudiantes[0]->getFechaGrado( )->getTipoGrado( )->getIdTipoGrado( ); ?>" />
				<input type="submit" id="btnGenerarActa" value="Exportar Candidatos"/>&nbsp;&nbsp;
				<input type="hidden" id="txtFechaGrado" name="txtFechaGrado" value="<?php echo $txtFechaGrado; ?>" />
				<?php 
					if( $existeSecretaria != 1 ){
					echo "
						<div ><br /><a id=\"btnRActa\">Registrar Acta CF</a>&nbsp;&nbsp;
								"; ?>
								
								
								<?php 
								if( $existeActa != 0 ){ ?>
									<a id="btnAnularActa">Anular Acta CF</a>&nbsp;&nbsp;
									
									<?php if( count( glob( $existeAnexo ) ) > 0 ){ ?>
									<a id="btnDescargarArchivo" name="btnDescargarArchivo" >Ver Anexos</a>&nbsp;&nbsp;
									<a id="btnEnviarSecretaria" name="btnEnviarSecretaria">Enviar Secretaría General</a>
									<?php } ?>
									<div align="left">
									<input type="file" class="nicefile" id="flCargarArchivo"  />&nbsp;&nbsp;&nbsp;&nbsp;
									<a id="btnCargar" name="btnCargar" class="submit" >Cargar</a>
									</div>
									<?php 
									 }
							echo "&nbsp;&nbsp;
						</div>";
						}
					echo "<br />
				</form>
				</div>
				";
		}
			
		echo "<div style=\"overflow: auto; width: 100%; top: 0px; height: 100%\">
			<br />
			<p style=\"font-size: 9pt;\"><b>Por favor recuerda que la fecha máxima de cumplimiento de requisitos por parte de los estudiantes para el grado es : $txtFechaMaxima</b></p>

			<table border=\"0\" id=\"estudiantes\" class=\"display compact\"  cellspacing=\"0\" >
				<thead>
					<tr >
						<th>No</th>
						<th>Estudiante</th>
						<th>Plan Estudiantil</th>
						<th>Financiera</th>
						<th>Documentos</th>
						<th>Trabajo de Grado</th>
						<th>Derechos de Grado</th>
						<th>Inglés</th>
						<th>Otros</th>
						<th>Actualizar</th>
						<th>Sub Total</th>";
						if( $existeActa != 0 ){
						echo "<th>Acta CF</th>";
						}
						if( $existeAcuerdo != 0 ){
						echo "<th>Acuerdo</th>";
						}
					echo "</tr>
				</thead>
			<tbody>";
				
			foreach( $estudiantes as $estudiante ) {
		
				
				if( $cmbPeriodoTMando != -1 ){
					$txtCodigoPeriodo = $cmbPeriodoTMando;
				}else{
					$controlPeriodo = new ControlPeriodo( $persistencia );
					$periodo = $controlPeriodo->buscarPeriodo( );
					
					$txtCodigoPeriodo = $periodo->getCodigo( );
				}
				
				$txtCodigoEstudiante = $estudiante->getCodigoEstudiante( );
				$txtActualizaDatos = $estudiante->getEstadoActualizaDato( );
				
				
				$txtCodigoCarrera = $estudiante->getFechaGrado( )->getCarrera( )->getCodigoCarrera( );
				
				$controlTrabajoGrado = new ControlTrabajoGrado( $persistencia );
				$controlConcepto = new ControlConcepto( $persistencia );
				$controlDocumentacion = new ControlDocumentacion( $persistencia );
				$controlPreMatricula = new ControlPreMatricula( $persistencia );
				$controlDeudaPeople = new ControlDeudaPeople( $persistencia );
				//$controlClienteWebService = new ControlClienteWebService( $persistencia );
				
				
				
				$existeTrabajoGrado = $controlTrabajoGrado->buscarTrabajoGrado( $txtCodigoEstudiante );
				
				$derechoGrado = $controlConcepto->buscarDerechoGrado( $txtCodigoEstudiante );
				$pendientes = $controlDocumentacion->buscarPendientes( $txtCodigoCarrera, $txtCodigoEstudiante );
				$documentoIngles = $controlDocumentacion->buscarPendienteIngles( $txtCodigoEstudiante, $txtCodigoCarrera );
				$documentoOtros = $controlConcepto->buscarExisteOtrosP($txtCodigoEstudiante, $txtCodigoPeriodo);
				
				//$existeMaterias = $controlPreMatricula->buscarMateriasActuales( $txtCodigoEstudiante );
				
				$txtCodigoSituacionCarreraEstudiante = $estudiante->getSituacionCarreraEstudiante( )->getCodigoSituacion( );
				if( $txtCodigoSituacionCarreraEstudiante != 104 ){
					$existeMaterias = $controlPreMatricula->buscarMateriasActuales( $txtCodigoEstudiante );
					$materiasPendientes = $existeMaterias["detallePreMatricula"];
				}else{
					$materiasPendientes = "../css/images/circuloVerde.png";
					$existeMaterias["pendienteMateria"] = 1;
				}
				
				//$deudaPeople = $controlClienteWebService->verificarDeudaPeople( $txtCodigoEstudiante, $txtCodigoCarrera);
				$existeDeuda = $controlDeudaPeople->existeDeudaPeople( $txtCodigoEstudiante );
				
				
				
				if( $existeActa != 0 ){
					$actaAcuerdo = $controlActaAcuerdo->buscarActa($txtFechaGrado, $txtCodigoCarrera, $txtCodigoEstudiante );
					$txtIdActa = $actaAcuerdo->getIdActaAcuerdo( );
					if( count($txtIdActa) != 0 ){
						$detalleActaAcuerdo = $controlActaAcuerdo->buscarDetalleActa( $txtIdActa, $txtCodigoEstudiante );
						$detalleAcuerdo = $controlActaAcuerdo->buscarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante );
					}else{
						$detalleActaAcuerdo = "../css/images/circuloRojo.png";
						$detalleAcuerdo = "../css/images/circuloRojo.png";
					}
				}
				
				/*if( isset($deudaPeople["deudas"]) && $deudaPeople["deudas"] != ""){
					$txtItems = json_encode($deudaPeople["deudas"]);
				}else{
					$txtItems = "";
				}*/
				
				$deudaPeople = $existeDeuda["deudaPeople"];
				
				$documentoPendientes = $pendientes["documentacion"];
				
				$derechoPagoGrado = $derechoGrado["concepto"];
				
				$trabajoGrado = $existeTrabajoGrado["trabajoGrado"];
				
				$pendienteIngles = $documentoIngles["pendienteIngles"];
				
				$conceptoOtro = $documentoOtros["conceptoOtro"];
				
				//$materiasPendientes = $existeMaterias["detallePreMatricula"];
				
				
				$validarMateria = $existeMaterias["pendienteMateria"];
				
				$validarFinanciera = $existeDeuda["existeDeudaPeople"];//$deudaPeople["existeDeuda"];
				
				$validarDocumentos = $pendientes["existeDocumento"];
				
				$validarTGrado = $existeTrabajoGrado["existeTGrado"];
				
				$validarDGrado = $derechoGrado["existeDGrado"];
				
				$validarIngles = $documentoIngles["existeIngles"];
				
				$validarOtros = $documentoOtros["pendienteOtro"];
				
				if( $validarMateria != 1 || $validarFinanciera != 1 || $validarDocumentos != 1 || $validarTGrado != 1 || $validarDGrado != 1 || $validarIngles != 1 || $validarOtros != 1 || $txtActualizaDatos != 1 ){
					$subTotal = "../css/images/circuloRojo.png";
					/*$estudianteSeleccionado = $txtCodigoEstudiante;
					$estudianteSeleccionados[ count( $estudianteSeleccionados ) ] = $estudianteSeleccionado;*/
					
					}else{
						$subTotal = "../css/images/circuloVerde.png";
						$estudianteSeleccionado = $txtCodigoEstudiante;
						$estudianteSeleccionados[ count( $estudianteSeleccionados ) ] = $estudianteSeleccionado;
					}	
				
				if( $txtActualizaDatos != 1 ){
					$imgActualizar = "../css/images/vcard_edit.png";
				}else{
					$imgActualizar = "../css/images/tick.png";
				}
				
				
				echo "<tr>";
				echo "<td >". $i++ . "</td>";
				echo "<td>". $estudiante->getNombreEstudiante( ) ."</td>";
				echo "<td align=\"center\" >". "<img src=\"".$materiasPendientes."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verMaterias( '" . $txtCodigoEstudiante . "' , '" . $validarMateria . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$deudaPeople."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verDeuda( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoCarrera . "' , '" . $validarFinanciera . "' )\"  style=\"cursor:pointer;\" />". "</td>";
				//echo "<td align=\"center\" >". "<img src=\"".$deudaPeople."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verDeuda( '" . htmlentities($txtItems) . "' )\"  style=\"cursor:pointer;\" />". "</td>";
				//echo "<td>". "Financiera" ."</td>";
				//echo "<td align=\"center\" >". "<input type=\"button\" class=\"documentos\" name=\"btnDocu-" . $txtCodigoEstudiante . "\" id=\"btnDocu-" . $txtCodigoEstudiante . "\" title=\"Documentos Pendientes\" onClick=\"verDocumentosPendientes( '" . $txtCodigoCarrera . "' , '" . $txtCodigoEstudiante . "' )\" value=\"\" style=\"background:url('$pendientes') no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
				echo "<td align=\"center\" >". "<img src=\"".$documentoPendientes."\" id=\"imgDocumentos\" width=\"30\" height=\"30\" onClick=\"verDocumentosPendientes( '" . $txtCodigoCarrera . "' , '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$trabajoGrado."\" id=\"imgTrabajoGrado\" width=\"30\" height=\"30\" onClick=\"verTrabajoGrado( '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$derechoPagoGrado."\" id=\"imgDerechoGrado\" width=\"30\" height=\"30\" onClick=\"verDerechoGrado( '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$pendienteIngles."\" id=\"imgIngles\" width=\"30\" height=\"30\" onClick=\"verDocIngles( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoCarrera . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$conceptoOtro."\" id=\"imgOtros\" width=\"30\" height=\"30\" onClick=\"verOtros( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoPeriodo . "' )\" style=\"cursor:pointer;\" />". "</td>";
				//echo "<td align=\"center\">"."<input type=\"button\" class=\"editar\" name=\"btnEdit-" . $txtCodigoEstudiante . "\" id=\"btn-" . $txtCodigoEstudiante . "\" title=\"Actualizar Estudiante\" onClick=\"verActualizarEstudiante( '" . $txtCodigoCarrera . "' , '" . $txtCodigoEstudiante . "' , '" . $txtActualizaDatos . "' )\" value=\"\" style=\"background:url($imgActualizar) no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
				/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
				*Se añade id=\"$txtCodigoEstudiante\" a <td> para identificar la celda que se debe afectar al realizar actalizacion de datos del estudiante
				el id  realiza cambion en js/MainActualizarEstudiante.js
				*Since September 27 , 2017
				*/

				echo "<td align=\"center\" id=\"$txtCodigoEstudiante\">"."<input type=\"button\" class=\"editar\" name=\"btnEdit-" . $txtCodigoEstudiante . "\" id=\"btn-" . $txtCodigoEstudiante . "\" title=\"Actualizar Estudiante\" onClick=\"verActualizarEstudiante( '" . $txtCodigoEstudiante . "' , '" . $txtActualizaDatos . "' )\" value=\"\" style=\"background:url($imgActualizar) no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
				//fin modificacion Diego
				echo "<td align=\"center\" >". "<img src=\"".$subTotal."\" id=\"imgSubTotal\" width=\"30\" height=\"30\" style=\"cursor:pointer;\" />". "</td>";
				
				if( $existeActa != 0 ){
					echo "<td align=\"center\" >". "<img src=\"".$detalleActaAcuerdo."\" id=\"imgDetalleActa\" width=\"30\" height=\"30\" onClick=\"verActa( '" . $txtFechaGrado . "' , '" . $txtIdActa . "', '" . $txtCodigoCarrera . "', '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				}
				if( $existeAcuerdo != 0 ){
					echo "<td align=\"center\" >". "<img src=\"".$detalleAcuerdo."\" id=\"imgDetalleActa\" width=\"30\" height=\"30\" onClick=\"verAcuerdo( '" . $txtFechaGrado . "' , '" . $txtIdActa . "', '" . $txtCodigoCarrera . "', '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				}
				//echo "<td>". "Actualizar" ."</td>";
				echo "</tr>";
			}
				echo "</tbody>";
			
				echo "</table>";
				echo "</div>";
				
				$txtSeleccionados = serialize($estudianteSeleccionados);
			?>
				
			<p><input type="hidden" id="txtEstudianteSeleccionados" name="txtEstudianteSeleccionados" value="<?php echo htmlentities($txtSeleccionados); ?>" />
				<input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $cmbCarreraTMando; ?>" />
				<!--
					*Modidied Diego Rivera <riveradiego@unbosque.edu.co>
					*Se añade campo oculto txtUsuarioActual  almacena  nombre de usuario logueado
					*Since February 20 ,2018
				-->
				<input type="hidden" id="txtUsuarioActual" name="txtUsuarioActual" value="<?php echo $luser; ?>" />
			</p>
					
			<?php	}else{
				
						echo "0";
					?>
					<script src="../js/MainTableroMando.js"></script>		
					
					<?php
					}
			/*}else{
					echo $error;
				}*/
				}
		break;
		
		case "actualizarEstudiante":
		
			
			//$controlClienteWebService = new ControlClienteWebService( $persistencia );
			
			$estudiante = new Estudiante( $persistencia );
			
			$tipoDocumento = new TipoDocumento( null );
			$tipoDocumento->setIniciales($cmbTipoDocumentoAE);
		
			$estudiante->setTipoDocumento( $tipoDocumento );
			
			$genero = new Genero( null );
			$genero->setCodigo( $cmbGeneroAE );
			
			$estudiante->setGenero( $genero );
			
			$estudiante->setNumeroDocumento( $txtNumeroDocumentoAE );
			
			$estudiante->setNombreEstudiante( $txtNombreEstudianteAE );
			
			$estudiante->setApellidoEstudiante( $txtApellidoEstudianteAE );
			
			$estudiante->setExpedicion( $txtLugarExpedicion );
			
			$estudiante->setIdEstudiante( $txtIdEstudianteAE );
		
		
			$controlEstudiante->actualizarEstudiante( $estudiante , $txtCodigoEstudiante );
			
			//$controlClienteWebService->modificaDatosEstudiante( $estudiante , $txtCodigoEstudiante );
			
			//var_dump($result);
			
		break;
		
		
		case "consultarConsejoDirectivo":
		
	 	if( $cmbCarreraTMando == 'pregrados' ||  $cmbCarreraTMando == 'posgrados' ) {
			
		 echo "2";
			
		} else {
		
		
		$filtroActa = "";
		$estudianteSeleccionados = array( );
			
		if( $cmbFacultadTMando != -1 ){
			$filtroActa .= " AND F.codigofacultad = ".$cmbFacultadTMando."";
		}
		
		if( $cmbCarreraTMando != -1){
			$filtroActa .= " AND C.codigocarrera = ".$cmbCarreraTMando."";
		}
		
		if( $cmbPeriodoTMando != -1 ){
			$filtroActa .= " AND FG.CodigoPeriodo = ".$cmbPeriodoTMando."";
		}
		
		if( $cmbTipoGrado != -1 ){
			$filtroActa .= " AND FG.TipoGradoId = ".$cmbTipoGrado."";
		}
		
		/*$error = $controlEstudiante->validar($cmbFacultadTMando, $cmbCarreraTMando, $cmbPeriodoTMando);
		if( $error == ""){*/
		$controlActaAcuerdo = new ControlActaAcuerdo( $persistencia );
		
		$estudiantes = $controlActaAcuerdo->consultarEActas( $filtroActa, $txtIdRol );
		//ddd($estudiantes);
		$i = 1;
		if( count($estudiantes) != 0 ){ ?>
		<script src="../js/MainTableroMando.js"></script>
		<?php 
		
			
			
		$fechaActual = date("Y-m-d");
		$txtFechaMaxima = date( "Y-m-d", strtotime($estudiantes[0]->getEstudiante( )->getFechaGrado( )->getFechaMaxima( ) ) );
		$txtFechaGrado = $estudiantes[0]->getEstudiante( )->getFechaGrado( )->getIdFechaGrado( );	
		
		$txtCodigoModalidadAcademica = $estudiantes[0]->getEstudiante( )->getFechaGrado( )->getCarrera( )->getModalidadAcademica( )->getCodigoModalidadAcademica( );
		$txtIdTipoGrado = $estudiantes[0]->getEstudiante( )->getFechaGrado( )->getTipoGrado( )->getIdTipoGrado( );
		
		$existeActa = $controlActaAcuerdo->buscarActaAcuerdo($txtFechaGrado, $cmbCarreraTMando);
		$existeAcuerdo = $controlActaAcuerdo->existeAcuerdo( $txtFechaGrado, $cmbCarreraTMando );
		
		$existeActaAcuerdo = $controlActaAcuerdo->existeActaAcuerdo( $txtFechaGrado );
		
		//$txtItems = "";	
		if( $txtFechaMaxima != null ){
			//if( $fechaActual > $txtFechaMaxima ){
		
			echo "
			<div id=\"dvAcuerdo\" align=\"right\" style=\"font-size: 1.1em;\">
			<form>";?>
			<input type="hidden" id="txtFechaGrado" name="txtFechaGrado" value="<?php echo $txtFechaGrado; ?>" />
			<input type="hidden" id="txtIdRol" name="txtIdRol" value="<?php echo $txtIdRol; ?>" />
			<input type="hidden" id="txtIdTipoGrado" name="txtIdTipoGrado" value="<?php echo $txtIdTipoGrado; ?>" />
			<?php echo "
					<div ><br />"; 
						if( $txtIdRol != 13 && $txtIdRol != 75 ){
							echo "<a id=\"btnRAcuerdo\">Registrar Acuerdo</a>&nbsp;&nbsp;
							<a id=\"btnAnularAcuerdo\">Anular Acuerdo</a>&nbsp;&nbsp;"; ?>
							<?php 
							if( $existeAcuerdo != 0 ){
								?>
								<input type="hidden" id="tipoOperacion" name="tipoOperacion" value="generarAcuerdo" />
								<input type="submit" id="btnGenerarAcuerdo" value="Generar Acuerdo" onclick="this.form.action='../servicio/pdf.php'"/>
								<?php }
						echo "&nbsp;&nbsp;";
						}else{ 
							if( $existeActaAcuerdo != 0 && $txtIdRol == 13 ){
							?>
							<input type="hidden" id="tipoOperacion" name="tipoOperacion" value="generarActa" />
							<input type="hidden" id="txtCodigoModalidadAcademica" name="txtCodigoModalidadAcademica" value="<?php echo $txtCodigoModalidadAcademica; ?>" />
							<input type="submit" id="btnEnviarVicerrectoria" value="Enviar Vicerrectoría Académica" onclick="this.form.action='../servicio/pdf.php'"/>
							<?php }else{ 
										if( $txtIdRol == 13 ){							
										?>
								<p>Este programa ha sido verificado por Registro y Control</p>	
							<!--<a id="btnEnviarVicerrectoria" name="btnEnviarVicerrectoria">Enviar Vicerrectoría Académica</a>-->
							<?php	}	
								}
						}
					echo "</div>
					<br />
			</form>
			</div>
			";
			//}
		}
		
		echo "<div style=\"overflow: auto; width: 100%; top: 0px; height: 100%\">
			<table border=\"0\" id=\"estudiantesAcuerdo\" cellpadding=\"0\" cellspacing=\"0\" class=\"display\" >
				<thead>
					<tr >
						<th>No</th>
						<th>Estudiante</th>
						<th>Plan Estudiantil</th>
						<th>Financiera</th>
						<th>Documentos</th>
						<th>Trabajo de Grado</th>
						<th>Derechos de Grado</th>
						<th>Inglés</th>
						<th>Otros</th>";
						if( $existeActa != 0 ){
						echo "<th>Acta CF</th>";
						}
						if( $existeAcuerdo != 0 ){
						echo "<th>Acuerdo</th>";
						}
					echo "</tr>
				</thead>
			<tbody>";
			
			foreach( $estudiantes as $estudiante ) {
				
				
				if( $cmbPeriodoTMando != -1 ){
					$txtCodigoPeriodo = $cmbPeriodoTMando;
				}else{
					$controlPeriodo = new ControlPeriodo( $persistencia );
					$periodo = $controlPeriodo->buscarPeriodo( );
					
					$txtCodigoPeriodo = $periodo->getCodigo( );
				}
				
				$txtCodigoEstudiante = $estudiante->getEstudiante( )->getCodigoEstudiante( );
				$txtCodigoCarrera = $estudiante->getEstudiante( )->getFechaGrado( )->getCarrera( )->getCodigoCarrera( );
				
				
				
				$controlTrabajoGrado = new ControlTrabajoGrado( $persistencia );
				$controlConcepto = new ControlConcepto( $persistencia );
				$controlDocumentacion = new ControlDocumentacion( $persistencia );
				$controlPreMatricula = new ControlPreMatricula( $persistencia );
				$controlDeudaPeople = new ControlDeudaPeople( $persistencia );
				//$controlClienteWebService = new ControlClienteWebService( $persistencia );
				
				$existeTrabajoGrado = $controlTrabajoGrado->buscarTrabajoGrado( $txtCodigoEstudiante );
				$derechoGrado = $controlConcepto->buscarDerechoGrado( $txtCodigoEstudiante );
				$pendientes = $controlDocumentacion->buscarPendientes( $txtCodigoCarrera, $txtCodigoEstudiante );
				$documentoIngles = $controlDocumentacion->buscarPendienteIngles( $txtCodigoEstudiante, $txtCodigoCarrera );
				$documentoOtros = $controlConcepto->buscarExisteOtrosP($txtCodigoEstudiante, $txtCodigoPeriodo);
				
				$txtCodigoSituacionCarreraEstudiante = $estudiante->getEstudiante( )->getSituacionCarreraEstudiante( )->getCodigoSituacion( );
				
				//echo $txtCodigoSituacionCarreraEstudiante."<br />";
				
				if( $txtCodigoSituacionCarreraEstudiante != 104 && $txtCodigoSituacionCarreraEstudiante != 400 ){
					$existeMaterias = $controlPreMatricula->buscarMateriasActuales( $txtCodigoEstudiante );
					$materiasPendientes = $existeMaterias["detallePreMatricula"];
				}else{
					$materiasPendientes = "../css/images/circuloVerde.png";
					$existeMaterias["pendienteMateria"] = 1;
				}
				
				$existeDeuda = $controlDeudaPeople->existeDeudaPeople( $txtCodigoEstudiante );
				//$deudaPeople = $controlClienteWebService->verificarDeudaPeople( $txtCodigoEstudiante, $txtCodigoCarrera);
				
				if( $existeActa != 0 ){
					$actaAcuerdo = $controlActaAcuerdo->buscarActa($txtFechaGrado, $txtCodigoCarrera, $txtCodigoEstudiante );
					$txtIdActa = $actaAcuerdo->getIdActaAcuerdo( );
					if( count($txtIdActa) != 0 ){
						//$existeAcuerdo = $actaAcuerdo->buscarAcuerdo($txtFechaGrado, $txtCodigoCarrera, $txtIdActa);
						$detalleActaAcuerdo = $controlActaAcuerdo->buscarDetalleActa( $txtIdActa, $txtCodigoEstudiante );
						
						$detalleAcuerdo = $controlActaAcuerdo->buscarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante );
						
					}else{
						$detalleActaAcuerdo = "../css/images/circuloRojo.png";
						$detalleAcuerdo = "../css/images/circuloRojo.png";
					}
					
				}
				
				/*if( isset($deudaPeople["deudas"]) && $deudaPeople["deudas"] != ""){
					$txtItems = json_encode($deudaPeople["deudas"]);
				}else{
					$txtItems = "";
				}*/
				$deudaPeople = $existeDeuda["deudaPeople"];
				
				$documentoPendientes = $pendientes["documentacion"];
				
				$derechoPagoGrado = $derechoGrado["concepto"];
				
				$trabajoGrado = $existeTrabajoGrado["trabajoGrado"];
				
				$pendienteIngles = $documentoIngles["pendienteIngles"];
				
				$conceptoOtro = $documentoOtros["conceptoOtro"];
				
				
				
				$validarMateria = $existeMaterias["pendienteMateria"];
				
				$validarFinanciera = $existeDeuda["existeDeudaPeople"];
				
				$estudianteSeleccionado = $txtCodigoEstudiante;
				$estudianteSeleccionados[ count( $estudianteSeleccionados ) ] = $estudianteSeleccionado;
				
				
				echo "<tr>";
				echo "<td>". $i++ . "</td>";
				echo "<td>". $estudiante->getEstudiante( )->getNombreEstudiante( ) ."</td>";
				echo "<td align=\"center\" >". "<img src=\"".$materiasPendientes."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verMaterias( '" . $txtCodigoEstudiante . "' , '" . $validarMateria . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$deudaPeople."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verDeuda( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoCarrera . "' , '" . $validarFinanciera . "' )\"  style=\"cursor:pointer;\" />". "</td>";
				//echo "<td align=\"center\" >". "<img src=\"".$deudaPeople["imagen"]."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verDeuda( '" . htmlentities($txtItems) . "' )\"  style=\"cursor:pointer;\" />". "</td>";
				//echo "<td>". "Financiera" ."</td>";
				//echo "<td align=\"center\" >". "<input type=\"button\" class=\"documentos\" name=\"btnDocu-" . $txtCodigoEstudiante . "\" id=\"btnDocu-" . $txtCodigoEstudiante . "\" title=\"Documentos Pendientes\" onClick=\"verDocumentosPendientes( '" . $txtCodigoCarrera . "' , '" . $txtCodigoEstudiante . "' )\" value=\"\" style=\"background:url('$pendientes') no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
				echo "<td align=\"center\" >". "<img src=\"".$documentoPendientes."\" id=\"imgDocumentos\" width=\"30\" height=\"30\" onClick=\"verDocumentosPendientes( '" . $txtCodigoCarrera . "' , '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$trabajoGrado."\" id=\"imgTrabajoGrado\" width=\"30\" height=\"30\" onClick=\"verTrabajoGrado( '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$derechoPagoGrado."\" id=\"imgDerechoGrado\" width=\"30\" height=\"30\" onClick=\"verDerechoGrado( '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$pendienteIngles."\" id=\"imgIngles\" width=\"30\" height=\"30\" onClick=\"verDocIngles( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoCarrera . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$conceptoOtro."\" id=\"imgOtros\" width=\"30\" height=\"30\" onClick=\"verOtros( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoPeriodo . "' )\" style=\"cursor:pointer;\" />". "</td>";
				//echo "<td align=\"center\" >". "<img src=\"".$subTotal."\" id=\"imgSubTotal\" width=\"30\" height=\"30\" style=\"cursor:pointer;\" />". "</td>";
				if( $existeActa != 0 ){
					echo "<td align=\"center\" >". "<img src=\"".$detalleActaAcuerdo."\" id=\"imgDetalleActa\" width=\"30\" height=\"30\" onClick=\"verActa( '" . $txtFechaGrado . "' , '" . $txtIdActa . "', '" . $txtCodigoCarrera . "', '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				}
				if( $existeAcuerdo != 0 ){
					echo "<td align=\"center\" >". "<img src=\"".$detalleAcuerdo."\" id=\"imgDetalleActa\" width=\"30\" height=\"30\" onClick=\"verAcuerdo( '" . $txtFechaGrado . "' , '" . $txtIdActa . "', '" . $txtCodigoCarrera . "', '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				}
				//echo "<td>". "Actualizar" ."</td>";*/
				echo "</tr>";
			}
				echo "</tbody>";
			
				echo "</table>";
				echo "</div>";
				
				$txtSeleccionados = serialize($estudianteSeleccionados);
				
				?>
				
			<p><input type="hidden" id="txtEstudianteSeleccionados" name="txtEstudianteSeleccionados" value="<?php echo htmlentities($txtSeleccionados); ?>" />
				<input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $cmbCarreraTMando; ?>" />
			</p>	
		<?php 	}else{
					echo "0";
				}
			/*}else{
				echo $error;
			}*/
		}
		break;
		
		case "consultarSecretaria":
			
		$filtroAcuerdo = "";
		$estudianteSeleccionados = array( );
			
		if( $cmbCarreraTMando == 'pregrados' ||  $cmbCarreraTMando == 'posgrados' ) {
			
			echo "2";
			
		}else {	
			
		if( $cmbFacultadTMando != -1 ){
			$filtroAcuerdo .= " AND F.codigofacultad = ".$cmbFacultadTMando."";
		}
		
		if( $cmbCarreraTMando != -1){
			$filtroAcuerdo .= " AND C.codigocarrera = ".$cmbCarreraTMando."";
		}
		
		if( $cmbPeriodoTMando != -1 ){
			$filtroAcuerdo .= " AND FG.CodigoPeriodo = ".$cmbPeriodoTMando."";
		}
		
		if( $cmbTipoGrado != -1 ){
			$filtroAcuerdo .= " AND FG.TipoGradoId = ".$cmbTipoGrado."";
		}
		
		/*$error = $controlEstudiante->validar($cmbFacultadTMando, $cmbCarreraTMando, $cmbPeriodoTMando);
		if( $error == ""){*/
		
		$controlActaAcuerdo = new ControlActaAcuerdo( $persistencia );
		$controlRegistroGrado = new ControlRegistroGrado( $persistencia );
		
		$estudiantes = $controlActaAcuerdo->consultarEAcuerdo( $filtroAcuerdo );
		
		$i = 1;
		if( count($estudiantes) != 0 ){?>
		<script src="../js/MainTableroMando.js"></script>
		<script src="../js/MainFolio.js"></script>
		<script src="../js/MainFirma.js"></script>
		<?php 
		
		
			
			
		$fechaActual = date("Y-m-d");
		$txtFechaMaxima = date( "Y-m-d", strtotime($estudiantes[0]->getEstudiante( )->getFechaGrado( )->getFechaMaxima( ) ) );
		$txtFechaGrado = $estudiantes[0]->getEstudiante( )->getFechaGrado( )->getIdFechaGrado( );
		$txtCodigoModalidadAcademica = $estudiantes[0]->getEstudiante( )->getFechaGrado( )->getCarrera( )->getModalidadAcademica( )->getCodigoModalidadAcademica( );
		
		$existeNumeroPromocion = $controlRegistroGrado->buscarRegistroGradoFechaGrado( $txtFechaGrado );
		
		$existeActa = $controlActaAcuerdo->buscarActaAcuerdo($txtFechaGrado, $cmbCarreraTMando);
		$existeAcuerdo = $controlActaAcuerdo->existeAcuerdo( $txtFechaGrado, $cmbCarreraTMando );
		
		$txtNumeroActaConsejoDirectivo = $estudiantes[0]->getActaAcuerdo( )->getNumeroActaConsejoDirectivo( );
		
		$txtItems = "";	
		if( $txtFechaMaxima != null ){
			//if( $fechaActual > $txtFechaMaxima ){
			echo "<div id=\"dvSecretaria\" align=\"right\" style=\"font-size: 1.1em;\">
					<div ><br /><a id=\"btnRGrado\">Registrar Grado</a>&nbsp;&nbsp;
							<a id=\"btnFirma\">Registrar Firmas</a>&nbsp;&nbsp;
							<a id=\"btnImprimirGrado\">Imprimir Documentos Grado</a>&nbsp;&nbsp;	
					</div>
					<br />
			</div>";
			//}
		}
		
		echo "<div style=\"overflow: auto; width: 100%; top: 0px; height: 100%\">
			<br />
			<p style=\"font-size: 9pt;\"><b>El Número de Acta del Consejo Directivo es: $txtNumeroActaConsejoDirectivo</b></p>";
			//if( $existeNumeroPromocion == 0 ){ 
			echo "<p style=\"font-size: 9pt;\"><b>Número de Promoción</b>: &nbsp;&nbsp;&nbsp; <input type=\"text\" id=\"txtNumeroPromocion\" name=\"txtNumeroPromocion\" /></p>";
			//}
			echo "<div class=\"frmSearch\">
									<b style=\"font-size: 9pt;\">Directivo Autoriza el Grado:</b> &nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"txtDirectivoSecretaria\" name=\"txtDirectivoSecretaria\" />
									<input type=\"hidden\" id=\"idDirectivoSecretaria\" name=\"idDirectivoSecretaria\" />
									<div id=\"suggesstion-box\"></div>
									</div>
				<br />
				<table border=\"0\" id=\"estudiantesSecretaria\" cellpadding=\"0\" cellspacing=\"0\" class=\"display\" >
				<thead>
					<tr >
						<th>No</th>
						<th>Estudiante</th>
						<th>Plan Estudiantil</th>
						<th>Financiera</th>
						<th>Documentos</th>
						<th>Trabajo de Grado</th>
						<th>Derechos de Grado</th>
						<th>Inglés</th>
						<th>Otros</th>";
						if( $existeActa != 0 ){
						echo "<th>Acta CF</th>";
						}
						if( $existeAcuerdo != 0 ){
						echo "<th>Acuerdo</th>";
						}
						echo "<th><input type=\"checkbox\" id=\"selectAllSecretaria\" name=\"selectAllSecretaria\" checked /></th>
						<th>Diploma</th>
						<th>Anular</th>
						<th>Notas</th>
                                                <th>Actualizar</th>
					</tr>
				</thead>
			<tbody>";
			
			foreach( $estudiantes as $estudiante ) {
				
				
				if( $cmbPeriodoTMando != -1 ){
					$txtCodigoPeriodo = $cmbPeriodoTMando;
				}else{
					$controlPeriodo = new ControlPeriodo( $persistencia );
					$periodo = $controlPeriodo->buscarPeriodo( );
					
					$txtCodigoPeriodo = $periodo->getCodigo( );
				}
				
				$txtCodigoEstudiante = $estudiante->getEstudiante( )->getCodigoEstudiante( );
				$txtCodigoCarrera = $estudiante->getEstudiante( )->getFechaGrado( )->getCarrera( )->getCodigoCarrera( );
				
				
				
				$controlTrabajoGrado = new ControlTrabajoGrado( $persistencia );
				$controlConcepto = new ControlConcepto( $persistencia );
				$controlDocumentacion = new ControlDocumentacion( $persistencia );
				$controlPreMatricula = new ControlPreMatricula( $persistencia );
				//$controlClienteWebService = new ControlClienteWebService( $persistencia );
				$controlActaGrado = new ControlActaGrado( $persistencia );
				
				
				$controlDeudaPeople = new ControlDeudaPeople( $persistencia );
	
				
				$existeTrabajoGrado = $controlTrabajoGrado->buscarTrabajoGrado( $txtCodigoEstudiante );
				$derechoGrado = $controlConcepto->buscarDerechoGrado( $txtCodigoEstudiante );
				$pendientes = $controlDocumentacion->buscarPendientes( $txtCodigoCarrera, $txtCodigoEstudiante );
				$documentoIngles = $controlDocumentacion->buscarPendienteIngles( $txtCodigoEstudiante, $txtCodigoCarrera );
				$documentoOtros = $controlConcepto->buscarExisteOtrosP($txtCodigoEstudiante, $txtCodigoPeriodo);
				
				$txtCodigoSituacionCarreraEstudiante = $estudiante->getEstudiante( )->getSituacionCarreraEstudiante( )->getCodigoSituacion( );
				if( $txtCodigoSituacionCarreraEstudiante != 104 && $txtCodigoSituacionCarreraEstudiante != 400 ){
					$existeMaterias = $controlPreMatricula->buscarMateriasActuales( $txtCodigoEstudiante );
					$materiasPendientes = $existeMaterias["detallePreMatricula"];
				}else{
					$materiasPendientes = "../css/images/circuloVerde.png";
					$existeMaterias["pendienteMateria"] = 1;
				}
				
				$existeDeuda = $controlDeudaPeople->existeDeudaPeople( $txtCodigoEstudiante );
				//$deudaPeople = $controlClienteWebService->verificarDeudaPeople( $txtCodigoEstudiante, $txtCodigoCarrera);
				
				if( $existeActa != 0 ){
					$actaAcuerdo = $controlActaAcuerdo->buscarActa($txtFechaGrado, $txtCodigoCarrera, $txtCodigoEstudiante );
					$txtIdActa = $actaAcuerdo->getIdActaAcuerdo( );
					if( count($txtIdActa) != 0 ){
						//$existeAcuerdo = $actaAcuerdo->buscarAcuerdo($txtFechaGrado, $txtCodigoCarrera, $txtIdActa);
						$detalleActaAcuerdo = $controlActaAcuerdo->buscarDetalleActa( $txtIdActa, $txtCodigoEstudiante );
						
						$detalleAcuerdo = $controlActaAcuerdo->buscarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante );
						
						$registroGrado = $controlRegistroGrado->buscarRegistroGradoEstudiante( $txtCodigoEstudiante, $txtIdActa ); 
						
						$existeGrado = $controlRegistroGrado->buscarRegistroGradoId( $txtCodigoEstudiante, $txtIdActa );
						
						$txtIdRegistroGrado = $existeGrado->getIdRegistroGrado( );
						
						$txtNumeroDiploma = $existeGrado->getNumeroDiploma( ); 
						
					}else{
						$detalleActaAcuerdo = "../css/images/circuloRojo.png";
						$detalleAcuerdo = "../css/images/circuloRojo.png";
						$registroGrado = "../css/images/circuloRojo.png";
					}
					
				}
				
				/*if( isset($deudaPeople["deudas"]) && $deudaPeople["deudas"] != ""){
					$txtItems = json_encode($deudaPeople["deudas"]);
				}else{
					$txtItems = "";
				}*/
				
				$deudaPeople = $existeDeuda["deudaPeople"];
				
				$documentoPendientes = $pendientes["documentacion"];
				
				$derechoPagoGrado = $derechoGrado["concepto"];
				
				$trabajoGrado = $existeTrabajoGrado["trabajoGrado"];
				
				$pendienteIngles = $documentoIngles["pendienteIngles"];
				
				$conceptoOtro = $documentoOtros["conceptoOtro"];
				
				//$materiasPendientes = $existeMaterias["detallePreMatricula"];
				
				$validarMateria = $existeMaterias["pendienteMateria"];
				
				$validarFinanciera = $existeDeuda["existeDeudaPeople"];
				
                                $txtActualizaDatos = 0;			
                                $imgActualizar = "../css/images/vcard_edit.png";

                                
                                
				echo "<tr>";
				if( $txtIdRegistroGrado != ""){
				echo "<td>". $txtIdRegistroGrado ."</td>";
				}else{
					echo "<td>". $i++ ."</td>";
				}
				echo "<td>". $estudiante->getEstudiante( )->getNombreEstudiante( ) ."</td>";
				echo "<td align=\"center\" >". "<img src=\"".$materiasPendientes."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verMaterias( '" . $txtCodigoEstudiante . "' , '" . $validarMateria . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$deudaPeople."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verDeuda( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoCarrera . "' , '" . $validarFinanciera . "' )\"  style=\"cursor:pointer;\" />". "</td>";
				//echo "<td align=\"center\" >". "<img src=\"".$deudaPeople["imagen"]."\" id=\"imgMateriasActuales\" width=\"30\" height=\"30\" onClick=\"verDeuda( '" . htmlentities($txtItems) . "' )\"  style=\"cursor:pointer;\" />". "</td>";
				//echo "<td>". "Financiera" ."</td>";
				//echo "<td align=\"center\" >". "<input type=\"button\" class=\"documentos\" name=\"btnDocu-" . $txtCodigoEstudiante . "\" id=\"btnDocu-" . $txtCodigoEstudiante . "\" title=\"Documentos Pendientes\" onClick=\"verDocumentosPendientes( '" . $txtCodigoCarrera . "' , '" . $txtCodigoEstudiante . "' )\" value=\"\" style=\"background:url('$pendientes') no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
				echo "<td align=\"center\" >". "<img src=\"".$documentoPendientes."\" id=\"imgDocumentos\" width=\"30\" height=\"30\" onClick=\"verDocumentosPendientes( '" . $txtCodigoCarrera . "' , '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$trabajoGrado."\" id=\"imgTrabajoGrado\" width=\"30\" height=\"30\" onClick=\"verTrabajoGrado( '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$derechoPagoGrado."\" id=\"imgDerechoGrado\" width=\"30\" height=\"30\" onClick=\"verDerechoGrado( '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$pendienteIngles."\" id=\"imgIngles\" width=\"30\" height=\"30\" onClick=\"verDocIngles( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoCarrera . "' )\" style=\"cursor:pointer;\" />". "</td>";
				echo "<td align=\"center\" >". "<img src=\"".$conceptoOtro."\" id=\"imgOtros\" width=\"30\" height=\"30\" onClick=\"verOtros( '" . $txtCodigoEstudiante . "' , '" . $txtCodigoPeriodo . "' )\" style=\"cursor:pointer;\" />". "</td>";
				//echo "<td align=\"center\" >". "<img src=\"".$subTotal."\" id=\"imgSubTotal\" width=\"30\" height=\"30\" style=\"cursor:pointer;\" />". "</td>";
				if( $existeActa != 0 ){
					echo "<td align=\"center\" >". "<img src=\"".$detalleActaAcuerdo."\" id=\"imgDetalleActa\" width=\"30\" height=\"30\" onClick=\"verActa( '" . $txtFechaGrado . "' , '" . $txtIdActa . "', '" . $txtCodigoCarrera . "', '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				}
				if( $existeAcuerdo != 0 ){
					echo "<td align=\"center\" >". "<img src=\"".$detalleAcuerdo."\" id=\"imgDetalleActa\" width=\"30\" height=\"30\" onClick=\"verAcuerdo( '" . $txtFechaGrado . "' , '" . $txtIdActa . "', '" . $txtCodigoCarrera . "', '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				}?>
				
				<?php
				if( count($txtIdRegistroGrado) != 0 ){ ?>
					<td align="center"><input type="checkbox" id="ckSeleccionarGrado" name="ckSeleccionarGrado" disabled="disabled" checked /></td>
					<?php
					echo "<td align=\"center\" >". "<img src=\"../css/images/actualizar.png\" id=\"imgRegistroGrado\" onClick=\"actualizarDiploma( '" . $txtIdRegistroGrado . "' , '" . $txtNumeroDiploma . "' , '" . $txtCodigoEstudiante . "' )\" style=\"cursor:pointer;\" />". "</td>";
				}else{ ?>
					<td align="center"><input type="checkbox" id="ckSeleccionarSecretaria" name="ckSeleccionarSecretaria" value="<?php echo $txtCodigoEstudiante; ?>" /></td>
					<td align="center"><input type="text" id="txtNumeroDiploma" name="txtNumeroDiploma" class="txtNumeroDiploma" size="5" /></td>	
				<?php }
				echo "<td align=\"center\">"."<input type=\"button\" class=\"eliminar\" name=\"btnEli-" . $txtCodigoEstudiante . "\" id=\"btn-" . $txtCodigoEstudiante . "\" title=\"Eliminar Registro Grado\" value=\"\" onClick=\"eliminarRGrado( '" . $txtIdRegistroGrado . "' , '" . $txtFechaGrado . "', '" . $txtIdActa . "', '" . $txtCodigoCarrera . "', '" . $txtCodigoEstudiante . "' )\"  style=\"background:url(../css/images/delete.png) no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
				echo "<td align=\"center\">"."<input type=\"button\" class=\"nota\" name=\"btnNot-" . $txtCodigoEstudiante . "\" id=\"btn-" . $txtCodigoEstudiante . "\" title=\"Observaciones\" value=\"\" onClick=\"verNota( '" . $txtIdRegistroGrado . "' )\"  style=\"background:url(../css/images/page.png) no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
				echo "<td align=\"center\" id=\"$txtCodigoEstudiante\">"."<input type=\"button\" class=\"editar\" name=\"btnEdit-" . $txtCodigoEstudiante . "\" id=\"btn-" . $txtCodigoEstudiante . "\" title=\"Actualizar Estudiante\" onClick=\"verActualizarEstudiante( '" . $txtCodigoEstudiante . "' , '" . $txtActualizaDatos . "' )\" value=\"\" style=\"background:url($imgActualizar) no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;\"></td>";
                                echo "</tr>";
			}
				echo "</tbody>";
			
				echo "</table>";
				echo "</div>";
				
				?>
				
			<p>	<input type="hidden" id="txtFechaGrado" name="txtFechaGrado" value="<?php echo $txtFechaGrado; ?>" />
				<input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $cmbCarreraTMando; ?>" />
				<input type="hidden" id="txtCodigoModalidadAcademica" name="txtCodigoModalidadAcademica" value="<?php echo $txtCodigoModalidadAcademica; ?>" />
			</p>	
			<?php }else{
						echo "0";
					}
			/*}else{
				echo $error;
			}*/
			
			}
		break;
                case "estudianteCarrera":
                    $jsonDatos =array();
                
                    $controlRegistroGrado = new ControlRegistroGrado( $persistencia );
                    
                    $datoEstudiante = $controlEstudiante->estudianteCarrera( $idCarrera, $documento);
                    
                    $codigo=$datoEstudiante->getCodigoEstudiante();
                    $jsonDatos["codigo"] = $datoEstudiante->getCodigoEstudiante();
                    $jsonDatos["nombre"] =$datoEstudiante->getNombreEstudiante();
                    
                    if( $codigo ){
                        $existeGrado = $controlRegistroGrado->existeRegistroGrado( $datoEstudiante->getCodigoEstudiante() );
                        $jsonDatos["registro"]=$existeGrado->getIdRegistroGrado();
                    
                    }else{
                       $jsonDatos["registro"]=null;
                        
                    }
                    
                    
                    
                    header('content-type:application/json;charset=utf-8');
                    echo json_encode($jsonDatos);
                    
                 break;
	}
  
  
?>