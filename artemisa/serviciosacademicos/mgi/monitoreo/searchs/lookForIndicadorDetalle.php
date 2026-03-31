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
$monitoreo = $_GET["monitoreo"];

if (!$q) die();

$query_programa = "SELECT g.idsiq_indicador,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera 
                    FROM siq_indicador g 
                    inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
                    inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion                     
                    left join carrera c on c.codigocarrera = g.idCarrera WHERE 
                    CONCAT(id.nombre,' (',IFNULL(c.nombrecarrera, d.nombre),')') LIKE '%$q%' 
                    AND g.codigoestado='100'
                    ORDER BY id.nombre ASC, c.nombrecarrera ASC";
//var_dump($query_programa);
//die();
$result =$db->Execute($query_programa);
$users = array(); 

while ($row = $result->FetchRow()) {
    //var_dump($row);
    if($row["disc"]==1){
        $res['label']=$row["nombre"]." (".$row["discriminacion"].")";
        $res['value']=$row["nombre"]." (".$row["discriminacion"].")";
    } else if($row["disc"]==3){
        $res['label']=$row["nombre"]." (".$row["carrera"].")";
        $res['value']=$row["nombre"]." (".$row["carrera"].")";    
    }
    $res['id']=$row["idsiq_indicador"];
    
    $query_programa = "SELECT r.idsiq_relacionIndicadorMonitoreo, m.idsiq_monitoreo, m.fecha_prox_monitoreo, m.idPeriodicidad  
        FROM siq_relacionIndicadorMonitoreo r, siq_monitoreo m 
        WHERE r.idIndicador = '".$res['id']."' AND r.codigoestado='100' AND r.idMonitoreo=m.idsiq_monitoreo";

    //var_dump($query_programa);
    //die();
    $resultado =$db->GetRow($query_programa);
    
    $res['idrelacion']=false;
    $res['idmonitoreo']=false;
    $res['fecha']=false;
    $res['periodicidad']=false;
    
    if(count($resultado)>0){
        $res['idrelacion']=$resultado["idsiq_relacionIndicadorMonitoreo"];
        $res['idmonitoreo']=$resultado["idsiq_monitoreo"];
        $res['fecha']=$resultado["fecha_prox_monitoreo"];
        $res['periodicidad']=$resultado["idPeriodicidad"];
    }    
    
    if((isset($monitoreo) && $monitoreo==true && count($resultado)>0) || !isset($monitoreo)){
        array_push($users,$res);   
    }
}

// return the array as json
echo json_encode($users);
?>