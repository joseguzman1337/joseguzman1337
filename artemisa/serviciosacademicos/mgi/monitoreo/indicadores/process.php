<?php 

/*
 * Se encarga del procesamiento de datos
 */
include_once("../variables.php");
if(isset($_POST["idPeriodicidad"])&&$_POST["idPeriodicidad"]==""&&$_POST["action"]=="update"){
    $_POST["idPeriodicidad"] = 0;
    $_POST["dia_predefinido"] = 0;
} 

if(isset($_POST["idPeriodicidad"])&&$_POST["idPeriodicidad"]!=""){
    $choosenDate = explode("-", $_POST["fecha_prox_monitoreo"]);
    $_POST["dia_predefinido"] = $choosenDate[2];
}
include($rutaTemplate.'templateProcess.php');

$message = 'Ya existe un indicador con el nombre especificado.';

if(isset($_POST["entity2"])&&(strcmp($_POST["entity2"],"relacionIndicadorMonitoreo")==0)){
    $api = new API_Monitoreo();
    $monitoreo = $_POST["idsiq_monitoreo"];
    $action = $_POST["action2"];
    
    if($result!=NULL&&$result!=0){
        $_POST["idMonitoreo"] = $result;
        $monitoreo = $result;
    }
    $result = $utils->processData($action, $_POST["entity2"]);
        
    //Debe inactivar las actividades que no esten actualizadas a excepción de la activa que le cambia la fecha limite
    $api->generarActividadesActualizacionIndicador($monitoreo);
    
    $fields["fecha_proximo_vencimiento"] = $_POST["fecha_prox_monitoreo"];
    $fields["idsiq_indicador"] = $_POST["idIndicador"];
    $result = $utils->processData("update", "indicador", $fields);    
} else if(isset($_POST["action2"])&&(strcmp($_POST["action2"],"asignarAlerta")==0)){
        //Asignar alertas a indicadores
        $fields = array();

        $action = "save";
        $_POST["action"] = "save";
        
        //$fields["idIndicador"] = $indicadores[$i];            
        $fields["tipo"] = 1;
        $fields["idTipoAlerta"] = $_POST["idAlerta"];
        $fields["idPeriodicidad"] = $_POST["idPeriodicidad"];
        if(!isset($_POST["indicadores"])){
                $fields["idMonitoreo"]= $_POST["idsiq_monitoreo"];
        }
        $result = $utils->processData($action, "alertaPeriodica",$fields,false);
        
        $message = 'No se asignó la alerta de forma correcta.';
    } else if(isset($_POST["action2"])&&(strcmp($_POST["action2"],"editarAlerta")==0)){
        //Asignar alertas a indicadores
        $fields = array();

        $action = "update";
        $_POST["action"] = "update";
        
        //$fields["idIndicador"] = $indicadores[$i];            
        $fields["tipo"] = 1;
        $fields["idTipoAlerta"] = $_POST["idAlerta"];
        $fields["idsiq_alertaPeriodica"] = $_POST["idsiq_alertaPeriodica"];
        $fields["idPeriodicidad"] = $_POST["idPeriodicidad"];
        $fields["fecha_prox_alerta"] = "0000-00-00";
        $result = $utils->processData($action, "alertaPeriodica",$fields,false);
        
        $message = 'No se asignó la alerta de forma correcta.';
    }
    
    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        if(strcmp($_POST["entity"],"tipoOrientacion")==0){
            $message = 'Ya existe un tipo de orientación con el nombre especificado.';            
        }
        $data = array('success'=> false,'message'=>$message);

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {
        // Set up associative array
        $data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>
