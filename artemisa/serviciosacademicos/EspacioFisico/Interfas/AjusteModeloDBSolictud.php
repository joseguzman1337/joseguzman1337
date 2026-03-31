<?php

include("../templates/template.php");
		
$db = getBD();

$userid = '32957';//mgi

  $SQL='SELECT
        s.SolicitudAsignacionEspacioId,
        t.nombretiposalon,
        c.Nombre,
        sg.idgrupo,
        d.nombredia,
        g.nombregrupo,
        m.nombremateria,
        s.FechaCreacion,
        s.FechaInicio,
        s.FechaFinal,
        s.AccesoDiscapacitados,
        s.Estatus,
        p.periodicidad,
        d.nombredia,
        CASE s.Estatus
        WHEN 1 THEN
        "Pendiente"
        WHEN 2 THEN
        "Parcial"
        WHEN 3 THEN
        "Atendida"
        END AS Estadotext,
        s.NombreEvento,
        s.UnidadNombre,
        s.codigomodalidadacademica,
        if(s.codigomodalidadacademica=001,"Interna","Externa") AS TipoSolicitud
        
        FROM
        SolicitudAsignacionEspacios s
        INNER JOIN siq_periodicidad p ON p.idsiq_periodicidad = s.idsiq_periodicidad
        INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspaciosId
        INNER JOIN dia d ON d.codigodia = s.codigodia
        INNER JOIN SolicitudAsignacionEspaciostiposalon st ON s.SolicitudAsignacionEspacioId = st.SolicitudAsignacionEspacioId
        INNER JOIN tiposalon t ON st.codigotiposalon = t.codigotiposalon
        LEFT JOIN  SolicitudEspacioGrupos sg ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
        LEFT JOIN grupo g ON g.idgrupo = sg.idgrupo
        LEFT JOIN materia m ON m.codigomateria = g.codigomateria
        
        WHERE
        s.codigoestado = 100
        AND t.codigoestado = 100
        AND p.codigoestado = 100
        AND (sg.codigoestado = 100 OR sg.codigoestado IS NULL)
        
        GROUP BY s.SolicitudAsignacionEspacioId
        
        ORDER BY   SolicitudAsignacionEspacioId';
        
        if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL De Data....<br><br>'.$SQL;
            die;
        }
        
        while(!$Data->EOF){
            $id = $Data->fields['SolicitudAsignacionEspacioId'];
            
            /**************************************************/
            $SQL='SELECT 
                    
                    s.FechaInicio,
                    s.FechaFinal,
                    sg.idgrupo
                    
                    FROM
                    
                    SolicitudAsignacionEspacios s INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    
                    WHERE
                    
                    s.SolicitudAsignacionEspacioId="'.$id.'"
                    AND
                    s.codigoestado=100';
                    
              if($DataUno=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Datas Uno...<br><br>'.$SQL;
                die;
              }    
              
              if(!$DataUno->EOF){
                 $SQL='SELECT 

                        s.SolicitudAsignacionEspacioId AS id,
                        s.codigodia,
                        d.nombredia,
                        s.ClasificacionEspaciosId AS Sede,
                        c.Nombre,
                        s.UsuarioCreacion
                        
                        FROM SolicitudEspacioGrupos  sg INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                                                        INNER JOIN dia d ON d.codigodia=s.codigodia
                                                        INNER JOIN ClasificacionEspacios c ON s.ClasificacionEspaciosId=c.ClasificacionEspaciosId

                        
                        WHERE sg.idgrupo="'.$DataUno->fields['idgrupo'].'"
                        AND
                        s.FechaInicio="'.$DataUno->fields['FechaInicio'].'"
                        AND
                        s.FechaFinal="'.$DataUno->fields['FechaFinal'].'"
                        AND
                        s.codigoestado=100';
                        
                        if($DataDos=&$db->Execute($SQL)===false){
                            echo'Error en el SQL data Dos...<br><br>'.$SQL;
                            die;
                        }
                        
                   if(!$DataDos->EOF){
                    /****************Inser a PadreSolicitud************/
                     $SQL='SELECT * FROM AsociacionSolicitud WHERE SolicitudAsignacionEspaciosId="'.$id.'"';   
                            
                      if($Valida=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL de la Validacion ....<br><br>'.$SQL;
                        die;
                      }  
                    
                  if($Valida->EOF){  
                    
                    $SQL_InsertPadre='INSERT INTO SolicitudPadre(UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion)VALUES("'.$userid.'","'.$userid.'",NOW(),NOW())';
                    if($InsertPadre=&$db->Execute($SQL_InsertPadre)===false){
                        echo 'Error en el sql del Padre id Solicud...<br><BR>'.$SQL_InsertPadre;
                        die;
                    }
                    
                    $Last_id=$db->Insert_ID();
                    /**************************************************/
                          while(!$DataDos->EOF){
                            /*********************************************/
                            $ID_Solicitud = $DataDos->fields['id'];       
                            
                                 
                            /*****************Insert AsociacionSolicitud**********************/
                            
                                
                                $SQL_InsertAsociacion='INSERT INTO AsociacionSolicitud(SolicitudPadreId,SolicitudAsignacionEspaciosId)VALUES("'.$Last_id.'","'.$ID_Solicitud.'")';
                                
                                if($InsertAsociacion=&$db->Execute($SQL_InsertAsociacion)===false){
                                    echo 'Error en el SQL de la Asociacion....<br><br>'.$SQL_InsertAsociacion;
                                    die;
                                }
                                
                            
                            /*****************************************************************/
                             $DataDos->MoveNext();
                          }//while
                      }//Valida    
                   }//DatosDos 
              }//DatosUno  
            /**************************************************/
            $Data->MoveNext();
        }//while
 /*****************************Externas****************************************/
  
  $SQL='SELECT
                s.SolicitudAsignacionEspacioId AS id,
                s.FechaInicio,
                s.FechaFinal,
                s.codigomodalidadacademica,
                s.NombreEvento,
                s.NumAsistentes,
                s.UnidadNombre
        FROM
                SolicitudAsignacionEspacios s
        
        WHERE
                s.codigomodalidadacademica<>001
                AND
                s.codigoestado=100
                
        GROUP BY s.FechaInicio,s.FechaFinal,s.NombreEvento,s.NumAsistentes

        ORDER BY s.SolicitudAsignacionEspacioId';
                
        if($DataExterna=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Data Externa...<br><br>'.$SQL;
            die;
        }   
        
      while(!$DataExterna->EOF){
        /*****************************************************************/
                                   $SQL_AgrupoExterna='SELECT
                                   s.SolicitudAsignacionEspacioId AS id
                           FROM
                                   SolicitudAsignacionEspacios s
                           WHERE
                                   s.FechaInicio="'.$DataExterna->fields['FechaInicio'].'"
                                   AND
                                   s.FechaFinal="'.$DataExterna->fields['FechaFinal'].'"
                                   AND
                                   s.codigomodalidadacademica="'.$DataExterna->fields['codigomodalidadacademica'].'"
                                   AND
                                   s.NombreEvento="'.addslashes($DataExterna->fields['NombreEvento']).'"
                                   AND
                                   s.NumAsistentes="'.$DataExterna->fields['NumAsistentes'].'"';
 
                           if($DetalleGrpExterna=&$db->Execute($SQL_AgrupoExterna)===false){
                                echo'Error en el SQL del Detalle Agrupacion Exeternas....<br><br>'.$SQL_AgrupoExterna;
                                die;
                           } 
                           
                           if(!$DetalleGrpExterna->EOF){
                                $SQL_InsertPadre='INSERT INTO SolicitudPadre(UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion)VALUES("'.$userid.'","'.$userid.'",NOW(),NOW())';
                                
                                if($InsertPadre=&$db->Execute($SQL_InsertPadre)===false){
                                    echo 'Error en el sql del Padre id Solicud...<br><BR>'.$SQL_InsertPadre;
                                    die;
                                }
                                
                                $Last_id=$db->Insert_ID();
                                /**************************************************/
                                      while(!$DetalleGrpExterna->EOF){
                                        /*********************************************/
                                            $ID_Solicitud = $DetalleGrpExterna->fields['id'];
                                                 
                                            /*****************Insert AsociacionSolicitud**********************/
                                                
                                                $SQL_InsertAsociacion='INSERT INTO AsociacionSolicitud(SolicitudPadreId,SolicitudAsignacionEspaciosId)VALUES("'.$Last_id.'","'.$ID_Solicitud.'")';
                                                
                                                if($InsertAsociacion=&$db->Execute($SQL_InsertAsociacion)===false){
                                                    echo 'Error en el SQL de la Asociacion....<br><br>'.$SQL_InsertAsociacion;
                                                    die;
                                                }
                                                
                                            
                                            /*****************************************************************/
                                             $DetalleGrpExterna->MoveNext();
                                          }//while
                           }        
        /*****************************************************************/
        $DataExterna->MoveNext();
      }//while             

?>
