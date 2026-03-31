<?php
require_once('../common/Configuracion.php');
require_once('../utils/StringUtils.php');

require "common_instalador.php";



$cfn=Configuracion::getInstance();


/**
 *  Variables de configuracion necesaria para poder avanzar en el proceso de instalacion
 *  
 *  upload_max_filesize - Tamaños maximo de archivo para poder subir a CELSIUS    >= 12M 
 *  post_max_filesize - Tamaño maximo de archivo por POST para poder subir CELSIUS  >= 12M
 *  memory_limit - Tamaño minimo de mamoria  >= 48 M
 *   
 * 
 *  La siguientes carpetas deber tener permiso de escritura.
 *  /common
 *  /soap-celsius
 *  /soap-directorio
 * 
 * 
 */







/*
 * Posibles directorios a verificar permisos de Escrituras
 * 
 * $wsdl_filename_celsius - /soap-celsius/celsius-celsius.wsdl
 * $wsdl_filename_directorio - /soap-directorio/celsius-directorio.wsdl
 * $directory_common - /common/
 */
 
 
$wsdl_filename_celsius = realpath(dirname(__FILE__).'/../').'/soap-celsius/celsius-celsius.wsdl';
$wsdl_filename_directorio = realpath(dirname(__FILE__).'/../').'/soap-directorio/celsius-directorio.wsdl';
$directory_common=realpath(dirname(__FILE__).'/../').'/common/';	

$mensajes=array();
$condicion_booleana_permiso=true;
if (!is_writable($directory_common)){
   $mensajes['directory_common']='<div class="error">'.PASO0_ERROR_ESCRITURA.$directory_common.PAS_ERROR_ESCRITURA1.'</div>';	
   $condicion_booleana_permiso=false;
}

if (!is_writable($wsdl_filename_celsius)){
	$mensajes['directory_wsdl_celsius']='<div class="error">'.PASO0_ERROR_ESCRITURA.$wsdl_filename_celsius.PAS_ERROR_ESCRITURA1.'</div>';
    $condicion_booleana_permiso=false;
}
if (!is_writable($wsdl_filename_directorio)){
	$mensajes['directory_wsdl_directorio']='<div class="error">'.PASO0_ERROR_ESCRITURA.$wsdl_filename_directorio.PAS_ERROR_ESCRITURA1.'</div>';
    $condicion_booleana_permiso=false;
} 


$maxUploadArchive=ini_get('upload_max_filesize');
$maxPOSTArchive=ini_get('post_max_size');

$memoryLimit=ini_get('memory_limit');

$maxUploadArchiveValue=StringUtils::convert_AbbrNotation_to_AbbrNotation($maxUploadArchive, 'm');
if ($cfn->getMaxFilesizeUpload()>=$maxUploadArchiveValue){
	$mensajes['upload_max_filesize']='<div class="error">Warning:'.PASO0_WARNING_VARIABLE.' upload_max_filesize'.PASO0_WARNING_VARIABLE1.' '.$maxUploadArchiveValue.PASO0_WARNING_VARIABLE2.' =12M</div>';
    
}
$maxPostArchiveValue=StringUtils::convert_AbbrNotation_to_AbbrNotation($maxPOSTArchive, 'm');
if ($cfn->getMaxFilesizePOST()>=$maxPostArchiveValue){
	$mensajes['post_max_filesize']='<div class="error">Warning: '.PASO0_WARNING_VARIABLE.'  post_max_filesize'.PASO0_WARNING_VARIABLE1.' '.$maxPostArchiveValue.PASO0_WARNING_VARIABLE2.'=12M</div>';
    
}
$maxMemoryLimitValue=StringUtils::convert_AbbrNotation_to_AbbrNotation($memoryLimit, 'm');
if ($cfn->getMemoryLimit()>=$maxMemoryLimitValue){
	$mensajes['memory_limit']='<div class="error">Warning: '.PASO0_WARNING_VARIABLE.' memory_limit'.PASO0_WARNING_VARIABLE1.' '.$maxMemoryLimitValue.PASO0_WARNING_VARIABLE2.' =48M</div>';
    
}

if (!empty($mensajes)){
	require "top_layout_install.php";?>
	Instalador de Celsius NT
	<br>
	<br>	
<?
	foreach ($mensajes as $mensaje){
		echo $mensaje;
		echo "<br>";
	}
	if ($condicion_booleana_permiso){?>
		  <br>
		  <INPUT TYPE="button" onclick="forward();" value="<?=PASO0_BUTTON_CONTINUAR?>">
		  <br>
		  <br>
		  
	<?} 
	require "base_layout_install.php";
}else{
	header("Location:instalador_controller.php");
}

?>
 <SCRIPT LANGUAGE="JavaScript">
 function forward(){
 	document.location.href="instalador_controller.php";
 }
 </SCRIPT>
