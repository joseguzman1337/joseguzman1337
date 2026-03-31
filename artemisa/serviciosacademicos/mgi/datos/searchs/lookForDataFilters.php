<?php
/****
 * Look for users base on name and last_name  
 ****/
require_once("../templates/template.php");
$db = getBD();

$utils = new Utils_datos();
if(isset($_REQUEST["alias"])){
    $sql = "SELECT * FROM siq_data WHERE alias = '".$_REQUEST["alias"]."' AND codigoestado='100' ";
    $data = $db->GetRow($sql);
} else {
    $data = $utils->getDataEntity("data",$_REQUEST["id"]);
}
$cat = $utils->getDataEntity("categoriaData",$data["categoria"]);
if($data["tipo_data"]==1){
    include("../datos/".$cat["alias"]."/filtrosClass.php");
    $filters = new filtrosClass();
} else {
    include("../informacion/".$cat["alias"]."/filtrosInfoClass.php");
    $filters = new filtrosInfoClass();
}


$filtros = array();
$metodo = 'getFiltros'.ucfirst($data["alias"]);
if(method_exists($filters,$metodo)){
    $filtros = $filters->$metodo();
}

$users = array();
forEach($filtros as $key => $value)
{    
    $res['label']=$value;
    $res['value']=$key;
    
    array_push($users,$res);
}

// return the array as json
echo json_encode($users);
?>
