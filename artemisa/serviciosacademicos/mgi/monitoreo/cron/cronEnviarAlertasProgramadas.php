<?php
// this starts the session 
 session_start(); 
$_SESSION['MM_Username'] = 'admintecnologia';

    include("../../templates/template.php");
    $db = writeHeaderSearchs();
    
    //Para correr cada hora o 2 en /serviciosacademicos/mgi/monitoreo/cron/cronEnviarAlertasProgramadas.php
    
    //Envio las alertas por evento 
    $api = new API_Alertas();
    $utils = new Utils_monitoreo();
    
    $query_programa = "SELECT * FROM siq_colaAlertaPorEvento i where i.codigoestado='100' 
    AND i.enviado='0' AND i.fecha_envio=CURDATE()";
    
    $result = $db->Execute($query_programa);
    
    $action = "update";
    $fields=array();
    while ($row = $result->FetchRow()) {
        $asunto = $row["asunto"];
        $mensaje = $row["mensaje"];
        $to = $row["destinatarios"];
        if($row["idAlerta"]!=null){
            $asunto = $api->procesarFuncionesEnTexto($asunto);
            $mensaje = $api->procesarFuncionesEnTexto($mensaje);              
        }
        
        $send = $api->enviarAlerta($to, $asunto, $mensaje, true);
        if($send["succes"]){
            $fields["enviado"] = 1;
        } else if($row["resultado"]!=NULL){
            //ya se trato de enviar antes entonces mejor se inactiva
            $fields["codigoestado"] = 200;
        } 
                
        $fields["resultado"] = $send["mensaje"];
        $fields["idsiq_colaAlertaPorEvento"] = $row["idsiq_colaAlertaPorEvento"];
        $utils->processData($action,"colaAlertaPorEvento",$fields,false);
    }
    
    //Envio las alertas periodicas 
?>
