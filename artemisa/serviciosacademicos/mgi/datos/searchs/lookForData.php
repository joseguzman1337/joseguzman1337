<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../templates/template.php");
$db = getBD();

$q = strtolower($_REQUEST["data"]);
$infoOnly = strtolower($_REQUEST["infoOnly"]);

$infoOnly = ($infoOnly === '1');


if (!$q) die();

if(!$infoOnly){
    $query_programa = "SELECT nombre, alias, idsiq_data FROM siq_data  
        WHERE nombre LIKE '%".$q."%' AND codigoestado='100' ORDER BY nombre ASC";
} else {
    $query_programa = "SELECT nombre, alias, idsiq_data FROM siq_data  
        WHERE nombre LIKE '%".$q."%' AND codigoestado='100' AND tipo_data='2' ORDER BY nombre ASC";    
}

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"];
    $res['value']=$row["nombre"];
    $res['id']=$row["idsiq_data"];
    $res['filtro']=$row["alias"];
    
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
