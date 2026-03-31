<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    require_once("../modelos/rotaciones/EspecialidadCarrera.php");

    $action = $_REQUEST["action"];
    $message = null;
    if(isset($_REQUEST["action"]) && (strcmp($action,"saveEspecialidad")==0)){
            $now = date('Y-m-d H-i-s');
    		
    		$sql = "SELECT idusuario FROM usuario WHERE usuario = ?";
    		$stmt = $db->Prepare($sql);
    		$usuario = $db->GetRow($stmt,array($_SESSION['MM_Username'])); 
    		
    		$especialidad = new especialidadCarrera();
    		//var_dump($especialidad->getAttributeNames());
            $especialidad->especialidad = $_POST['especialidad'];
    		$especialidad->codigocarrera  = $_POST['codigocarrera'];
    		$especialidad->codigoestado  = 100;
    		$especialidad->fechacreacion  = date('Y-m-d');
    		$especialidad->usuariocreacion  = $usuario["idusuario"];
    		$especialidad->fechamodificacion  = date('Y-m-d');
    		$especialidad->usuariomodificacion  = $usuario["idusuario"];
    		$especialidad->save();
    		$result=true;
    		$data = array('success'=> true,'message'=> "La especialidad se ha creado correctamente.");
    } else if(isset($_REQUEST["action"]) && (strcmp($action,"updateEspecialidad")==0)) {
    	$especialidad = new especialidadCarrera();
    		$especialidad->load("EspecialidadCarreraId=?", array($_REQUEST["EspecialidadCarreraId"]));
    	$especialidad->especialidad = $_POST['especialidad'];
    		$especialidad->save();
    		$result=true;
    		$data = array('success'=> true,'message'=> "La especialidad se ha modificado correctamente.");
    } else if(isset($_REQUEST["action"]) && (strcmp($action,"inactivateEspecialidad")==0)) {
    	$especialidad = new especialidadCarrera();
    		$especialidad->load("EspecialidadCarreraId=?", array($_REQUEST["id"]));
    	$especialidad->codigoestado = 200;
    		$especialidad->save();
    		$result=true;
    		$data = array('success'=> true,'message'=> "La especialidad se ha modificado correctamente.");
    }
        // Do lots of devilishly clever analysis and processing here...
        if($result == 0){ 
            // Set up associative array
            if($message===null){
                $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear la especialidad.');
            } else {
                $data = array('success'=> false,'message'=>$message);
            }
    
            // JSON encode and send back to the server
            echo json_encode($data);
        } else {        
            // Set up associative array
            //$data = array('success'=> true,'message'=> $result);
    
            // JSON encode and send back to the server
            echo json_encode($data);
        }
    
?>