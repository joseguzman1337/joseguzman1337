<?php
class PermisosConvenio{
    public function Roles($db){
        $SQL='SELECT RolSistemaId AS id, Nombre FROM RolSistema WHERE CodigoEstado=100 AND TipoSistema=1';        
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
        $SQL=$Select.'SELECT ModuloSistemaId, Nombre FROM ModulosSistema WHERE CodigoEstado=100 AND TipoSistema=1'.$Condicion_2.$Condicion.' ORDER BY Orden ASC';
        
        if($Modulos=&$db->GetAll($SQL)===false){
            Echo 'Error en el SQL de Modulos...<br><br>'.$SQL;
            die;
        }
        
        return $Modulos;
    }//public function Roles 
    public function NenRolModuloConvenio($db,$Info,$userid){
        $User    = $Info['BuscarUser_id'];
        $Rol     = $Info['Rol'];
        $Modulos = $Info['Modulos'];
        
        $Update='UPDATE PermisoSistema SET    CodigoEstado=200,  UsuarioUltimaModificacion="'.$userid.'", FechaUltimaModificacion=NOW()
                 WHERE Usuarioid="'.$User.'"';
        if($Cancela=&$db->Execute($Update)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error al Modificar o Activar los Permisos al Usuario Convenios 1 ....';
            echo json_encode($a_vectt);
            exit; 
        }
        
        for($i=0;$i<count($Modulos);$i++)
        {
            $SQL='SELECT PermisoSistemaId,CodigoEstado FROM PermisoSistema WHERE ModuloSistemaId="'.$Modulos[$i].'" AND RolSistemaId="'.$Rol.'" AND Usuarioid="'.$User.'"';
            if($Valida=&$db->Execute($SQL)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Validar los Permisos al Usuario Convenios ....';
                echo json_encode($a_vectt);
                exit; 
            }
            
            if($Valida->EOF)
            {    
                $Query='INSERT INTO  PermisoSistema(ModuloSistemaId,Usuarioid,RolSistemaId,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$Modulos[$i].'","'.$User.'","'.$Rol.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
                
                if($Insert=&$db->Execute($Query)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error al Insertar los Permisos al Usuario Convenios ....';
                    echo json_encode($a_vectt);
                    exit; 
                }
                
            }else{
                if($Valida->fields['CodigoEstado']==200){
                    
                    $Update='UPDATE PermisoSistema
                             SET    CodigoEstado=100,
                                    UsuarioUltimaModificacion="'.$userid.'",
                                    FechaUltimaModificacion=NOW(),
                                    RolSistemaId="'.$Rol.'"
                             WHERE
                                    ModuloSistemaId="'.$Modulos[$i].'" AND Usuarioid="'.$User.'" ';
                    
                    if($Activa=&$db->Execute($Update)===false){
                        $a_vectt['val']			=false;
                        $a_vectt['descrip']		='Error al Modificar o Activar los Permisos al Usuario Convenios  2....';
                        echo json_encode($a_vectt);
                        exit; 
                    }
                }//if 200
            }  
        }//for  
        
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
                        AND r.TipoSistema = 1
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
    public function PermisoUsuarioConvenio($db,$userid,$op,$Archivo)
    {
        $SQL="SELECT p.RolSistemaId, p.ModuloSistemaId, m.Url, m.Nombre
            FROM
            	PermisoSistema p INNER JOIN ModulosSistema  m ON m.ModuloSistemaId=p.ModuloSistemaId
            WHERE
            	p.CodigoEstado = 100
            AND p.Usuarioid = '".$userid."' 
            AND p.ModuloSistemaId = '".$Archivo."'";                                 		
          if($op==1){
             if($Rol=&$db->execute($SQL)===false){
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
            case 1:{
                /*Administrador Jurídico*/
                $Data[] = 1;//Gestión de Convenios
                $Data[] = 2;//Gestión de Instituciones
                $Data[] = 3;//Gestión de Acuerdos
                $Data[] = 4;//Gestión de Solicitud de Convenios
                $Data[] = 5;//Reporte de Convenios
                $Data[] = 6;//Cargue de Covenios/Instituciones
                $Data[] = 7;//Actividades de Convenios
                //$Data[] = 8;//Detalles Convenios en Tramite
                $Data[] = 9;//Detalles Convenios en Tramite
            }break;
            case 2:{
                /*Administrador Convenios*/
                $Data[] = 1;//Gestión de Convenios
                $Data[] = 2;//Gestión de Instituciones
                $Data[] = 3;//Gestión de Acuerdos
                $Data[] = 4;//Gestión de Solicitud de Convenios
                $Data[] = 5;//Reporte de Convenios
                $Data[] = 6;//Cargue de Covenios/Instituciones
                $Data[] = 7;//Actividades de Convenios
                $Data[] = 9;//Detalles Convenios en Tramite
                //$Data[] = 8;//Detalles Convenios en Tramite
                $Data[] = 14;//Gestion de Contraprestaciones
            }break;
            case 3:{
                /*Administrador Facultad*/
                $Data[] = 1;//Gestión de Convenios
                $Data[] = 2;//Gestión de Instituciones
                $Data[] = 4;//Gestión de Solicitud de Convenios
                $Data[] = 12;//Detalles Convenio En Tramite  
                //$Data[] = 8;//Sistema de Convenios             
            }break;
            case 4:{
                /*Supervisor Facultad*/
                $Data[] = 7;//Actividades de Convenios
               // $Data[] = 8;//Sistema de Convenios    
            }break;
            case 8:{
                /*Administrador Financiero*/
                $Data[] = 14;//Gestion de Contraprestaciones  
                 $Data[] = 9;//Reporte Rotaciones  
            }break;
            case 9:{
                /*Administrador Convenios Nacionales*/
                $Data[] = 1;//Gestión de Convenios
                $Data[] = 2;//Gestión de Instituciones
                $Data[] = 4;//Gestión de Solicitud de Convenios 
                $Data[] = 5;//Reporte de Convenios
            }break;
            case 10:{
                /*Administrador Convenios Internacionales*/
                $Data[] = 1;//Gestión de Convenios
                $Data[] = 2;//Gestión de Instituciones
                $Data[] = 4;//Gestión de Solicitud de Convenios
                $Data[] = 5;//Reporte de Convenios    
            }break;
            case 11:{
                /*Administrador Jurídico Secretaria Generral*/
                $Data[] = 1;//Gestión de Convenios
                $Data[] = 4;//Gestión de Solicitud de Convenios                
 
            }break;
            case 12:{
                /*Firmas (Rectoria - Vicerrectoria)*/
                $Data[] = 1;//Gestión de Convenios
                $Data[] = 4;//Gestión de Solicitud de Convenios                
            }break;
        }
        
        if($Op==1){
            $this->VerModulosRolActivo($db,$Data);
        }else{
        
            $Modulos = $this->PermisoUsuarioConvenio($db,$userid,2,$Archivo);
            
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