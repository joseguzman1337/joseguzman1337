<?php

switch($_REQUEST['actionID']){
    case 'Entrevistas':{
        global $db,$userid,$C_ReportesEntrevistas,$CodigoCarreraUser;
        
        define(AJAX,true);
        MainGeneral();
        
        $Carrera_id      = $_POST['Carrera_id'];
        $CodigoPeriodo   = $_POST['CodigoPeriodo'];
        
        $C_ReportesEntrevistas->ViewEntrevista($Carrera_id,$CodigoPeriodo);        
        
    }break;
    case 'Repote':{
        global $db,$userid,$C_ReportesEntrevistas,$CodigoCarreraUser;
        
        define(AJAX,false);
        
        MainGeneral();
        MainJSGeneral();
        
        $C_ReportesEntrevistas->EntrevistasReport();
        
    }break;
    case 'VerDetalle':{
        global $db,$userid,$C_ReportesEntrevistas,$CodigoCarreraUser;
        
        define(AJAX,true);
        MainGeneral();
        
        $Carrera_id      = $_REQUEST['Carrera_id'];
        $CodigoPeriodo   = $_REQUEST['CodigoPeriodo'];
        
        $C_ReportesEntrevistas->ViewDetalleReport($Carrera_id,$CodigoPeriodo);
        
    }break;
    case 'BuscarInfo':{
        global $db,$userid,$C_ReportesEntrevistas,$CodigoCarreraUser;
        
        define(AJAX,true);
        MainGeneral();
        
        $Carrera_id      = $_POST['Carrera_id'];
        $CodigoPeriodo   = $_POST['CodigoPeriodo'];
        
        $C_ReportesEntrevistas->ViewReport($Carrera_id,$CodigoPeriodo);
        
    }break;
    default:{
        global $db,$userid,$C_ReportesEntrevistas,$CodigoCarreraUser;
        
        define(AJAX,false);
        
        MainGeneral();
        MainJSGeneral();
        
        $C_ReportesEntrevistas->RerporteSaberOnce();
    }break;
}//switch
function MainGeneral(){
    global $db,$userid,$C_ReportesEntrevistas,$CodigoCarreraUser;
    
    include_once ('ReportesEntrevistas_Class.php');
    
    $C_ReportesEntrevistas = new ReportesEntrevistas();
    
    if(AJAX==false){
        
    include("../templates/templateObservatorio.php");
    
     $db =writeHeader('Reportes Entrevistas',true,"Reportes",1);
    
    }else{
        
        include ('../templates/mainjson.php');
        
    }

    //echo '<pre>';print_r($_SESSION);
    $CodigoCarreraUser  = $_SESSION['codigofacultad'];
    
   	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
    
}//function MainGeneral
function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}//function MainJson
function MainJSGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="ReportesEntrevistas.js"></script> 
    <?PHP
}//MainJSGeneral
?>