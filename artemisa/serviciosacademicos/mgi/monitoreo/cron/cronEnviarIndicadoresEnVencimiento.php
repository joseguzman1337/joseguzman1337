<?php
// this starts the session 
 session_start(); 
$_SESSION['MM_Username'] = 'admintecnologia';

    include("../../templates/template.php");
    $db = writeHeaderSearchs();
    
    //Para correr 1 vez al dia tipo 5am en /serviciosacademicos/mgi/monitoreo/cron/cronEnviarIndicadoresEnVencimiento.php
    
    //compara los usuarios
    function compareArrays($v1,$v2)
    {
        return strcasecmp($v1['idUsuarioResponsable'] , $v2['idUsuarioResponsable']);
    }
    
    //compara los indicadores
    function compareArraysByIndicador($v1,$v2)
    {
        return strcasecmp($v1['idsiq_indicador'] , $v2['idsiq_indicador']);
    }
    
    //Encuentro todos los usuarios con indicadores que vencen hoy y no han sido actualizados
    $complete_sql = "    ( SELECT raf.idUsuarioResponsable FROM v_responsableIndicadorFactor raf WHERE raf.idsiq_indicador IN (SELECT r.idIndicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)) GROUP BY raf.idUsuarioResponsable )
            
                                   UNION
                                    (SELECT rac.idUsuarioResponsable FROM v_responsableIndicadorCaracteristica rac WHERE rac.idsiq_indicador IN (SELECT r.idIndicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)) GROUP BY rac.idUsuarioResponsable )    
            
                                    UNION
                                    (SELECT raa.idUsuarioResponsable FROM v_responsableIndicadorAspecto raa WHERE raa.idsiq_indicador IN  (SELECT r.idIndicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)) GROUP BY raa.idUsuarioResponsable) 
            
                                    UNION
                                    (SELECT ri.idUsuarioResponsable FROM siq_responsableIndicador ri   
                                                    JOIN siq_indicador gi ON ri.idIndicador=gi.idsiq_indicador AND gi.codigoestado='100' 
                                                    WHERE ri.codigoestado='100' AND ri.idIndicador IN  (SELECT r.idIndicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)) GROUP BY ri.idUsuarioResponsable ) ";
    
    $sql1 = "SELECT raf.idUsuarioResponsable FROM v_responsableIndicadorFactor raf WHERE raf.idsiq_indicador IN (SELECT r.idIndicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)) GROUP BY raf.idUsuarioResponsable";
    
    $result1 =$db->GetAll($sql1);
    
    $sql1 = "SELECT rac.idUsuarioResponsable FROM v_responsableIndicadorCaracteristica rac WHERE rac.idsiq_indicador IN (SELECT r.idIndicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)) GROUP BY rac.idUsuarioResponsable";
    
    $result2 =$db->GetAll($sql1);
    
    //var_dump($result1);
    //var_dump("<br/><br/>");
    //var_dump($result2);
    //var_dump("<br/><br/>");
    
    //encuentro los usuarios que se repiten en el arreglo
    $result = array_uintersect($result1, $result2,"compareArrays");
    
    if($result!=NULL){
        //var_dump($result);
        //var_dump("<br/><br/>");

        //saco los usuarios que se repiten
        $result = array_udiff($result1, $result, "compareArrays");

        //var_dump($result);
        //var_dump("<br/><br/>");
    } else {
        $result = $result1;
    }
    $end_result = array_merge($result, $result2);
    
    //var_dump($end_result);
    //var_dump("<br/><br/>");
    
    $sql1 = "SELECT raa.idUsuarioResponsable FROM v_responsableIndicadorAspecto raa WHERE raa.idsiq_indicador IN  (SELECT r.idIndicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)) GROUP BY raa.idUsuarioResponsable";
    
    $result1 =$db->GetAll($sql1);
        
    //encuentro los usuarios que se repiten en el arreglo
    $result = array_uintersect($result1, $end_result,"compareArrays");
    
    if($result!=NULL){
    //var_dump($result);
    //var_dump("<br/><br/>");
    
    //saco los usuarios que se repiten
    $result = array_udiff($result1, $result, "compareArrays");
    
    //var_dump($result);
    //var_dump("<br/><br/>");
    } else {
        $result = $result1;
    }
    
    //combino los arreglos
    $end_result = array_merge($end_result, $result);
    
    //var_dump($end_result);
    //var_dump("<br/><br/>");
    
    $sql1 = "SELECT ri.idUsuarioResponsable FROM siq_responsableIndicador ri   
                                                    JOIN siq_indicador gi ON ri.idIndicador=gi.idsiq_indicador AND gi.codigoestado='100' 
                                                    WHERE ri.codigoestado='100' AND ri.idIndicador IN  (SELECT r.idIndicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)) GROUP BY ri.idUsuarioResponsable";
    
    $result1 =$db->GetAll($sql1);
    
    //encuentro los usuarios que se repiten en el arreglo
    $result = array_uintersect($result1, $end_result,"compareArrays");
    
    if($result!=NULL){
    //var_dump($result);
    //var_dump("<br/><br/>");
    
    //saco los usuarios que se repiten
    $result = array_udiff($result1, $result, "compareArrays");
    
    //var_dump($result);
    //var_dump("<br/><br/>");
    } else {
        $result = $result1;
    }
    
    //combino los arreglos
    $end_result = array_merge($end_result, $result);
    
    //var_dump($end_result);
    //var_dump("<br/><br/>");
    
    $api = new API_Monitoreo();
    $apiAlertas = new API_Alertas();
    $apiAlertas->initialize($db);
    
    //Todos los indicadores que vencen hoy
    $query = "SELECT i.idsiq_indicador FROM siq_indicador i 
                    inner join siq_relacionIndicadorMonitoreo r ON r.idIndicador=i.idsiq_indicador AND r.codigoestado='100' 
                    inner join siq_actividadActualizar a ON a.fecha_limite=i.fecha_proximo_vencimiento 
                        AND r.idMonitoreo= a.idMonitoreo AND a.codigoestado='100'
                    WHERE i.fecha_proximo_vencimiento IS NOT NULL AND 
                    i.codigoestado='100' AND CURDATE()=i.fecha_proximo_vencimiento";
    
    /*$query = "SELECT r.idIndicador as idsiq_indicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
        r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE a.fecha_limite=CURDATE() 
        AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)";*/
    $indicadores =$db->GetAll($query);    

    //Por cada usuario encuentro los indicadores que le correspondan y que se venzan hoy para enviar el correo
    foreach ($end_result as $key => $row){
        $indicadoresAcargo = $db->GetAll($api->getQueryIndicadoresACargo($row['idUsuarioResponsable']));
        
        $query = "SELECT * FROM usuario WHERE idusuario='".$row['idUsuarioResponsable']."'";
        $usu = $db->GetRow($query);
        $destinatario = $usu["nombres"]." ".$usu["apellidos"]."<".$usu["usuario"]."@unbosque.edu.co>";
        
        $parametros = array();
        
        //encuentro los indicadores a cargo que se vencen hoy
        $result = array_uintersect($indicadoresAcargo, $indicadores,"compareArraysByIndicador");
        if(count($result)>0){
            $parametros["getIndicadoresACargo()"] = array_values($result);
            //if($row['idUsuarioResponsable']==4186){
                //var_dump($parametros["getIndicadoresACargo()"]);var_dump("<br/><br/>");
                //var_dump($apiAlertas->procesarPlantillaAlertaPorEvento(3,$parametros));var_dump("<br/><br/>");
                //$destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
                $apiAlertas->enviarAlertaEventoConPlantilla(3,$destinatario,$parametros);
            //}
        }    
    }
?>
