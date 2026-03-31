<?php
/**
 * 
 */
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cache_expire',(int)(Configuracion::getDuracionSesion()/60));
ini_set('session.gc_maxlifetime',Configuracion::getDuracionSesion());
ini_set('session.cookie_lifetime',Configuracion::getDuracionSesion());
session_start();

class SessionHandler{
	
	function SessionHandler(){
		die("buuuuuuuuuuuu no se puede instanciar esta clase, son todos metodos de clase");
	}
	
	function guardarUsuario($usuario){
		$_SESSION["Usuario"] = $usuario;
		$_SESSION["Rol_Usuario"] = SessionHandler::calcularRolUsuario($usuario);
	}
	
	function getUsuario(){
		if (empty($_SESSION["Usuario"]))
			return null;
		else
			return $_SESSION["Usuario"];
	}
	
	function getRolUsuario(){
		if (empty($_SESSION["Rol_Usuario"]))
			return ROL__INVITADO;
		else
			return $_SESSION["Rol_Usuario"];
	}
	
	function guardarIdioma($idioma){
		$_SESSION["Idioma"]=$idioma;
		setcookie("IdiomaSitio", $idioma, mktime(0, 0, 0, date("m"), date("d"), date("y") + 10), "/");
		global $IdiomaSitio;
		$IdiomaSitio = $idioma;
	}
	
	
	function getIdioma(){
		if (empty($_SESSION["Idioma"])){
			SessionHandler::guardarIdioma(SessionHandler::calcularIdioma());
		}
		global $IdiomaSitio;
		$IdiomaSitio = $_SESSION["Idioma"];
		return $IdiomaSitio;
	}	
	
	function calcularIdioma(){
		if (!empty($_COOKIE["IdiomaSitio"]))
			return $_COOKIE["IdiomaSitio"];
		
		$browserLanguages = array();
		
		
		if(empty($_SERVER["HTTP_ACCEPT_LANGUAGE"])){
			$browserLocales = array();
		}else{
 			$browserLocales = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
 			$languages = array();
 			
 			//consigo los lenguajes, sin el pais
 			$locales = explode(",", $browserLocales);
 			$browserLocales = array();
 			foreach ($locales as $locale){
   		   		$language = explode("-", $locale);
   		   		$languages[]=$language[0];
   		   	}
   		   	
   		   	foreach ($languages as $language){
   		   		$language = explode(";", $language);
   		   		$browserLocales[]=$language[0];
   		   	}
   		   	
   			$browserLanguages= array_unique($browserLocales);
 		}
 		
 		global $servicesFacade;
		foreach($browserLanguages as $language){
			$idioma = $servicesFacade->getIdiomaDisponible(array("Nombre" => $language));
			if (!empty($idioma))
				return $idioma["Id"];
		}
		
		$defaultLanguage = $servicesFacade->getIdiomaPredeterminado();
		return $defaultLanguage["Id"];
	}

	function calcularRolUsuario($usuario){
		if (empty($usuario))
			return ROL_INVITADO;
		if ($usuario["Personal"])
			return ROL__ADMINISTADOR;
		elseif ($usuario["Bibliotecario"] > 0)
			return ROL__BIBLIOTECARIO;
		else
			return ROL__USUARIO;
	}
	
	function validar_nivel_acceso($rol_requerido){
		$rol_usuario = SessionHandler::getRolUsuario();
		 
		if ($rol_requerido <= $rol_usuario)
			return;
		header("Location: ../sitio_usuario/login_usuario.php");
		
		return;
	}
	
	function borrar_session(){
		session_destroy();
	}
	
	
}

global $IdiomaSitio;
$IdiomaSitio = SessionHandler::getIdioma();
//session_write_close();
?>