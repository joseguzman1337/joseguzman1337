<?php
//session_start();
/*
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */
switch($_REQUEST['actionID']){
    case 'listadoestudiantes':{
        global $db,$userid,$C_ViewReporte_ComparativoSaber11;
        define(AJAX,true);
        MainGeneral();
        $rango=explode("_",$_POST["rango"]);
        $C_ViewReporte_ComparativoSaber11->ViewListadoEstudiantesRango($rango[0],$rango[1]);
    }break;
    default:{
        global $db,$userid,$C_ViewReporte_ComparativoSaber11;
        define(AJAX,ture);
        MainGeneral();
        MainJSGeneral();
        
        $C_ViewReporte_ComparativoSaber11->Principal();
    }break;
}//switch
function MainGeneral(){
    
    global $db,$userid,$C_ViewReporte_ComparativoSaber11,$C_Reporte_ComparativoSaber11;
    
    //include ('../templates/mainjson.php');
    if(AJAX==false){
    include("../templates/templateObservatorio.php");
    
        $Titulo = 'Reporte Comparativo Saber 11'; 
   
    
    
    $db =writeHeader($Titulo,true,"Reporte Comparativo Saber 11",1);
    }else{
         include ('../templates/mainjson.php');
    }
    
    include ('Reporte_ComparativoSaber11.view.php');  
    $C_ViewReporte_ComparativoSaber11 = new ViewReporte_ComparativoSaber11();
	
	
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
    <script type="text/javascript" language="javascript" src="Reporte_ComparativoSaber11.js"></script> 
    <?PHP
}//MainJSGeneral
?>