<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$q = strtolower($_REQUEST["nombre"]);
//var_dump($_REQUEST);

if (!$q) die();

//var_dump($q);
$fechahoy=date("Y-m-d H:i:s"); 
            

$query_programa = "SELECT codigocarrera, nombrecarrera FROM carrera WHERE nombrecarrera = '$q' AND codigomodalidadacademica=400 AND 
	codigomodalidadacademicasic=400 AND fechavencimientocarrera > '".$fechahoy."' ORDER BY nombrecarrera ASC";
//var_dump($query_programa);
$result =$db->GetRow($query_programa);

$existe = false;
$id=-1;
if (count($result)>0) {
    $existe = true;   
    $id = $result["codigocarrera"];   
}
//var_dump($existe);
// return the array as json
echo json_encode(array("result"=>$existe,"id"=>$id));
?>
