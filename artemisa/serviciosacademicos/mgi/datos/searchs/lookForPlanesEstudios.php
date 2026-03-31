<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../templates/template.php");
$db = getBD();

$q = strtolower($_REQUEST["carrera"]);
//var_dump($_REQUEST);

if (!$q) die();

$currentdate  = date("Y-m-d H:i:s");
$query_programa = "SELECT idplanestudio,nombreplanestudio FROM planestudio WHERE codigocarrera='".$q."' AND fechavencimientoplanestudio>'".$currentdate."' AND codigoestadoplanestudio=100 ORDER BY nombreplanestudio ASC";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombreplanestudio"];
    $res['value']=$row["idplanestudio"];
    
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
