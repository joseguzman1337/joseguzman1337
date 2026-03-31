<?php
/****
 * Look for users base on name and last_name  
 ****/
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

include("../../templates/template.php");
$db = writeHeaderSearchs();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);

if (!$q) die();

$query_programa = "SELECT i.nombre,i.idsiq_indicadorGenerico,a.nombre as aspecto,i.idAspecto,i.descripcion,i.idTipo,i.area,s.nombre as nombreArea,i.codigo  
                    FROM siq_indicadorGenerico i, siq_area s, siq_aspecto a WHERE 
                    i.nombre LIKE '%$q%' AND i.codigoestado='100' AND s.idsiq_area=i.area AND a.idsiq_aspecto = i.idAspecto
                    ORDER BY i.nombre ASC";

$result =$db->Execute($query_programa);
$users = array(); 

while ($row = $result->FetchRow()) {
    //var_dump($row);
    $res['label']=$row["nombre"];
    $res['value']=$row["nombre"];
    $res['id']=$row["idsiq_indicadorGenerico"];
    $res['descripcion']=$row["descripcion"];
    $res['codigo']=$row["codigo"];
    $res['aspecto']=$row["aspecto"];
    $res['idAspecto']=$row["idAspecto"];
    $res['idTipo']=$row["idTipo"];
    $res['area']=$row["area"];
    $res['idArea']=$row["nombreArea"];
    
    $query_programa = "SELECT idsiq_indicador FROM siq_indicador WHERE idIndicadorGenerico = '".$res['id']."'
                    AND discriminacion='1'";

    $resultado =$db->GetRow($query_programa);
    $res['institucional']=false;
    if(count($resultado)>0){
        $res['institucional']=true;
    }
     
    array_push($users,$res);   
}

// return the array as json
echo json_encode($users);
?>