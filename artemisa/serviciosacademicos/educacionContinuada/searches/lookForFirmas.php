<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$q = strtolower($_GET["term"]);
//$q = strtolower($_REQUEST["data"]);
//var_dump($_REQUEST);

if (!$q) die();
            

$query_programa = "SELECT nombre, cargo, unidad, ubicacionFirmaEscaneada, idfirmaEscaneadaEducacionContinuada FROM firmaEscaneadaEducacionContinuada  
        WHERE nombre LIKE '%".$q."%' AND codigoestado='100' ORDER BY nombre ASC";
//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"]." (".$row["cargo"].")";
    $res['value']=$row["nombre"];
    $res['id']=$row["idfirmaEscaneadaEducacionContinuada"];
    $res['cargo']=$row["cargo"];
    $res['unidad']=$row["unidad"];
    $res['ubicacion']=$row["ubicacionFirmaEscaneada"];
    //$res['idFactor']=$row["idFactor"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
