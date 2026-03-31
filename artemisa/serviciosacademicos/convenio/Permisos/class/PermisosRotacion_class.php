<?php
class PermisosRotacion{
    public function Roles($db){
        $SQL='SELECT RolSistemaId AS id, Nombre FROM RolSistema WHERE CodigoEstado=100 AND TipoSistema=2';
        
        if($Roles=&$db->GetAll($SQL)===false){
            Echo 'Error en el SQL de Roles...<br><br>'.$SQL;
            die;
        }
        
        return $Roles;
    }//public function Roles    
    public function Modulos($db,$Data=''){
        $Select      = '';
        $Condicion   = '';
        $Condicion_2 = '';
        if($Data){
            for($i=0;$i<count($Data);$i++){
                if($i<1){
                    $IN = $Data[$i];    
                }else{
                    $IN = $IN.','.$Data[$i];
                }
                
            }//for
             $Select = 'SELECT
                            m.ModuloSistemaId,
                            m.Nombre,
                            IF(x.ModuloSistemaId=m.ModuloSistemaId,"1","0") AS Activo
                        FROM
                            ModulosSistema m LEFT JOIN (';
            $Condicion = ') x ON x.ModuloSistemaId=m.ModuloSistemaId'; 
            
            $Condicion_2 = ' AND ModuloSistemaId IN('.$IN.')';               
        }
        $SQL=$Select.'SELECT ModuloSistemaId, Nombre FROM ModulosSistema WHERE CodigoEstado=100 AND TipoSistema=2'.$Condicion_2.$Condicion.' ORDER BY Orden ASC';
        
        if($Modulos=&$db->GetAll($SQL)===false){
            Echo 'Error en el SQL de Modulos...<br><br>'.$SQL;
            die;
        }
        
        return $Modulos;
    }//public function Roles 
    public function NenRolModuloConvenio($db,$Info,$userid){
        $User    = $Info['BuscarUser_id'];
        $Rol     = $Info['Rol'];
	  
        //Consultar si el usuario existe en la tabla de permisos 
        $SQL="SELECT P.PermisoSistemaId,P.Usuarioid,P.RolSistemaId
		FROM PermisoSistema P
		INNER JOIN RolSistema R ON R.RolSistemaId = P.RolSistemaId
		WHERE P.RolSistemaId = '$Rol'
		AND Usuarioid='$User'
		AND R.TipoSistema = 2";
        
		if($Valida=&$db->Execute($SQL)===false){
			$a_vectt['val']			=false;
			$a_vectt['descrip']		='Error al Validar los Permisos al Usuario  ....';
			echo json_encode($a_vectt);
			exit; 
		}
		$idPermiso= $Valida->fields['PermisoSistemaId'];
		
		if (empty($idPermiso))
		{
			if($Rol <> '5')
			{
				$Modulos = 9;
				$Query='INSERT INTO PermisoSistema(ModuloSistemaId,Usuarioid,RolSistemaId,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)
			     VALUES("'.$Modulos.'","'.$User.'","'.$Rol.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
				if($Insert=&$db->Execute($Query)===false){
					$a_vectt['val']			=false;
					$a_vectt['descrip']		='Error al Insertar los Permisos al Usuario ....';
					echo json_encode($a_vectt);
					exit; 
				}
			}else{
				/*Necesario para insertar todos los permisos*/
				$Query='INSERT INTO PermisoSistema(ModuloSistemaId,Usuarioid,RolSistemaId,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)
			     VALUES("9","'.$User.'","'.$Rol.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
				if($Insert=&$db->Execute($Query)===false){
					$a_vectt['val']			=false;
					$a_vectt['descrip']		='Error al Insertar los Permisos al Usuario ....';
					echo json_encode($a_vectt);
					exit; 
				}
				$Query='INSERT INTO PermisoSistema(ModuloSistemaId,Usuarioid,RolSistemaId,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)
			     VALUES("10","'.$User.'","'.$Rol.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
				if($Insert=&$db->Execute($Query)===false){
					$a_vectt['val']			=false;
					$a_vectt['descrip']		='Error al Insertar los Permisos al Usuario ....';
					echo json_encode($a_vectt);
					exit; 
				}
				$Query='INSERT INTO PermisoSistema(ModuloSistemaId,Usuarioid,RolSistemaId,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)
			     VALUES("11","'.$User.'","'.$Rol.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
				if($Insert=&$db->Execute($Query)===false){
					$a_vectt['val']			=false;
					$a_vectt['descrip']		='Error al Insertar los Permisos al Usuario ....';
					echo json_encode($a_vectt);
					exit; 
				}
				
			}
		   /*Inactivar el resto de roles para Rotación*/
			$Update="UPDATE PermisoSistema
					SET    
					    CodigoEstado = '200'
					WHERE
						Usuarioid='$userid'
						AND ModuloSistemaId >4
						AND RolSistemaId <> '$Rol'";
			
			if($Insert=&$db->Execute($Update)===false){
				$a_vectt['val']			=false;
				$a_vectt['descrip']		='Error al Actualizar los Permisos al Usuario ....';
				echo json_encode($a_vectt);
				exit; 
			}
		}else
		{
		   $Update="UPDATE PermisoSistema
					SET    RolSistemaId='$Rol',
							UsuarioUltimaModificacion='$userid',
							FechaUltimaModificacion=NOW(),
							CodigoEstado = '100'
					WHERE
						Usuarioid='$userid'
						AND RolSistemaId = '$Rol'";
			if($Cancela=&$db->Execute($Update)===false)
			{
				$a_vectt['val']			=false;
				$a_vectt['descrip']		='Error al Modificar o Activar los Permisos al Usuario   ....';
				echo json_encode($a_vectt);
				exit; 
			}
			 /*Inactivar el resto de roles para Rotación*/
			$Update="UPDATE PermisoSistema
					SET    
					    CodigoEstado = '200'
					WHERE
						Usuarioid='$userid'
						AND ModuloSistemaId >4
						AND RolSistemaId <> '$Rol'";
			
			if($Insert=&$db->Execute($Update)===false){
				$a_vectt['val']			=false;
				$a_vectt['descrip']		='Error al Actualizar los Permisos al Usuario ....';
				echo json_encode($a_vectt);
				exit; 
			}
        }	
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Almacenado Correctamente.';
        echo json_encode($a_vectt);
        exit;
    }//public function NenRolModuloConvenio
    public function RolesUserActivo($db,$id){
           $SQL='SELECT
                        r.RolSistemaId AS id,
                        r.Nombre
                FROM
                        RolSistema r INNER JOIN PermisoSistema p ON p.RolSistemaId=r.RolSistemaId
                WHERE
                        r.CodigoEstado = 100
                        AND r.TipoSistema = 2
                        AND p.Usuarioid="'.$id.'"
                        AND p.CodigoEstado=100
                
                GROUP BY r.RolSistemaId';
                
          if($RolActivo=&$db->Execute($SQL)===false){
                echo 'Error en el SQL del Rol Activo en el Usuario...';
                die;
          } 
          
          $Roles = $this->Roles($db);     
          
          ?>
           <select id="Rol" name="Rol" onchange="ModuloRoles(this.value)" >
              <option value="-1"></option>
              <?PHP 
              for($i=0;$i<count($Roles);$i++){
                if($Roles[$i]['id']==$RolActivo->fields['id']){
                    $selected = 'selected="selected"';
                }else{
                    $selected = '';
                }
                ?>
                <option <?PHP echo $selected?> value="<?PHP echo $Roles[$i]['id']?>"><?PHP echo $Roles[$i]['Nombre']?></option>
                <?PHP
              }//for
              ?>
          </select>    
          <?PHP
    }//public function RolesUserActivo
    public function ModulosUserActivo($db,$id){
          $SQL='SELECT
                ms.ModuloSistemaId,
                ms.Nombre,
                IF (x.id = ms.ModuloSistemaId,"1","0") AS X
                FROM
                ModulosSistema ms
                LEFT JOIN (
                            SELECT
                            	m.ModuloSistemaId AS id
                            FROM
                            	ModulosSistema m
                            INNER JOIN PermisoSistema p ON p.ModuloSistemaId = m.ModuloSistemaId
                            WHERE
                            	p.CodigoEstado = 100
                            AND p.Usuarioid="'.$id.'"
                ) x ON x.id = ms.ModuloSistemaId
                
                GROUP BY ms.ModuloSistemaId';
                        
          if($ModulosActivo=&$db->GetAll($SQL)===false){
                echo 'Error en el SQL del Modulos Activo en el Usuario...';
                die;
          } 
          
        for($i=0;$i<count($ModulosActivo);$i++){
            
            if($ModulosActivo[$i]['X']==1){
                $Checked = 'checked="checked"';
            }else{
                $Checked = '';
            }
             ?>
             <input type="checkbox" <?PHP echo $Checked?> id="Modulo_<?PHP echo $ModulosActivo[$i]['ModuloSistemaId']?>" name="Modulos[]" class="ModulosClass" value="<?PHP echo $ModulosActivo[$i]['ModuloSistemaId']?>" />&nbsp;<?PHP echo $ModulosActivo[$i]['Nombre']?><br />
             <?PHP
        }//for
        
    }//public function ModulosUserActivo
    public function PermisoUsuarioRotacion($db,$userid,$op,$Archivo){
      if($op==1){
        $Group_By = 'GROUP BY RolSistemaId';
      }else{
        $Group_By = 'GROUP BY ModuloSistemaId';
      }
        $SQL='SELECT
            	p.RolSistemaId,
            	p.ModuloSistemaId,
            	m.Url,
                m.Nombre
            FROM
            	PermisoSistema p INNER JOIN ModulosSistema  m ON m.ModuloSistemaId=p.ModuloSistemaId
            WHERE
				m.TipoSistema=2
				and	p.CodigoEstado = 100
            AND p.Usuarioid = "'.$userid.'"
            '.$Group_By;
            //echo $SQL;
          if($op==1){
             if($Rol=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Rol....<br><br>'.$SQL;
                die;
             }
             if(!$Rol->EOF){
                $Acceso = $this->AccesoRol($db,$userid,$Rol->fields['RolSistemaId'],$Archivo);
                
                $C_Rol['val'] = $Acceso;
                $C_Rol['Rol'] = $Rol->fields['RolSistemaId'];
                $C_Rol['msn'] = 'No tiene Acceso. !!!';
                
                return $C_Rol;
             }else{
                $C_Rol['val'] = false;
                $C_Rol['msn'] = 'No tiene Acceso. !!!';
                
                return $C_Rol;
             }
          }else{
			
            if($Permisos=&$db->GetAll($SQL)===false){
                echo 'Error en el SQL de Permisos....<br><br>'.$SQL;
                die;
             }
			 
             if(!$Permisos->EOF){
                $C_permiso['val']  = true;
                $C_permiso['Data'] = $Permisos;
                
                return $C_permiso;
             }else{
                $C_permiso['val']  = false;
                $C_permiso['msn'] = 'No tiene Acceso. !!!';
                return $C_permiso;
             }
          }    
    }//public function PermisoUsuarioConvenio
    public function AccesoRol($db,$userid,$Rol,$Archivo,$Op=''){
        switch($Rol){
            case 5:{
                /*Responsable Rotaciones*/
                $Data[] = 9;//Reporte de Rotaciones
				$Data[] = 10;//Rotacion de Grupos
				$Data[] = 11;//Administrar Especialidades
            }break;
			case 6:{
                /*Supervisor Rotaciones*/
                $Data[] = 9;//Reporte de Rotaciones
            }break;
			case 7:{
                /*Administrador financiero*/
                $Data[] = 9;//Reporte de Rotaciones
                $Data[] = 16;//Reporte de Rotaciones
            }break;
        }
        
        if($Op==1){
            $this->VerModulosRolActivo($db,$Data);
        }else{
        
            $Modulos = $this->PermisoUsuarioRotacion($db,$userid,2,$Archivo);
            
            for($j=0;$j<count($Modulos['Data']);$j++){
                for($x=0;$x<count($Data);$x++){
                    if($Modulos['Data'][$j]['ModuloSistemaId']==$Data[$x]){
                        $Acceso[] = $Data[$x];
                    }
                }//for            
            }//for
            
            $val = 0;
            for($i=0;$i<count($Acceso);$i++){
                if($Archivo==$Acceso[$i]){
                    $val = 1;
                }
            }//for
            
            if($val==1){
                return true;
            }else{
                return false;
            }
        }
    }//public function AccesoRol
    public function VerModulosRolActivo($db,$Data){
        $Modulos = $this->Modulos($db,$Data);
        
         for($i=0;$i<count($Modulos);$i++){
            if($Modulos[$i]['Activo']==1){
                $Disabled = '';
            }else{
                $Disabled = 'disabled="disabled"';
            }
                 ?>
                 <input type="checkbox"  <?PHP echo $Disabled?> id="Modulo_<?PHP echo $Modulos[$i]['ModuloSistemaId']?>" name="Modulos[]" class="ModulosClass" value="<?PHP echo $Modulos[$i]['ModuloSistemaId']?>" />&nbsp;<?PHP echo $Modulos[$i]['Nombre']?><br />
                 <?PHP
             
        }//for
    }//public function VerModulosRolActivo
}//class PermisosConvenio
?>