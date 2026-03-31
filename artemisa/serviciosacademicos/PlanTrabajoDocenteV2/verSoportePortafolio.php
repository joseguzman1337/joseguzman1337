<?php

/*include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/


header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors','On');
session_start();


include "funciones.php";
//var_dump($db);
/*if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}*/

if($_POST){ 
    $keys_post = array_keys($_POST); 
    foreach ($keys_post as $key_post){ 
      $$key_post = $_POST[$key_post] ; 
     } 
 }

 if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = $_GET[$key_get]; 
     } 
 }
 
 
$idDocente = $_GET["id_Docente"];
$idPrograma = $_GET["txtIdCarrera"];
$idPeriodo = $_GET["idPeriodo"];

$txtIdMateria = $_GET["txtIdMateria"];
$txtIdVocacion = $_GET["txtIdVocacion"];
//echo "<pre>";print_r($txtIdMateria);

$ruta = "documentos/".$idDocente."/".$idPeriodo."/".$idPrograma."/".$txtIdVocacion."/".$txtIdMateria."";

//echo $ruta;

$archivos = listar_archivos($ruta);

echo $archivos;
?>
					


