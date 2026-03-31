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
	include '../control/ControlIncentivoAcademico.php';
	
	
	if($_POST){
		$keys_post = array_keys($_POST);
		foreach ($keys_post as $key_post) {
			$$key_post = $_POST[$key_post];
		}
	}
	
	if($_GET){
	    $keys_get = array_keys($_GET); 
	    foreach ($keys_get as $key_get){ 
	        $$key_get = $_GET[$key_get]; 
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
	$controlIncentivoAcademico = new ControlIncentivoAcademico( $persistencia );
	
	$incentivos = $controlIncentivoAcademico->consultarIncentivo( );
		
	$txtCodigoEstudiantes = unserialize(stripslashes($txtEstudianteSeleccionados));
	
	?>
	<script src="../js/MainRegistrarActaAcuerdo.js"></script>
	<div id="dvRegistrarActaAcuerdo">
	<form id="formRegistrarActaAcuerdo">
		<br />
		<p><input type="hidden" id="txtFechaGrado" name="txtFechaGrado" value="<?php echo $txtFechaGrado; ?>" /></p>
		<table width="100%" border="0">
			<tr>
				<td>	
					<fieldset style="width: 50%;">
						<legend>Registrar Acta</legend>
						<table width="100%" border="0">
							<tr>
								<td>Número de Acta</td>
								<td><input type="text" id="txtNumeroActa" name="txtNumeroActa" /></td>
							</tr>
							<tr>
								<td>Fecha de Acta</td>
								<td><input type="text" id="fechaActa" name="fechaActa" /></td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
			<br />
			<br />
			<table width="100%" id="registroActaAcuerdo" cellpadding="0" cellspacing="0" class="display compact" >
				<thead>
					<tr >
						<th>No</th>
						<th>Nombre Estudiante</th>
						<th>Número de Identificación</th>
						<th>Agregar Incentivo</th>
						<th><input type="checkbox" id="selectAll" name="selectAll" checked /></th>
						
					</tr>
				</thead>
				<tbody class="listaRadicaciones">
		<?php
				$i = 1; 
				foreach( $txtCodigoEstudiantes as $txtCodigoEstudiante ){ 
					$estudiante = $controlEstudiante->buscarEstudiante( $txtCodigoEstudiante );
					
					$txtNombreEstudiante = $estudiante->getNombreEstudiante( )." ".$estudiante->getApellidoEstudiante( );
				?>
				<tr>
					<td align="center"><?php echo $i++; ?></td>
					<td ><?php echo $txtNombreEstudiante; ?></td>
					<td align="center"><?php echo $estudiante->getNumeroDocumento( ); ?></td>
					<td align="center"><img src="../css/images/vcard_edit.png" id="imgIncentivo" width="15" height="15" onClick="capturarEstudiante( '<?php echo $txtCodigoEstudiante; ?>','<?php echo $txtNombreEstudiante; ?>' )" style="cursor:pointer;" /></td>
					<!--<td align="center"><?php echo "Incentivo"; ?></td>-->
					<td align="center"><input type="checkbox" id="ckSeleccionar" name="ckSeleccionar" value="<?php echo $txtCodigoEstudiante; ?>" /></td>
				</tr>
		<?php } ?>
				</tbody>
			</table>
			</br>
			  <div align="left"><a id="btnRegistrarActaAcuerdo">Guardar</a>
			  </div>
		</form>
	</div>
	
	<div id="dvRegistrarIncentivo" style="display: none;">
		<form id="formRegistrarIncentivo">
			<br />
			<p><input type="hidden" id="txtEstudiante" name="txtEstudiante" /></p>
			<h3><span id="txtNombreEstudiante"></span></h3>
			<table width="80%" border="0">
				<tr>
					<td>
						<fieldset>
							<legend>Registrar Incentivo Académico</legend>
							<table width="100%" border="0">
								<tr>
									<td>Tipo Incentivo</td>
									<td>
										<?php
											foreach ($incentivos as $incentivo ) { ?>
											<input type="checkbox" id="ckIncentivo" name="ckIncentivo" value="<?php echo $incentivo->getIdIncentivo( ); ?>" />
											<label for="ckIncentivo"><?php echo $incentivo->getNombreIncentivo( ); ?></label><br />	
										<?php	}
										 ?>
									</td>
								</tr>
								<tr>
									<td>Observación</td>
									<td><textarea id="txtObservacion" name="txtObservacion" rows="4" cols="40"></textarea></td>
								</tr>
							</table>
						</fieldset>
					</td>
				</tr>
			</table>
			</br>
			  <div align="left"><a id="btnRegistrarIncentivo">Guardar</a>
			  </div>
		</form>
	</div>
<div id="mensageActaAcuerdo" align="center">¿Desea agregar el Acta del Consejo de Facultad?</div>