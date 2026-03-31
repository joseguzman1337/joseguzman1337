<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../templates/template.php");
$db = getBD();

$mes = strtolower($_REQUEST["mes"]);
$anio = strtolower($_REQUEST["anio"]);
$comunidad = strtolower($_REQUEST["comunidad"]);
//var_dump($_REQUEST);

if (!$anio || !$mes || !$comunidad) die();

$query_programa = "SELECT idsiq_valoresCampoFormulario,valor FROM siq_valoresCampoFormulario WHERE 
    idCampo='".$comunidad."' AND codigoestado='100' ORDER BY valor ASC";

$result =$db->Execute($query_programa);
$users = array();
$users['success']=true;
$users['data']=array();
$users['lugares']=array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["valor"];
    $res['value']=$row["idsiq_valoresCampoFormulario"];
    
    array_push($users["lugares"],$res);
   
}

// return the array as json
echo json_encode($users);
?>
