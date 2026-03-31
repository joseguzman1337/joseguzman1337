<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    require_once("NotificacionConvenio.php");
    //echo '<pre>';print_r($_SESSION);die;

    include_once ('../EspacioFisico/templates/template.php');
    include_once ('NotificacionConvenio.php');
    $db = getBD();   
    $SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

    if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>'.$SQL_User;
		die;
	}
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
         return $cadena;
    }

 $userid=$Usario_id->fields['id'];  
//echo '<pre>';print_r($_REQUEST['actionID']);
switch($_REQUEST['actionID']){
    case 'CambiarEstadoProceso':{
        $id    = $_POST['id'];
        $valor = $_POST['valor'];
        $institucion = $_POST['institucion'];
        
        $id = limpiarCadena(filter_var($id,FILTER_SANITIZE_NUMBER_INT));
        $valor = limpiarCadena(filter_var($valor,FILTER_SANITIZE_NUMBER_INT));
        $institucion = limpiarCadena(filter_var($institucion,FILTER_SANITIZE_NUMBER_INT));
        
        $SQl='UPDATE SolicitudConvenios SET  ConvenioProcesoId ="'.$valor.'", UsuarioModificacion ="'.$userid.'", FechaModificacion =NOW() WHERE SolicitudConvenioId ="'.$id.'"  AND CodigoEstado = 100';
                         
        if($CambioProceso=&$db->Execute($SQl)===false){
                $a_vectt['val']			  =false;
                $a_vectt['descrip']		  ='Error del Sistema....';
                echo json_encode($a_vectt);
                exit; 
        }
        $fecha = date('Y-m-d H-i-s');
        $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$id."', '".$valor."', '".$userid."', '".$fecha."')";
        //echo $logCambios;
        $insertar4= $db->execute($logCambios);
              
        $to = "seconsejoacademico@unbosque.edu.co";
        $asunto = "Notificacion solicitud de convenio";
        $mensaje = "Nuevo estado del proceso juridico de una solicitud de convenio. Por favor ingrese al sistema para verificar la lista de convenios en tramite.";
        EnviarCorreo($to,$asunto,$mensaje);
        
           
        $a_vectt['val']			  =true;
        $a_vectt['descrip']		  ='El proceso se Actualizado de forma correcta.';
        echo json_encode($a_vectt);
        exit;             
    }break;
}

?>