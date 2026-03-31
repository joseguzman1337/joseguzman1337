<?php
class PermisoEspacioFisico{
    Public function Principal($db){
        ?>
        <div id="container">
            <fieldset>
                <legend>Consola De Permisos Espacios F&iacute;sicos</legend>
                <form id="FromRolEspacioFisico">
                <input type="hidden" id="actionID" name="actionID" value="" />
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
                    <thead>
                        <tr>
                            <th colspan="2">Usuario</th>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align: center;">
                                <?PHP $this->AutoBox('BuscarUser','FormatUser','BuscarUser_id','AutoCompleteUser','Digite el Usuario o Nombre del Usuario o Numero Documento');?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Rol</td>
                            <td>
                                <div id="CargaRol">
                                <?PHP $this->Roles($db);?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="CargaModulos">
                                <?PHP $this->Modulos($db);?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right;">
                                <input type="button" id="SavePermisoRol" name="SavePermisoRol" onclick="GuardarPeriso();" value="Guardar" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </fieldset>
        </div>    
        <?PHP
    }//Public function Principal
    public function AutoBox($name,$Onclik,$NameHidden,$Auto,$Example){
        ?>
        <input type="text" id="<?PHP echo $name?>" id="<?PHP echo $name?>" placeholder="<?PHP echo $Example?>" autocomplete="off" size="70" onclick="<?PHP echo $Onclik?>()" style="text-align: center;" onkeypress="<?php echo $Auto?>()" /><input type="hidden" id="<?PHP echo $NameHidden?>" name="<?PHP echo $NameHidden?>" />
        <?PHP
    }//public function AutoBox
    public function Modulos($db,$id=''){
        if($id){
         $DataPermiso = $this->SQLModuloUsuario($db,$id);   
         }
         
         $Data = $this->SQLModulo($db);
        
        //echo '<pre>';print_r($Data);die;
        ?>
        <fieldset>
            <legend>Modulos</legend>
            <table>
                <?PHP 
                $Check = '';
                $ModuloPermiso = '';
                 for($i=0;$i<count($Data);$i++){
                    if($id){
                        for($j=0;$j<count($DataPermiso);$j++){
                            
                            if($Data[$i]['id']==$DataPermiso[$j]['permiso']){
                                if($DataPermiso[$j]['CodigoEstado']==100){
                                    $Check = 'checked="checked"';
                                }else{
                                    $Check = '';
                                }
                            $ModuloPermiso = $DataPermiso[$j]['id'];
                            }
                        }//for
                    }//if
                    
                    
                       /*************************************************/
                        ?>
                        <tr>
                            <td>
                                <?PHP echo $i+1;?>&nbsp;&nbsp;<input type="checkbox" class="PermisoCheck" <?PHP echo $Check?> onclick="CambioCheck('<?PHP echo $i?>','<?PHP echo $Data[$i]['id'];?>','<?PHP echo $ModuloPermiso;?>')"  id="Permiso_<?PHP echo $i?>" name="Permiso[]" value="<?PHP echo $Data[$i]['id']?>" />&nbsp;&nbsp;<?PHP echo $Data[$i]['Nombre']?>
                            </td>
                        </tr>
                        <?PHP
                        /*************************************************/
                        
                    }//for   
                  
                ?>
            </table>
        </fieldset>
        <?PHP
    }//public function Modulos
    public function SQLModulo($db){
          $SQL='SELECT 

                ModulosEspacioFisicoId As id,
                Nombre,
                Url
                
                FROM 
                
                ModulosEspacioFisico 
                
                WHERE 
                
                CodigoEstado=100';
                
          if($Consulta=&$db->Execute($SQL)===false){
            Echo 'Error En El SQL...<br><br>'.$SQL;
            die;
          }
          
          $Data = $Consulta->GetArray();
          
          Return $Data;      
    }//public function SQLModulo
    public function Roles($db,$id=''){
        if($id){
            $DatoRol = $this->RolUsuarioCarga($db,$id);
        }
        $Dato = $this->SQLRoles($db);
        ?>
        <select id="RolPermiso" name="RolPermiso">
            <option value="0"></option>
            <?PHP 
            for($i=0;$i<count($Dato);$i++){
                if($DatoRol==$Dato[$i]['id']){
                    $Selecte='selected="selected"';
                }else{
                    $Selecte='';
                }
                ?>
                <option <?PHP echo $Selecte?> value="<?PHP echo $Dato[$i]['id']?>"><?PHP echo $Dato[$i]['Nombre']?></option>
                <?PHP
            }//for
            ?>
        </select>
        <?PHP
    }//public function Roles
    public function SQLRoles($db){
          $SQL='SELECT 

                RolEspacioFisicoId AS id,
                Nombre
                
                FROM 
                
                RolEspacioFisico
                
                WHERE 
                
                CodigoEstado=100';
                
          if($Consulta=&$db->execute($SQL)===false){
            echo 'Error EN SQL de Rol...<br><br>'.$SQL;
            die;
          } 
          
        $Data = $Consulta->GetArray();
        
        Return $Data;       
    }//public function SQLRoles
    public function SQLModuloUsuario($db,$id){
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
                    p.Usuarioid="'.$id.'"';
                    
           if($ModulosUsuario=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de los Modulos ASociados a el Usuario...<br><br>'.$SQL;
                die;
           } 
           
           
           
           $i=0;
           
            while(!$ModulosUsuario->EOF){
            /**************************************************/
                $Data[$i]['id']           = $ModulosUsuario->fields['PermisoEspacioFisicoId'];
                $Data[$i]['permiso']      = $ModulosUsuario->fields['ModulosEspacioFisicoId'];
                $Data[$i]['CodigoEstado'] = $ModulosUsuario->fields['CodigoEstado'];
            /**************************************************/
            $i++;
            $ModulosUsuario->MoveNext();
           }//while     
           //echo '<pre>';print_r($Data);
           Return $Data;   
    }//public function SQLModuloUsuario
    public function RolUsuarioCarga($db,$id){
        $SQLRol='SELECT 
           
                    r.RolEspacioFisicoId,
                    r.Nombre
                    
                    FROM PermisoEspacioFisico p  INNER JOIN ModulosEspacioFisico m ON m.ModulosEspacioFisicoId=p.ModulosEspacioFisicoId
                                                 INNER JOIN RolEspacioFisico r ON r.RolEspacioFisicoId=p.RolEspacioFisicoId
                    
                    WHERE
                    
                    r.CodigoEstado=100
                    AND
                    m.CodigoEstado=100
                    AND
                    p.CodigoEstado=100
                    AND
                    p.Usuarioid="'.$id.'"
                    
                GROUP BY r.Nombre';
                    
           if($UsuarioRol=&$db->Execute($SQLRol)===false){
                echo 'Error en el SQL de los Modulos ASociados a el Usuario Rol...<br><br>'.$SQLRol;
                die;
           } 
           
        Return $UsuarioRol->fields['RolEspacioFisicoId'];    
    }//public function RolUsuarioCarga
    public function ResponsableEspacioFisico($db){
         ?>
        <div id="container">
            <fieldset>
                <legend>Consola De Asignaci&oacute;n Responsable Espacios F&iacute;sicos</legend>
                <form id="FromRolEspacioFisico">
                <input type="hidden" id="actionID" name="actionID" value="" />
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="left"  style="width: 100%; text-align: left;" >
                    <thead>
                        <tr>
                            <td><strong>Usuario</strong></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <?PHP $this->AutoBox('BuscarUserName','FormatUserName','BuscarUserName_id','AutoCompleteUserName','Digite el Usuario o Nombre del Usuario o Numero Documento');?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>Espacio F&iacute;sico</strong></td>
                        </tr>
                        <tr>    
                            <td>
                                <div id="Div_EspacioFisico">
                                <?PHP $this->EspaciosFisicos($db,'','BuscarTipoAula');?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de Aula</strong></td>
                        </tr>
                        <tr>    
                            <td>
                                <div id="Div_TipoAula">
                                    <select name="TipoAula" id="TipoAula">
                                        <option value="-1"></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">
                                <input type="button" id="SavePermisoRol" name="SavePermisoRol" onclick="GuardarRespon();" value="Guardar" />
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <div id="VerUserEspacio" ></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </fieldset>
        </div>    
        <?PHP
    }//public function ResponsableEspacioFisico
    public function EspaciosFisicos($db,$id='',$Funcion=''){
        
        
              $SQL='SELECT
                        EspaciosFisicosId AS id,
                        Nombre
                    FROM
                        EspaciosFisicos
                    WHERE
                        codigoestado = 100
                        AND PermitirAsignacion = 1';
                        
            if($Espacios=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Espacios Fiscos...<br><br>'.$SQL;
                die;
            }     
            
         ?>
         <select id="Espacio" name="Espacio" style="display: block;margin:5px;margin-left:20px" onchange="<?PHP echo $Funcion?>(this.value)">
            <option value="-1"></option>
            <?PHP 
            while(!$Espacios->EOF){
                if($id==$Espacios->fields['id']){
                    $Selected = 'selected="selected"';
                }else{
                    $Selected = '';
                }
                ?>
                <option <?PHP echo $Selected;?> value="<?PHP echo $Espacios->fields['id']?>"><?PHP echo $Espacios->fields['Nombre']?></option>
                <?PHP
                $Espacios->MoveNext();
            }
            ?>
         </select>
         <div style="heigth:1px;clear:both"><div>
         <?PHP          
    }//public function EspaciosFisicos
    public function VerEspaciosAsignados($db,$id){
        /*****************************************************/
        $Data = $this->BuscarEspaciosUsuario($db,$id);
        
        ?>
        <style>
            .BorderDiv{
                -webkit-border-radius: 50px;
                -moz-border-radius: 50px;
                border-radius: 50px;
            }
        </style>
        <fieldset>
            <legend><?PHP echo $Data[0]['UserName'];?></legend>
            <table border="1" cellpadding="0" cellspacing="0" style="width: 50%;text-align: left;" class="display">
                <tr>
                    <td><strong>Espacios F&iacute;sicos</strong></td>
                    <td><strong>Tipo Aula</strong></td>
                    <td><strong>Opci&oacute;n</strong></td>
                </tr>
                <?PHP 
                for($i=0;$i<count($Data);$i++){
                   
                    ?>
                    <tr>
                        <td><?PHP echo $Data[$i]['Nombre'];?></td>
                        <td><?PHP $this->TipoEspacioFisico($db,$Data[$i]['EspaciosFisicosId'],$Data[$i]['CodigoTipoSalon'],'ValidarExite',$Data[$i]['UsuarioId'],$Data[$i]['id']);?></td>
                        <td><img src="../../mgi/images/delete.png" title="Eliminar" style="cursor: pointer;;margin: 6px 0;" width="20" onclick="EliminarResponsabilidad(<?PHP echo $Data[$i]['EspaciosFisicosId']?>,'<?PHP echo $Data[$i]['UsuarioId']?>','<?PHP echo $Data[$i]['id']?>','<?PHP echo $Data[$i]['CodigoTipoSalon']?>')" /></td>
                    </tr>
                    <?PHP
                }//for
                ?>
            </table>
        </fieldset>
        <?PHP
        /*****************************************************/
    }//public function VerEspaciosAsignados
    public function BuscarEspaciosUsuario($db,$id){
        
        /*************************************************/
            $SQL='SELECT
                	r.ResponsableEspacioFisicoId AS id,
                	e.EspaciosFisicosId,
                	r.CodigoTipoSalon,
                	CONCAT(u.usuario," :: ",u.nombres," ",u.apellidos) AS UserName,
                	r.UsuarioId,
                    e.Nombre
                FROM
                	ResponsableEspacioFisico r
                INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId = r.EspaciosFisicosId
                INNER JOIN usuario u ON u.idusuario = r.UsuarioId
                WHERE
                	r.CodigoEstado = 100
                AND e.codigoestado = 100
                AND  u.idusuario="'.$id.'"';
                        
               if($UserEspacios=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Usuario Espasio Responsable...<br><br>'.$SQL;
                    die;
               }     
               
            $Data = $UserEspacios->GetArray();
            
            return $Data;        
        /*************************************************/
    }//public function BuscarEspaciosUsuario
    public function TipoEspacioFisico($db,$Espacio,$id='',$Funcion='',$User='',$Indi=''){
        /***********************************************************/
        $Condicion = '';
        if($Espacio==5){
            $Condicion = '  UNION
            
                            SELECT 
                            x.codigotiposalon,
                            x.nombretiposalon
                            FROM
                            tiposalon x
                            WHERE
                            x.codigotiposalon = 0
                            AND x.codigoestado = 100';
        }
          $SQL='SELECT 

                        t.codigotiposalon,
                        t.nombretiposalon
                        
                FROM
                
                        ClasificacionEspacios c INNER JOIN tiposalon t ON t.codigotiposalon=c.codigotiposalon
                
                WHERE 
                
                        c.EspaciosFisicosId="'.$Espacio.'"
                        AND
                        c.codigoestado=100
                        AND
                        t.codigoestado=100 
                
                GROUP BY t.codigotiposalon
                        '.$Condicion.'
                ORDER BY nombretiposalon';
                
            if($TipoEspacio=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de ......<br><br>'.$SQL;
                die;
            }    
            
            ?>
            <select name="TipoAula" id="TipoAula" onchange="<?PHP echo $Funcion?>(this.value,'<?PHP echo $User?>','<?PHP echo $Indi?>','<?PHP echo $Espacio?>')">
                <option value="-1"></option>
                <?PHP 
                while(!$TipoEspacio->EOF){
                    /******************************************************************/
                    if($id==$TipoEspacio->fields['codigotiposalon']){
                        $Selected = 'selected="selected"';
                    }else{
                        $Selected = '';
                    }
                    ?>
                    <option <?PHP echo $Selected?> value="<?PHP echo $TipoEspacio->fields['codigotiposalon']?>"><?PHP echo $TipoEspacio->fields['nombretiposalon']?></option>
                    <?PHP   
                    /******************************************************************/
                    $TipoEspacio->MoveNext();
                }        
                ?>
            </select>
            <?PHP
            
        /***********************************************************/
    }//public function TipoEspacioFisico
}//Class
?>