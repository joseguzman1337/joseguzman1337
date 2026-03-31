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

if (!$q) die();

function compareArrays($v1,$v2)
{
    return strcasecmp($v1['idsiq_indicador'] , $v2['idsiq_indicador']);
}

$api = new API_Monitoreo();

$indicadores_responsable = $api->getQueryIndicadoresACargo();

//separarla en varias y voy verificando por cada una si hay resultados con un boolean tiene_responsabilidades
//var_dump($indicadores_responsable);
//$result =$db->GetRow($indicadores_responsable);

//si el usuario tiene responsabilidades
//if(count($result)>0){
/*$query_programa = "SELECT g.idsiq_indicador,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera 
                    FROM siq_indicador g 
                    inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
                    inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion                     
                    left join carrera c on c.codigocarrera = g.idCarrera WHERE 
                    CONCAT(id.nombre,' (',IFNULL(c.nombrecarrera, d.nombre),')') LIKE '%$q%' 
                    AND g.codigoestado='100' AND g.idsiq_indicador IN (".$indicadores_responsable.") 
                    ORDER BY id.nombre ASC, c.nombrecarrera ASC";*/

$query_programa = "SELECT g.idsiq_indicador,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera 
                    FROM siq_indicador g 
                    inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
                    inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion                     
                    left join carrera c on c.codigocarrera = g.idCarrera 
                    inner join (".$indicadores_responsable.") rid ON rid.idsiq_indicador=g.idsiq_indicador
                    WHERE CONCAT(id.nombre,' (',IFNULL(c.nombrecarrera, d.nombre),')') LIKE '%$q%' 
                    AND g.codigoestado='100' ORDER BY id.nombre ASC, c.nombrecarrera ASC";

//separarla en varias y con php las organizo alfabeticamente
$query_programa1 = "SELECT g.idsiq_indicador,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera 
                    FROM siq_indicador g 
                    inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
                    inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion                     
                    left join carrera c on c.codigocarrera = g.idCarrera 
                    WHERE CONCAT(id.nombre,' (',IFNULL(c.nombrecarrera, d.nombre),')') LIKE '%$q%' 
                    AND g.codigoestado='100' ORDER BY id.nombre ASC, c.nombrecarrera ASC";

//$result1 =$db->GetAll($query_programa1);
//$result2 =$db->GetAll($indicadores_responsable);
//$result =$db->GetAll($query_programa);
//var_dump($query_programa1);
//var_dump(count($result1));
//var_dump(count($result2));

//var_dump(count($result));
//$result = array_uintersect($result1, $result2,"compareArrays");
//var_dump(count($result));
        
/*} else {
    $query_programa = "SELECT g.idsiq_indicador,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera 
                    FROM siq_indicador g 
                    inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico 
                    inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion                     
                    left join carrera c on c.codigocarrera = g.idCarrera WHERE 
                    CONCAT(id.nombre,' (',IFNULL(c.nombrecarrera, d.nombre),')') LIKE '%$q%' 
                    AND g.codigoestado='100' 
                    ORDER BY id.nombre ASC, c.nombrecarrera ASC";
}*/
//var_dump($query_programa);
$result =$db->Execute($query_programa);
//$result =$db->Execute($query_programa1);
$users = array(); 

while ($row = $result->FetchRow()) {
//foreach ($result as $key => $row){
        //var_dump($row);
        if($row["disc"]==1){
            $res['label']=$row["nombre"]." (".$row["discriminacion"].")";
            $res['value']=$row["nombre"]." (".$row["discriminacion"].")";
        } else if($row["disc"]==3){
            $res['label']=$row["nombre"]." (".$row["carrera"].")";
            $res['value']=$row["nombre"]." (".$row["carrera"].")";    
        }
        $res['id']=$row["idsiq_indicador"];

        $query_programa = "SELECT r.idsiq_relacionIndicadorMonitoreo, m.idsiq_monitoreo, m.fecha_prox_monitoreo, m.idPeriodicidad, 
            m.fin_de_mes  FROM siq_relacionIndicadorMonitoreo r, siq_monitoreo m 
            WHERE r.idIndicador = '".$res['id']."' AND r.codigoestado='100' AND r.idMonitoreo=m.idsiq_monitoreo";

        $resultado =$db->GetRow($query_programa);

        $res['idrelacion']=false;
        $res['idmonitoreo']=false;
        $res['fecha']=false;
        $res['periodicidad']=false;
        $res['mes']=0;

        if(count($resultado)>0){
            $res['idrelacion']=$resultado["idsiq_relacionIndicadorMonitoreo"];
            $res['idmonitoreo']=$resultado["idsiq_monitoreo"];
            $res['fecha']=$resultado["fecha_prox_monitoreo"];
            $res['periodicidad']=$resultado["idPeriodicidad"];
            $res['mes']=$resultado["fin_de_mes"];
        }    

        array_push($users,$res); 
}

// return the array as json
echo json_encode($users);
?>