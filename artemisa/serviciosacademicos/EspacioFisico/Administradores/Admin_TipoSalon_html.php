<?php

session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
     case 'CambiarTipo':{
        global $db,$userid;
        
        MainJson();
        
       $SQL_update='UPDATE  tiposalon
                     
                     SET     EspaciosFisicosId="'.$_POST['Espacio'].'",
                             UsuarioUltimaModificacion="'.$userid.'",
                             FechaUltimaModificacion=NOW()
                             
                     WHERE   codigotiposalon="'.$_POST['id'].'"';
                     
        if($CambioStado=&$db->Execute($SQL_update)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en El Update ... <br><br>'.$SQL_update;
            echo json_encode($a_vectt);
            exit;
         }  
         
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Modificado Correctamente...';
        echo json_encode($a_vectt);
        exit;               
     }break; 
     case 'Editar':{
        global $db,$userid;
        
        MainJson();
        
        $SQL_update='UPDATE  tiposalon
                     
                     SET     nombretiposalon="'.$_POST['value'].'",
                             UsuarioUltimaModificacion="'.$userid.'",
                             FechaUltimaModificacion=NOW()
                             
                     WHERE   codigotiposalon="'.$_POST['id'].'"';
                     
        if($CambioStado=&$db->Execute($SQL_update)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en El Update ... <br><br>'.$SQL_update;
            echo json_encode($a_vectt);
            exit;
         }  
         
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Modificado Correctamente...';
        echo json_encode($a_vectt);
        exit;               
                     
                     
    }break;
    case 'View':{
        global $C_Admin_TipoSalon,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        
        $C_Admin_TipoSalon->ViewTipoSalon();
    }break;
    case 'stado':{
        global $db,$userid;
        
        MainJson();
        
        $SQL_update='UPDATE  tiposalon
                     
                     SET     codigoestado="'.$_POST['estado'].'",
                             UsuarioUltimaModificacion="'.$userid.'",
                             FechaUltimaModificacion=NOW()
                             
                     WHERE   codigotiposalon="'.$_POST['id'].'"';
                     
         if($CambioStado=&$db->Execute($SQL_update)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en El Update ... <br><br>'.$SQL_update;
            echo json_encode($a_vectt);
            exit;
         }  
         
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Modificado Correctamente...';
        echo json_encode($a_vectt);
        exit;          
                     
    }break;
    case 'InsertSalon':{
        global $db,$userid;
        
        MainJson();
        
        $SQL_max='SELECT max(codigotiposalon)+1 FROM tiposalon WHERE codigoestado=100';
        
        if($Max=&$db->Execute($SQL_max)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en El Buscar el Max ... <br><br>'.$SQL_max;
            echo json_encode($a_vectt);
            exit;
        }
        
        $id = $Max->fields[0];
        
        $SQL_insert='INSERT INTO tiposalon(codigotiposalon,nombretiposalon,FechaCreacion,UsuarioCreacion,FechaUltimaModificacion,UsuarioUltimaModificacion,EspaciosFisicosId)VALUES("'.$id.'","'.$_POST['T_Salon'].'",NOW(),"'.$userid.'",NOW(),"'.$userid.'","'.$_POST['EspacioFisico'].'")';
        
        if($InsertSalon=&$db->Execute($SQL_insert)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en ElInsert Salon ... <br><br>'.$SQL_insert;
            echo json_encode($a_vectt);
            exit;
        }
        
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Almacenado Correctamente...';
        echo json_encode($a_vectt);
        exit; 
    }break;
    default:{
        global $C_Admin_TipoSalon,$userid,$db;
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        $C_Admin_TipoSalon->Principal();
    }break;
}
function MainGeneral(){
	
		
		global $C_Admin_TipoSalon,$userid,$db;
		
		//var_dump(is_file("templates/template.php"));die;
		include("../templates/template.php");
        
        if(AJAX==false){
            $db = writeHeader('Creaci&oacute;n Tipo Sal&oacute;n',true);    
        }else{
            $db = getBD();
        }
		
        
		include('Admin_TipoSalon_class.php');  $C_Admin_TipoSalon = new Admin_TipoSalon();
	
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
function JsGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="../Administradores/Admin_TipoSalon.js"></script>
    <?PHP
}    
?>