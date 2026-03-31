<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../../templates/template.php");
$db = writeHeaderSearchs();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);

if (!$q) die();

$currentdate  = date("Y-m-d H:i:s");
$query_programa = "SELECT nombre,idsiq_area FROM siq_area WHERE nombre LIKE '%$q%' AND codigoestado='100' ORDER BY nombre ASC";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"];
    $res['value']=$row["nombre"];
    $res['id']=$row["idsiq_area"];
     
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
