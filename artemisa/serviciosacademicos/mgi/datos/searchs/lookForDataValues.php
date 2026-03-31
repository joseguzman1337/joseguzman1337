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

$filtros = $utils->getDataValue($db,$data,$cat);

$users = array();
$num = count($filtros);
for ($i = 0; $i < $num; $i++) 
{    
    $res['label']=$filtros[$i]["label"];
    //en cero siempre debe estar el id
    $res['value']=$filtros[$i]["value"];
    
    array_push($users,$res);
}

// return the array as json
echo json_encode($users);
?>
