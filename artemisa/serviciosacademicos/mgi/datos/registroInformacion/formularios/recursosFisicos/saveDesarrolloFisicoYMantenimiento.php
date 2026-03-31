<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $action = $_REQUEST["action"];
    
if((strcmp($action,"getDataDynamic2")==0)){
    if(!isset($_REQUEST["joinField"])){
        $result = $utils->getDataFormDynamic2($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],"",$_REQUEST["codigocarrera"]);
    } else {
        $result = $utils->getDataFormDynamic2($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],$_REQUEST["joinField"],$_REQUEST["codigocarrera"]);
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
                        $num = count($_REQUEST[$key]);
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
        $result = $utils->processData($_POST["action"],$fields["entity"],$fields,false);
        $ids[$i] = $result;
        $idsCat[$i] = $fields["idCategory"];
    }
    
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de guardar los datos.');
    } else {        
        // Set up associative array
        $data = array('success'=> true,'message'=>$id,'total'=> count($ids),'data'=> $ids,'dataCat'=> $idsCat);
    }
    
    // JSON encode and send back to the server
   echo json_encode($data);
}
?>
