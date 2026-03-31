<?php

include_once("../../variables.php");

$_REQUEST["action"] ="dontProcess";
include($rutaTemplateCalendar.'templateProcess.php');
$doc = $_REQUEST["documento"];

$indicador = $utils->getDataEntity("indicador", $_REQUEST["indicador"]);

$valido = true;

//esta tratando de aprobar documentos
if($_REQUEST["chequeo"]==1){
    //tiene principal?
    if($_REQUEST["principal"]){
        $sql = "SELECT idsiq_archivodocumento FROM siq_archivo_documento WHERE codigoestado='100' AND siq_documento_id='".$doc."' AND tipo_documento='1' AND version_final='1'";        
        $row = $db->GetRow($sql);

        if(count($row)==0){
            $valido = false;
            $mensaje = "No ha señalado la versión final del documento principal.";
        }
    }
    if($indicador["tiene_anexo"]==1){
        $sql = "SELECT idsiq_archivodocumento FROM siq_archivo_documento WHERE codigoestado='100' AND siq_documento_id='".$doc."' AND tipo_documento='3' AND version_final='1'";        
        $row = $db->GetRow($sql);

        if(count($row)==0){
            if($valido){
                $mensaje = "No ha señalado la versión final del documento anexo.";
            } else {
                $mensaje = "No ha señalado la versión final del documento principal ni del anexo.";                
            }
            $valido = false;
        }
    }
    if($indicador["es_objeto_analisis"]==1){
        $sql = "SELECT idsiq_archivodocumento FROM siq_archivo_documento WHERE codigoestado='100' AND siq_documento_id='".$doc."' AND tipo_documento='2' AND version_final='1'";        
        $row = $db->GetRow($sql);

        if(count($row)==0){
            $valido = false;
            $mensaje = "No ha señalado la versión final del documento de análisis.";
        }
    }
} else {
    //esta tratando de rechazar
    if($_REQUEST["principal"] || $indicador["tiene_anexo"]==1 || $indicador["es_objeto_analisis"]==1){
        $sql = "SELECT idsiq_archivodocumento FROM siq_archivo_documento WHERE codigoestado='100' AND siq_documento_id='".$doc."' AND rechazado='1'";        
        $row = $db->GetAll($sql);

        if(count($row)==0){
            $valido = false;
            $mensaje = "No ha rechazada ningún documento. Mire la lista de documentos en ver indicador e indique cual rechaza.";
        }
    }
}
//$sql = "SELECT idsiq_documento FROM siq_archivo_documento WHERE codigoestado='100' AND siqindicador_id='".$idIndicador."' ";        
//$rows = $db->GetAll($sql);
        

$data = array('success'=> $valido,'message'=> $mensaje." ");//.$sql);

    // JSON encode and send back to the server
   echo json_encode($data);

?>
