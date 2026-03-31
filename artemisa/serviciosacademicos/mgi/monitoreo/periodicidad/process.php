<?php

/*
 * Se encarga del procesamiento de datos
 */
include_once("../variables.php");
if($_POST["entity"]=="periodicidad"){
    //pasar a 0 los checkbox no elegidos
    if(!isset($_POST["aplica_monitoreo"])){
        $_POST["aplica_monitoreo"] = "0";
    }
    if(!isset($_POST["aplica_alerta"])){
        $_POST["aplica_alerta"] = "0";
    }
    if(!isset($_POST["aplica_autoevaluacion"])){
        $_POST["aplica_autoevaluacion"] = "0";
    }
}

include($rutaTemplate.'templateProcess.php');

    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ya existe una periodicidad con el nombre especificado.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {
        // Set up associative array
        $data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>
