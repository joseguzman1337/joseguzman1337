<?php

session_start();
//echo '<pre>';print_r($_SESSION);
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi?n en el sistema</strong></blink>';
	exit();
}
        
     
//echo '<pre>';print_r($_POST);die;

switch($_REQUEST['actionID']){
    case 'SolicitudMasiva':{
        global $C_SolicitudMasiva,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        
        $PeriodoDestino = $_POST['fecha2'];
        
        $C_SolicitudMasiva->Inicio($db,$userid,$PeriodoDestino);
    }break;
}
function MainGeneral(){

		
		global $C_SolicitudMasiva,$userid,$db;
		
		//var_dump(is_file("../templates/template.php"));die;
        include("../templates/template.php"); 	
        
        if(AJAX==false){  
            $db = writeHeader('Interfaz Solicitud',true);
        }else{
            $db = getBD();
        }
	
		include('SolicitudMasiva_class.php');  $C_SolicitudMasiva = new SolicitudMasiva();
        
       // echo 'Nmae->'.$_SESSION['MM_Username'];
	
		$SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
        
        

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
        $codigorol=$Usario_id->fields['codigorol'];
	}
function MainJson(){
	global $userid,$db,$codigorol;
		
		
		include("../templates/template.php");
		
		$db = getBD();
        
		$SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
         $codigorol=$Usario_id->fields['codigorol'];
	}

?>