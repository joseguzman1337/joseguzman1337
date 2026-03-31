<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
 session_start(); 

require_once("../../../templates/template.php");
$db = getBD();
$action = $_REQUEST["action"];
$utils = new Utils_datos();
if((strcmp($action,"getData")==0)){
    $result = $utils->getDataEntityByQuery($_REQUEST["entity"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"]);
    $result2 = array();
    
    if(isset($_REQUEST["verificar"])){
        $result2 = $utils->getDataEntityByQuery("verificar".$_REQUEST["entity"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"]);
    }
    
    if(count($result)>0){
        $data = array('success'=> true,'data'=>$result,'datav'=>$result2);
        echo json_encode($data);
    } else {
        $data = array('success'=> false);
        echo json_encode($data);
    }
} else if((strcmp($action,"getDataDynamic")==0)){
    $order = "";
    if(isset($_REQUEST["order"])){
        $order = $_REQUEST["order"];
    }
    $result = $utils->getDataFormFieldsByJoin($db,"siq_".$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],$order);
    if(count($result)>0){
        $data = array('success'=> true,'total'=> count($result),'data'=>$result);
        echo json_encode($data);
    } else {
        $data = array('success'=> false);
        echo json_encode($data);
    }
    
} else if((strcmp($action,"saveDynamic")==0) || (strcmp($action,"updateDynamic")==0)){
    $_POST["action"] = str_replace("Dynamic", "", $_REQUEST["action"]);
    $num = 0;
    $arreglos = array();
    $fields = array();
    $ids = array();
    foreach ($_REQUEST as $key => $value)  {
                if (strcmp($key,"action") == 0 || strcmp($key,"entity") == 0) {
                } else if(is_array($_REQUEST[$key])){ 
                        $arreglos[$key] = $value;
                        $num = count($_REQUEST[$key]);
                } else {
                    $fields[$key] = $value;
                }
    }
    
    for ($i = 0; $i < $num; $i++) {
        foreach ($arreglos as $key => $value)  {
            $fields[$key] = $value[$i];
        }
        $fields["entity"] = $_REQUEST["entity"];
        //var_dump($fields);
        $result = $utils->processData($_POST["action"],$_REQUEST["entity"],$fields,false);
        $ids[$i] = $result;
    }
    
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else if($result == -7){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'La información ya se encuentra validad por lo que no se pueden guardar nuevos datos para este periodo.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        $data = array('success'=> true,'total'=> count($ids),'data'=> $ids);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
} else if((strcmp($action,"getDataDynamic2")==0)){
   
    if (!empty($_REQUEST['actividad'])){
       $result = $utils->getDataFormDynamic2($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],$_REQUEST["joinField"],null,$_REQUEST['actividad']);
    }else if(!isset($_REQUEST["joinField"])){
        $result = $utils->getDataFormDynamic2($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"]);
    } else {
        $result = $utils->getDataFormDynamic2($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],$_REQUEST["joinField"]);
    }
    //var_dump($result);
    if(count($result["data"])>0){
        $data = array('success'=> true,'total'=> count($result["data"]),'data'=>$result["data"],'message'=>$result["id"]);
        echo json_encode($data);
    } else {
        $data = array('success'=> false);
        echo json_encode($data);
    }
    
} else if((strcmp($action,"saveDynamic2")==0) || (strcmp($action,"updateDynamic2")==0)){
    $_POST["action"] = str_replace("Dynamic2", "", $_REQUEST["action"]);
    //primero el registro del periodo
    $result = $utils->processData($_POST["action"],$_REQUEST["entity"],$_REQUEST);
    $id = $result;
    //ahora el detalle de los valores de ese periodo    
    $num = 0;
    $arreglos = array();
    $fields = array();
    $ids = array();
    foreach ($_REQUEST as $key => $value)  {
                if (strcmp($key,"action") == 0 || strcmp($key,"entity") == 0) {
                } else if(is_array($_REQUEST[$key])){ 
                        $arreglos[$key] = $value;
                        if($num==0){
                            $num = count($_REQUEST[$key]);
                        }
                } else {
                    $fields[$key] = $value;
                }
    }

    for ($i = 0; $i < $num; $i++) {
        foreach ($arreglos as $key => $value)  {
            $fields[$key] = $value[$i];
        }
        $fields["idData"]=$id;
        $fields["entity"] = "detalle".$_REQUEST["entity"];
        //echo "<br/><br/><pre>";print_r($fields);
        $result = $utils->processData($_POST["action"],$fields["entity"],$fields,false);
        $ids[$i] = $result;
        $idsCat[$i] = $fields["idCategory"];
    }
    
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');
    }else if($result == -7){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'La información ya se encuentra validad por lo que no se pueden guardar nuevos datos para este periodo.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        $data = array('success'=> true,'message'=>$id,'total'=> count($ids),'data'=> $ids,'dataCat'=> $idsCat);
    }
    
    // JSON encode and send back to the server
   echo json_encode($data);
} else {

    $result = $utils->processData($_REQUEST["action"],$_REQUEST["entity"],$_REQUEST);
    
    if(isset($_REQUEST["verificar"])){
        $data = $utils->getDataEntity("verificar".$_REQUEST["entity"],$_REQUEST["codigoperiodo"],"siq_","codigoperiodo");
        $_POST["idsiq_verificar".$_REQUEST["entity"]]=$data["idsiq_verificar".$_REQUEST["entity"]];
        $result = $utils->processData($_REQUEST["action"],"verificar".$_REQUEST["entity"],$_REQUEST);
    }

    // Do lots of devilishly clever analysis and processing here...
    
    if($result == 0 ){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');

        // JSON encode and send back to the server
        echo json_encode($data);
    }else if($result == -7){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'La información ya se encuentra validad por lo que no se pueden guardar nuevos datos para este periodo.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        $data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
}
?>
