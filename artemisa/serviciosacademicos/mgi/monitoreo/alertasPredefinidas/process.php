<?php

/*
 * Se encarga del procesamiento de datos
 */
include_once("../variables.php");
include($rutaTemplate.'templateProcess.php');

    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ya existe un tipo de alerta con el nombre especificado.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        $data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>
