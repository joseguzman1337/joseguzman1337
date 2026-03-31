<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);

if (!$q) die();

//var_dump($q);
$fechahoy=date("Y-m-d H:i:s"); 
            

$query_programa = "SELECT codigocarrera, nombrecarrera FROM carrera WHERE nombrecarrera LIKE '%$q%' AND codigomodalidadacademica=400 AND 
	codigomodalidadacademicasic=400 AND fechainiciocarrera < '".$fechahoy."' AND fechavencimientocarrera > '".$fechahoy."' ORDER BY nombrecarrera ASC";
//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombrecarrera"];
    $res['value']=$row["nombrecarrera"];
    $res['id']=$row["codigocarrera"];
    //$res['idFactor']=$row["idFactor"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
