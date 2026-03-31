<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
/****
 * Look for users base on name and last_name  
 ****/
$ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    } 
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');

$q = strtolower($_REQUEST["facultad"]);

if (!$q) die();

$currentdate  = date("Y-m-d H:i:s");
$query_programa = "SELECT codigocarrera,nombrecarrera FROM carrera WHERE codigofacultad='".$q."' 
        AND fechavencimientocarrera>'".$currentdate."' AND codigomodalidadacademica=200 ORDER BY nombrecarrera ASC";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombrecarrera"];
    $res['value']=$row["codigocarrera"];
    
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
