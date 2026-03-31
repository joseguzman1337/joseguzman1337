<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */

ini_set('display_errors','On');

session_start( );


include '../tools/includes.php';

include '../servicio/funciones.php';

//include '../control/ControlRol.php';
include '../control/ControlRender.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlLineaEstrategica.php';
include '../control/ControlPrograma.php';
include '../control/ControlProyecto.php';
include '../control/ControlIndicador.php';
include '../control/ControlMeta.php';
include '../control/ControlTipoIndicador.php';
include '../control/ControlProgramaProyecto.php';
include '../control/ControlActividadMetaSecundaria.php';

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
	$txtCodigoFacultad = $user[4];
	$persistencia = new Singleton( );
	$persistencia = $persistencia->unserializar( $user[ 5 ] );
	$persistencia->conectar( );
}else{
	header("Location:error.php");
}


	$rutaAnexos = "../".$txtCarpeta."/".$txtIdMetaPrincipal."/".$txtIdMetaSecundaria."";	
	$verAnexos = listar_archivos($rutaAnexos);
	
	echo $verAnexos;


?>