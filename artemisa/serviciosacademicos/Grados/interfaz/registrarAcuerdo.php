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
	include '../control/ControlFechaGrado.php';
	include '../control/ControlActaAcuerdo.php';
	
	
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
	$controlActaAcuerdo = new ControlActaAcuerdo( $persistencia );
		
	$txtCodigoEstudiantes = unserialize(stripslashes($txtEstudianteSeleccionados));
?>

<script src="../js/MainRegistrarAcuerdo.js"></script>
	<div id="dvRegistrarAcuerdo">
	<form id="formRegistrarAcuerdo">
		<br />
		<p><input type="hidden" id="txtCodigoFechaGrado" name="txtCodigoFechaGrado" value="<?php echo $txtFechaGrado; ?>" />
			<input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $txtCodigoCarrera; ?>" />
		</p>
		<table width="100%" border="0">
			<tr>
				<td>	
					<fieldset style="width: 50%;">
						<legend>Registrar Acuerdo</legend>
						<table width="100%" border="0">
							<tr>
								<td>Número del Acuerdo</td>
								<td><input type="text" id="txtNumeroAcuerdo" name="txtNumeroAcuerdo" /></td>
							</tr>
							<tr>
								<td>Fecha del Acuerdo</td>
								<td><input type="text" id="fechaAcuerdo" name="fechaAcuerdo" /></td>
							</tr>
							<tr>
								<td>Número del Acta Consejo</td>
								<td><input type="text" id="txtNumeroActaAcuerdo" name="txtNumeroActaAcuerdo" /></td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
			<br />
			<br />
			<table width="100%" id="registroAcuerdo" cellpadding="0" cellspacing="0" class="display compact" >
				<thead>
					<tr >
						<th>No</th>
						<th>Nombre Estudiante</th>
						<th>Número de Identificación</th>
						<th><input type="checkbox" id="selectAllAcu" name="selectAllAcu" checked /></th>
						
					</tr>
				</thead>
				<tbody class="listaRadicaciones">
		<?php
				$i = 1; 
				foreach( $txtCodigoEstudiantes as $txtCodigoEstudiante ){ 
					$estudiante = $controlEstudiante->buscarEstudianteAcuerdo( $txtCodigoEstudiante );
					$actaAcuerdo = $controlActaAcuerdo->buscarActa($txtFechaGrado, $txtCodigoCarrera, $txtCodigoEstudiante);
					$txtIdActa = $actaAcuerdo->getIdActaAcuerdo( );
					
					$txtNombreEstudiante = $estudiante->getNombreEstudiante( )." ".$estudiante->getApellidoEstudiante( );
					
				?>
				<?php if( $estudiante->getIdEstudiante( ) != null ){
					
					?>
				<tr>
					
					<td align="center"><?php echo $i++; ?></td>
					<td ><?php echo $txtNombreEstudiante; ?></td>
					<td align="center"><?php echo $estudiante->getNumeroDocumento( ); ?></td>
					<td align="center"><input type="checkbox" id="ckSeleccionarAcuerdo" name="ckSeleccionarAcuerdo" value="<?php echo $txtIdActa.",".$txtCodigoEstudiante; ?>" />
					</td>
				</tr>
		<?php } 
				}?>
				</tbody>
			</table>
			</br>
			  <div align="left"><a id="btnRegistrarAcuerdo">Guardar</a>
			  </div>
		</form>
	</div>
<div id="mensageAcuerdo" align="center"><br /><br />¿Desea agregar el Acuerdo del Consejo Directivo?</div>