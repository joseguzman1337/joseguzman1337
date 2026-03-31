<?php

switch($_REQUEST['actionID']){
    case 'EliminarPermiso':{
        global $db,$userid,$C_Permisos; 
           
        define(AJAX,true);
        MainGeneral();
        
        $Usuario = $_POST['id_Usuario'];
        $Data    = $_POST['Data'];
        
        $C_Data = explode('-',$Data);
        
        $C_Modulo = $C_Permisos->ConsultaModulos($C_Data[1],1);
        
        
        $SQL='UPDATE obs_usuarios_roles
          
          SET    codigoestado=200,
                 changedate=NOW(),
                 useridestado="'.$userid.'"
         
          WHERE
                 usuariopermiso="'.$Usuario.'" AND  url="'.$C_Modulo[0]['url'].'"';
                 
          if($Update=&$db->Execute($SQL)===false){
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error Al Eliminar el Permiso del usuario'.$SQL;
                echo json_encode($a_vectt);
                exit;    
          } 
          
            $a_vectt['val']			='TRUE';           
            echo json_encode($a_vectt);
            exit;        
        
    }break;
    case 'PermisosUsuarios':{
        global $db,$userid;
        
        MainJson();
        
        $Usuario = $_POST['id_Usuario'];
        
			$SQL='SELECT 
				C.id_categoriamodulo AS id,
				C.ver,
				C.editar,
				C.eliminar,
				C.crear,
				C.id_categoriamodulo,
				C.id_categoria
				FROM obs_usuariosRolPermiso U
				INNER JOIN obs_rolusuarios R ON R.idobs_rolusuario = U.idobs_rol
				INNER JOIN obs_categoriamodulo C ON C.idobs_rolusuario = R.idobs_rolusuario
				WHERE U.usuarioConPermiso = "'.$Usuario.'" 
				AND C.codigoestado = 100
				AND U.codigoestado = 100
				AND C.codigoestado = 100';
			
               if($SelectPermiso=&$db->Execute($SQL)===false){
                echo 'Error en el SQL del Select de los Permisos ';
                die;
               } 
           
          $Cadena = ''; 
               
          while(!$SelectPermiso->EOF){
            
                $Cadena = $Cadena.'::'.$SelectPermiso->fields['id_categoria'].'-'.$SelectPermiso->fields['id_categoriamodulo'].'-'.$SelectPermiso->fields['editar'].'-'.$SelectPermiso->fields['ver'].'-'.$SelectPermiso->fields['eliminar'].'-'.$SelectPermiso->fields['crear'];
            
            $SelectPermiso->MoveNext();
          }//while     
          
          echo json_encode($Cadena); //$Cadena;
        
    }break;
	case 'PermisosUsuariosRol':{
        global $db,$userid;
        
        MainJson();
        
        $Rol = $_POST['id_Rol'];
        
              $SQL='SELECT 
					C.id_categoriamodulo AS id,
					C.ver,
					C.editar,
					C.eliminar,
					C.crear,
					C.id_categoriamodulo,
					C.id_categoria
					FROM obs_rolusuarios R
					INNER JOIN obs_categoriamodulo C ON C.idobs_rolusuario = R.idobs_rolusuario
					WHERE R.idobs_rolusuario = "'.$Rol.'" 
					AND C.codigoestado = 100
					AND C.codigoestado = 100';
               if($SelectPermiso=&$db->Execute($SQL)===false){
                echo 'Error en el SQL del Select de los Permisos ';
                die;
               } 
           
          $Cadena = ''; 
               
          while(!$SelectPermiso->EOF){
            
                $Cadena = $Cadena.'::'.$SelectPermiso->fields['id_categoria'].'-'.$SelectPermiso->fields['id_categoriamodulo'].'-'.$SelectPermiso->fields['editar'].'-'.$SelectPermiso->fields['ver'].'-'.$SelectPermiso->fields['eliminar'].'-'.$SelectPermiso->fields['crear'];
            
            $SelectPermiso->MoveNext();
          }//while     
          
          echo json_encode($Cadena); //$Cadena;
        
    }break;
    case 'ActualizarTabla':{
        global $db,$userid;
        
        MainJson();
        
          $SQL='SELECT 
                
                        p.idobs_usuarios_roles as id,
                        p.cedula_usuario,
                        u.idusuario,
                        u.usuario
                FROM 
                
                        obs_usuarios_roles  p INNER JOIN usuario u ON u.numerodocumento=p.cedula_usuario
                
                WHERE 
                
                        p.codigoestado=100
                
                GROUP BY p.cedula_usuario';
                
                if($Result=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de la Busqueda y Actualizacion...<br><br>'.$SQL;
                    die;
                }
        
            
            while(!$Result->EOF){
                
                    $Cedula     = $Result->fields['cedula_usuario'];
                    $id_Usuario = $Result->fields['idusuario'];
                    
                    
                    $SQL_Update='UPDATE obs_usuarios_roles
                                 
                                 SET    usuariopermiso="'.$id_Usuario.'",
                                        changedate=NOW(),
                                        useridestado="'.$userid.'"
                                        
                                 WHERE  cedula_usuario="'.$Cedula.'" AND codigoestado=100';
                                 
                                 
                          if($Update=&$db->Execute($SQL_Update)===false){
                                echo 'Error en el SQL de Modificar tabla o Datos...<br><br>'.$SQL_Update;
                                die;
                          }       
                    
                
                $Result->MoveNext();
            }//while
            
            echo 'Termino....';
        
    }break;
    case 'AutocompleteUsuario':{
        global $db,$userid;
        
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
    case 'CargarPermisos':{
      	global $db,$userid,$C_Permisos; 
           
        define(AJAX,true);
        MainGeneral();

		
		$C_Permisos->CargarPermisos($_POST['PermisosCargados'],$_POST['id_Usuario']);
        
    }break;
    case 'BuscarModulos':{
        global $db,$userid,$C_Permisos;
        
        define(AJAX,true);
        MainGeneral();
        
        
        $C_Permisos->Modulos($_POST['Categoria']);
        
    }break;
    case 'InsertRolUsuario':{
		global $db,$userid;
        MainJson();
				$SqlConsulta='SELECT idobs_rol FROM obs_usuariosRolPermiso 
				WHERE usuarioConPermiso = "'.$_POST['id_Usuario'].'"
				AND idobs_rol = "'.$_POST['Rol'].'"';
				if($Consulta=&$db->Execute($SqlConsulta)===false){
						echo 'Error en el SQL de Modificar tabla o Datos...<br><br>';
						die;
				}
				$Usuario = $Consulta->GetAll();
				$existe= $Usuario[0][0]['idobs_rol'];
				if(empty($existe)){
					$SQL_Update="INSERT INTO obs_usuariosRolPermiso (
						idobs_rol,
						usuarioCreoPermiso,
						usuarioConPermiso,
						fechaCreacion,
						fechaUltimaModificacion,
						codigoestado
						)
						VALUES
						(
							'".$_POST['Rol']."',
							'".$_POST['usuarioSession']."',
							'".$_POST['id_Usuario']."',
							NOW(),
							'NOW()',
							'100'
						);";                       
						if($Update=&$db->Execute($SQL_Update)===false){
							echo 'Error en el SQL de Modificar tabla o Datos...<br><br>';
							die;
						}  
				}else{
					$SqlConsultaD='SELECT idobs_rol FROM obs_usuariosRolPermiso 
					WHERE usuarioConPermiso = "'.$_POST['id_Usuario'].'"
					AND idobs_rol = "'.$_POST['Rol'].'"
					AND codigoestado = 200';
					if($ConsultaD=&$db->Execute($SqlConsultaD)===false){
							echo 'Error en el SQL de Modificar tabla o Datos...<br><br>';
							die;
					}
				$UsuarioD = $ConsultaD->GetAll();
				$existeD= $UsuarioD[0][0]['idobs_rol'];
					if(empty($existeD)){
							return false;
					}else{
						 $SQL_Update='UPDATE   obs_usuariosRolPermiso                                    
								SET    codigoestado = 100,
								usuarioCreoPermiso= "'.$_POST['usuarioSession'].'",
								fechaUltimaModificacion=NOW()
								WHERE  usuarioConPermiso = "'.$_POST['id_Usuario'].'" 
								AND codigoestado=200
								AND idobs_rol = "'.$_POST['Rol'].'"';
						
						if($Update=&$db->Execute($SQL_Update)===false){
							echo 'Error en el SQL de Modificar tabla o Datos...<br><br>';
							die;
						}		
					}
					
						
				}
						
				 
	}
	case 'EliminarRol':{
        global $db,$userid,$C_Permisos; 
           
        define(AJAX,true);
        MainGeneral();
        $Usuario = $_POST['id_Usuario'];
		$rol = $_POST['rol'];
        $SQL="UPDATE obs_usuariosRolPermiso
				SET codigoestado = 200
				WHERE
				usuarioConPermiso = '".$Usuario."'
				AND idobs_rol = '".$rol."'";
                 
          if($Update=&$db->Execute($SQL)===false){
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error Al Eliminar el Permiso del usuario';
                echo json_encode($a_vectt);
                exit;    
          } 
          
            $a_vectt['val']			='TRUE';           
			$a_vectt['descrip']		='Rol Eliminado con exito';
            echo json_encode($a_vectt);
            exit;        
        
    }break;
	default:{
        global $db,$userid,$C_Permisos;
        define(AJAX,false);
        
        MainGeneral();
        MainJSGeneral();
        
        $C_Permisos->Display();
        
    }break;
}//switch

function MainGeneral(){
    global $db,$userid,$C_Permisos;
    
    include_once ('Consola_Permisos.class.php');
    
    $C_Permisos = new Permisos();
    
    if(AJAX==false){
        
    include("../templates/templateObservatorio.php");
    
     $db =writeHeader('Consola de Permisos',true,"Permisos",1);
    
    }else{
        
        include ('../templates/mainjson.php');
        
    }
    
   	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
    
}//function MainGeneral
function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}//function MainJson
function MainJSGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="Consola_Permisos.js"></script> 
    <?PHP
}//MainJSGeneral
?>