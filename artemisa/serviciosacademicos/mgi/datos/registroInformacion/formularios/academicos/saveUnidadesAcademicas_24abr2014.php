<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
 session_start(); 

require_once("../../../templates/template.php");
$db = getBD();
$action = $_REQUEST["action"];

//echo '<pre>';print_r($_REQUEST);die;

$utils = new Utils_datos();
if((strcmp($action,"getData")==0)){
    if(isset($_REQUEST["planEstudio"])){
        $result = $utils->getDataEntityByQuery($_REQUEST["entity"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],"siq_",$_REQUEST["codigocarrera"],$_REQUEST["planEstudio"]);
        
        
    } else {
        $result = $utils->getDataEntityByQuery($_REQUEST["entity"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],"siq_",$_REQUEST["codigocarrera"]);
        
    }
    $result2 = array();
    
    if(isset($_REQUEST["verificar"])){
        $result2 = $utils->getDataEntityByQuery("verificar".$_REQUEST["entity"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],"siq_",$_REQUEST["codigocarrera"],$_REQUEST["planEstudio"]);
        //var_dump($result2);
        
    }
    
    if(count($result)>0){
        $data = array('success'=> true,'data'=>$result,'datav'=>$result2);
        echo json_encode($data);
    } else {
        $data = array('success'=> false);
        echo json_encode($data);
    }
} else if((strcmp($action,"getData2")==0)){
    $result = $utils->getDataFormFields($db,"siq_".$_REQUEST["entity"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],$_REQUEST["codigocarrera"]);
    if(count($result)>0){
        $data = array('success'=> true,'total'=> count($result),'data'=>$result);
        echo json_encode($data);
    } else {
        $data = array('success'=> false);
        echo json_encode($data);
    }
    
}elseif ((strcmp($action,"academicoExtranjeros")==0) || (strcmp($action,"updateAcademicoExtranjeros")==0)){

    $consultaPeriodo = "select idsiq_".$_REQUEST['entity']." from siq_".$_REQUEST['entity']." ep where ep.codigoperiodo = '".$_REQUEST['codigoperiodo']."'";
	
    $resultado = $db->GetRow($consultaPeriodo);
    $arreglo = array("codigoperiodo"=>$_REQUEST['codigoperiodo'],"verificada"=>"0","codigoestado"=>100);
    if (empty($resultado)){
        $result = $utils->processData("save",$_REQUEST['entity'],$arreglo,false);
        $resultado = $db->GetRow($consultaPeriodo);
    }else{
        $actulizarCodigoEstado = "update siq_".$_REQUEST['entity']." ep set ep.codigoestado=100 where ep.codigoperiodo =".$_REQUEST['codigoperiodo'];
    }
	//print_r($resultado);
    $eliminarPais = "update siq_detalle".$_REQUEST['entity']." dep set codigoestado = 200 where dep.idData =".$resultado['idsiq_'.$_REQUEST['entity']];
	$db->Execute($eliminarPais);
	
    $consultaDetalle = "select idCategory,idsiq_detalle".$_REQUEST['entity']." from siq_detalle".$_REQUEST['entity']." where idData = ".$resultado['idsiq_'.$_REQUEST['entity']];
    $resultadoConsultaDetalle = $db->GetAll($consultaDetalle);
	
	//guardar datos por pais
    $ids = array();
    foreach ($_REQUEST['idPais'] as $key => $value) {
		$encontrado = false;
		$id = -1;
        foreach ($resultadoConsultaDetalle as $llave => $valor) {
            if ($value == $valor['idCategory']){
                $encontrado = true;
				$id = $valor['idsiq_detalle'.$_REQUEST['entity']];
            }
        }
	
		if($encontrado){
			$arreglo = array("idsiq_detalle".$_REQUEST['entity']=>$id,"valor"=>$_REQUEST['valor'][$key],"codigoestado"=>100);
			$result = $utils->processData("update","detalle".$_REQUEST['entity'],$arreglo,false);
		} else {
			$arreglo = array("idData"=>$resultado['idsiq_'.$_REQUEST['entity']],"idCategory"=>$value,"valor"=>$_REQUEST['valor'][$key],"codigoestado"=>100,"verificada"=>"0");
			$result = $utils->processData("save","detalle".$_REQUEST['entity'],$arreglo,false);
		}
        $ids[$i] = $result;
    }
	
	if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de guardar los datos.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        $data = array('success'=> true,'total'=> count($ids),'data'=> $ids);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
}else if((strcmp($action,"save2")==0) || (strcmp($action,"update2")==0)){
    $_POST["action"] = str_replace("2", "", $_REQUEST["action"]);
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
    //echo $num;
    for ($i = 0; $i < $num; $i++) {
        foreach ($arreglos as $key => $value)  {
            $fields[$key] = $value[$i];
        }
        $fields["entity"] = $_REQUEST["entity"];
        
        //var_dump($fields);
        //var_dump($fields["idsiq_".$_REQUEST["entity"]]);
        if($fields["idsiq_".$_REQUEST["entity"]]!==""){
            $result = $utils->processData($_POST["action"],$_REQUEST["entity"],$fields,false);
        } else {
            $result = $utils->processData("save",$_REQUEST["entity"],$fields,false);
        }
        $ids[$i] = $result;
    }
    
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de guardar los datos.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        $data = array('success'=> true,'total'=> count($ids),'data'=> $ids);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
} else if((strcmp($action,"getDataDynamic")==0)){
    $result = $utils->getDataFormFieldsByJoin($db,"siq_".$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"]);

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
        $result = $utils->processData($_POST["action"],$_REQUEST["entity"],$fields,false);
        $ids[$i] = $result;
    }
    
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        $data = array('success'=> true,'total'=> count($ids),'data'=> $ids);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
} else if((strcmp($action,"getDataDynamic2")==0)){
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
    
} else if((strcmp($action,"getDataDynamicConsolidada")==0)){
    if(!isset($_REQUEST["joinField"])){
        $result = $utils->getDataDynamicConsolidada($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],
		$_REQUEST["periodo2"],$_REQUEST["tipo"],$_REQUEST["formato"],$_REQUEST["funcion"],$_REQUEST["idFormulario"], $_REQUEST["pestana"],
		"",$_REQUEST["codigocarrera"],null,$_REQUEST["order"]);
    } else {
        $result = $utils->getDataDynamicConsolidada($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],
		$_REQUEST["periodo"],$_REQUEST["periodo2"],$_REQUEST["tipo"],$_REQUEST["formato"],$_REQUEST["funcion"],$_REQUEST["idFormulario"], $_REQUEST["pestana"],
		$_REQUEST["joinField"],$_REQUEST["codigocarrera"]);
    }
    
    if(count($result)>0){
        $data = array('success'=> true,'total'=> count($result["data"]),'data'=>$result["data"],
		'message'=>$result["id"],'infoPeriodos'=>$result["infoPeriodos"],'infoAdjuntos'=>$result["infoAdjuntos"]);
        echo json_encode($data);
    } else {
        $data = array('success'=> false);
        echo json_encode($data);
    }
    
} else if((strcmp($action,"getDataConsolidada")==0)){
    $result = $utils->getDataConsolidada($db,$_REQUEST["entity"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],"siq_",$_REQUEST["codigocarrera"],$_REQUEST["planEstudio"],
		$_REQUEST["periodo2"],$_REQUEST["tipo"],$_REQUEST["formato"],$_REQUEST["funcion"],$_REQUEST["idFormulario"], $_REQUEST["pestana"],$_REQUEST["order"]);        
    
    if(count($result)>0){
        $data = array('success'=> true,'total'=> count($result["data"]),'data'=>$result["data"],
		'infoPeriodos'=>$result["infoPeriodos"],'infoAdjuntos'=>$result["infoAdjuntos"]);
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
    $sql = "UPDATE siq_detalleformUnidadesAcademicasProyectosGruposInteres SET `codigoestado`=200 
        WHERE idData='".$id."'";
    $db->Execute($sql);
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
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');
    } else {        
        // Set up associative array
        $data = array('success'=> true,'message'=>$id,'total'=> count($ids),'data'=> $ids,'dataCat'=> $idsCat);
    }
    
    // JSON encode and send back to the server
   echo json_encode($data);
} else if((strcmp($action,"getDataByDate")==0)){
    $result = $utils->getDataFormFieldsByDate($db,"siq_".$_REQUEST["entity"],$_REQUEST["campoFecha"],$_REQUEST["periodo"],$_REQUEST["codigocarrera"],$_REQUEST["tipo"]);
    if(count($result)>0){
        $data = array('success'=> true,'total'=> count($result),'data'=>$result);
        echo json_encode($data);
    } else {
        $data = array('success'=> false);
        echo json_encode($data);
    }
    
} else if((strcmp($action,"inactivateEntity")==0)) {
   $_REQUEST["idsiq_".$_REQUEST["entity"]] = $_REQUEST["id"];
    $result = $utils->processData("inactivate",$_REQUEST["entity"],$_REQUEST);

    // Do lots of devilishly clever analysis and processing here...
    
    if($result == 0 ){ 
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
} else {
   
    $result = $utils->processData($_REQUEST["action"],$_REQUEST["entity"],$_REQUEST);
    
    if(isset($_REQUEST["verificar"])){
        $data = $utils->getDataEntityByQuery("verificar".$_REQUEST["entity"],"codigoperiodo",$_REQUEST["codigoperiodo"],"siq_",$_REQUEST["codigocarrera"],$_REQUEST["planEstudio"]);
        //$data = $utils->getDataEntity("verificar".$_REQUEST["entity"],$_REQUEST["codigoperiodo"],"siq_","codigoperiodo");
        //var_dump($data); die;
        $_POST["idsiq_verificar".$_REQUEST["entity"]]=$data["idsiq_verificar".$_REQUEST["entity"]];
        $result = $utils->processData($_REQUEST["action"],"verificar".$_REQUEST["entity"],$_REQUEST);
    }

    // Do lots of devilishly clever analysis and processing here...
    
    if($result == 0 ){ 
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
}
?>
