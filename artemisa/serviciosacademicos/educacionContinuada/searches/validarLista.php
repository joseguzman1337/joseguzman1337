<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$q = strtolower($_REQUEST["grupo"]);
//var_dump($_REQUEST);

if (!$q) die();

//var_dump($q);
$sacarListaSql="select idlistaAsistenciaGrupo from listaAsistenciaGrupo where idGrupo='".$_REQUEST["grupo"]."' and fechaLista='".$_REQUEST["fecha"]."' AND codigoestado='100'";
$sacarListaSqlRow = $db->GetRow($sacarListaSql);
	
if($sacarListaSqlRow!=NULL && count($sacarListaSqlRow)>0){
		$registrado = true;
} else {
	$registrado = false;
}

//var_dump($existe);
// return the array as json
echo json_encode(array("registrado"=>$registrado));
?>
