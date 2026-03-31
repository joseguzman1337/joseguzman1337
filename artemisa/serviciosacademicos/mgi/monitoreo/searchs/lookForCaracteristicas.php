<?php
/****
 * Look for users base on name and last_name  
 ****/
 session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

include("../../templates/template.php");
$db = writeHeaderSearchs();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);

if (!$q) die();

//var_dump($db);

if($_GET["factor"]!=""){
    $query_programa = "SELECT idsiq_caracteristica, nombre, idFactor FROM siq_caracteristica WHERE idFactor=".$_GET["factor"]." AND nombre LIKE '%$q%' ORDER BY nombre ASC";
} else{
    $query_programa = "SELECT idsiq_caracteristica, nombre, idFactor FROM siq_caracteristica WHERE nombre LIKE '%$q%' ORDER BY nombre ASC";
}
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"];
    $res['value']=$row["nombre"];
    $res['id']=$row["idsiq_caracteristica"];
    $res['idFactor']=$row["idFactor"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
