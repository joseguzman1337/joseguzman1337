<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();
$q = $_REQUEST["carrera"];

//var_dump($_REQUEST);

if (!$q) die();
            

 $query_programa = "SELECT g.idgrupo,g.codigogrupo,g.nombregrupo,g.fechainiciogrupo,
					g.fechafinalgrupo FROM grupo g
					inner join materia m ON m.codigomateria=g.codigomateria AND g.fechainiciogrupo!='0000-00-00' 
					inner join carrera c ON c.codigocarrera=m.codigocarrera AND c.codigomodalidadacademicasic=400
					AND c.codigocarrera='".$q."' ORDER BY g.fechainiciogrupo DESC";
 //var_dump($query_programa);
$result = $db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombregrupo"]." (".$row["fechainiciogrupo"]." - ".$row["fechafinalgrupo"].")";
    $res['value']=$row["idgrupo"];
    //$res['idFactor']=$row["idFactor"];
    array_push($users,$res);
   
}

// return the array as json
if(count($users)>0){
    echo json_encode(array("data"=>$users,"success"=>true,"total"=>count($users)));
} else {
    echo json_encode(array("success"=>false));
}
?>
