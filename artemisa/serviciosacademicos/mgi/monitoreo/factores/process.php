<?php

/*
 * Se encarga del procesamiento de datos
 */
include_once("../variables.php");
include($rutaTemplate.'templateProcess.php');

    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ya existe un factor con el nombre especificado.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {
        if((strcmp($action,"inactivate")==0)&&(strcmp($_POST["entity"],"factor")==0)){
            $id = $_POST["idsiq_factor"];
            $result = $utils->inactivateDataJoin("idFactor", "caracteristica", $id,$db, "caracteristica,aspecto,indicadorGenerico,indicador","idFactor,idCaracteristica,idAspecto,idIndicadorGenerico");
        } 
        // Set up associative array
        $data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>
