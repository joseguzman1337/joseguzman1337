<?php
  /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package interfaz
    */
   
   	header('Content-type: text/html; charset=utf-8');
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
	include '../control/ControlCarreraPeople.php';
	include '../control/ControlActaAcuerdo.php';
	include '../control/ControlIncentivoAcademico.php';
	
	
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
	
	$controlActaAcuerdo = new ControlActaAcuerdo( $persistencia );
	$controlEstudiante = new ControlEstudiante( $persistencia );
	$controlIncentivo = new ControlIncentivoAcademico( $persistencia );

	switch( $tipoOperacion ){
		
		case "consultarActa":
			if( $txtIdActa != ""){
				//$existeDetalleAcuerdo = $controlActaAcuerdo->buscarDetalleActaId( $txtIdActa, $txtCodigoEstudiante );
				$detalleActaAcuerdo = $controlActaAcuerdo->buscarActaId( $txtFechaGrado, $txtIdActa, $txtCodigoCarrera );
				
				$incentivos = $controlIncentivo->listarIncentivoEstudiante($txtCodigoEstudiante, $txtCodigoCarrera);
					?>
					<script src="../js/MainAcuerdoIncentivo.js"></script>
					<div class="detalles">
						<p align="justify">El estudiante se aprobó para grado por medio del acta número: <b><?php echo $detalleActaAcuerdo->getNumeroActa( ); ?></b> de fecha: <b><?php echo date("Y-m-d", strtotime($detalleActaAcuerdo->getFechaActa( ))); ?></b></p>
						<input type="hidden" id="txtCodigoEstudiante" name="txtCodigoEstudiante" value="<?php echo $txtCodigoEstudiante; ?>" />
						<input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $txtCodigoCarrera; ?>" />
						<?php 
							if(count($incentivos) > 0 ){
								$i = 1; ?>
								<p align="justify"><b>Incentivos académicos: </b></p>
							<?php	
									$cuentaIncentivo = 1;
									foreach( $incentivos as $incentivo ){ ?>
									<input type="hidden" id="txtIdIncentivo<?php echo $cuentaIncentivo; ?>" name="txtIdIncentivo<?php echo $cuentaIncentivo; ?>" class="txtIdIncentivo" value="<?php echo $incentivo->getIdIncentivo( ); ?>" />
									<p align="justify"><b><?php echo $i++."."." ".$incentivo->getNombreIncentivo( ); ?></b></p>
									<br />
									<table width="75%" border="0" cellpadding="0" cellspacing="0">
										<?php if( $lrol == 89 || $lrol == 53 ){ ?>
										<tr>
											<td>Número Acta Incentivo</td>
											<td><input type="text" id="txtNumeroActaIncentivo<?php echo $cuentaIncentivo; ?>" name="txtNumeroActaIncentivo<?php echo $cuentaIncentivo; ?>" class="txtNumeroActaIncentivo" value="<?php if( $incentivo->getNumeroActaAcuerdoIncentivo( ) != "") echo $incentivo->getNumeroActaAcuerdoIncentivo( ); ?>" /> </td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Número Acuerdo Incentivo</td>
											<td><input type="text" id="txtNumeroAcuerdoIncentivo<?php echo $cuentaIncentivo; ?>" name="txtNumeroAcuerdoIncentivo<?php echo $cuentaIncentivo; ?>" class="txtNumeroAcuerdoIncentivo" value="<?php if( $incentivo->getNumeroAcuerdoIncentivo( ) != "") echo $incentivo->getNumeroAcuerdoIncentivo( ); ?>" /> </td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Fecha Incentivo</td>
											<td><input type="text" id="txtFechaIncentivo<?php echo $cuentaIncentivo; ?>" name="txtFechaIncentivo<?php echo $cuentaIncentivo; ?>" class="txtFechaIncentivo" value="<?php if( $incentivo->getFechaAcuerdoIncentivo( ) != "") echo $incentivo->getFechaAcuerdoIncentivo( ); ?>" /> </td>
										</tr>
										<?php if( $lrol == 53 ) { ?>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>Número Consecutivo</td>
											<td><input type="text" id="txtNumeroConsecutivoIncentivo<?php echo $cuentaIncentivo; ?>" name="txtNumeroConsecutivoIncentivo<?php echo $cuentaIncentivo; ?>" class="txtNumeroConsecutivoIncentivo" value="<?php if( $incentivo->getNumeroConsecutivoIncentivo( ) != "") echo $incentivo->getNumeroConsecutivoIncentivo( ); ?>" /> </td>
										</tr>
										<?php } ?>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										
										<?php }?>
									</table>
							<?php 
							$cuentaIncentivo = $cuentaIncentivo + 1;
							}
							if( $lrol == 89 || $lrol == 53 ){ ?>
								<br />
								<a id="btnActualizarIncentivo" name="btnActualizarIncentivo">Actualizar</a>
						<?php } 
							} ?>
					</div>
				<?php
			}else{
				echo "El estudiante no tiene aprobada ningún número de acta";
			}
			 break;
		 
		
		case "consultarAcuerdo":
			
			 
			if( $txtIdActa != ""){
				$actaAcuerdo = $controlActaAcuerdo->buscarAcuerdo($txtFechaGrado, $txtCodigoCarrera, $txtIdActa, $txtCodigoEstudiante);
				//var_dump($actaAcuerdo);
				$txtNumeroAcuerdo = $actaAcuerdo->getNumeroAcuerdo( );
				if( $txtNumeroAcuerdo != ""){					?>
					<div class="detalles">
						<p align="justify">El estudiante se aprobó para grado por medio del acuerdo número: <b><?php echo $actaAcuerdo->getNumeroAcuerdo( ); ?></b> de fecha: <b><?php echo date("Y-m-d", strtotime($actaAcuerdo->getFechaAcuerdo( ))); ?></b></p>
					</div>
				<?php }else{
					echo "El estudiante no tiene aprobada ningún número de acuerdo";
				}
			}else{
				echo "El estudiante no tiene aprobada ningún número de acuerdo";
			}
		 break;
	}
	
?>