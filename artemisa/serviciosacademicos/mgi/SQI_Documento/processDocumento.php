<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
        session_start();
	    require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		
switch($_REQUEST['action']){
	case 'editarDocumento':{
	$SQL_VF="UPDATE `siq_archivo_documento` 
				SET `descripcion`='".$_REQUEST['descripcion']."' 
				WHERE (`idsiq_archivodocumento`='".$_REQUEST['archivo_id']."')";
	$db->Execute($SQL_VF);
	header("Location: ".$_REQUEST['url']);
	die();
	
		}break;
	default:{
		$data = array('success'=> false,'message'=>'Ha ocurrido un problema.');

        // JSON encode and send back to the server
        echo json_encode($data);
		
		}break;
	}
?>