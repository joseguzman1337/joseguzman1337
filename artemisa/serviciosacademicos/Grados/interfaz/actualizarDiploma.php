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
	include '../control/ControlCarreraPeople.php';
	include '../control/ControlActaAcuerdo.php';
	include '../control/ControlRegistroGrado.php';
	include '../control/ControlFechaGrado.php';
	
	
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
	
?>
<script src="../js/MainDiploma.js"></script>
<br />
<br />
<div id="dvNumeroDiploma">
	<form id="formNumeroDiploma">
	<p><input type="hidden" id="txtIdRegistroGrado" name="txtIdRegistroGrado" value="<?php echo $txtIdRegistroGrado; ?>" />
		<input type="hidden" id="txtNumeroDiplomaAnterior" name="txtNumeroDiplomaAnterior" value="<?php echo $txtNumeroDiploma; ?>" />
		<input type="hidden" id="txtCodigoEstudiante" name="txtCodigoEstudiante" value="<?php echo $txtCodigoEstudiante; ?>" />
	</p>
	<fieldset>
		<legend>Actualizar Número de Diploma</legend>
		<br />
		<br />
		<table width="50%"  border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td>Anterior: </td>
							<td><b><?php echo $txtNumeroDiploma; ?></b></td>
						</tr>
						<tr>
							<td>Número de Diploma</td>
							<td><input type="text" id="txtNumeroDiploma2" name="txtNumeroDiploma2" /></td>
						</tr>
						<tr>
							<td>Observación</td>
							<td><textarea id="txtObservacionDiploma" name="txtObservacionDiploma"></textarea></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<div align="left"><a id="btnGuardarDiploma">Guardar</a>
		  	<!--<a id="btnRestaurarTMando">Restaurar</a>
		  	<input type="submit" id="btnExportarRGrado" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>
		  <input type="submit" id="btnExportarRadicacion" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>-->
	  	</div>
	</fieldset>	
	</form>
</div>
<br />
<br />
