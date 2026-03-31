<?php
// this starts the session 
 session_start(); 

require_once("template.php");
$db = writeHeaderSearchs();

$utils = new Utils_monitoreo();
//$api = new API_Monitoreo();

$action = $_REQUEST["action"];

if($action=="dontProcess"){
    //$result = $api->actualizarEstadoIndicador($_POST["idsiq_indicador"], 2);   
    //$result = $api->enviarIndicadorARevision($_POST["idsiq_indicador"]);    
    //$result = $api->registrarRevisionCalidadIndicador($_POST["idsiq_indicador"], 1,"Probando generar actividad");    
} else {
    $result = $utils->processData($action, $_REQUEST["entity"]);
}

?>
