<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
 session_start(); 

require_once("../templates/template.php");
$db = getBD();

$utils = new Utils_datos();
//$api = new API_Monitoreo();

$action = $_REQUEST["action"];

if((strcmp($action,"updateRecordsListings")==0)){
        $_POST["action"] = $_REQUEST["action2"];
        $sql = "SELECT idsiq_relacionReporteIndicador FROM siq_relacionReporteIndicador WHERE idReporte = '" .$_REQUEST["idReporte"]. "' AND idIndicador = '".$_REQUEST["idIndicador"]. "'";
        $row = $db->GetRow($sql);
    if((strcmp($_REQUEST["action2"],"inactivate")==0)){
        //var_dump($row);
        $result = $utils->processData($_REQUEST["action2"], "relacionReporteIndicador", $row,false);
    } else {    
        //var_dump($_POST);
        if(count($row)>0){
            $_POST["action"] = "update";
            $row["codigoestado"] = 100;
            $result = $utils->processData("update", "relacionReporteIndicador", $row,false);
        } else {
            $result = $utils->processData($_REQUEST["action2"], "relacionReporteIndicador");
        }
    }
    
} else if((strcmp($action,"inactivate")!=0)&&intval($_REQUEST["estado_definicion_reporte"])==1&&(strcmp($_REQUEST["entity"],"reporte")==0)){

    if($_POST["periodoFecha"] == ""){
        $_POST["periodoFecha"] = "NULL";
    } else {
        $_POST["fecha_final"] = "NULL";
        $_POST["fecha_inicial"] = "NULL";
    }
    if($_POST["fecha_inicial"] == ""){
        $_POST["fecha_inicial"] = "NULL";
    }
    if($_POST["fecha_final"] == ""){
        $_POST["fecha_final"] = "NULL";
    }
    $result = $utils->processData($action, $_POST["entity"]);
    
} /*else if((strcmp($action,"inactivate")!=0)&&intval($_REQUEST["estado_definicion_reporte"])==2&&(strcmp($_REQUEST["entity"],"reporte")==0)){
    $col = $utils->UltimaColumnaReporte($db, $_POST["idsiq_reporte"]);
    $numP = intval($_POST["columnas"]); 
    $_POST["estado_definicion_reporte"] = 3;
    
    if($numP>0 && $col>0){
        $action = "update";
        $result = $utils->processData($action, $_POST["entity"]);
        
        if($col>$numP){
            $utils->inactivateColumns($db, $_POST["idsiq_reporte"], $numP);
        }
    } else {
        $result = "no puede pasar";
    }
    
    
} else if((strcmp($action,"inactivate")!=0)&&intval($_REQUEST["estado_definicion_reporte"])==3&&(strcmp($_REQUEST["entity"],"reporte")==0)){
    $_POST["estado_definicion_reporte"] = 4;
    if($_POST["periodoFecha"] == ""){
        $_POST["periodoFecha"] = "NULL";
    } else {
        $_POST["fecha_final"] = "NULL";
        $_POST["fecha_inicial"] = "NULL";
    }
    if($_POST["fecha_inicial"] == ""){
        $_POST["fecha_inicial"] = "NULL";
    }
    if($_POST["fecha_final"] == ""){
        $_POST["fecha_final"] = "NULL";
    }
    $result = $utils->processData($action, $_POST["entity"]);
    
}*/else if((strcmp($action,"inactivate")!=0)&&intval($_REQUEST["estado_definicion_reporte"])==4&&(strcmp($_REQUEST["entity"],"reporte")==0)){

    $result = 1;
    
} else if((strcmp($action,"inactivate")!=0)&&intval($_REQUEST["estado_definicion_reporte"])==5&&(strcmp($_REQUEST["entity"],"reporte")==0)){

    $_POST["estado_definicion_reporte"] = 4;
    $result = $utils->processData($action, $_POST["entity"]);
    
} else if((strcmp($action,"inactivate")==0)&&(strcmp($_POST["entity"],"reporte")==0)){
    $result = $utils->processData($action, $_POST["entity"]);
} else if((strcmp($action,"save")==0)&&(strcmp($_POST["entity"],"detalleReporte")==0)){
    $fields = array();
    $result = $utils->processData($action, $_POST["entity"]);
    
    $filtro = $_POST["filtro"];
    $pieces = explode(".", $filtro);
    $num = count($pieces);
    $filtro = "";
    
    for($i=0; $i < $num; $i++){
        if($filtro == ""){
           $filtro = $pieces[$i]; 
        } else {
            $filtro = $filtro."_".$pieces[$i]; 
        }
        
        if(isset($_POST[$filtro])&& $_POST[$filtro]!=""){
            $fields["filtro"] = str_replace("_", ".", $filtro);
            $fields["valor"] = $_POST[$filtro];
            $fields["idDetalleReporte"] = $result;
            $fields["entity"] = "filtroDetalleReporte";
            $utils->processData("save", $fields["entity"],$fields,false);
        }
    }
    
} else if((strcmp($action,"update")==0)&&(strcmp($_POST["entity"],"detalleReporte")==0)){
    $fields = array();
    $result = $utils->processData($action, $_POST["entity"]);
    
    $filtro = $_POST["filtro"];
    $pieces = explode(".", $filtro);
    $num = count($pieces);
    $filtro = "";
    
    $utils->inactivateAllFilters($db, $_POST["idsiq_detalleReporte"]);
    for($i=0; $i < $num; $i++){
        if($filtro == ""){
           $filtro = $pieces[$i]; 
        } else {
            $filtro = $filtro."_".$pieces[$i]; 
        }
        
        if(isset($_POST[$filtro])&& $_POST[$filtro]!=""){
            $fields["filtro"] = str_replace("_", ".", $filtro);
            $fields["valor"] = $_POST[$filtro];
            $fields["idDetalleReporte"] = $result;
            $fields["codigoestado"] = 100;
            $fields["entity"] = "filtroDetalleReporte";
            $filter = $utils->getFilterReporte($db, $_POST["idsiq_detalleReporte"], $fields["filtro"]);
            
            if(count($filter)>0){
                $fields["idsiq_filtroDetalleReporte"] = $filter["idsiq_filtroDetalleReporte"];
                $utils->processData("update", $fields["entity"],$fields,false);
            } else {
                $utils->processData("save", $fields["entity"],$fields,false);
            }
        }
    }
    
} else if((strcmp($_POST["entity"],"categoriasExcluidas")==0)){
    $fields = array();
    
    $fields["idDetalleReporte"] = $_POST["idDetalleReporte"];
    if(strcmp($action,"update")==0){
        $fields["idsiq_categoriasExcluidas"] = $_POST["idsiq_categoriasExcluidas"];
    }
    
    $categorias = $_POST["categorias"];
    $num = count($categorias);
    $filtro = "";
    
    for($i=0; $i < $num; $i++){
        if($filtro == ""){
           $filtro = $categorias[$i]; 
        } else {
            $filtro = $filtro.";".$categorias[$i]; 
        }        
    }
    
    if($num>0){
        $fields["categoriasExcluidas"] = $filtro;
        $result = $utils->processData($action, $_POST["entity"],$fields,false);        
    } else if(strcmp($action,"update")==0){
        $fields["categoriasExcluidas"] = " ";
        //var_dump($fields);
        $result = $utils->processData($action, $_POST["entity"],$fields,false);      
        $result = $utils->processData("inactivate", $_POST["entity"],$fields,false);      
    }
    
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
