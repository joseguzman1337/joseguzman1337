<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */ 
header ('Content-type: text/html; charset=utf-8');
ini_set('display_errors','On');
error_reporting(E_ALL);
session_start( );

include '../tools/includes.php';


//include '../control/ControlRol.php';
//include '../control/ControlRol.php';
//include '../control/ControlItem.php';
/*include '../control/ControlClienteCorreo.php';*/


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


$persistencia = new Singleton( );
$persistencia->conectar( );

$controlUsuario = new ControlUsuario( $persistencia );

$txtUsuario = $_SESSION["MM_Username"];
$txtClave = $_SESSION["key"]; 	



$txtIdRol = $_SESSION["rol"];


$codigofacultad = $_SESSION['codigofacultad'];
$idCarrera = $_SESSION['codigofacultad'];


$rol = $_SESSION['rol'];
/*MOdified Diego Rivera <riveradiego@unbosque.edu.co>
*Se añaden variables de session de logueo a sala  con el fin de identificar la carrera en la que se encuentra el usuario
se creo variable idCarrera   la cual se añade al  control $controlUsuario->buscar
*Since March 15,2018
*/
if((empty($codigofacultad) && $rol==1) || ($codigofacultad==1 && !empty($idCarrera))){
    $idCarrera = $_SESSION['idCarrera'];
}
if(empty($idCarrera)){
    $idCarrera = $codigofacultad;
}


$usuario = $controlUsuario->buscar( $txtUsuario, $txtClave , $idCarrera );


$persistencia->close( );
if( $usuario->getId( ) != ""){
	$user[ 0 ] = $usuario->getId( );
	$user[ 1 ] = $usuario->getUser( );
	$user[ 2 ] = date("d_m_y h_i_s");
	$user[ 3 ] = $usuario->getRol( )->getId( );
	$user[ 4 ] = $usuario->getCarrera( )->getFacultad( )->getCodigoFacultad( );
	$persistencia->close( );
	$user[ 5 ] = $persistencia->serializar( );
	
	$_SESSION["datoSesion"] = $user;
	/*$datoSesion = array( );
	$_SESSION["datoSesion"] = $usuario->getId( );*/
}else{
	echo "Error usuario o contraseña";
}

if ( isset ( $_SESSION["datoSesion"] ) ){
   header("Location:home.php");
}else 
	header("Location:../../index.php");
?>