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

$query_programa = "SELECT i.idsiq_indicador,i.idCarrera,c.codigomodalidadacademica FROM siq_indicador i, carrera c WHERE idIndicadorGenerico='".$q."' AND codigoestado='100' AND discriminacion='3' AND c.codigocarrera=i.idCarrera";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["idsiq_indicador"];
    $res['value']=$row["idCarrera"];
    $res['modalidad']=$row["codigomodalidadacademica"];
     
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
