<?php
/****
 * Look for users base on name and last_name  
 ****/
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
include_once("variables.php");
include($rutaTemplateSingle."template.php");
$db = writeHeaderSearchs();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);
if (!$q) die();
 
//var_dump($db);

//$query_programa = "SELECT idusuario, nombres, apellidos FROM usuario WHERE nombres LIKE '%$q%' or apellidos LIKE '%$q%' ORDER BY nombres, apellidos ASC";
//no muestro estudiantes por lo que hay un lio en que aparecen repetidos y no se sabe cual es el usuario vigente y no creo que se usen estudiantes
$query_programa = "SELECT idusuario, CONCAT(nombres,' ',apellidos) as nombre_completo, t.nombretipousuario, u.usuario FROM usuario u 
    inner join tipousuario t ON t.codigotipousuario=u.codigotipousuario AND t.codigoestado='100' AND 
 t.codigotipousuario NOT IN (500,600,610,620,630,640,650,660,670,900) 
 WHERE (CONCAT(nombres,' ',apellidos) LIKE '%$q%' OR u.usuario LIKE '%$q%') ORDER BY nombres, apellidos ASC ";
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre_completo"]." (".$row["usuario"].")";
    $res['value']=$row["nombre_completo"]." (".$row["usuario"].")";
    $res['id']=$row["idusuario"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
