<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    $rutaVistas = "../vistas"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once(realpath(dirname(__FILE__))."/../../../../Mustache/load.php"); /*Ruta a /html/Mustache */

switch($_REQUEST['actionID']){
    case 'ModulosActivar':{
        global $C_Permisos,$userid,$db;
        MainGeneral();
        
        $id = $_POST['id'];
        
        $C_Permisos->AccesoRol($db,$userid,$id,0,1);
    }break;
    case 'BuscarInfo2':{
        global $C_Permisos,$userid,$db;
        MainGeneral();
        
        $id = $_POST['id'];
        
        $Roles   = $C_Permisos->ModulosUserActivo($db,$id);
        
    }break;
    case 'BuscarInfo':{
        global $C_Permisos,$userid,$db;
        MainGeneral();
        
        $id = $_POST['id'];
        
        $Roles   = $C_Permisos->RolesUserActivo($db,$id);
        
    }break;
    case 'NewRolModulos':{
        global $C_Permisos,$userid,$db;
        MainGeneral();
        
        $Info = $_POST;
        
        $C_Permisos->NenRolModuloConvenio($db,$Info,$userid);
    }break;
    default:{
        global $C_Permisos,$userid,$db;
          MainGeneral();
          JsGeneral();
          
          $template = $mustache->loadTemplate('Display'); /*carga la plantilla*/
          
          $Roles   = $C_Permisos->Roles($db);
          $Modulos = $C_Permisos->Modulos($db);
          
          $DataView['title']      = 'Permisos';
          $DataView['Label']      = 'Permisos y Roles Convenios';
          $DataView['LabelUser']  = 'Usuario';
          $DataView['LabelRol']   = 'Rol';
          $DataView['LabelModulo']= 'Modulo';
          $DataView['name']       = 'BuscarUser';
          $DataView['Example']    = 'Digite el Usuario o Nombre del Usuario o Numero Documento';
          $DataView['function']   = 'FormatUser';
          $DataView['auto']       = 'AutoCompleteUser';
          $DataView['NameHidden'] = 'BuscarUser_id';
          $DataView['Roles']      = $Roles;
          $DataView['Modulos']    = $Modulos;
          $DataView['funcionRol'] = 'ModuloRoles';
          
          
          echo $template->render($DataView);
    }break;
}
function MainGeneral(){
    global $C_Permisos,$userid,$db;
	    
        include(realpath(dirname(__FILE__))."/../../../EspacioFisico/templates/template.php"); 
        include(realpath(dirname(__FILE__)).'/../class/PermisosConvenio_class.php');  $C_Permisos = new PermisosConvenio();	
        
        $db = getBD();
      
      	$SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
        
      	if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
	    $userid=$Usario_id->fields['id'];
}//function MainGeneral
function MainJson(){
	global $userid,$db;
    
		include(realpath(dirname(__FILE__))."/../../../EspacioFisico/templates/template.php"); 
		
		$db = getBD();
        
		$SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
        
}
function JsGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="../js/PermisosConvenio.js"></script>    
    <?PHP
}
?>