
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

	switch( $tipoOperacion ){ 
		
		case "anularActa": ?>
				<script src="../js/MainAnularActa.js"></script>
				<p align="justify">Por favor seleccione al estudiante al cuál desea anularle el Acta: </p>
				<p><input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $txtCodigoCarrera; ?>" /></p>
				<table width="100%" id="TablaAnularActa" cellpadding="0" cellspacing="0" class="display">
					<thead>
					<tr >
						<th>No</th>
						<th>Nombre Estudiante</th>
						<th><input type="checkbox" id="selectAllActa" name="selectAllActa" checked /></th>
						
					</tr>
				</thead>
				<tbody class="listaRadicaciones">
					<?php
						$detalleActaAcuerdos = $controlActaAcuerdo->consultarEstudianteActa( $txtFechaGrado );
						$i = 1; 
						foreach( $detalleActaAcuerdos as $detalleActaAcuerdo ){
								$txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante( )->getCodigoEstudiante( );
								$txtIdDetalleActa = $detalleActaAcuerdo->getIdDetalleActaAcuerdo( ); 
							 ?>
							<tr>
								<td align="center"><?php echo $i++; ?></td>
								<td ><?php echo $detalleActaAcuerdo->getEstudiante( )->getNombreEstudiante( ); ?></td>
								<td align="center"><input type="checkbox" id="ckAnularActa" name="ckAnularActa" value="<?php echo $txtIdDetalleActa; ?>" />
									<!--<input type="text" id="txtCodigoEstudiante" name="txtCodigoEstudiante" class="txtCodigoEstudiante" value="<?php echo $txtCodigoEstudiante; ?>" />-->
								</td>
							</tr>
					<?php }					
					?>
				</tbody>
				</table>
				</br>
				  <div align="left"><a id="btnEstudianteAnularActa">Anular</a>
				  </div>
				<div id="mensageAnularActa" align="center"><br /><br />¿Desea anular el Acta del Consejo de Facultad?</div>
		<?php break;
		
		case "anularAcuerdo": ?>
				<script src="../js/MainAnularAcuerdo.js"></script>
				<p align="justify">Por favor seleccione al estudiante al cuál desea anularle el Acuerdo: </p>
				<p><input type="hidden" id="txtCodigoCarreraAcuerdo" name="txtCodigoCarreraAcuerdo" value="<?php echo $txtCodigoCarrera; ?>" /></p>
				<table width="100%" id="TablaAnularAcuerdo" cellpadding="0" cellspacing="0" class="display">
					<thead>
					<tr >
						<th>No</th>
						<th>Nombre Estudiante</th>
						<th><input type="checkbox" id="selectAllAcuerdo" name="selectAllAcuerdo" checked /></th>
						
					</tr>
				</thead>
				<tbody class="listaRadicaciones">
					<?php
						$detalleActaAcuerdos = $controlActaAcuerdo->consultarEstudianteAcuerdo( $txtFechaGrado );
						$i = 1; 
						foreach( $detalleActaAcuerdos as $detalleActaAcuerdo ){
								$txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante( )->getCodigoEstudiante( );
								$txtIdDetalleActa = $detalleActaAcuerdo->getIdDetalleActaAcuerdo( ); 
							 ?>
							<tr>
								<td align="center"><?php echo $i++; ?></td>
								<td ><?php echo $detalleActaAcuerdo->getEstudiante( )->getNombreEstudiante( ); ?></td>
								<td align="center"><input type="checkbox" id="ckAnularAcuerdo" name="ckAnularAcuerdo" value="<?php echo $txtIdDetalleActa; ?>" />
									<!--<input type="text" id="txtCodigoEstudiante" name="txtCodigoEstudiante" class="txtCodigoEstudiante" value="<?php echo $txtCodigoEstudiante; ?>" />-->
								</td>
							</tr>
					<?php }					
					?>
				</tbody>
				</table>
				</br>
				  <div align="left"><a id="btnEstudianteAnularAcuerdo">Anular</a>
				  </div>
				<div id="mensageAnularAcuerdo" align="center"><br /><br />¿Desea anular el Acuerdo del Consejo de Directivo a los estudiantes seleccionados?</div>
		<?php break;
		
	}
	
?>