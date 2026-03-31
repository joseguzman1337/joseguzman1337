<?php

/*
 * Se encarga del procesamiento de datos
 */

include_once("../variables.php");
//include($rutaTemplate.'templateProcess.php');
include ($rutaTemplate.'templateProcessNum.php');
    // Do lots of devilishly clever analysis and processing here...


$funcion = $_POST["funcion"];
//$entity = $_POST["entity"];
//$tipo = $_POST["tipo"];
//$valor = $_POST["valor"];
//var_dump($action);
//var_dump($entity);
//var_dump($tipo);
//var_dump($valor);

 if($funcion == 1){
     
     

     if($result == 0){ 
        
       // var_dump("Ingrese a la  funcion");
       // Set up associative array
        $data = array('success'=> false,'message'=>'Ya existe una funcion para este Indicador.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {
        /*if((strcmp($action,"inactivate")==0)&&(strcmp($_POST["entity"],"aspecto")==0)){
            $id = $_POST["idsiq_aspecto"];
            $result = $utils->inactivateDataJoin("idAspecto", "indicadorGenerico", $id,$db, "indicadorGenerico,indicador","idAspecto,idIndicadorGenerico");
        } */
         // Set up associative array
        $data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
    
 }
?>

