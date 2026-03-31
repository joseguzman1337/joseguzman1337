<?php
session_start();


switch($_REQUEST['actionID']){
    case 'BuscarPrograma':{
        global $db,$userid,$C_DesercionCostos;
        
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->ModalidadDinamica($_POST['Modalida']);
        
    }break;
    case 'BuscarDemografica':{
        global $db,$userid,$C_DesercionCostos;
        
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->TablaReporte($_POST['Periodo'],$_POST['Modalida'],$_POST['Carrera_id']);
    }break;
    case 'Reporte':{
        global $db,$userid,$C_DesercionCostos;
        define(AJAX,false);
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->Reporte();
        
    }break;
    default:{
        global $db,$userid,$C_DesercionCostos;
        
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->Display();
        
    }break;
}//switch
function MainGeneral(){
    
    global $db,$userid,$C_DesercionCostos;
    
    //include ('../templates/mainjson.php');
    if(AJAX==false){
    include("../templates/templateObservatorio.php");
    $db =writeHeader("Desercion Y Retencion",true,"Desercion",1);
    }else{
         include ('../templates/mainjson.php');
    }
    
    include ('DesercionCosto_Class.php');  $C_DesercionCostos = new DesercionCostos();
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
    
}
function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}
function MainJSGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="Desercion.js"></script> 
    <?PHP
}//MainJSGeneral

?>