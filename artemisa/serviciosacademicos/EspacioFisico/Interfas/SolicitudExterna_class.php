<?php
class InterfazSolicitudExterna{
    public function Principal($db,$C_InterfazSolicitud='',$id=''){
        $DisabledClass = '';
        $Funcion = '';
        if($id){
            $Datos = $this->DataEditar($db,$id);
            //echo '<pre>';print_r($Datos);die;
            $Modalidad       = $Datos['Principal'][0]['codigomodalidadacademica'];
            $Carrera         = $Datos['Principal'][0]['codigocarrera'];
            $UnidadNombre    = $Datos['Principal'][0]['UnidadNombre'];
            $NombreEvento    = $Datos['Principal'][0]['NombreEvento'];
            $NumAsistentes   = $Datos['Principal'][0]['NumAsistentes'];
            $Responsable     = $Datos['Principal'][0]['Responsable'];
            $Telefono        = $Datos['Principal'][0]['Telefono'];
            $Email           = $Datos['Principal'][0]['Email'];
            $TipoAula        = $Datos['Principal'][0]['codigotiposalon'];  
            $Acceso          = $Datos['Principal'][0]['AccesoDiscapacitados'];  
            $FechaInicio     = $Datos['Principal'][0]['FechaInicio'];
            $FechaFinal      = $Datos['Principal'][0]['FechaFinal'];
            $SolicitudPadreId = $Datos['SolicitudPadreId'];
            $DisabledClass = 'disabled="disabled"';
            
            if($Acceso==1){
                $checked = 'checked="checked"';
            }else{
                $checked = '';
            }
            
            $IDS             = $Datos['IDS'];
           
            $Grupos          = $Datos['Grupos'];
            
            if($Grupos){
                for($G=0;$G<count($Grupos);$G++){
                    $DataGrupo = $DataGrupo.'::'.$Grupos[$G]['idgrupo'];
                }//for
            }
             
            $Horario = $Datos['Horaio'];    
            
            $Funcion = '2';   
        }
        
        ?>
        <!DOCTYPE HTML  "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <link rel="stylesheet" href="../css/jquery.clockpick.1.2.9.css" type="text/css" /> 
                <link rel="stylesheet" href="../css/Styleventana.css" type="text/css" />
                
                <link rel="stylesheet" href="../../mgi/../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
                
                <script type="text/javascript" language="javascript" src="../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.js"></script>
                <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.js"></script>
                <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.min.js"></script>
                <script type="text/javascript" language="javascript" src="../js/jquery.bpopup.min.js"></script>
               
         </head>
            <body>
                <div id="pageContainer">
                <h2>M&oacute;dulo de Solicitudes Externas de  Espacios F&iacute;sicos</h2>
                <fieldset style="width:90%;" aling="center">
                	<legend>Solicitud Externa de Espacios F&iacute;sicos</legend>
                        <form id="SolicitudExterna">
                           <input type="hidden" name="actionID" id="actionID" <?php echo (isset($id)) ? 'value="ModificarSolicitud"' : '' ; ?> />
                           <input type="hidden" name="SolicitudPadre" id="SolicitudPadre" value="<?PHP echo $SolicitudPadreId?>" />
                           <?PHP 
                          // echo'<pre>';print_r($IDS);
                           for($i=0;$i<count($IDS);$i++){
                                ?>
                                <input type="hidden" name="SolicitudExt_ID[]" id="SolicitudExt_ID" value="<?PHP echo $IDS[$i]['id']?>" />
                                <?PHP
                            }//for
                           ?>
                           
                           <table  border="0" style="width: 100%; " cellpadding="0" cellspacing="0"  >
                                <thead>
                                    <tr>
                                        <th>Unidad Academica o Administrativa&nbsp;<span style="color: red;">*</span></th>
                                        <th>
                                            <?PHP Modalidad($db,'',$Modalidad,'',$DisabledClass);?>
                                            <?PHP 
                                            if($Modalidad){
                                                ?>
                                                <input value="<?PHP echo $Modalidad?>" name="Modalidad" id="Modalidad" type="hidden" />
                                                <?PHP
                                            }
                                            ?>
                                            
                                        </th>
                                    </tr>
                                    <tr>
                                    <th>Programa Acad&eacute;mico&nbsp;&nbsp;<span style="color: red;">*</span></th>
                                    <th id="Th_Progra" style=" width: 20%;">
                                       <?PHP
                                       if($Carrera){
                                        AutoPrograma('ProgramaText','Programa',$db,$Carrera,'',$DisabledClass);
                                       }else{
                                       AutocompletarBox('ProgramaText','Programa','AutocomplePrograma');
                                       }
                                       ?>
                                    </th>
                                    </tr>
                                    <tr>
                                        <th>Nombre de la Unidad Solicitante&nbsp;<span style="color: red;">*</span></th>
                                        <th>
                                            <input type="text" id="Unidad" name="Unidad" size="80" value="<?PHP echo $UnidadNombre?>" />
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Nombre de la Actividad - Evento&nbsp;<span style="color: red;">*</span></th>
                                        <th>
                                            <input type="text" name="Evento" id="Evento" size="80" value="<?PHP echo $NombreEvento?>" />
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Grupos &oacute; Materia</th>
                                        <th id="Th_Grupo" style=" width: 20%;">
                                           <?PHP
                                           AutocompletarBox('GrupoMateria','GrupoMateria_id','AutocompleGrupoMateria','');
                                           ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" name="GruposAdd" id="GruposAdd" value="<?PHP echo $DataGrupo?>" />
                                            <fieldset>
                                                <legend>Grupos Y Materias</legend>
                                                <div id="DivGruposMateria">
                                                <?PHP                                                 
                                                if($DataGrupo){
                                                    $this->MultiGrupoMateria($db,$DataGrupo);
                                                }
                                                ?>    
                                                </div>
                                            </fieldset>
                                        </td>
                                    </tr>
                                     <tr>
                                        <th>N&deg; Asistentes&nbsp;<span style="color: red;">*</span></th>
                                        <th>
                                            <input type="text" id="NumAsistentes" name="NumAsistentes" size="25" onkeydown="return validarNumeros(event)" value="<?PHP echo $NumAsistentes?>" />
                                        </th>
                                     </tr>
                                     <tr>   
                                        <th>Acceso a Discapacitados</th>
                                        <th>
                                            <input type="checkbox" id="Acceso" name="Acceso" <?PHP echo $checked?>  />
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">
                                            <fieldset>
                                                <legend>Informaci&oacute;n Contacto</legend>
                                                <table>
                                                    <tr>
                                                        <th>Persona Responsable&nbsp;<span style="color: red;">*</span></th>
                                                        <th>
                                                            <input type="text" id="Persona" name="Persona" size="80" value="<?PHP echo $Responsable?>" />
                                                        </th>
                                                    </tr>    
                                                    <tr>    
                                                        <th>Telefono&nbsp;<span style="color: red;">*</span></th>
                                                        <th>
                                                            <input type="text" id="Telefono" name="Telefono" onkeydown="return validarNumeros(event)"  value="<?PHP echo $Telefono?>" />
                                                        </th>
                                                    </tr>
                                                    <tr>    
                                                        <th>E-mail&nbsp;<span style="color: red;">*</span></th>
                                                        <th>
                                                            <input type="text" id="Email" name="Email" value="<?PHP echo $Email?>"  />
                                                        </th>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                        <?PHP //TipoSalon($db,$TipoAula,'need','1');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?PHP 
                                            Tabs($db,$Horario,2,$FechaInicio,$FechaFinal);
                                            ?>
                                        </td>
                                    </tr>   
                                    <tr>
                                        <td colspan="2"><strong>Observaciones</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <textarea id="Observacion" name="Observacion" cols="160" rows="10"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: right;">
                                            <input type="button" id="SaveSolicitudExterna" name="SaveSolicitudExterna" value="Guardar" onclick="SaveExterno('<?PHP echo $Funcion;?>')" />
                                        </td>
                                    </tr>
                                </tbody>    
                           </table>
                        </form> 
                </fieldset>
                </div>    
            </body>
         </html>             
        <?PHP
    }//public function Principal 
    public function MultiGrupoMateria($db,$grupo){
        $Data = explode('::',$grupo);
        
        //echo '<pre>';print_r($Data);
        ?>
        <table>
        <?PHP
       for($i=1;$i<count($Data);$i++){
             $SQL='SELECT
                    	g.idgrupo,
                    g.nombregrupo,
                    m.nombremateria,
                    m.codigomateria
                    FROM
                    	grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
                    
                    WHERE 
                    g.idgrupo="'.$Data[$i].'"';
                    
                    if($GrupoMateria=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL de Grupo Multi Materia....<br><BR>'.$SQL;
                        die;    
                    }
              ?>
              <tr>
                <td><?PHP echo 'ID Grupo :: '.$GrupoMateria->fields['idgrupo']?></td>
                <td><?PHP echo ':: Grupo :: '.$GrupoMateria->fields['nombregrupo']?></td>
                <td><?PHP echo 'ID Materia :: '.$GrupoMateria->fields['codigomateria']?></td>
                <td><?PHP echo ':: Materia :: '.$GrupoMateria->fields['nombremateria']?></td>
                <td>
                    <input type="checkbox" checked="true" id="Grupo_<?PHP echo $Data[$i]?>" name="MultiGrupos[]" value="<?PHP echo $Data[$i]?>" onclick="DeleteGrupoMateria('<?PHP echo $Data[$i]?>')"  />
                </td>
              </tr>     
              <?PHP      
        }//for
       ?>
       </table>
       <?PHP
    }//public function MultiGrupoMateria
    public function DataEditar($db,$id){
         
        $SQL='SELECT

                s.SolicitudAsignacionEspacioId AS id,
				a.SolicitudPadreId,
                s.AccesoDiscapacitados,
                s.FechaInicio,
                s.FechaFinal,
                s.observaciones,
                s.NombreEvento,
                s.NumAsistentes,
                s.UnidadNombre,
                s.Responsable,
                s.Telefono,
                s.Email,
                s.codigomodalidadacademica,
                s.codigocarrera,
                c.nombrecarrera,
                m.nombremodalidadacademica,
                st.codigotiposalon,
                s.UsuarioCreacion
				
                FROM
                
                SolicitudAsignacionEspacios s INNER JOIN carrera c ON c.codigocarrera=s.codigocarrera
                                              INNER JOIN modalidadacademica m ON m.codigomodalidadacademica=s.codigomodalidadacademica
                                              INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
											  INNER JOIN AsociacionSolicitud a ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
											  
                WHERE
                
                a.SolicitudPadreId="'.$id.'"
                AND
                s.codigoestado=100'; 
				
                if($DataPrincipal=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Data Principal...<br><br>'.$SQL;
                    die;
                }
                
                /*********************************************/
                   $SQL='SELECT
                        s.SolicitudAsignacionEspacioId AS id
                        FROM
                        AsociacionSolicitud a INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                        INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                        WHERE
                        a.SolicitudPadreId="'.$id.'"
                        AND
                        s.codigoestado=100';
                        
                 if($DataId=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL de Data Id Asociado...<br><br>'.$SQL;
                        die;
                    }       
                    
                 $ID_Asociado = $DataId->GetArray();      
                /********************************************/
                
                $C_Principal = $DataPrincipal->GetArray();
                
                $SQL_Grupo='SELECT
                            idgrupo
                            FROM
                            SolicitudEspacioGrupos 
                            WHERE
                            SolicitudAsignacionEspacioId="'.$ID_Asociado[0]['id'].'"
                            AND
                            codigoestado=100';
                            
                            
               if($DataGrupo=&$db->Execute($SQL_Grupo)===false){
                    echo 'Error en el SQL de Data Grupo...<br><br>'.$SQL_Grupo;
                    die;
                }  
                
                $C_Grupo = $DataGrupo->GetArray();
                //echo '<pre>';print_r($C_Grupo);die;           
                 for($i=0;$i<count($C_Grupo);$i++){
                        if($i<1){
                            $Grupos_IN = '"'.$C_Grupo[$i]['idgrupo'].'"';
                        }else{
                            $Grupos_IN = $Grupos_IN.',"'.$C_Grupo[$i]['idgrupo'].'"';
                        }
                 }//for   
                 
                 if($Grupos_IN){      
                 
                       
                            for($i=0;$i<count($ID_Asociado);$i++){
                                if($i<1){
                                    $ID_IN = '"'.$ID_Asociado[$i]['id'].'"';
                                }else{
                                    $ID_IN = $ID_IN.',"'.$ID_Asociado[$i]['id'].'"';
                                }
                            }//for   
                            
                            
                    $SQL_D='SELECT
                            	s.FechaInicio,
                            	s.FechaFinal,
                            	sg.idgrupo
                            FROM
                            	SolicitudAsignacionEspacios s
                                    INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                            WHERE
                            	s.SolicitudAsignacionEspacioId = "'.$ID_Asociado[0]['id'].'"
                                AND s.codigoestado = 100 '; 
                            
                       if($Inicio=&$db->Execute($SQL_D)===false){
                        echo 'Error en el SQl Incio de Busqueda...<br><br>'.$SQL_D;
                        die;
                       }  
                       
                   while(!$Inicio->EOF){
                    
                    $SQL_C='SELECT
                                    s.SolicitudAsignacionEspacioId AS id,
                                    s.codigodia,
                                    d.nombredia,
                                    s.ClasificacionEspaciosId AS Sede,
                                    c.Nombre,
                                    a.HoraInicio,
                                    a.HoraFin
                            FROM
                                    SolicitudEspacioGrupos sg
                                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                                        INNER JOIN dia d ON d.codigodia = s.codigodia
                                        INNER JOIN ClasificacionEspacios c ON s.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                                        INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                            WHERE
                                    sg.idgrupo = "'.$Inicio->fields['idgrupo'].'"
                                    AND s.FechaInicio = "'.$Inicio->fields['FechaInicio'].'"
                                    AND s.FechaFinal = "'.$Inicio->fields['FechaFinal'].'"
                                    AND s.codigoestado = 100
                            
                            GROUP BY s.codigodia';
                            
                     if($Final=&$db->Execute($SQL_C)===false){
                        echo 'Error en el SQL De la Fianlizacion de la Busqueda...<br><br>'.$SQL_C;
                        die;
                     }  
                    
                    $Data  = $Final->GetArray();
                    
                    for($i=0;$i<count($Data);$i++){
                        
                       $SQL_C='SELECT
                                    s.SolicitudAsignacionEspacioId AS id,
                                    s.codigodia,
                                    d.nombredia,
                                    s.ClasificacionEspaciosId AS Sede,
                                    c.Nombre,
                                    a.HoraInicio,
                                    a.HoraFin
                            FROM
                                    SolicitudEspacioGrupos sg
                                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                                        INNER JOIN dia d ON d.codigodia = s.codigodia
                                        INNER JOIN ClasificacionEspacios c ON s.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                                        INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                            WHERE
                                    sg.idgrupo = "'.$Inicio->fields['idgrupo'].'"
                                    AND s.FechaInicio = "'.$Inicio->fields['FechaInicio'].'"
                                    AND s.FechaFinal = "'.$Inicio->fields['FechaFinal'].'"
                                    AND s.codigoestado = 100
                                    AND s.codigodia="'.$Data[$i]['codigodia'].'"
                            
                            GROUP BY s.codigodia,s.ClasificacionEspaciosId,a.HoraInicio,a.HoraFin';
                            
                     if($FinalDetalle=&$db->Execute($SQL_C)===false){
                        echo 'Error en el SQL De la Fianlizacion de la Busqueda...<br><br>'.$SQL_C;
                        die;
                     }  
                        
                        /*$C_Cuerpo[$i][$Data[$i]['codigodia']]['id'] = $Data[$i]['id'];
                        $C_Cuerpo[$i][$Data[$i]['codigodia']]['codigodia'] = $Data[$i]['codigodia'];
                        $C_Cuerpo[$i][$Data[$i]['codigodia']]['nombredia'] = $Data[$i]['nombredia'];
                        $C_Cuerpo[$i][$Data[$i]['codigodia']]['Sede'] = $Data[$i]['Sede'];
                        $C_Cuerpo[$i][$Data[$i]['codigodia']]['Nombre']= $Data[$i]['Nombre'];
                        $C_Cuerpo[$i][$Data[$i]['codigodia']]['HoraInicio'] = $Data[$i]['HoraInicio'];
                        $C_Cuerpo[$i][$Data[$i]['codigodia']]['HoraFin'] = $Data[$i]['HoraFin'];*/
                        
                        $C_Cuerpo[$Data[$i]['codigodia']] = $FinalDetalle->GetArray();
                    }//for
                    
                    $Inicio->MoveNext();
                   }       
                
           }else{
               
                 
                      
                       $C_Grupo = '';
                       
                       for($i=0;$i<count($ID_Asociado);$i++){
                            $id        = $ID_Asociado[$i]['id'];
                            $codigodia = $ID_Asociado[$i]['codigodia'];
                            
                               $SQL_C='SELECT
                                                s.SolicitudAsignacionEspacioId AS id,
                                                s.codigodia,
                                                d.nombredia,
                                                s.ClasificacionEspaciosId AS Sede,
                                                c.Nombre,
                                                a.HoraInicio,
                                                a.HoraFin
                                        FROM
                                                SolicitudAsignacionEspacios s 
                                                    INNER JOIN dia d ON d.codigodia = s.codigodia
                                                    INNER JOIN ClasificacionEspacios c ON s.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                                                    INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                                        WHERE
                                                s.SolicitudAsignacionEspacioId="'.$id.'"
                                                AND s.codigoestado = 100
                                                AND s.codigodia="'.$codigodia.'"
                                        
                                        GROUP BY s.codigodia,s.ClasificacionEspaciosId,a.HoraInicio,a.HoraFin';
                                        
                                 if($FinalDetalle=&$db->Execute($SQL_C)===false){
                                    echo 'Error en el SQL De la Fianlizacion de la Busqueda...<br><br>'.$SQL_C;
                                    die;
                                 }  
                                    
                                    /*$C_Cuerpo[$i][$Data[$i]['codigodia']]['id'] = $Data[$i]['id'];
                                    $C_Cuerpo[$i][$Data[$i]['codigodia']]['codigodia'] = $Data[$i]['codigodia'];
                                    $C_Cuerpo[$i][$Data[$i]['codigodia']]['nombredia'] = $Data[$i]['nombredia'];
                                    $C_Cuerpo[$i][$Data[$i]['codigodia']]['Sede'] = $Data[$i]['Sede'];
                                    $C_Cuerpo[$i][$Data[$i]['codigodia']]['Nombre']= $Data[$i]['Nombre'];
                                    $C_Cuerpo[$i][$Data[$i]['codigodia']]['HoraInicio'] = $Data[$i]['HoraInicio'];
                                    $C_Cuerpo[$i][$Data[$i]['codigodia']]['HoraFin'] = $Data[$i]['HoraFin'];*/
                                    
                                    $C_Cuerpo[$codigodia] = $FinalDetalle->GetArray();
                       }//for
           }     
                
                //echo '<pre>';print_r($C_DiaHora);die;
                
                $Resultado['Principal'] = $C_Principal;
                $Resultado['IDS']       = $ID_Asociado;
                $Resultado['Grupos']    = $C_Grupo; 
                $Resultado['SolicitudPadreId'] = $C_Principal[0]['SolicitudPadreId'];     
                //$Resultado['Horaio']    = $C_Cuerpo;
                $Resultado['Horaio']    = $C_Principal[0]['SolicitudPadreId'];                
                //echo '<pre>';print_r($Resultado['Horaio']);
                
                return $Resultado;
    }//public function DataEditar
}//class

?>