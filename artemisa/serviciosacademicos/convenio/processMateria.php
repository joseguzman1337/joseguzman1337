<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    require_once("../modelos/Materia.php");

$action = $_REQUEST["action"];
$message = null;
if(isset($_REQUEST["action"]) && (strcmp($action,"updateMateria")==0)) {
	$especialidad = new Materia();
		$especialidad->load("codigomateria=?", array($_REQUEST["codigomateria"]));
	$especialidad->tiporotacionid = $_POST['tiporotacion'];
		$especialidad->save();
		$result=true;
		$data = array('success'=> true,'message'=> "La materia se ha modificado de forma correcta.");
} 
    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        if($message===null){
            $data = array('success'=> false,'message'=>'Ha ocurrido un problema con la materia.');
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