<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$utils = Utils::getInstance();

$action = $_REQUEST["action"];

if((strcmp($action,"save")==0)||(strcmp($action,"update")==0)){
        $city = $_REQUEST["idciudadresidencia"];
        if((strcmp($city,"null")==0)||$city==null){
            //crear ciudad y poner a $_POST el id
            $fields = array();
            $fields["nombrecortociudad"] = $_REQUEST["tmp_ciudad"];
            $fields["nombreciudad"] = $_REQUEST["tmp_ciudad"];
            //extranjero
            $fields["iddepartamento"] = 216;
            $fields["codigosapciudad"] = "0";
            $fields["codigoestado"] = "100";
            $result = $utils->processData("save","ciudad","idciudad",$fields,false);
            
            $_POST["idciudadresidencia"] = $result;
        }
        
        $result = $utils->processData($_REQUEST["action"],"docenteEducacionContinuada","iddocenteEducacionContinuada");        
           
	$data = array('success'=> true,'message'=> "Se ha guardado la información del docente de forma correcta.");
} else {
	$result = $utils->processData($_REQUEST["action"],"docenteEducacionContinuada","iddocenteEducacionContinuada");
	$data = array('success'=> true,'message'=> "Se ha guardado la información del docente de forma correcta.");
 } 

    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        //$data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>
