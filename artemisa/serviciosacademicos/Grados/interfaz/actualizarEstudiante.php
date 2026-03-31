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
	set_time_limit(0);
	
	session_start( );
	
	require_once("../../../kint/Kint.class.php");
	
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
	include '../control/ControlEstudianteDocumento.php';
	include '../control/ControlLocalidad.php';
	
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
	
	$estudiante = $controlEstudiante->buscarEstudiante( $txtCodigoEstudiante );
	
	$controlTipoDocumento = new ControlTipoDocumento( $persistencia );

	$tiposDocumentos = $controlTipoDocumento->consultar( );
	
	$generos = $controlEstudiante->consultarGenero( );
	
?>
<script src="../js/MainActualizarEstudiante.js"></script>
<?php if( $txtActualizaDatos != 1 ){ ?>
<form id="formActualizarEstudiante">
	<p>
		<input type="hidden" id="tipoOperacion" name="tipoOperacion" value="actualizarEstudiante" />
		<input type="hidden" id="txtCodigoEstudiante" name="txtCodigoEstudiante" value="<?php echo $txtCodigoEstudiante; ?>" />
		<input type="hidden" id="cmbCarreraTMando" name="cmbCarreraTMando" value="<?php echo $estudiante->getCarrera()->getCodigoCarrera(); ?>" />
	</p>
	<fieldset>
		<legend>Actualizar Datos Estudiante</legend>
		<br />
		<table width="100%" border="0">
			<tr>
				<td>
					<fieldset>
						<legend>Información</legend>
						<br />
						<table width="100%" border="0">
							<tr>
								<td>Tipo Documento:&nbsp;&nbsp;</td>
								<td><select id="cmbTipoDocumentoAE" name="cmbTipoDocumentoAE" class="campobox" >
									<option value="-1">Seleccione</option>
									<?php foreach ( $tiposDocumentos as $tipoDocumento ) { ?>
										<option <?php if($tipoDocumento->getIniciales( ) == $estudiante->getTipoDocumento( )->getIniciales( ) ) echo "selected=\"selected\""; ?>value="<?php echo $tipoDocumento->getIniciales( ); ?>"><?php echo $tipoDocumento->getDescripcion( ); ?></option>
									<?php } ?>
								</select></td>
								<td>Número de Documento:&nbsp;&nbsp; </td>
								<td><input type="text" id="txtNumeroDocumentoAE" name="txtNumeroDocumentoAE" value="<?php echo $estudiante->getNumeroDocumento( ); ?>" />
									<input type="hidden" id="txtIdEstudianteAE" name="txtIdEstudianteAE" value="<?php echo $estudiante->getIdEstudiante( ); ?>"/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Nombres:&nbsp;&nbsp;</td>
								<td><input type="text" id="txtNombreEstudianteAE" name="txtNombreEstudianteAE"  value="<?php echo $estudiante->getNombreEstudiante( ) ?>"/></td>
								<td>Apellidos:&nbsp;&nbsp;</td>
								<td><input type="text" id="txtApellidoEstudianteAE" name="txtApellidoEstudianteAE" value="<?php echo $estudiante->getApellidoEstudiante( ); ?>" /></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Lugar de Expedición:&nbsp;&nbsp;</td>
								<td><input type="text" id="txtLugarExpedicion" name="txtLugarExpedicion" value="<?php echo $estudiante->getExpedicion( ); ?>" /></td>
								<td>Genero:&nbsp;&nbsp;</td>
								<td><select id="cmbGeneroAE" name="cmbGeneroAE" class="campobox" >
									<option value="-1">Seleccione</option>
									<?php foreach ( $generos as $genero ) { ?>
										<option <?php if($genero->getCodigo( ) == $estudiante->getGenero( )->getCodigo( ) ) echo "selected=\"selected\""; ?>value="<?php echo $genero->getCodigo( ); ?>"><?php echo $genero->getNombre( ); ?></option>
									<?php } ?>
								</select></td>
							</tr>
						</table>
						<br />
					</fieldset>
				</td>
			</tr>
		</table>
		<br />
	</fieldset>
	
	<br />
	  <div align="left">
	  	<a id="btnActualizarEstudiante">Actualizar</a>
	  </div>
	<br />
</form>
<?php }else{
	echo "Ya se han modificado los datos del estudiante";
} ?>