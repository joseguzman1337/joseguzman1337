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

$q = $_REQUEST["indicador"];
//var_dump($_REQUEST);

if (!$q) die();

$query_programa = "SELECT idsiq_indicador,idFacultad FROM siq_indicador WHERE idIndicadorGenerico='".$q."' AND codigoestado='100' AND discriminacion='2'";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["idsiq_indicador"];
    $res['value']=$row["idFacultad"];
     
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
