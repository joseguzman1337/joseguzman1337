<?php
session_start();


switch($_REQUEST['actionID']){
    case 'Ecxel':{
         global $db,$userid,$C_DesercionSemestre;
        
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=DesercionSemestre.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        
        
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionSemestre->Rerporte();
    }break;
    default:{
        global $db,$userid,$C_DesercionSemestre;
        
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionSemestre->Rerporte();
        
    }break;
    
}
function MainGeneral(){
    
    global $db,$userid,$C_DesercionSemestre;
    
    //include ('../templates/mainjson.php');
    if(AJAX==false){
    include_once("../templates/templateObservatorio.php");
    $db =writeHeader("Desercion Semestral",true,"Causas Asistencias");
    }else{
         include_once ('../templates/mainjson.php');
    }
    
    include_once ('DesercionSemestre_Class.php');  $C_DesercionSemestre = new DesercionSemestre();
	
	
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
    <script type="text/javascript" language="javascript" src="DesercionSemestre.js"></script> 
    <script language="javascript">
    function GenerarExcel(){
        location.href='DesercionSemestre_html.php?actionID=Ecxel';
    }/*function GenerarExcel*/
    </script>
    <?PHP
}//MainJSGeneral
?>