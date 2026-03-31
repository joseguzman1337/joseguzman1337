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
	
	$controlDocumentacion = new ControlDocumentacion( $persistencia );
	
	$documentos = $controlDocumentacion->consultarDocPendiente($txtCodigoCarrera, $txtCodigoEstudiante);
	
	
	
?>
<p>Los siguientes documentos son los que tiene pendientes por entregar el estudiante: </p>
<?php 
	if(count($documentos) != 0 ){
		foreach( $documentos as $documento ){ ?>
		
		<span><b><?php echo $documento->getNombreDocumentacion( ); ?></b></span><br />
		<?php } 
		}else{ ?>
			<p><b>El estudiante se encuentra al día con los documentos de la universidad</b></p>
		<?php }?>