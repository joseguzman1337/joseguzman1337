<?php
  /**
   * @author Diego RIvera <riveradiego@unbosque.edu.co>
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
	
	$controlIncentivo = new ControlIncentivoAcademico( $persistencia );

	$verIncentivo = $controlIncentivo->buscarIncentivoEstudiantes( $estudiante , $carrera , $incentivo );

	$fecha = substr($verIncentivo->getFechaActaIncentivo( ),0,10);
	$observacion  = $verIncentivo->getObservacionIncentivo( );
	$id = $verIncentivo->getIdIncentivo( );
	$numeroActa = $verIncentivo->getNumeroActaIncentivo( );
	$tipoIncentivo = $verIncentivo->getNombreIncentivo( );
	$numeroConsecutivoIncentivo = $verIncentivo->getNumeroConsecutivoIncentivo( );

	
?>
<script src="../js/MainRegistrarActaAcuerdo.js"></script>
<div id="dvActualizarIncentivo">
			
		<form id="formActualizarIncentivo">
			<input type="hidden" name="idRegistro" id="idRegistro"  value="<?php echo $id ?>">
			<input type="hidden" name="accion" value="actualizar">
			
			<br />
			<h3><span id="nombre"><?php echo $nombre?></span></h3>
			<table width="80%" border="0">
				<tr>
					<td>
						<fieldset>
							<legend>Actualizar Incentivo Académico</legend>
							<table width="100%" border="0">
								<tr>
									<td>Tipo Incentivo</td>
									<td>
										<?php echo $tipoIncentivo?>
									</td>
								</tr>
								<tr>
									<td>Observación</td>
									<td><textarea id="txtObservacionActualizar" name="txtObservacionActualizar" rows="4" cols="40"><?php echo $observacion?></textarea></td>
								</tr>
								<tr>
									<td>Acta Incentivo</td>
									<td><input type="text" id="txtNumeroActaIncentivoActualizar" name="txtNumeroActaIncentivoActualizar" value="<?php echo $numeroActa?>" /></td>
								</tr>
								<tr>
									<td>Fecha Acta Incentivo</td>
									<td><input type="text" id="txtFechaActaIncentivoActualizar" name="txtFechaActaIncentivoActualizar"  value="<?php echo $fecha?>" /></td>
								</tr>
							</table>
						</fieldset>
					</td>
				</tr>
			</table>
			</br>
			  <div align="left"><a id="btnIncentivoActualizar">Actualizar</a>
			  </div>
		</form>
		
	</div>

