<?php
// this starts the session 
 session_start(); 
$_SESSION['MM_Username'] = 'admintecnologia';

    include("../../templates/template.php");
    $db = writeHeaderSearchs();
    
    //Para correr 1 vez al día tipo 3am en /serviciosacademicos/mgi/monitoreo/cron/cronCambiarEstadoIndicadores.php
    
    //Inactivar todos los indicadores cuyas carreras ya no aplican
    $utils = new Utils_monitoreo();
    
    //$today = date("Y-m-d H:i:s");   
    
    $query_programa = "SELECT idsiq_indicador FROM siq_indicador i where i.codigoestado='100' 
    AND i.idCarrera IN (SELECT codigocarrera FROM carrera WHERE fechavencimientocarrera<CURDATE())";
    
    $result = $db->Execute($query_programa);
    
    $action = "inactivate";
    $table = "indicador";
    $fields["codigoestado"] = 200;
    while ($row = $result->FetchRow()) {
        $fields["idsiq_indicador"] = $row["idsiq_indicador"];        
        $utils->processData($action,$table,$fields,false);
        
        $query = "UPDATE siq_actividadActualizar a SET a.codigoestado=200 WHERE a.idMonitoreo IN ( 
            SELECT r.idMonitoreo FROM siq_relacionIndicadorMonitoreo r WHERE r.idIndicador='".$row["idsiq_indicador"]."')";
            
        $db->Execute($query);            
    }
    
    //var_dump("ya inactive lo que es");
    
    //Encontrar todos los indicadores que toca desactualizar
    $api = new API_Monitoreo();
    $today_date = date("Y-m-d");  
    $today = strtotime($today_date);
    
    $query_programa = "SELECT idMonitoreo FROM siq_actividadActualizar WHERE fecha_limite<CURDATE() 
        AND codigoestado='100' AND idEstado!=3 GROUP BY idMonitoreo";
    
    $result = $db->Execute($query_programa);
    $action = "update";
    $fields=array();
    $fields["idEstado"] = 1;
    while ($row = $result->FetchRow()) {
        $actividad = $api->getActividadActualizarActiva($row["idMonitoreo"]);
        $limit_date = strtotime($actividad["fecha_limite"]);
        if ($limit_date < $today) {
            //se desactualizo
            $relacion = $api->getRelacionIndicadorMonitoreo($row["idMonitoreo"],true);
            $fields["idsiq_indicador"] = $relacion["idIndicador"];    
            $utils->processData($action,$table,$fields,false);
        }     
    }
    //var_dump("se desactualizaron los indicadores");
?>
