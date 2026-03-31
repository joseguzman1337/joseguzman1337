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
	
	$controlRegistroGrado = new ControlRegistroGrado( $persistencia );
	
	$observaciones = $controlRegistroGrado->consultarObservaciones( $txtIdRegistroGrado );
	
?>
<script src="../js/MainHistorico.js"></script>
<div style=" overflow: auto; width: 100%; top: 0px; height: 232px">
<?php if( count( $observaciones ) != 0 ){
	$i = 0;
	?>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="observacion">
    <thead>
        <tr class="ui-widget-header ">
        	<th>No.</th>
			<th >Registro</th>
			<th >Numero Diploma</th>
			<th >Observación</th>
			<!--<th >PDF</th>-->
		</tr>			
    </thead>
    <tbody>
		<?php foreach ($observaciones as $observacion ) { ?> 
					<td><?php echo $i++;?></td> 	
		            <td><?php echo $observacion->getRegistroGrado( )->getIdRegistroGrado( );?></td>
		            <td><?php echo $observacion->getNumeroDiplomaAnterior( );?></td>
		            <td><?php echo $observacion->getObservacionDiploma( );?></td>
		       </tr>
		<?php } ?>  	
    </tbody>
</table>
<?php }else{ ?>
	<p align="center">No existen Observaciones a este Registro</p>
<?php } ?>
</div>