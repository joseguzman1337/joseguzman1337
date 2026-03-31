<?php

include_once ('../EspacioFisico/templates/template.php');
require_once("../modelos/convenios/SolicitudConvenios.php");
require_once("NotificacionConvenio.php");

if(!$db){
	$db = getBD();
}
$fechahoy = date("Y-m-d");

$sqlconvenios = "SELECT ConvenioId, TipoRenovacionId, idsiq_duracionconvenio, FechaClausulaTerminacion, FechaFin FROM `Convenios` WHERE FechaFin = '".$fechahoy."' OR FechaClausulaTerminacion ='".$fechahoy."'";
$convenios = $db->GetAll($sqlconvenios);

if($convenios)
{
    foreach($convenios as $conve)
    {
        switch($conve['TipoRenovacionId'])
        {
            case '1': 
            {
                if($conve['FechaFin']==$fechahoy)
                {
                    $C_Fecha = strtotime("+".$conve['idsiq_duracionconvenio']." years",strtotime($fechahoy));          
                    $Fecha = date("Y-m-d", $C_Fecha);
                    
                    $Cl_Fecha = strtotime("-3 month",strtotime($Fecha));          
                    $FechaClau = date("Y-m-d", $Cl_Fecha);          
                    
                    $sqlupdate = "update Convenios set FechaInicio='".$fechahoy."', FechaFin='".$Fecha."', FechaClausulaTerminacion='".$FechaClau."' where ConvenioId = '".$conve['ConvenioId']."'";    
                    $update= $db->execute($sqlupdate);
                    
                    $to = "seconsejoacademico@unbosque.edu.co";
                    $asunto = "Notificacion Estado Convenio";
                    $mensaje = "Convenio Renovado automaticamente. por favor ingrese al sistema para consultar la lista de convenios activos.";  
                    EnviarCorreo($to,$asunto,$mensaje);   
                }
                if($conve['FechaClausulaTerminacion']==$fechahoy)
                {              
                    $to = "seconsejoacademico@unbosque.edu.co";
                    $asunto = "Notificacion Estado Convenio";
                    $mensaje = "Convenio por vencer. por favor ingrese al sistema para consultar la lista de convenios activos.";  
                    EnviarCorreo($to,$asunto,$mensaje); 
                }
            }break;
            case '2':
            {
                if($conve['FechaFin']==$fechahoy)
                {            
                    $sqlupdate = "update Convenios set idsiq_estadoconvenio = '4' where ConvenioId = '".$conve['ConvenioId']."'";    
                    $update= $db->execute($sqlupdate);
                    
                    $to = "seconsejoacademico@unbosque.edu.co";
                    $asunto = "Notificacion Estado Convenio";
                    $mensaje = "Convenio Vencido. por favor ingrese al sistema para consultar la lista de convenios activos o vencidos.";  
                    EnviarCorreo($to,$asunto,$mensaje);   
                }
                if($conve['FechaClausulaTerminacion']==$fechahoy)
                {              
                    $to = "seconsejoacademico@unbosque.edu.co";
                    $asunto = "Notificacion Estado Convenio";
                    $mensaje = "Convenio por vencer. por favor ingrese al sistema para consultar la lista de convenios activos.";  
                    EnviarCorreo($to,$asunto,$mensaje); 
                }
            }break;
            case '3':
            {
                if($conve['FechaFin']==$fechahoy)
                {            
                    $sqlupdate = "update Convenios set idsiq_estadoconvenio = '4' where ConvenioId = '".$conve['ConvenioId']."'";    
                    $update= $db->execute($sqlupdate);
                    
                    $to = "seconsejoacademico@unbosque.edu.co";
                    $asunto = "Notificacion Estado Convenio";
                    $mensaje = "Convenio Vencido. por favor ingrese al sistema para consultar la lista de convenios activos o vencidos.";  
                    EnviarCorreo($to,$asunto,$mensaje);   
                }
                if($conve['FechaClausulaTerminacion']==$fechahoy)
                {              
                    $to = "seconsejoacademico@unbosque.edu.co";
                    $asunto = "Notificacion Estado Convenio";
                    $mensaje = "Convenio por vencer. por favor ingrese al sistema para consultar la lista de convenios activos.";  
                    EnviarCorreo($to,$asunto,$mensaje); 
                }
            }break;
        }
    }
}
?>