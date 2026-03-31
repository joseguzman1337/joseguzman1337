<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../templates/template.php");
$db = getBD();

$q = strtolower($_REQUEST["categoria"]);
$tipo = strtolower($_REQUEST["tipo"]);
//var_dump($_REQUEST);

if (!$q) die();

$query_programa = "SELECT nombre, alias, idsiq_data FROM siq_data  
    WHERE categoria='".$q."' AND tipo_data='".$tipo."' AND codigoestado='100' ORDER BY nombre ASC";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"];
    $res['value']=$row["idsiq_data"].";".$row["alias"];
    
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
