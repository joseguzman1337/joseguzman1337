<?php
 /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package servicio
 */

header ('Content-type: text/html; charset=utf-8');
ini_set('display_errors','On');
session_start( );

include '../tools/includes.php';
include '../control/ControlCarrera.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoDocumento.php';
include '../control/ControlContacto.php';
include '../control/ControlDirectivo.php';
include '../control/ControlRegistroGrado.php';

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


switch( $tipoOperacion ){
	case 'buscar':
			$controlContacto =  new ControlContacto( $persistencia );
			$controlRegistroGrado = new ControlRegistroGrado( $persistencia );
			$contacto = $controlContacto->buscarDocumento( $txtNumeroDocumento, $txtCodigoCarrera );
			$txtCodigoEstudiante = $contacto->getId( );
			$registroGrado = $controlRegistroGrado->existeRegistroGrado( $txtCodigoEstudiante );
			//echo count($registroGrado->getIdRegistroGrado( ));
			if( count( $registroGrado->getIdRegistroGrado( ) ) != 0 ){
				$cadena = "txtIdEstudiante=" . $contacto->getId( ) .
						"&txtNombreEstudiante=" . $contacto->getNombres( ) .
						"&txtApellidoEstudiante=" . $contacto->getApellidos( ) .
						"&cmbTipoDocumento=";
						
				if ( $contacto->getTipoDocumento( ) != null )
					$cadena .= $contacto->getTipoDocumento( )->getIniciales( );
				echo $cadena;
			}
			
		break;
	
	case 'listaUsuarios':
		if( $txtNombres != ""){
		$controlDirectivo =  new ControlDirectivo( $persistencia );
		$directivos = $controlDirectivo->consultarDirectivo( $txtNombres );
		//echo "<pre>";print_r($contactos);
		?>
		<style type="text/css">
			@import url("../css/estilo.css");
		</style>
		<?php if(!empty($directivos)) { ?>
		<ul id="listUsuarios">
		<?php
			foreach( $directivos as $directivo ){
			 ?>
			<li onClick="selectUser('<?php echo strtoupper($directivo->getNombreDirectivo( )." ".$directivo->getApellidoDirectivo( )); ?>');selectId('<?php echo $directivo->getIdDirectivo( ); ?>');"><?php echo strtoupper($directivo->getNombreDirectivo( )." ".$directivo->getApellidoDirectivo( )." - ".$directivo->getCargoDirectivo( )); ?></li>
		<?php } ?>
		</ul>
		
		<?php 	
		} }
		break;
}
?>