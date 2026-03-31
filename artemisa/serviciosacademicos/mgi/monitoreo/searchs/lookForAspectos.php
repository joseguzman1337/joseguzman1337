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

if($_GET["caracteristica"]!=""){
    $query_programa = "SELECT a.idsiq_aspecto, a.nombre, a.idCaracteristica, c.nombre as caracteristica, c.idFactor FROM siq_aspecto a, siq_caracteristica c WHERE a.idCaracteristica=".$_GET["caracteristica"]." AND a.nombre LIKE '%$q%' 
            AND a.idCaracteristica = c.idsiq_caracteristica AND a.codigoestado=100 ORDER BY a.nombre ASC";
} else{
    $query_programa = "SELECT a.idsiq_aspecto, a.nombre, a.idCaracteristica, c.nombre  as caracteristica, c.idFactor FROM siq_aspecto a, 
    siq_caracteristica c WHERE a.nombre LIKE '%$q%' AND a.idCaracteristica = c.idsiq_caracteristica AND a.codigoestado=100 ORDER BY a.nombre ASC";
}
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"];
    $res['value']=$row["nombre"];
    $res['id']=$row["idsiq_aspecto"];
    $res['idFactor']=$row["idFactor"];
    $res['idCaracteristica']=$row["idCaracteristica"];
    $res['caracteristica']=$row["caracteristica"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
