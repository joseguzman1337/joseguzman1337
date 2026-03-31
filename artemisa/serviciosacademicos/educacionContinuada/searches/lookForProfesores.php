<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);

if (!$q) die();
            

$query_programa = "SELECT numerodocumento, CONCAT(nombredocente, ' ', apellidodocente) AS nombre 
FROM docente WHERE CONCAT(nombredocente, ' ', apellidodocente) LIKE '%$q%' AND codigoestado='100' 
	UNION 
	SELECT numerodocumento, CONCAT(nombredocente, ' ', apellidodocente) AS nombre 
FROM docenteEducacionContinuada WHERE CONCAT(nombredocente, ' ', apellidodocente) LIKE '%$q%' AND codigoestado='100'
    ORDER BY nombre ASC";
//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombre"];
    $res['value']=$row["nombre"];
    $res['id']=$row["numerodocumento"];
    //$res['idFactor']=$row["idFactor"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
