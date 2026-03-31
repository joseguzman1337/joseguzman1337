<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 * @since enero  23, 2017
 */ 
 header ('Content-type: text/html; charset=utf-8');
ini_set('display_errors','On');
error_reporting(E_ALL);
session_start( );

include '../tools/includes.php';


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
$txtClave = $_SESSION["key"];  //admintecnologia	




$txtIdRol = $_SESSION["rol"];

	$usuario = $controlUsuario->buscar( $txtUsuario, $txtClave );



$persistencia->close( );
if( $usuario->getId( ) != ""){
	$user[ 0 ] = $usuario->getId( );
	$user[ 1 ] = $usuario->getUser( );
	$user[ 2 ] = date("d_m_y h_i_s");
	$user[ 3 ] = $usuario->getRol( )->getId( );
	$persistencia->close( );
	$user[ 4 ] = $persistencia->serializar( );
	$_SESSION["datoSesion"] = $user;
	
}else{
	echo "Error usuario o contraseña";
}

if ( isset ( $_SESSION["datoSesion"] ) ){
   header("Location:home.php");
}else 
	header("Location:../index.php");
?>