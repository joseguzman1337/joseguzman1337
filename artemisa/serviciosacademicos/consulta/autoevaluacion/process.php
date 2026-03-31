<?php
// this starts the session 
//session_start();
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
        
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    $today = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO `sala`.`tempEncuestaAutoevaluacion` (`conoceProceso`, `mediosDivulgacion`, 
    `mediosSugeridos`, `fecha_creacion`) VALUES ('".$_REQUEST['conoceProceso']."', 
        '".$_REQUEST["mediosDivulgacion"]."', '".$_REQUEST["otrosMedios"]."', '".$today."')";
    
    $result = $db->Execute($sql);
    
    if($result != 0){ 
        $sql = "INSERT INTO `sala`.`actualizacionusuario` (`usuarioid`, `tipoactualizacion`, `codigoperiodo`, 
            `estadoactualizacion`, `userid`, `entrydate`, `codigoestado`) VALUES 
            ('".$_REQUEST['usuario']."',2,'".$_REQUEST['periodo']."',1,'".$_REQUEST['usuario']."','".$today."',100)";

        $result = $db->Execute($sql);
    }
    if($result != 0){ 
        // Set up associative array
        $data = array('success'=> true,'message'=>'Todo bien');
    } else {
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');
    }
    echo json_encode($data);
?>
