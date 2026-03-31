<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();

//require_once("crearlistacorreo.php");
include_once "google/examples/templates/base.php";
ini_set('max_execution_time', '216000');

set_include_path(realpath(dirname(__FILE__))."/google/src/".PATH_SEPARATOR);
require_once 'Google/Client.php';
require_once 'Google/Service/Directory.php';
require_once 'Google/Service/Groupssettings.php';

function crearUsuarioGoogle($usuario,$apellidosEst,$nombresEst,$clave){
     echo "se va a crear ".$usuario;
		# CONEXION A GOOGLE
		
		$client_id = '950142759358-9uqnqkts3fk6e74d7bl42r3ksgfoqtqi.apps.googleusercontent.com';
		$service_account_name = '950142759358-9uqnqkts3fk6e74d7bl42r3ksgfoqtqi@developer.gserviceaccount.com';
		$key_file_location = realpath(dirname(__FILE__)).'/google-privatekey.p12';
		
		$client = new Google_Client();
		$client->setApplicationName("Creacion de Correos U. El Bosque");
		$service = new Google_Service_Directory($client);    
		
		unset($_SESSION['service_token']); 
		if (isset($_SESSION['service_token'])) {
		  $client->setAccessToken($_SESSION['service_token']);
		}
		$key = file_get_contents($key_file_location);
		$cred = new Google_Auth_AssertionCredentials(
		$service_account_name,
		array('https://www.googleapis.com/auth/admin.directory.group', 'https://www.googleapis.com/auth/admin.directory.group.member',
			  'https://www.googleapis.com/auth/apps.groups.settings','https://www.googleapis.com/auth/admin.directory.user'),
		$key
		);
		$cred->sub = "administradorcorreo@unbosque.edu.co";
		$client->setAssertionCredentials($cred);
		if($client->getAuth()->isAccessTokenExpired()) {
		  $client->getAuth()->refreshTokenWithAssertion($cred);
		}
		$_SESSION['service_token'] = $client->getAccessToken();
		
		#VERIFICAR SI EL USUARIO EXISTE
	//if($_GET["clavemd5"]==md5(CLAVECONEXIONGOOGLE)){
	if(!existeUsuario($usuario,$service)){
		echo "CREANDO";//exit();
		$creado=true;
		$i=0;      
		
		
		do{
		
		$i++;	
		if($i>10){
		echo "<b><font color='red'>ERROR:</font></b> El usuario <b>".$usuario."</b> no se pudo crear en <b>GOOGLE APPS</b>, contáctese con el area de tecnología.<br>";
		break;
		}
		
		
		try{
		
			echo "<br>CREANDO usuario=".$usuario."<br>";	    
			
			$apellidos=str_replace("_"," ",trim($apellidosEst));
			$nombres=str_replace("_"," ",trim($nombresEst));
			$password=trim($clave);
			$emailEstudiante=trim($usuario);
			$emailEstudiante=$emailEstudiante."@unbosque.edu.co";

			$body2 = new Google_Service_Directory_UserName();
			$body2->setFamilyName($apellidos);
			$body2->setGivenName($nombres);
			$body = new Google_Service_Directory_User();
			$body->setName($body2);
			$body->setPassword($password);
			$body->setPrimaryEmail($emailEstudiante);
		
			$results = $service->users->insert($body);

			$creado=false;
			
			echo "Creado usuario ".$usuario." - ".$nombres." - ".$apellidos;	
		}
		catch(Google_Service_Exception $miExcepcion) {
			echo "Intento fallido ".$i." usuario=".$usuario;
			//echo '<br>Caught exception: ',  $error->getMessage(), "<br>";
			$creado=true;
		}
		
		}while($creado);
		
	}    
	else{
		echo "Ya se encontraba creado en google apps";
	}
}

function existeUsuario($usuario,$service){
	$yaExiste = false;
	try{
	  $email = $usuario."@unbosque.edu.co";
		$r = $service->users->get($email);
		if($r) {
			$yaExiste = true;
			 echo "<br/>Ya existe. Name: ".$r->name->fullName."<br/>";
			 //echo "Suspended?: ".(($r->suspended === true) ? 'Yes' : 'No')."<br/>";
			 //echo "Org/Unit/Path: ".$r->orgUnitPath."<br/>";
		} else {
			 echo "User does not exist: $email<br/>";
			 // if the user doesn't exist, it's safe to create the new user
		}
	} catch(Google_Service_Exception $e) {
		if($e->getCode()==404){			
			echo "el usuario no existe ";
			 // if the user doesn't exist, it's safe to create the new user
		} else {
			echo "Ocurrio un error ".$e->getCode()." ".$e->getMessage();
		}
	}
	return $yaExiste;
}

?>