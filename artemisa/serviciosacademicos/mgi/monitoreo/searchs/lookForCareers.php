<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../../templates/template.php");
$db = writeHeaderSearchs();

$q = strtolower($_REQUEST["modalidad"]);
$idGen = $_REQUEST["indicador"];
//var_dump($_REQUEST);

if (!$q) die();

$currentdate  = date("Y-m-d H:i:s");
$query_programa = "SELECT codigocarrera,nombrecarrera FROM carrera WHERE codigofacultad='".$q."' AND fechavencimientocarrera>'".$currentdate."' ORDER BY nombrecarrera ASC";

$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombrecarrera"];
    $res['value']=$row["codigocarrera"];
    $res['enable']=true;
    
    if($idGen!=""){
        $query_programa = "SELECT idsiq_indicador FROM siq_indicador WHERE idIndicadorGenerico = '".$idGen."'
                        AND discriminacion='3' AND  idCarrera = '".$res['value']."'";

        $resultado =$db->GetRow($query_programa);
        if(count($resultado)>0){
            $res['enable']=false;
        }
    }
    
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
