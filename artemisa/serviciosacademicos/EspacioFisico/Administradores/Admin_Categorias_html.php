<?php

session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */

switch($_REQUEST['actionID']){
    case 'CambiarCheck':{
        global $db,$userid;
        
        MainJson();
        
        $SQL_update='UPDATE  EspaciosFisicos
                     
                     SET     PermitirAsignacion="'.$_POST['Check'].'",
                             UsuarioUltimaModificacion="'.$userid.'",
                             FechaUltimaModificacion=NOW()
                             
                     WHERE   EspaciosFisicosId="'.$_POST['id'].'"';
                     
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
        
        $SQL_update='UPDATE  EspaciosFisicos
                     
                     SET     Nombre="'.$_POST['value'].'",
                             UsuarioUltimaModificacion="'.$userid.'",
                             FechaUltimaModificacion=NOW()
                             
                     WHERE   EspaciosFisicosId="'.$_POST['id'].'"';
                     
        if($CambioText=&$db->Execute($SQL_update)===false){
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
    case 'stado':{
        global $db,$userid;
        
        MainJson();
        
        $SQL_update='UPDATE  EspaciosFisicos
                     
                     SET     codigoestado="'.$_POST['estado'].'",
                             UsuarioUltimaModificacion="'.$userid.'",
                             FechaUltimaModificacion=NOW()
                             
                     WHERE   EspaciosFisicosId="'.$_POST['id'].'"';
                     
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
        global $C_Admin_Categorias,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        
        $C_Admin_Categorias->ViewCategorias();
    }break;
    case 'InsertCategoria':{
        global $db,$userid;
        
        MainJson();
        
        $SQL_insert='INSERT INTO EspaciosFisicos(Nombre,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion,PermitirAsignacion)VALUES("'.$_POST['Categoria'].'","'.$userid.'",NOW(),"'.$userid.'",NOW(),"'.$_POST['Check'].'")';
        
        if($NewspaciosFisicos=&$db->Execute($SQL_insert)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en El Insert ... <br><br>'.$SQL_insert;
            echo json_encode($a_vectt);
            exit;
        }
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Almacenado Correctamente...';
        echo json_encode($a_vectt);
        exit;
    }break;
    default:{
        global $C_Admin_Categorias,$userid,$db;
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
       
        $C_Admin_Categorias->Principal();
    }break;
}
function MainGeneral(){
	
		
		global $C_Admin_Categorias,$userid,$db;
		
		//var_dump(is_file("templates/template.php"));die;
		include("../templates/template.php"); 
        
        if(AJAX==false){
            $db = writeHeader('Creaci&oacute;n Categor&iacute;as',true);    
        }else{
           $db = getBD(); 
        }
		
        
		include('Admin_Categorias_class.php');  $C_Admin_Categorias = new Admin_Categorias();
	
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
    <script type="text/javascript" language="javascript" src="../Administradores/Admin_Categorias.js"></script>
    <?PHP
    }    
?>
