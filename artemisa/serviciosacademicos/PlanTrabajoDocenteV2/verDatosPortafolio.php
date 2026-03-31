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

session_start();
//var_dump($db);

include "funciones.php";


if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

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



$idDocente = $_GET["idDocente"];

$idPrograma = $_GET["idPrograma"];

$idPeriodo = $_GET["idPeriodo"];

$idVocaciones = $_GET["idVocacion"];

$id_Vocaciones = explode("|", $idVocaciones);
$id_Vocaciones = array_merge(array_unique( $id_Vocaciones ));
$id_Vocaciones = orderMultiDimensionalArray($id_Vocaciones);

?>
<h3 style="margin-top:30px;margin-bottom:0; margin-left: 50px; font-weight: normal; font-family: Lucida Grande,Lucida Sans Unicode,Lucida Sans,Geneva,Verdana,sans-serif;">Los siguientes son los documentos asociados como evidencia a las actividades académicas</h3>

<?php foreach( $id_Vocaciones as $idVocacion ){

$rutaDocumentoDecano = "documentos/".$idDocente."/".$idPeriodo."/".$idPrograma."/".$idVocacion."";


$archivoDecanos = recorre_arbol($rutaDocumentoDecano, $db, $idVocacion);


echo $archivoDecanos;
}
?>
