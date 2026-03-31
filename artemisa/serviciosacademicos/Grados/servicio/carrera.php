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

$controlCarrera = new ControlCarrera( $persistencia );



switch ($tipoOperacion) {
	
	case 'listaCarreras':
	if ( $lrol != 3 && $lrol != 93 ) {
		$carreras = $controlCarrera->consultar( $cmbFacultad );
	} else {
		$carreras = $controlCarrera->consultarCarreraUsuario( $idPersona, $cmbFacultad );
	}
	/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
	*Se añaden dos opciones con el fin de cargar fechas de grado a todos los programas  de pregrados o posgrados al tiempo 
	*Since July 25 ,2017 
	*/
	echo "<option value=\"-1\">Seleccione</option>
		  <option value=\"pregrados\">TODOS LOS PROGRAMAS DE PREGRADO</option>
		  <option value=\"posgrados\">TODOS LOS PROGRAMAS DE POSGRADO</option>";
	
	foreach( $carreras as $carrera )
		echo "<option value=\"" . $carrera->getCodigoCarrera( ) . "\">" . $carrera->getNombreCarrera( ) . "</option>";	
		
	break;
}

?>