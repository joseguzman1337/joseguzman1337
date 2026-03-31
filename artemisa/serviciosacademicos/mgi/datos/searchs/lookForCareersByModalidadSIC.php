<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../templates/template.php");
$db = getBD();

$q = strtolower($_REQUEST["modalidad"]);
//var_dump($_REQUEST);

if (!$q) die();

$currentdate  = date("Y-m-d H:i:s");
$query_programa = "SELECT codigocarrera,nombrecarrera FROM carrera WHERE codigomodalidadacademicasic='".$q."' AND fechavencimientocarrera>'".$currentdate."' ORDER BY nombrecarrera ASC";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombrecarrera"];
    $res['value']=$row["codigocarrera"];
    
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
