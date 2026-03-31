<?php

session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */
switch($_REQUEST['actionID']){
    default:{
        global $C_Admin_Actividades,$userid,$db;
        MainGeneral();
       
        $C_Admin_Actividades->Principal();
    }break;
}
function MainGeneral(){
	
		
		global $C_Admin_Actividades,$userid,$db;
		
		//var_dump(is_file("templates/template.php"));die;
		include("../templates/template.php"); 
		$db = writeHeader('Creaci&oacute;n Tipo Actividad',true);
        
		include('Admin_Actividades_class.php');  $C_Admin_Actividades = new Admin_Actividades();
	
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
	}
function MainJson(){
	global $userid,$db;
		
		
		include("../templates/template.php");
		
		$db = getBD();
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}
?>