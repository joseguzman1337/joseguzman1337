<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("variables.php");
include($rutaTemplateSingle."template.php");
$db = writeHeaderSearchs();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);
if (!$q) die();

//var_dump($db);

//$query_programa = "SELECT idusuario, nombres, apellidos FROM usuario WHERE nombres LIKE '%$q%' or apellidos LIKE '%$q%' ORDER BY nombres, apellidos ASC";
$query_programa = "SELECT idusuario, nombres, apellidos FROM usuario WHERE CONCAT(nombres,' ',apellidos) LIKE '%$q%' ORDER BY nombres, apellidos ASC";
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombres"]." ".$row["apellidos"];
    $res['value']=$row["nombres"]." ".$row["apellidos"];
    $res['id']=$row["idusuario"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
