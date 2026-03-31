<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
include_once ('../EspacioFisico/templates/template.php');
$db = getBD();

$action = $_REQUEST["action"];
$message = null;
if(isset($_REQUEST["action"]) && (strcmp($action,"inactivateCarrera")==0)){
        $now = date('Y-m-d H-i-s');
		
        $sql = "UPDATE conveniocarrera SET codigoestado = 200 WHERE idconveniocarrera = '" .$_REQUEST["id"]. "'";
        $result = $db->Execute($sql);
   
		$data = array('success'=> true,'message'=> "El programa se ha eliminado correctamente.");
} 
    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        if($message===null){
            $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el curso.');
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