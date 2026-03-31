<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
 //session_start(); 
 
 //error_reporting(E_ALL);
//ini_set('display_errors', '0');

require_once("../../../templates/template.php");
$db = getBD();
$action = $_REQUEST["action"];
$utils = new Utils_datos();

//echo '<pre>';print_r($_REQUEST);

$Retornar = array();

if((strcmp($action,"getData_Academico")==0)){
    $Data = $utils->getDataFormCategoryDynamic($db,"formTalentoHumanoAcademicosExtranjerosFacultad","codigoperiodo","facultad","nombrefacultad",false);
    $nump=count($Data['dataPeriodos']);
    $control=false;
    for ($i=0; $i < $nump; $i++) {//for..1 
        $periodoData=$Data['dataPeriodos'][$i]['periodo'];
        //echo '<br>'.$_REQUEST["periodo"].'=='.$periodoData;
        if ($_REQUEST["periodo"]==$periodoData) {
            $numA=count($Data['actividades']);
            for ($j=0; $j < $numA; $j++) {//for..2
                $actividades = $Data['actividades'][$j]['codigofacultad'];
                $Resultado = $utils->getValorDynamic($db,"formTalentoHumanoAcademicosExtranjerosFacultad","codigoperiodo","facultad",$periodoData,$actividades,"codigofacultad","nombrefacultad");
                if(!$Resultado['valor']){$Valor = 0;}else{$Valor = $Resultado['valor'];}
                $Retornar['Num'][]     = $Valor;
                $Retornar['Nombre'][]  = $Data['actividades'][$j]['nombrefacultad'];
                $control = true;
            }//for..2
        }//if
    }//for..1
        $a_vectt['success']     = $control;
        $a_vectt['Datos']   = $Retornar;
        //echo '<pre>';print_r($a_vectt);
        echo json_encode($a_vectt);
        exit;
}else if((strcmp($action,"getData")==0)){ 
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
		$actionF = $_POST["action"];
		if($fields["idsiq_".$_REQUEST["entity"]]==null || $fields["idsiq_".$_REQUEST["entity"]]==""){
			$actionF = "save";
		}
        //echo '<pre>';print_r($fields);
		//$sql = "select * from siq_detalle".$_REQUEST["entity"]." where ";
       
        $result = $utils->processData($actionF,$_REQUEST["entity"],$fields,false);
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
       $result = $utils->getDataFormDynamic2($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],$_REQUEST["joinField"],null,$_REQUEST['actividad'],$_REQUEST["order"]);
    }else if(!isset($_REQUEST["joinField"])){
        $result = $utils->getDataFormDynamic2($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],"",null,null,$_REQUEST["order"]);
    } else {
        $result = $utils->getDataFormDynamic2($db,$_REQUEST["entity"],$_REQUEST["entityJoin"],$_REQUEST["campoPeriodo"],$_REQUEST["periodo"],$_REQUEST["joinField"],null,null,$_REQUEST["order"]);
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
	//var_dump($id);
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
		$actionF = $_POST["action"];
		if($fields["idsiq_detalle".$_REQUEST["entity"]]==null || $fields["idsiq_detalle".$_REQUEST["entity"]]==""){
			$actionF = "save";
		}
        //echo "<br/><br/><pre>";print_r($fields);
        $result = $utils->processData($actionF,$fields["entity"],$fields,false);
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
}  else if((strcmp($action,"Semilleros")==0)){
		$year = $_REQUEST["anio"];
		$carreras = $_REQUEST["carrera"];
		$currentdate  = date("Y-m-d H:i:s");
		foreach($carreras as $carrera){
			$sql = 'SELECT * FROM semillerosinvestigacion WHERE carrera_id ='.$carrera.' AND periosidaanual = "'.$year.'" AND codigoestado=100';
			$resultRow = $db->GetRow($sql);
			if(count($resultRow)>0){
				//toca hacer update
				$sql = "UPDATE `semillerosinvestigacion` SET `num_semillero`='".$_REQUEST["Semillero_num_".$carrera]."' WHERE (`semillerosinvestigacion_id`='".$resultRow["semillerosinvestigacion_id"]."')";
			} else {
				//toca insertar
				$sql = "INSERT INTO `semillerosinvestigacion` (`carrera_id`, `num_semillero`, `periosidaanual`, `entrydate`, `userid`) VALUES 
						('".$carrera."', '".$_REQUEST["Semillero_num_".$carrera]."', '".$year."', '".$currentdate."', '4186')";
			}
			$db->Execute($sql);
			
			$sql = 'SELECT * FROM verificar_semillerosinvestigacion WHERE codigocarrera ='.$carrera.' AND codigoperiodo = "'.$year.'" AND codigoestado=100';
            $resultRowVerificar = $db->GetRow($sql);
			$validar = 0;
			if(isset($_REQUEST["vSemillero_num_".$carrera])){
				$validar = $_REQUEST["vSemillero_num_".$carrera];
			}
			if(count($resultRowVerificar)>0){
				//toca hacer update
				$sql = "UPDATE `verificar_semillerosinvestigacion` SET `vnum_semillero`='".$validar."' WHERE (`idverificar_semillerosinvestigacion`='".$resultRowVerificar["idverificar_semillerosinvestigacion"]."')";
			} else {
				//toca insertar
				$sql = "INSERT INTO `verificar_semillerosinvestigacion` (`codigoperiodo`, `codigocarrera`, `vnum_semillero`, `fecha_creacion`, `usuario_creacion`, `codigoestado`, `fecha_modificacion`, `usuario_modificacion`) 
						VALUES ('".$year."','".$carrera."', '".$validar."', '".$currentdate."', '4186', '100', '".$currentdate."', '4186')";
			}
			$db->Execute($sql);
			
		}

		$data = array('success'=> true,'message'=> "se han guardado los datos de forma correcta.");

        // JSON encode and send back to the server
        echo json_encode($data);

}  else if((strcmp($action,"getDataInvestigaciones")==0)){
		$year = $_REQUEST["periodo"];
		$tabla = $_REQUEST["entity"];
		$tabla2 = $_REQUEST["entityVerificar"];
		$campoPeriodo = $_REQUEST["campoPeriodo"];
		$sql = "SELECT * from ".$tabla." WHERE ".$campoPeriodo."='".$year."' AND codigoestado=100";
		$dataNum = $db->GetAll($sql);
		$sql = "SELECT * from ".$tabla2." WHERE codigoperiodo='".$year."' AND codigoestado=100";
		$dataVerificar = $db->GetAll($sql);
		
		$data = array('success'=> true,'total'=>count($dataNum ),'dataNum'=>$dataNum,'dataVerificar'=>$dataVerificar);

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
