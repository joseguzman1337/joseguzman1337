<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

include("../../templates/templateAutoevaluacion.php");
$db =writeHeaderBD();
$q = strtolower($_GET["term"]);
$tipo = strtolower($_GET["tipousuario"]);
//var_dump($_REQUEST);
if (!$q) die();

//var_dump($db);

//$query_programa = "SELECT idusuario, nombres, apellidos FROM usuario WHERE nombres LIKE '%$q%' or apellidos LIKE '%$q%' ORDER BY nombres, apellidos ASC";
$query_programa = "SELECT idusuario, numerodocumento, nombres, apellidos FROM usuario WHERE 
                   CONCAT(nombres,' ',apellidos) LIKE '%$q%' and
                   codigotipousuario='".$tipo."'
                    ORDER BY nombres, apellidos ASC";
//echo $query_programa;
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombres"]." ".$row["apellidos"];
    $res['value']=$row["nombres"]." ".$row["apellidos"];
    $res['ndoc']=$row["numerodocumento"];
    $res['id']=$row["idusuario"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>