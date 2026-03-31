<?php
session_start();
//echo '<pre>';print_r($_SESSION);
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}

switch($_REQUEST['actionID']){
    case 'EliminarClasificacion':{
        global $userid,$db;
        MainJson();
        
        $User_id = $_POST['User'];
        $Id      = $_POST['id'];
        
        $UpdateClasificacion='UPDATE ResponsableClasificacionEspacios
        
                              SET    CodigoEstado=200,
                                     UsuarioUltimaModificacion="'.$userid.'",
                                     FechaultimaModificacion=NOW()
                                     
                              WHERE  ClasificacionEspaciosId="'.$Id.'" AND idusuario="'.$User_id.'" AND CodigoEstado=100';
                              
          if($DeleteClasificaRespon=&$db->Execute($UpdateClasificacion)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Eliminar La responsabilidad En Clasificacion Espacio....';
                echo json_encode($a_vectt);
                exit; 
            }   

        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Eliminado Correctamente';
        $a_vectt['User_id']		=$User_id;
        echo json_encode($a_vectt);
        exit;    
                           
    }break;
    case 'ResponClasificacionEspacio':{
        global $C_OtherPermiso,$C_Permiso,$userid,$db;
        
        define(AJAX,true);
        MainGeneral();
        
        $C_OtherPermiso->VerClasificacionEspacio($db,$_POST['User']);
    }break;
    case 'SaveClasificacionEspacio':{
        global $userid,$db;
        /*
        [BuscarUser_id] => 4186
        [Espacio] => 5
        [TipoAula] => 01
        [ClasificacionEspacio] => 29
        */
        MainJson();
        
        $User_id = $_POST['BuscarUser_id'];
        $Id      = $_POST['ClasificacionEspacio'];
        
        $SQL='SELECT ClasificacionEspaciosId,CodigoEstado FROM ResponsableClasificacionEspacios WHERE ClasificacionEspaciosId="'.$Id.'" AND idusuario="'.$User_id.'"';
        
        if($Valida=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Valida...<br><br>'.$SQL;
            die;
        }
        
        if($Valida->fields['CodigoEstado']==200 || $Valida->fields['CodigoEstado']=='200'){
            
            $UpdateInsert='UPDATE ResponsableClasificacionEspacios
        
                                  SET    CodigoEstado=100,
                                         UsuarioUltimaModificacion="'.$userid.'",
                                         FechaultimaModificacion=NOW()
                                         
                                  WHERE  ClasificacionEspaciosId="'.$Id.'" AND idusuario="'.$User_id.'" AND CodigoEstado=200';
                                  
              if($InsertClasificaRespon=&$db->Execute($UpdateInsert)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error Al Inser Update';
                    echo json_encode($a_vectt);
                    exit; 
                }   
            
        }else{
        
            if($Valida->EOF){
            
                $Insert='INSERT INTO ResponsableClasificacionEspacios(ClasificacionEspaciosId,idusuario,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion)VALUES("'.$Id.'","'.$User_id.'","'.$userid.'","'.$userid.'",NOW(),NOW())';
                
                if($NewResponsabilidad=&$db->Execute($Insert)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error al Insertar La responsabilidad En Clasificacion Espacio....';
                    echo json_encode($a_vectt);
                    exit; 
                }
            
            }else{
                    $a_vectt['val']			=true;
                    $a_vectt['descrip']		='Ya el Usuario Tiene la Responsabilidad';
                    $a_vectt['User_id']		=$User_id;
                    echo json_encode($a_vectt);
                    exit;
            }
        
        }
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Almacenado Correctamente';
        $a_vectt['User_id']		=$User_id;
        echo json_encode($a_vectt);
        exit;
    }break;
    case 'BuscarEspcaioFisico':{
        global $C_OtherPermiso,$C_Permiso,$userid,$db;
        
        define(AJAX,true);
        MainGeneral();
        
        $C_OtherPermiso->EspcaioFisicoDetalle($db,$_POST['id'],$_POST['Espacio']);
    }break;
    case 'TipoAulaDetalle':{
        global $C_OtherPermiso,$C_Permiso,$userid,$db;
        
        define(AJAX,true);
        MainGeneral();
        
        $C_Permiso->TipoEspacioFisico($db,$_POST['id'],'','BuscarEspcaioFisico');
    }break;
    default:{
        global $C_OtherPermiso,$C_Permiso,$userid,$db;
        
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
       
        $C_OtherPermiso->Display($db,$C_Permiso);
    }break;
}
function MainGeneral(){
	
		
		global $C_OtherPermiso,$C_Permiso,$userid,$db;
		
		//var_dump(is_file("templates/template.php"));die;
        include("../templates/template.php"); 
        
        if(AJAX==false){
            $db = writeHeader('Otros Permisos',true);
        }else{
            $db = getBD();
        }
	
		include('OtrosPermisosEspacioFisico_class.php');  $C_OtherPermiso = new OtherPermisosEspaciosFiscos();
        include('PermisosEspacioFisico_class.php');  $C_Permiso      = new PermisoEspacioFisico();
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
    <script type="text/javascript" language="javascript" src="PermisosEspacioFisico.js"></script>
    
    <?PHP
}
?>