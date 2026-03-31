<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../templates/template.php");
$db = getBD();

$q = strtolower($_REQUEST["carrera"]);
$periodo = strtolower($_REQUEST["periodo"]);
//var_dump($_REQUEST);

if (!$q || !$periodo) die();

$query_programa = "SELECT p.codigoestudiante, CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre from prematricula p
        INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante AND e.codigocarrera='".$q."' 
        INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral 
        where p.codigoperiodo='".$periodo."' AND p.codigoestadoprematricula IN (40,41) ORDER BY nombre";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"];
    $res['value']=$row["codigoestudiante"];
    
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
