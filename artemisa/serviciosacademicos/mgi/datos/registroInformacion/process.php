<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
 session_start(); 

require_once("../templates/template.php");
$db = getBD();

$utils = new Utils_datos();

$action = $_REQUEST["action"];
        //var_dump($action);

if((strcmp($action,"updateRecordsListings")==0)){
        $_POST["action"] = $_REQUEST["action2"];
        $_POST["idFormulario"] = $_REQUEST["idForm"];
        $sql = "SELECT idsiq_relacionFormularioIndicador FROM siq_relacionFormularioIndicador WHERE idFormulario = '" .$_REQUEST["idForm"]. "' AND idIndicador = '".$_REQUEST["idIndicador"]. "'";
        $row = $db->GetRow($sql);
        var_dump($sql);
        var_dump($row);
    if((strcmp($_REQUEST["action2"],"inactivate")==0)){
        //var_dump($row);
        $result = $utils->processData($_REQUEST["action2"], "relacionFormularioIndicador", $row,false);
    } else {    
        //var_dump($_POST);
        if(count($row)>0){
            $_POST["action"] = "update";
            $row["codigoestado"] = 100;
            $result = $utils->processData("update", "relacionFormularioIndicador", $row,false);
        } else {
            $result = $utils->processData($_REQUEST["action2"], "relacionFormularioIndicador");
        }
    }
    
} else if((strcmp($action,"asociarIndicadores")==0)){
    $result = $utils->processData("update", "formulario");
}

    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        $data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>
