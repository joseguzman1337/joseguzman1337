<?php
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */
switch($_REQUEST['actionID']){
    case 'CargarInfo':{ 
        global $db,$userid,$C_Reporte_AdmitidoNoAdmitidos;
        define(AJAX,true);
        MainGeneral();
        
        $C_Reporte_AdmitidoNoAdmitidos->Respuesta($_POST['Periodo'],$_POST['Carrera']);
    }break;
    case 'Programas':{
        global $db,$userid,$C_Reporte_AdmitidoNoAdmitidos;
        define(AJAX,true);
        MainGeneral();
        
        $C_Reporte_AdmitidoNoAdmitidos->Programas($_POST['Modalidad']);
    }break;
    default:{
        global $db,$userid,$C_Reporte_AdmitidoNoAdmitidos;
        define(AJAX,false);
        MainGeneral();
        MainJSGeneral();
        
        $C_Reporte_AdmitidoNoAdmitidos->Principal();
    }break;
}//switch
function MainGeneral(){
    
    global $db,$userid,$C_Reporte_AdmitidoNoAdmitidos;
    
    //include ('../templates/mainjson.php');
    if(AJAX==false){
    include("../templates/templateObservatorio.php");
    
        $Titulo = 'Reporte de Estudiantes Admitidos y No Admitidos'; 
   
    
    
    $db =writeHeader($Titulo,true,"Admitidos y No Admitidos",1);
    }else{
         include ('../templates/mainjson.php');
    }
    
    include ('Reporte_AdmitidoNoAdmitidos.class.php');  $C_Reporte_AdmitidoNoAdmitidos = new Reporte_AdmitidoNoAdmitidos();
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
    
}//MainGeneral
function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}//MainJson
function MainJSGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="Reporte_AdmitidoNoAdmitidos.js"></script> 
    <?PHP
}//MainJSGeneral
?>