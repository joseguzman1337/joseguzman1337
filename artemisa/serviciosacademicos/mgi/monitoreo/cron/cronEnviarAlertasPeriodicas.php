<?php
// this starts the session 
 session_start(); 
$_SESSION['MM_Username'] = 'admintecnologia';

    include("../../templates/template.php");
    $db = writeHeaderSearchs();
    
    //Para correr 1 vez al dia tipo 6am en /serviciosacademicos/mgi/monitoreo/cron/cronEnviarAlertasPeriodicas.php
            
    $api = new API_Monitoreo();
    $utils = new Utils_monitoreo();
    $apiAlertas = new API_Alertas();
    $apiAlertas->initialize($db);
    
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
    
    /*function getIndicadoresACargoActualizar($db,$api,$utils,$user)
    {
        $indicadoresActualizar = $db->GetAll($api->getQueryIndicadoresACargoActualizar($user));
        foreach ($indicadoresActualizar as $key => $row){
            $permisos = $utils->getResponsabilidadesIndicador($db,$row['idsiq_indicador']);
            var_dump(array_search(1, $permisos[1]));
        }
        return $indicadoresActualizar;
    }*/
    
    //buscar alertas asignadas a.idsiq_alertaPeriodica,a.idMonitoreo,
    $query = "SELECT * FROM siq_alertaPeriodica a 
        inner join siq_periodicidad p ON p.idsiq_periodicidad = a.idPeriodicidad AND p.codigoestado='100' 
        inner join siq_tipoValorPeriodicidad tv ON tv.idsiq_tipoValorPeriodicidad = p.tipo_valor AND tv.codigoestado='100' 
        inner join siq_tipoAlerta t ON t.idsiq_tipoAlerta = a.idTipoAlerta AND t.codigoestado='100' 
        WHERE a.codigoestado='100' ";
    $alertas = $db->GetAll($query); 
    
    //var_dump(count($alertas));
    
    foreach ($alertas as $key => $row){
        //verifico si aplica a todos los indicadores
        if($row["idMonitoreo"]==NULL){
            //defino operadores
            if($row["valor"]<0){
                $op = "DATE_SUB";
                $val = 0 - $row["valor"];
            }else{
                $op = "DATE_ADD";
                $val = $row["valor"];
            }
            
            if($row["tipo_valor"]==1){
                $unit = "DAY";
            } else if($row["tipo_valor"]==2){
                $unit = "MONTH";                
            }else if($row["tipo_valor"]==3){
                $unit = "YEAR";                
            }
    
            //buscar indicadores que venzan en el periodo definido
            $query = "SELECT i.idsiq_indicador FROM siq_indicador i 
                    inner join siq_relacionIndicadorMonitoreo r ON r.idIndicador=i.idsiq_indicador AND r.codigoestado='100' 
                    inner join siq_actividadActualizar a ON a.fecha_limite=i.fecha_proximo_vencimiento 
                        AND r.idMonitoreo= a.idMonitoreo AND a.codigoestado='100'
                    WHERE i.fecha_proximo_vencimiento IS NOT NULL AND 
                    i.codigoestado='100' AND CURDATE()=".$op."(i.fecha_proximo_vencimiento, INTERVAL ".$val." ".$unit.") ";
            
            /*$query = "SELECT r.idIndicador as idsiq_indicador FROM siq_relacionIndicadorMonitoreo r WHERE r.codigoestado='100' AND 
                    r.idMonitoreo IN (SELECT a.idMonitoreo FROM siq_actividadActualizar a WHERE 
                    CURDATE()=".$op."(a.fecha_limite, INTERVAL ".$val." ".$unit.") 
                    AND a.codigoestado='100' AND a.idEstado!=3 GROUP BY a.idMonitoreo)";*/
            $indicadores =$db->GetAll($query); 
            
            //si hay indicadores que aplican entonces siga
            if(count($indicadores)>0){
                //var_dump($query);
                //var_dump("<br/><br/>");
                //var_dump($indicadores);
                //var_dump("<br/><br/>");

                //busco los usuarios a cargo de estos indicadores 
                $sql1 = "SELECT raf.idUsuarioResponsable FROM v_responsableIndicadorFactor raf WHERE raf.idsiq_indicador IN (".$query.") GROUP BY raf.idUsuarioResponsable";

                $result1 =$db->GetAll($sql1);

                $sql1 = "SELECT rac.idUsuarioResponsable FROM v_responsableIndicadorCaracteristica rac WHERE rac.idsiq_indicador IN (".$query.") GROUP BY rac.idUsuarioResponsable";

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

                $sql1 = "SELECT raa.idUsuarioResponsable FROM v_responsableIndicadorAspecto raa WHERE raa.idsiq_indicador IN  (".$query.") GROUP BY raa.idUsuarioResponsable";

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
                                                                WHERE ri.codigoestado='100' AND ri.idIndicador IN  (".$query.") GROUP BY ri.idUsuarioResponsable";

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
                
                //var_dump($result);
                //var_dump("<br/><br/>");

                //combino los arreglos
                $end_result = array_merge($end_result, $result);

                //var_dump($end_result);
                //var_dump("<br/><br/>");

                //Por cada usuario encuentro los indicadores que le correspondan y que se venzan en el periodo de la alerta para enviar el correo
                foreach ($end_result as $keyUsers => $rowUsers){
                    //indicadores que el usuario deba actualizar
                    //$indicadoresAcargo = getIndicadoresACargoActualizar($db,$api,$utils,$row['idUsuarioResponsable']);
                    $indicadoresAcargo = $db->GetAll($api->getQueryIndicadoresACargoActualizar($rowUsers['idUsuarioResponsable']));
                    //var_dump($indicadoresAcargo);
                    $query = "SELECT * FROM usuario WHERE idusuario='".$rowUsers['idUsuarioResponsable']."'";
                    $usu = $db->GetRow($query);
                    $destinatario = $usu["nombres"]." ".$usu["apellidos"]."<".$usu["usuario"]."@unbosque.edu.co>";

                    $parametros = array();

                    //encuentro los indicadores a cargo que se vencen en la fecha especificada
                    $result = array_uintersect($indicadoresAcargo, $indicadores,"compareArraysByIndicador");
                    //var_dump($result);var_dump("<br/><br/>");var_dump($destinatario);var_dump("<br/><br/>");
                    if(count($result)>0){
                        $parametros["siq_indicador"] = array_values($result);
                        //if($rowUsers['idUsuarioResponsable']==4186){
                            //$destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
                            //var_dump($apiAlertas->procesarPlantillaAlertaPeriodica($row["idTipoAlerta"],$parametros));
                            //envio las alertas por usuario
                            $apiAlertas->enviarAlertaPeriodicaConPlantilla($row["idTipoAlerta"],$parametros,$destinatario);
                        //}
                    }    
                }
                
            }
            
        } else {
            //busco el indicador respectivo
        }
    
    }
    
?>
