<?php
session_start();
//echo '<pre>';print_r($_SESSION);
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}

switch($_REQUEST['actionID']){
    case 'TipoAula':{
        global $C_Permiso,$userid,$db;
        
        define(AJAX,true);
        MainGeneral();
        
        $C_Permiso->TipoEspacioFisico($db,$_POST['id']);
    }break;
    case 'UpdateRespo':{
        global $userid,$db;
        
        MainJson();
        
        $Responsable = $_POST['User'];
        $Espacio     = $_POST['Espacio'];
        $id          = $_POST['id'];
        $TipoAula    = $_POST['TipoAula'];
        
        $SQL='UPDATE ResponsableEspacioFisico
        
              SET    UsuarioUltimaModificacion="'.$userid.'",
                     FechaUltimaModificacion=NOW(),
                     EspaciosFisicosId="'.$Espacio.'",
                     CodigoTipoSalon="'.$TipoAula.'" 
                     
              WHERE  UsuarioId="'.$Responsable.'" AND CodigoEstado=100 AND ResponsableEspacioFisicoId="'.$id.'"';
             
            if($UpdateEspacio=&$db->Execute($SQL)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Modificar Responsabilidad Usuario Espacio Fisico....';
                echo json_encode($a_vectt);
                exit; 
             }   
             
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se Ha Modificado La Responsabilidad Correctamente...';
            echo json_encode($a_vectt);
            exit;
              
    }break;
    case 'EliminarRespo':{
        global $userid,$db;
        
        MainJson();
        
        $Responsable = $_POST['User'];
        $Espacio     = $_POST['Espacio'];
        $id          = $_POST['id'];
        $TipoAula    = $_POST['TipoAula'];
        
        $SQL='UPDATE ResponsableEspacioFisico
        
              SET    UsuarioUltimaModificacion="'.$userid.'",
                     FechaUltimaModificacion=NOW(),
                     CodigoEstado=200
                     
              WHERE  UsuarioId="'.$Responsable.'" AND EspaciosFisicosId="'.$Espacio.'" AND ResponsableEspacioFisicoId="'.$id.'" AND CodigoTipoSalon="'.$TipoAula.'"'; 
             
            if($Eliminar=&$db->Execute($SQL)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Eliminar Responsabilidad Usuario Espacio Fisico....';
                echo json_encode($a_vectt);
                exit; 
             }   
             
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se Ha Eliminado La Responsabilidad Correctamente...';
            echo json_encode($a_vectt);
            exit;
              
    }break;
    case 'ValidaExite':{
        global $userid,$db;
        
        MainJson();
        
        $Responsable = $_POST['User'];
        $Espacio     = $_POST['Espacio'];
        $TipoAula    = $_POST['id'];
        
        $SQL='SELECT
                *
                FROM
                
                ResponsableEspacioFisico
                
                WHERE
                UsuarioId="'.$Responsable.'"
                AND
                EspaciosFisicosId="'.$Espacio.'"
                AND 
                CodigoTipoSalon="'.$TipoAula.'"
                AND
                CodigoEstado=100';
                
             if($Validacion=&$db->Execute($SQL)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error en el SQL de Validacion ....';
                echo json_encode($a_vectt);
                exit; 
             }  
             
             if(!$Validacion->EOF){
                $a_vectt['val']			=false;
                echo json_encode($a_vectt);
                exit;
             }else{
                $a_vectt['val']			=true;
                echo json_encode($a_vectt);
                exit;
             }
    }break;
    case 'SaveResponsable':{
        global $userid,$db;
        
        MainJson();
        
        $Responsable = $_POST['UserId'];
        $Espacio     = $_POST['Espacio'];
        $TipoAula    = $_POST['TipoAula'];
        
          $SQL='SELECT
                *
                FROM
                
                ResponsableEspacioFisico
                
                WHERE
                UsuarioId="'.$Responsable.'"
                AND
                EspaciosFisicosId="'.$Espacio.'"
                AND 
                CodigoTipoSalon="'.$TipoAula.'"
                AND
                CodigoEstado=100';
                
             if($Validacion=&$db->Execute($SQL)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error en el SQL de Validacion ....';
                echo json_encode($a_vectt);
                exit; 
             }  
             
             if($Validacion->EOF){
                $InsertSQL='INSERT INTO ResponsableEspacioFisico (UsuarioId,EspaciosFisicosId,CodigoTipoSalon,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion)VALUES("'.$Responsable.'","'.$Espacio.'","'.$TipoAula.'","'.$userid.'","'.$userid.'",NOW(),NOW())';
                
                if($ResponsableNew=&$db->Execute($InsertSQL)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error en el SQL de Insert ....';
                    echo json_encode($a_vectt);
                    exit;
                }
                
             }else{
                $a_vectt['val']			=true;
                $a_vectt['descrip']		='El Usuario Ya Tiene Asociado El Espacio Fisico Con El Tipo de Aula';
                echo json_encode($a_vectt);
                exit; 
             } 
            
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se Ha Creado Correctamente...';
        echo json_encode($a_vectt);
        exit; 
             
    }break;
    case 'VerEspaciosAsigandos':{
        global $C_Permiso,$userid,$db;
        
        define(AJAX,true);
        MainGeneral();
        
        $C_Permiso->VerEspaciosAsignados($db,$_POST['id']);
    }break;
    case 'ResponsableEspacioFisico':{
        global $C_Permiso,$userid,$db;
        
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        
        $C_Permiso->ResponsableEspacioFisico($db);
    }break;
    case 'CheckCambio':{
        global $userid,$db;
        
        MainJson();
        
        $id         = $_POST['id'];
        $caso       = $_POST['caso'];
        $Modulo     = $_POST['Modulo'];
        $UsuarioId  = $_POST['UsuarioId'];
        $RolPermiso = $_POST['RolPermiso'];
        
        if($Modulo){
               $SQL='UPDATE  PermisoEspacioFisico
                     
                     SET     CodigoEstado="'.$caso.'",
                             UsuarioUltimaModificacion="'.$userid.'",
                             RolEspacioFisicoId="'.$RolPermiso.'",
                             FechaUltimaModificacion=NOW()
                     
                     WHERE   PermisoEspacioFisicoId="'.$Modulo.'"  AND  ModulosEspacioFisicoId="'.$id.'"  AND  Usuarioid="'.$UsuarioId.'"';
                     
        }else{
            
            $SQL='INSERT INTO PermisoEspacioFisico(ModulosEspacioFisicoId,Usuarioid,RolEspacioFisicoId,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$id.'","'.$UsuarioId.'","'.$RolPermiso.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
        }
        
        if($Cambio=&$db->Execute($SQL)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error al SQL DEl Check Cambio ....';
            echo json_encode($a_vectt);
            exit;  
        }
        
            $a_vectt['val']			=true;
            //$a_vectt['descrip']		='Error al SQL DEl Check Cambio ....';
            echo json_encode($a_vectt);
            exit;  
    }break;
    case 'BuscarRol':{
        global $C_Permiso,$userid,$db;
        
        define(AJAX,true);
        MainGeneral();
        
        $id  = $_POST['id'];
        
        $C_Permiso->Roles($db,$id);
    }break;
    case 'BuscarPermisos':{
        global $C_Permiso,$userid,$db;
        
        define(AJAX,true);
        MainGeneral();
        
        $id  = $_POST['id'];
        
        $C_Permiso->Modulos($db,$id);
    }break;
    case 'PermisoRolEspacioFisico':{
        //echo '<pre>';print_r($_POST);
        /*
        [actionID] => PermisoRolEspacioFisico
        [BuscarUser_id] => 4186
        [RolPermiso] => 1
        [Permiso] => Array
            (
                [0] => 1
                [1] => 2
            )
        */
        global $userid,$db;
        
        MainJson();
        
        $User_permiso = $_POST['BuscarUser_id'];
        $RolPermiso   = $_POST['RolPermiso'];
        $Permiso      = $_POST['Permiso'];
        
        
        
        for($i=0;$i<count($Permiso);$i++){
            /**************************************/
            
            $SQL='SELECT 

                    p.PermisoEspacioFisicoId,
                    m.ModulosEspacioFisicoId,
                    r.RolEspacioFisicoId,
                    p.CodigoEstado
                   
             FROM PermisoEspacioFisico p  INNER JOIN ModulosEspacioFisico m ON m.ModulosEspacioFisicoId=p.ModulosEspacioFisicoId
                						  INNER JOIN RolEspacioFisico r ON r.RolEspacioFisicoId=p.RolEspacioFisicoId
                
             WHERE
                
                    r.CodigoEstado=100
                    AND
                    m.CodigoEstado=100
                    AND
                    p.CodigoEstado=100
                    AND
                    p.Usuarioid="'.$User_permiso.'"
                    AND
                    m.ModulosEspacioFisicoId="'.$Permiso[$i].'"';
                    
             if($Existe=&$db->Execute($SQL)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error al Validar los Permisos al Usuario Espacios Fisicos ....';
                    echo json_encode($a_vectt);
                    exit; 
             }       
                
                if($Existe->EOF){ 
                    
                     
                    $InsertSQL='INSERT INTO PermisoEspacioFisico(ModulosEspacioFisicoId,Usuarioid,RolEspacioFisicoId,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$Permiso[$i].'","'.$User_permiso.'","'.$RolPermiso.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
                    
                    if($EspacioFisicoPermiso=&$db->Execute($InsertSQL)===false){
                        $a_vectt['val']			=false;
                        $a_vectt['descrip']		='Error al Insertar la Permisos al Usuario Espacios Fisicos ....';
                        echo json_encode($a_vectt);
                        exit;  
                    }
                }else{
                    if($Existe->fields['RolEspacioFisicoId']!=$RolPermiso){
                         $SQL='UPDATE  PermisoEspacioFisico
                     
                                 SET     UsuarioUltimaModificacion="'.$userid.'",
                                         RolEspacioFisicoId="'.$RolPermiso.'",
                                         FechaUltimaModificacion=NOW()
                                 
                                 WHERE   ModulosEspacioFisicoId="'.$Permiso[$i].'"  AND  Usuarioid="'.$User_permiso.'"';
                                 
                         if($CambioRol=&$db->Execute($SQL)===false){
                            $a_vectt['val']			=false;
                            $a_vectt['descrip']		='Error al Modificar El Rol Los Permisos al Usuario Espacios Fisicos ....';
                            echo json_encode($a_vectt);
                            exit; 
                         }        
                    }
                }    
            /**************************************/
        }//for
        
        
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se ha Almacenado la Informacion.';
            echo json_encode($a_vectt);
            exit; 
        
    }break;
    case 'AutocompleteUsuario':{
        global $userid,$db;
        
        MainJson();
        
       $Letra   		= $_REQUEST['term'];
        
       $SQL_Buscar='SELECT 
    
                                idusuario,
                                usuario,
                                nombres,
                                apellidos,
                                numerodocumento
                    
                    
                    FROM 
                    
                                usuario
                    
                    WHERE
                    
                                usuario LIKE "%'.$Letra.'%"
                                OR
                                nombres LIKE "%'.$Letra.'%"
                                OR
                                apellidos LIKE "%'.$Letra.'%"
                                OR
                                numerodocumento LIKE "%'.$Letra.'%"';
                                
                    if($ResultUsuario=&$db->Execute($SQL_Buscar)===false){
                        $a_vectt['val']			='FALSE';
                        $a_vectt['descrip']		='Error en el SQL de Busqueda de Usuarios... '.$SQL_Buscar;
                        echo json_encode($a_vectt);
                        exit; 
                    } 
                    
                    $Result = array();
                    
                    while(!$ResultUsuario->EOF){
                        /************************************/
                          $C_Result['label']                 = $ResultUsuario->fields['nombres'].' '.$ResultUsuario->fields['apellidos'].' ('.$ResultUsuario->fields['usuario'].')';
    				      $C_Result['value']                 = $ResultUsuario->fields['nombres'].' '.$ResultUsuario->fields['apellidos'].' ('.$ResultUsuario->fields['usuario'].')';
                          $C_Result['Usuario']               = $ResultUsuario->fields['usuario'];
                          $C_Result['Nombre']                = $ResultUsuario->fields['nombres'].' '.$ResultUsuario->fields['apellidos'];
                          $C_Result['NumeroDocumento']       = $ResultUsuario->fields['numerodocumento'];
                          $C_Result['id_Usuario']            = $ResultUsuario->fields['idusuario'];
                          array_push($Result,$C_Result);
                        /************************************/
                        $ResultUsuario->MoveNext();
                    }//while  
                    
         	echo json_encode($Result); 

        
    }break;
    default:{
        global $C_Permiso,$userid,$db;
        
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        
        $C_Permiso->Principal($db);
        
    }break;
    }
function MainGeneral(){
	
		
		global $C_Permiso,$userid,$db;
		
		//var_dump(is_file("templates/template.php"));die;
        include("../templates/template.php"); 
        
        if(AJAX==false){
            $db = writeHeader('Permisos',true);
        }else{
            $db = getBD();
        }
	 
		include('PermisosEspacioFisico_class.php');  $C_Permiso = new PermisoEspacioFisico();
	
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