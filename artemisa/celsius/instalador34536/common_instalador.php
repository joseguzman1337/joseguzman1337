<?
ini_set('session.use_cookies', 1);
session_start();

$errorMessages= array();
$successMessages = array();

if (!defined("instalador")){
	define("instalador",TRUE);
	define("ERROR_DB", 1);
	
	function getCfg(){
		
		if (empty($_SESSION["Configuracion"])){
			
			$defaultCFG = array();
			$defaultCFG["hostMySQL"]="localhost";
			$defaultCFG["userRootMySQL"]="root";
			$defaultCFG["passwordRootMySQL"]="";
			$defaultCFG["dbnameNT"]="celsiusNT";
			$defaultCFG["tipo_instalacion"]="instalacion";
			$defaultCFG["dbname16"]="celsius";
			$defaultCFG["idioma"]="es";
			
			$defaultCFG["userCelsiusMySQL"]="celsiusNT";
			$defaultCFG["passwordCelsiusMySQL"]="root";
			$defaultCFG["directorio_upload"]="C:/uploads";
			$defaultCFG["directorio_temporal"]="C:/windows/temp";
			$defaultCFG["mail_contacto"]="contacto@micelsius.com";
			$defaultCFG["titulo_sitio"]="CelsiusNT";
			$defaultCFG["url_completa"]="http://www.micelsius.com/celsius";
			$defaultCFG["id_celsius_local"]="";
			$defaultCFG["nt_enabled"]=true;
			$defaultCFG["password_directorio"]="";
			$defaultCFG["url_directorio"]="http://directorio.prebi.unlp.edu.ar";
			$defaultCFG["no_sincronizar_con_directorio"]=false;
			$defaultCFG["id_pais"]=0;
			$defaultCFG["id_institucion"]=0;
			$defaultCFG["id_dependencia"]=0;
			$defaultCFG["id_unidad"]=0;
			
			$_SESSION["Configuracion"] = $defaultCFG;
		}
		return $_SESSION["Configuracion"];
	}
	
	function setCfg($cfg = array()){
		$_SESSION["Configuracion"] = $cfg;
	}
	
	function addCfgValue($field_name, $value){
		$cfg = getCfg();
		$_SESSION["Configuracion"][$field_name] = $value;
		
	}
	
	function getCfgValue($field_name){
		$cfg = getCfg();
		
		return $cfg[$field_name];
	}
	

}
$idioma = getCfgValue('idioma');

if (empty($idioma) || !file_exists("idiomas/idioma_$idioma.php"))
	$idioma = 'es';

require_once "idiomas/idioma_$idioma.php";
?>