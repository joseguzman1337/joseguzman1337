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
            

$query_programa = "SELECT idciudad, nombreciudad FROM ciudad WHERE nombreciudad LIKE '%$q%' OR nombrecortociudad LIKE '%$q%' AND codigoestado=100 
    ORDER BY nombreciudad ASC";
//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombreciudad"];
    $res['value']=$row["nombreciudad"];
    $res['id']=$row["idciudad"];
    //$res['idFactor']=$row["idFactor"];
    array_push($users,$res);
   
}

if(count($users)<3){
    $res['label']="Crear nueva ciudad...";
    $res['value']="null";
    $res['id']="null";
    array_push($users,$res);
}

// return the array as json
echo json_encode($users);
?>
