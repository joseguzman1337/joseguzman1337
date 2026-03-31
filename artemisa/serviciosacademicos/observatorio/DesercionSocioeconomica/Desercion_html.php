<?php
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */
switch($_REQUEST['actionID']){
   case 'BuscarInfo':{
        global $db,$userid,$C_Desercion;
        
        MainGeneral();
        /*
        0=Semestral
        1=Anual
        2=Cohorte
        */
        if($_POST['TypeDesercion']==0 || $_POST['TypeDesercion']=='0'){
            $C_Desercion->Display($_POST['Periodo']);
        }else if($_POST['TypeDesercion']==1 || $_POST['TypeDesercion']=='1'){
            $C_Desercion->DisplayAnual($_POST['Periodo']);
        }

   }break; 
   case 'Semestral':{
        global $db,$userid,$C_Desercion;
        
        MainJson();
        
        $C_Desercion->Display($_POST['CodigoPeriodo']);         
   }break;
   case 'Consola':{
        global $db,$userid,$C_Desercion;
        
        MainGeneral();
        MainJSGeneral();
        
        
        $C_Desercion->Consola();         
   }break;        
}
function MainGeneral(){
    
    global $db,$userid,$C_Desercion;
    
    //include ('../templates/mainjson.php');
    include("../templates/templateObservatorio.php");
    $db =writeHeader("Desercion",true,"Causas Asistencias");
    
    
    include ('Desercion_class.php');  $C_Desercion = new Desercion();
	
	
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