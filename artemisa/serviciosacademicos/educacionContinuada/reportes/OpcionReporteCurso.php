<?php
session_start;
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
  

include_once'../class/OpcionesReporteCurso_Class.php'; $C_Opcion = new OpcionesReporteCurso();

 switch($_REQUEST['action_ID']){
    case 'Denegado':{
        global $db,$userid;
        BaseDatos();
        $idEstudiante     = $_POST['idestudiantegeneral'];
        $id               = $_POST['id'];
        $CodigoEstudiante = $_POST['codigoestudiante'];
        $CodigoPeriodo    = $_POST['codigoperiodo'];
        $Carrera          = $_POST['CodigoCarreraNew'];
        
        $CambioStatus = $C_Opcion->CambioCarrera($db,$CodigoEstudiante,$Carrera,$userid,$idEstudiante,$CodigoPeriodo,$id);        
        
    }break;
    case 'Aprobado':{
        global $db,$userid;
        BaseDatos();
        $idEstudiante     = $_POST['idestudiantegeneral'];
        $id               = $_POST['id'];
        $CodigoEstudiante = $_POST['codigoestudiante'];
        $CodigoPeriodo    = $_POST['codigoperiodo'];
        
        $C_Opcion->CambioStatus($db,1,$id,$idEstudiante,$userid,$CodigoEstudiante,$CodigoPeriodo);
       
    }break;
    case 'Cancelar':{
        global $db,$userid;
        BaseDatos();
        $idEstudiante = $_POST['idestudiantegeneral'];
        $id           = $_POST['id'];
        
        $C_Opcion->CancelarRegistro($db,$idEstudiante,$id,$userid);    
    }break;
 }//switch
 function BaseDatos(){
   global $db,$userid;
   include_once ('../../EspacioFisico/templates/template.php');
   $db = getBD();
   
   $SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

	if($Usario_id=&$db->Execute($SQL_User)===false){
			echo 'Error en el SQL Userid...<br>'.$SQL_User;
			die;
		}
	
	 $userid=$Usario_id->fields['id']; 
 }
?>