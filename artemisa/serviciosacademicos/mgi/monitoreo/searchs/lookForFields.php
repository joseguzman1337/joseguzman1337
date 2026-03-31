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

$q = strtolower($_REQUEST["categoria"]);
//var_dump($_REQUEST);

if (!$q) die();

if(isset($_REQUEST["periodicas"]) && $_REQUEST["periodicas"]==true){
     $query_programa = "SELECT nombre, campo_tabla, tabla FROM siq_campoPlantillaAlerta WHERE categoria='".$q."' AND codigoestado='100' AND aplica_periodicas='1' ORDER BY nombre ASC";
} else {
    $query_programa = "SELECT nombre, campo_tabla, tabla FROM siq_campoPlantillaAlerta WHERE categoria='".$q."' AND codigoestado='100' ORDER BY nombre ASC";
}

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"];
    if($row["tabla"]!=""){
        $res['value']="{{ ".$row["tabla"].".".$row["campo_tabla"]." }}";
    } else{
        $res['value']="{{ ".$row["campo_tabla"]." }}";
    }
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
