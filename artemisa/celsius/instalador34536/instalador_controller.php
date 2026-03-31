<?php
/**
 *
 */
require_once "common_instalador.php";

require_once "../exceptions/DB_Exception.php";
require_once "../exceptions/WS_Exception.php";
require_once "../common/ServicesFacade.php";
require_once "../common/PedidosUtils.php";

if (empty ($_REQUEST["paso_numero"]) || $_REQUEST["paso_numero"] > 8) 
	$paso_numero = 1;
else
	$paso_numero = $_REQUEST["paso_numero"];
call_user_func("paso_".$paso_numero."_submit");

/**
 * Registra el idioma seleccionado
 */
function paso_1_submit() {
	if (!empty ($_REQUEST["idioma"])){
	    
		addCfgValue("idioma", $_REQUEST["idioma"]);
		require "paso_2.php";
	}else
		require "paso_1.php";
}

/**
 * Crea la BDD de celsius NT
 * carga el schema de la BDD de celsiusNT
 */
function paso_2_submit() {
	
	addCfgValue("hostMySQL", $_REQUEST["hostMySQL"]);
	addCfgValue("userRootMySQL", $_REQUEST["userRootMySQL"]);
	addCfgValue("passwordRootMySQL", $_REQUEST["passwordRootMySQL"]);
	addCfgValue("dbnameNT", $_REQUEST["dbnameNT"]);
	addCfgValue("tipo_instalacion", $_REQUEST["tipo_instalacion"]);
	//addCfgValue("idioma", $_REQUEST["idioma"]);
	
	$configuracion = getCfg();
	
	//conecta con la BD
	$link = mysql_connect($configuracion["hostMySQL"],$configuracion["userRootMySQL"],$configuracion["passwordRootMySQL"]);
	if ($link === FALSE){
		$errorMessages[]=COMMON_ERROR_MYSQL_INCORRECTO;
		$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".mysql_errno()."<br/>".COMMON_MENSAJE_ERROR.": ".mysql_error();
		require "paso_2.php";
		return;
	}
	
	//crea la BDD para celsiusNT
	$db = mysql_query("CREATE DATABASE ".$configuracion["dbnameNT"]);
	if ($db === FALSE){
		$errorMessages[]="Se produjo un error al tratar de crear la BD para celsiusNT. Chequee que no exista ya una BD con el nombre'".
					$configuracion["dbnameNT"]."'. ";
		$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".mysql_errno()."<br/>".COMMON_MENSAJE_ERROR.": ".mysql_error();
		require "paso_2.php";
		return;
	}
	
	$successMessages[]="Se creo la BDD para CelsiusNT satisfactoriamente";
	
	$db = mysql_select_db($configuracion["dbnameNT"]);
	if ($db === FALSE){
		$errorMessages[]=COMMON_ERROR_CREAR_BASE."'".$configuracion["dbnameNT"]."'. ";
		$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".mysql_errno()."<br/>".COMMON_MENSAJE_ERROR.": ".mysql_error();
		require "paso_2.php";
		return;
	}
	
	//carga la estructura de la BDD de celsiusNT con algunos datos inciales
	$res = executeSQLFile("sql/celsiusNT_Schema.sql");
	if (is_a($res, "Celsius_Exception")){
		$errorMessages[]=COMMON_MENSAJE_ERRPR_CARGA_SCRIPT."\n";
		if (is_a($res, "DB_Exception"))
			$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".$res->dbError."<br/>".COMMON_MENSAJE_ERROR.": ".$res->dbErrorNo;
		require "paso_2.php";
		return;
	}
	
	$successMessages[]=COMMON_CREO_SATISFACTORIO;
	require "paso_3.php";
}

/**
 * Crea un usuario de mysql para celsius si corresponde
 * Crea parametros.properties.php
 */
function paso_3_submit() {
	if (getCfgValue("tipo_instalacion") == "actualizacion"){
		addCfgValue("dbname16", $_REQUEST["dbname16"]);
	}
	
	addCfgValue("userCelsiusMySQL", $_REQUEST["userCelsiusMySQL"]);
	addCfgValue("passwordCelsiusMySQL", $_REQUEST["passwordCelsiusMySQL"]);
	
	$configuracion = getCfg();
	mysql_connect($configuracion["hostMySQL"],$configuracion["userRootMySQL"],$configuracion["passwordRootMySQL"]);
	
	if ($configuracion["tipo_instalacion"] == "actualizacion"){
		//prueba que la BDD de celsius exista
		$db = mysql_select_db($configuracion["dbname16"]);
		if ($db === FALSE){
			$errorMessages[]=COMMON_MENSAJE_ERROR_SELECCIONAR_BASE."'".$configuracion["dbname16"]."'. ";
			$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".mysql_errno()."<br/>".COMMON_MENSAJE_ERROR.": ".mysql_error();
			require "paso_3.php";
			return;
		}
	}
	mysql_query("SET NAMES 'latin1'");
	mysql_select_db($configuracion["dbnameNT"]);
	/*
	 * solo funciona en mysql 5
	$query = "CREATE USER '".$configuracion["userCelsiusMySQL"]."' IDENTIFIED BY PASSWORD '".$configuracion["passwordCelsiusMySQL"]."'";
	$res = mysql_query($query);
	*/
	
	//crea un usuario para celsius si corresponde. si el usuario ya existe solo le da acceso sobre la bdd de celsiusNT	
	$res = mysql_query("GRANT ALL PRIVILEGES ON ".$configuracion["dbnameNT"].".* TO '".$configuracion["userCelsiusMySQL"]."'@'localhost' IDENTIFIED BY '".$configuracion["passwordCelsiusMySQL"]."'");
	if ($res === FALSE){
		$errorMessages[]=COMMON_MENSAJE_ERROR_USUARIO;
		$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".mysql_errno()."<br/>".COMMON_MENSAJE_ERROR.": ".mysql_error();
		require "paso_3.php";
		return;
	}
	
	$res = mysql_query("GRANT ALL PRIVILEGES ON ".$configuracion["dbname16"].".* TO '".$configuracion["userCelsiusMySQL"]."'@'localhost' IDENTIFIED BY '".$configuracion["passwordCelsiusMySQL"]."'");
	if ($res === FALSE){
		$errorMessages[]=COMMON_MENSAJE_ERROR_PERMISOS;
		$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".mysql_errno()."<br/>".COMMON_MENSAJE_ERROR.": ".mysql_error();
		require "paso_3.php";
		return;
	}
	
	//convierto el password al formato antiguo de mysql asi funciona con las librerias de mysql de php4
	$res = mysql_query("SET PASSWORD FOR '".$configuracion["userCelsiusMySQL"]."'@'localhost' = OLD_PASSWORD('".$configuracion["passwordCelsiusMySQL"]."')");
	if ($res === FALSE){
		$errorMessages[]=COMMON_MENSAJE_ERROR_OLDPASSWORD;
		$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".mysql_errno()."<br/>".COMMON_MENSAJE_ERROR.": ".mysql_error();
		require "paso_3.php";
		return;
	}
	
	$successMessages[]="Se creo el usuario '".$configuracion["userCelsiusMySQL"]."' de mysql para CelsiusNT satisfactoriamente";
		

	//se crea parametros.properties.php
	$res = crearCelsiusConf($configuracion);
	if (is_a($res, "Celsius_Exception")){
		$errorMessages[]=COMMON_MENSAJE_ERROR_ARCHIVO.$res->getMessage();
		require "paso_3.php";
		return;
	}
	
	$successMessages[]=COMMON_MENSAJE_ARCHIVO_SATISFACTORIO;
	require "paso_4.php";
}
function paso_4_submit() {
	
	require "paso_5.php";
}

/**
 * Se carga la tabla parametros de la BDD de celsiusNT
 */
function paso_5_submit() {
	addCfgValue("directorio_upload", $_REQUEST["directorio_upload"]);
	addCfgValue("directorio_temporal", $_REQUEST["directorio_temporal"]);
	addCfgValue("mail_contacto", $_REQUEST["mail_contacto"]);
	addCfgValue("titulo_sitio", $_REQUEST["titulo_sitio"]);
	addCfgValue("url_completa", rtrim($_REQUEST["url_completa"],'/').'/');
	
	if (getCfgValue("tipo_instalacion") != "actualizacion")
		addCfgValue("admin_password", $_REQUEST["admin_password"]);
	
	addCfgValue("id_celsius_local", $_REQUEST["id_celsius_local"]);
	$nt_enabled = (!empty($_REQUEST["nt_enabled"]) && $_REQUEST["nt_enabled"]=="ON");
	addCfgValue("nt_enabled", $nt_enabled);
	if ($nt_enabled){
		addCfgValue("password_directorio", $_REQUEST["password_directorio"]);
		addCfgValue("url_directorio", $_REQUEST["url_directorio"]);
	}
	//se carga la tabla parametros de la BDD de celsiusNT
	$res = guardarParametrosInstancia(getCfg());
	if (is_a($res, "Celsius_Exception")){
		$errorMessages[]=COMMON_MENSAJE_ERROR_PARAMETROS." \n";
		if (is_a($res, "DB_Exception"))
			$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".$res->dbError."<br/>".COMMON_MENSAJE_ERROR.": ".$res->dbErrorNo;
		require "paso_5.php";
		return;
	}
	
	//se modifica la url local en los wsdl
	$res = PedidosUtils::guardarURLLocalEnWSDLs(getCfgValue('url_completa'));
	if (is_a($res, "Celsius_Exception")){
		$errorMessages[]=COMMON_MENSAJE_ERROR_MODIFICARWSDL.".\n";
		if (is_a($res, "DB_Exception"))
			$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".$res->dbError."<br/>".COMMON_MENSAJE_ERROR.": ".$res->dbErrorNo;
		require "paso_5.php";
		return;
	}
	
	$successMessages[] =COMMON_MENSAJE_PARAMETROS_SATISFACTORIO;
	
	if (getCfgValue("tipo_instalacion") != "actualizacion"){ 
		if (!$nt_enabled){
			//carga un PIDU en la BDD. Solo lo hace si nt_enabled = false y si es una instalacion de cero
			$res = executeSQLFile("sql/celsiusNT_datos_iniciales_PIDU.sql");
			if (is_a($res, "Celsius_Exception")){
				$errorMessages[]=COMMON_MENSAJE_ERROR_SCRIPTPIDU."\n";
				if (is_a($res, "DB_Exception"))
					$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".$res->dbError."<br/>".COMMON_MENSAJE_ERROR.": ".$res->dbErrorNo;
				require "paso_5.php";
				return;
			}
		}
	}
	
	//redierecciona en base a si debe o no sincronizar el directorio
	if ($nt_enabled){
		$no_sincronizar = (!empty($_REQUEST["no_sincronizar_con_directorio"]) && $_REQUEST["no_sincronizar_con_directorio"] == "ON");
		addCfgValue("no_sincronizar_con_directorio", $no_sincronizar);
		if ($no_sincronizar)
			require "paso_8.php";
		else
			require "paso_6.php";
	}else{
		require "paso_7.php";
	}
}
function paso_6_submit() {
	//se actualizo el direcotrio. Es NT
	if (getCfgValue("tipo_instalacion") != "actualizacion"){
		$resCreacion = crear_usuario_admin();
			if (is_a($resCreacion, "Celsius_Exception")){
			$errorMessages[]=COMMON_MENSAJE_ERROR_CREARUSUARIO." \n";
			if (is_a($resCreacion, "DB_Exception"))
				$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".$res->dbError."<br/>".COMMON_MENSAJE_ERROR.": ".$res->dbErrorNo;
			//require "paso_8.php";
			//return false;
		}
	}
	require "paso_8.php";
}

function paso_7_submit() {
	//se selecciono el pidu del la instancia actual. no es NT
	addCfgValue("id_pais", $_REQUEST["id_pais"]);
	addCfgValue("id_institucion", $_REQUEST["id_institucion"]);
	addCfgValue("id_dependencia", $_REQUEST["id_dependencia"]);
	addCfgValue("id_unidad", $_REQUEST["id_unidad"]);
	
	//se termina de cargar la tabla parametros de la BDD de celsiusNT
	$res = guardarPIDUInstancia(getCfg());
	if (is_a($res, "Celsius_Exception")){
		$errorMessages[]=COMMON_MENSAJE_ERROR_GUARDARPIDU."\n";
		if (is_a($res, "DB_Exception"))
			$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".$res->dbError."<br/>".COMMON_MENSAJE_ERROR.": ".$res->dbErrorNo;
		require "paso_7.php";
		return;
	}
	
	if (getCfgValue("tipo_instalacion") != "actualizacion"){
		$resCreacion = crear_usuario_admin();
		if (is_a($resCreacion, "Celsius_Exception")){
			$errorMessages[]=COMMON_MENSAJE_ERROR_CREARUSUARIO.". \n";
			if (is_a($resCreacion, "DB_Exception"))
				$errorMessages[]=COMMON_MENSAJE_ERROR_MYSQL.": <br/>".COMMON_NUMERO_ERROR.": ".$res->dbError."<br/>".COMMON_MENSAJE_ERROR.": ".$res->dbErrorNo;
			require "paso_7.php";
			return false;
		}
	}
	require "paso_8.php";
}



//***************************************************************************************/
//*********************** FUNCIONES AUXILIARES ******************************************/
//***************************************************************************************/
function crear_usuario_admin(){
	$servicesFacade = ServicesFacade::getInstance();
	
	$configuracion = $servicesFacade->getConfiguracion();
	
	$usuario["Nombres"] = "admin";
	$usuario["Apellido"] = "admin";
	$usuario["Login"] = "admin";
	$usuario["Password"] = getCfgValue("admin_password");
	$usuario["Fecha_Solicitud"] = $usuario["Fecha_Alta"] = date("Y-m-d H:i:s");
	$usuario["Codigo_Pais"] = $configuracion["id_pais"];
	$usuario["Codigo_Institucion"] = $configuracion["id_institucion"];
	$usuario["Codigo_Dependencia"] = $configuracion["id_dependencia"];
	$usuario["Codigo_Unidad"] = $configuracion["id_unidad"];
	$usuario["Personal"] = 1;
	$usuario["Bibliotecario"] = 1;
	$usuario["Staff"] = 1;
	$usuario["Personal"] = 1;
			
	return $servicesFacade->agregarUsuario($usuario);
	
}

function guardarParametrosInstancia($cfg){
	$parametros = array();
	$parametros["directorio_upload"]=$cfg["directorio_upload"];
	$parametros["directorio_temporal"]=$cfg["directorio_temporal"];
	$parametros["mail_contacto"]=$cfg["mail_contacto"];
	$parametros["titulo_sitio"]=$cfg["titulo_sitio"];
	$parametros["url_completa"]=$cfg["url_completa"];
	$parametros["id_celsius_local"]=$cfg["id_celsius_local"];
	$parametros["nt_enabled"]=$cfg["nt_enabled"];
	
	if ($cfg["nt_enabled"]){
		$parametros["password_directorio"]=$cfg["password_directorio"];
		$parametros["url_directorio"]=$cfg["url_directorio"];
	}
	
	$servicesFacade = ServicesFacade::getInstance();
	return $servicesFacade->modificarParametros($parametros);
}




function guardarPIDUInstancia($cfg){
	$parametros = array();
	if (!empty($cfg["id_pais"])){
		$parametros["id_pais"]=$cfg["id_pais"];
		if (!empty($cfg["id_institucion"])){
			$parametros["id_institucion"]=$cfg["id_institucion"];
			if (!empty($cfg["id_dependencia"])){
				$parametros["id_dependencia"]=$cfg["id_dependencia"];
				if (!empty($cfg["id_unidad"])){
					$parametros["id_unidad"]=$cfg["id_unidad"];
				}
			}
		}
	}
	
	$servicesFacade = ServicesFacade::getInstance();
	return $servicesFacade->modificarParametros($parametros);
}

function crearCelsiusConf($cfg) {

	$conf_filename ="../common/parametros.properties.php";
	if (file_exists($conf_filename))
		$var = @ unlink($conf_filename);
		
		
	$file_contents = '<?
			#datos del servidor de bases de datos
			if (empty($properties))
				$properties=array();
			$properties["DB_Host"] ="'.$cfg['hostMySQL'].'" ;
			$properties["DB_User"] = "'.$cfg['userCelsiusMySQL'].'" ;
			$properties["DB_Password"] = "'.$cfg['passwordCelsiusMySQL'].'";
			$properties["DB_DatabaseName"] = "'.$cfg['dbnameNT'].'" ;
			$properties["DB_Port"] = 3306 ;
			return $properties;
		?>';

	$fh = @ fopen($conf_filename, "a+");
	if ($fh !== false) {
		fputs($fh, $file_contents);
		fclose($fh);
		return true;
	} else {
		$retorno = COMMON_MENSAJE_ERROR_CREAR_ARCHIVOPARAMETROS.' '.
				COMMON_MENSAJE_ERROR_PROPERTIES.":". $php_errormsg." \n". COMMON_MENSAJE_CONTENIDO_ARCHIVO.": <br>";
				
		//$retorno .= "<textarea>";
		//$retorno .= $file_contents;
		//$retorno .= "</textarea>";
		return new File_Exception($retorno);
	}
}


//////////////////////////////////////////////////////////////////////////////////
//////////////////////////// FUNCIONES AUXILIARES //////////////////////////////
////////////////////////////////////////////////////////////////////////////////
/**
 * Copia la erstructura y datos de una base de datos a otra
 * Copia la BDD origen en la destino
 */
function copiarBDD($dbOrigen, $dbDestino){
	$query_bkp= array();
	mysql_select_db($dbOrigen);
	$resultTablas = mysql_query("SHOW TABLES");
	$tablas_16=array();
	while ($rowTabla = mysql_fetch_row($resultTablas)){
		$tableName = strtolower($rowTabla[0]);
		$resCreateTable = mysql_query("SHOW CREATE TABLE $tableName");
		$resCreateTable = mysql_fetch_assoc($resCreateTable);
		$query_bkp []= $resCreateTable["Create Table"] ."\n";
		$query_bkp[]="INSERT INTO $tableName SELECT * FROM $dbOrigen.$tableName;\n\n"; 
	}
	$resultTablas = mysql_query("CREATE DATABASE $dbDestino");
	mysql_select_db($dbDestino);
	foreach($query_bkp as $queryI){
		$res = mysql_query($queryI);
		if ($res === false)
			return new DB_Exception(COMMON_MENSAJE_ERROR_COPIARBASE. $dbOrigen." a". $dbDestino, mysql_error(), mysql_errno());
	}
	return true;
}

/**
 * Ejecuta el archivo indicado por $filename
 */
function executeSQLFile($filename){
	require_once "../utils/import_sql_dump.php";
	return importSQLFile($filename);
}

/**
 * Ejecuta los contenidos del archivo $filename. No sirve para dumps, solo para creacion o modificacion del schema
 * @unused
 */
function executeSimpleSQLFile($filename){
	if (!is_readable($filename)) {
		return new File_Exception(COMMON_MENSAJE_ERROR_NOLEER. '$filename'.COMMON_MENSAJE_ERROR_PERMISOARCHIVOS);
	}
	$fpt = fopen($filename, "rt");
	if (!$fpt) {
		return new File_Exception(COMMON_MENSAJE_ERROR_ACCEDER_ARCHIVO. '$filename');
	}

	$sentence = "";
	while (!feof($fpt)) {
		$line = fgets($fpt);
		if ($line === false)
			break;

		//quita los comentarios
		$posComment = strpos($line, "--");
		if ($posComment !== false) 
			$line = substr($line,0,$posComment);
		
		//divide por ;
		$posSC = strpos($line, ";");
		if ($posSC !== false){
			//solo hasta el ; es parte de la sentencia actual
			$sentence .= substr($line,0,$posSC);
			$line = substr($line, $posSC + 1);
			
			//ejecuta la sentencia armada
			$res = mysql_query($sentence);
			if ($res === false)
				return new DB_Exception(COMMON_MENSAJE_ERROR_EJECUTAR_SCRIPT. $filename,mysql_error(),mysql_errno());
			
			//guarda el resto de la linea leida en la proxima sentencia a ejecutar
			$sentence = $line;
		}else
			$sentence .= $line;
	}
	return true;
}

/**
 * Calcula la interseccion de tablas y columnas de dos BDD.
 * La igualdad de tablas por nombre se hace CaseInsesitive
 */
function intersectarBDD($dbname1, $dbname2){
	mysql_select_db($dbname1);
	
	$resultTablas = mysql_query("SHOW TABLES");
	$tablas_16=array();
	while ($rowTabla = mysql_fetch_row($resultTablas)){
		$tableName = $rowTabla[0];
		
		$tablas_16[$tableName]=array();
		
		$resultInfoTabla = mysql_query("DESCRIBE ".$rowTabla[0]);
		while ($rowColumna = mysql_fetch_assoc($resultInfoTabla)){
			$tablas_16[$tableName][]=$rowColumna["Field"];
		}
	}
	
	mysql_select_db($dbname2);
	
	$resultTablas = mysql_query("SHOW TABLES");
	$tablas_16_nt=array();
	while ($rowTabla = mysql_fetch_row($resultTablas)){
		$tableName = $rowTabla[0];
		$tablas_16_nt[$tableName]=array();
		
		$resultInfoTabla = mysql_query("DESCRIBE ".$rowTabla[0]);
		while ($rowColumna = mysql_fetch_assoc($resultInfoTabla)){
			$tablas_16_nt[$tableName][]=$rowColumna["Field"];
		}
	}
	
	//calculo la interseccion de las tablas
	$tablas_Comunes=array();
	foreach($tablas_16 as $tablaIName => $tablaICols){
		if (!empty($tablas_16_nt[strtolower($tablaIName)])){
			$camposComunes = array_intersect($tablaICols,$tablas_16_nt[strtolower($tablaIName)]);
			if (!empty($camposComunes))
				$tablas_Comunes[$tablaIName] =$camposComunes; 
		}
	}
	return $tablas_Comunes;
}

/**
 * Copia los datos de tablas y columnas comunes entre dos BDD de $dbOrigen a $dbDestino 
 */
function copiarDatosComunesDeA($dbOrigen, $dbDestino){
	$tablas_Comunes = intersectarBDD($dbOrigen, $dbDestino);
	foreach($tablas_Comunes as $tabla_Comun_Name => $tabla_Comun_Cols){
		$query = "INSERT INTO $dbDestino.".strtolower($tabla_Comun_Name)." (".implode(", ",$tabla_Comun_Cols).") " .
				"SELECT ".implode(", ",$tabla_Comun_Cols)." FROM $dbOrigen.$tabla_Comun_Name";
		$res = mysql_query($query);
		if ($res === false)
			return new DB_Exception(COMMON_MENSAJE_ERROR_COPIARDATOS. $dbOrigen." a". $dbDestino." Query:". $query, mysql_error(), mysql_errno());
	}
	return true;
}
?>
