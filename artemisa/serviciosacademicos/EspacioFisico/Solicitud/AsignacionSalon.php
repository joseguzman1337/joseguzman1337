<?php
session_start();
class AsignacionSalon{
    public function ValidacionEspacio($db,$fecha,$hora_1,$hora_2,$id){
        
          $Fecha_HoraIni = $fecha.' '.$hora_1;
          $Fecha_HoraFin = $fecha.' '.$hora_2;  
            
          $SQL='SELECT
                x.ClasificacionEspaciosId
                FROM ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                             INNER JOIN DetalleClasificacionEspacios d ON d.ClasificacionEspaciosId=x.ClasificacionEspaciosId

									         
                where x.ClasificacionEspaciosId not in 
                (
                SELECT eventos.ClasificacionEspaciosId FROM (
                		SELECT
        					a.AsignacionEspaciosId,
        					a.FechaAsignacion AS fecha,
        					a.HoraInicio AS horainicio,
        					a.HoraFin AS horafinal,
        					c.ClasificacionEspaciosId,
        					c.Nombre AS Salon
        				FROM
        					AsignacionEspacios a
        				INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
        				INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
        				WHERE
        					a.FechaAsignacion = "'.$fecha.'"
        				AND a.HoraInicio <>"'.$hora_2.'"
                        AND a.HoraFin<> "'.$hora_1.'"
        				AND a.codigoestado = 100
                        AND c.codigoestado = 100
        				AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
        				AND "'.$Fecha_HoraFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
        				AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
        			    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                        OR ("'.$Fecha_HoraFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                        AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                        OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$Fecha_HoraFin.'") 
                        OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$Fecha_HoraFin.'"))
                		
                		) eventos
                		WHERE "'.$Fecha_HoraIni.'" <> CONCAT(fecha," ",horafinal) 
                		and "'.$Fecha_HoraFin.'" <> CONCAT(fecha," ",horainicio) 
                		and (
                		("'.$Fecha_HoraIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                		OR ("'.$Fecha_HoraFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_HoraIni.'" AND "'.$Fecha_HoraFin.'"  ) 
                		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_HoraIni.'"  AND "'.$Fecha_HoraFin.'"  )
                		)
                ) 
                
                AND
                e.PermitirAsignacion=1
                AND x.codigoestado = 100
                AND 
                "'.$fecha.'" BETWEEN d.FechaInicioVigencia and d.FechaFinVigencia
                AND
                x.ClasificacionEspaciosId="'.$id.'"';
                
                if($EspaciosDisponibles=&$db->Execute($SQL)===false){
                    Echo 'Error en el SQL de Validacion De Disponible Espacio...<br><br>'.$SQL;
                    die;
                }
                
                if(!$EspaciosDisponibles->EOF){
                    while(!$EspaciosDisponibles->EOF){
                        
                        if($id==$EspaciosDisponibles->fields['ClasificacionEspaciosId']){
                            return 1;exit;
                        }else{
                            return 0;
                        }
                        $EspaciosDisponibles->MoveNext();
                    }//while
                }else{
                    return 0;
                }
    }//public function ValidacionEspacio
    public function Disponibilidad($db,$Sede,$TipoSalon,$F_inicial,$F_final,$H_inicial,$H_final,$Acceso,$max,$op='',$Grupo='',$Carrera='',$url='',$userid='',$RolEspacioFisico=''){ 
      // echo 'Orale...';die;
        /*
        [Horaini] 
        [Horafin] 
        */
        //echo '$max-->'.$max;
        
        if(!$op){
           $C_Horas = $this->Horas($H_inicial,$H_final); 
           $hora_1  = $C_Horas['Horaini'];
           $hora_2  = $C_Horas['Horafin'];
        }else{
           $hora_1  = $H_inicial;
           $hora_2  = $H_final; 
        }
        
        $fecha  = $F_inicial;
        
        $Fecha_horaIni = $fecha.' '.$hora_1;
        $fecha_horaFin = $fecha.' '.$hora_2;
        
        if($Acceso==1){
            $Condicion = ' AND  x.AccesoDiscapacitados="'.$Acceso.'"';
        }else{
            $Condicion = '';
        }
        
        if($Grupo){
        
        $Resultado = $this->ValidacionGrupoEspacio($db,$Grupo,$fecha,$hora_1,$hora_2);
        //var_dump(is_file('../../../Solicitud/SolicitudEspacio_class.php'));die;
        }else{
            $Resultado['val'] = true;
        }
        
        /**************************************/
        if($Resultado['val']==false){
            $this->PirtarSalonGrupo($db,$Resultado);
        }else{
        /**************************************/
       
        for($i=0;$i<count($TipoSalon);$i++){
            if($i==0){
                $C_TipoSalon = '"'.$TipoSalon[$i].'"';
            }else{
                $C_TipoSalon = $C_TipoSalon.',"'.$TipoSalon[$i].'"';
            }
        }
        
        $InnerCondicon_Pribilegio = '';
        $Condicion_Pribilegio     = '';
        
        if($RolEspacioFisico==2){
            $InnerCondicon_Pribilegio = ' INNER JOIN ResponsableEspacioFisico r ON r.EspaciosFisicosId=e.EspaciosFisicosId  AND r.CodigoTipoSalon=c.codigotiposalon';
            $Condicion_Pribilegio     = ' AND r.UsuarioId="'.$userid.'" AND r.CodigoEstado=100';
        }else if($RolEspacioFisico==5){
             $InnerCondicon_Pribilegio = ' INNER JOIN ResponsableClasificacionEspacios z ON z.ClasificacionEspaciosId=  pf.ClasificacionEspaciosId';
             $Condicion_Pribilegio       = ' AND z.CodigoEstado=100 AND z.idusuario="'.$userid.'"';
          } 
        
        
         $SQL='SELECT 

                pf.ClasificacionEspaciosId AS id
                	
                FROM PrioridadesRestricciones p 
                INNER JOIN PrioridadesRestriccionesEspaciosFisicos pf ON p.PrioridadesRestriccionesId=pf.PrioridadesRestriccionesId
                INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=pf.ClasificacionEspaciosId
                INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=c.EspaciosFisicosId
                '.$InnerCondicon_Pribilegio.'
                																	
                AND pf.ClasificacionEspaciosId IN(SELECT
                                                        xx.ClasificacionEspaciosId AS id
                                                    FROM(
                                                        SELECT
                                                                x.ClasificacionEspaciosId, 
                                                                x.ClasificacionEspacionPadreId,
                                                                x.CapacidadEstudiantes,
                                                                x.EspaciosFisicosId,
                                                                e.Nombre
                                                        FROM 
                                                                ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                                                                        INNER JOIN DetalleClasificacionEspacios D ON D.ClasificacionEspaciosId=x.ClasificacionEspaciosId
  
                                                        WHERE x.ClasificacionEspaciosId not in (
                                                                SELECT 
                                                                    eventos.ClasificacionEspaciosId 
                                                                FROM (
                                                                		SELECT
                                                							a.AsignacionEspaciosId,
                                                							a.FechaAsignacion AS fecha,
                                                							a.HoraInicio AS horainicio,
                                                							a.HoraFin AS horafinal,
                                                							c.ClasificacionEspaciosId,
                                                							c.Nombre AS Salon
                                                						FROM
                                                							AsignacionEspacios a
                                                						INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                                						INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
                                                						WHERE
                                                							a.FechaAsignacion = "'.$fecha.'"
                                                						AND a.HoraInicio <>"'.$hora_2.'"
                                                                        AND a.HoraFin<> "'.$hora_1.'"
                                                						AND a.codigoestado = 100
                                                                        AND c.codigoestado = 100
                                                						AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
                                                						AND "'.$fecha_horaFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
                                                						AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                      								    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                                                        OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                                                        AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                                                        OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'") 
                                                                        OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$fecha_horaFin.'"))                                      
                                                                		
                                                                		) eventos
                                                                		WHERE 
                                                                            "'.$Fecha_horaIni.'" <> CONCAT(fecha," ",horafinal) 
                                                          		            AND 
                                                                            "'.$fecha_horaFin.'" <> CONCAT(fecha," ",horainicio) 
                                                                		    AND (
                                                                		("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                                                                		OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                                                                		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  ) 
                                                                		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  )
                                                       	         )
                                                        ) 
                                                        
                                                        
                                                        '.$Condicion.'
                                                        AND
                                                        x.codigoestado = 100
                                                        AND
                                                        e.PermitirAsignacion=1
                                                        AND 
                                                        "'.$fecha.'" BETWEEN D.FechaInicioVigencia and D.FechaFinVigencia 
                                                        
                                                        ) xx INNER JOIN ClasificacionEspacios cp ON xx.ClasificacionEspacionPadreId=cp.ClasificacionEspaciosId AND cp.codigoestado = 100  AND cp.ClasificacionEspacionPadreId="'.$Sede.'"
                                                        
                                                        ORDER BY xx.ClasificacionEspaciosId ASC ) 
                                            AND 
                                            p.codigocarrera="'.$Carrera.'" 
                                            AND p.codigoestado=100 AND p.Estatus=1
                                            '.$Condicion_Pribilegio;
                                                    
                        //echo 'Prioridad...<br><br>SQL<br>'.$SQL;                            
                                        
                        if($AulasPriorida=&$db->Execute($SQL)===false){
                            echo 'Error en el SQl de Aulas con Prioridad....<br><br>'.$SQL;
                            die;
                        } 
                        
        $this->ViewEspacios($db,4,$AulasPriorida,'#4CE5FF',$max,'',$op,$fecha,$hora_1,$hora_2,'Aulas con Prioridad Disponibles',$url);                
        
            $Inner_Condicion_Disponible = '';
            $Condicion_Disponible       = '';
        
        if($RolEspacioFisico==2){
            $Inner_Condicion_Disponible = ' INNER JOIN ResponsableEspacioFisico r ON r.EspaciosFisicosId=xx.EspaciosFisicosId AND r.CodigoTipoSalon=xx.codigotiposalon';
            $Condicion_Disponible       = ' AND r.UsuarioId="'.$userid.'" AND r.CodigoEstado=100';
        }else if($RolEspacioFisico==5){
             $Inner_Condicion_Disponible = ' INNER JOIN ResponsableClasificacionEspacios z ON z.ClasificacionEspaciosId= xx.ClasificacionEspaciosId';
             $Condicion_Disponible       = ' AND z.CodigoEstado=100 AND z.idusuario="'.$userid.'"';
          } 
        
        $SQL='SELECT
                    xx.ClasificacionEspaciosId AS id,
                    CAST(xx.CapacidadEstudiantes AS SIGNED),
                    cp.Nombre,
                    xx.EspaciosFisicosId,
	                xx.Nombre AS Nombre_Espacio,
                    xx.codigotiposalon
                FROM(
                    SELECT
                            x.ClasificacionEspaciosId, 
                            x.ClasificacionEspacionPadreId,
                            x.CapacidadEstudiantes,
                            x.EspaciosFisicosId,
                            e.Nombre,
                            x.codigotiposalon
                    FROM 
                            ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                                    INNER JOIN DetalleClasificacionEspacios D ON D.ClasificacionEspaciosId=x.ClasificacionEspaciosId
                                                    
                    WHERE x.ClasificacionEspaciosId not in (
                            SELECT 
                                eventos.ClasificacionEspaciosId 
                            FROM (
                            		SELECT
            							a.AsignacionEspaciosId,
            							a.FechaAsignacion AS fecha,
            							a.HoraInicio AS horainicio,
            							a.HoraFin AS horafinal,
            							c.ClasificacionEspaciosId,
            							c.Nombre AS Salon
            						FROM
            							AsignacionEspacios a
            						INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
            						INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
            						WHERE
            							a.FechaAsignacion = "'.$fecha.'"
            						AND a.HoraInicio <>"'.$hora_2.'"
                                    AND a.HoraFin<> "'.$hora_1.'"
            						AND a.codigoestado = 100
                                    AND c.codigoestado = 100
            						AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
            						AND "'.$fecha_horaFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
            						AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
  								    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                    OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                    OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'") 
                                    OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$fecha_horaFin.'"))                                       
                            		
                            		) eventos
                            		WHERE 
                                        "'.$Fecha_horaIni.'" <> CONCAT(fecha," ",horafinal) 
                      		            AND 
                                        "'.$fecha_horaFin.'" <> CONCAT(fecha," ",horainicio) 
                            		    AND (
                            		("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                            		OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                            		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  ) 
                            		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  )
                   	         )
                    ) 
                    AND
                    x.codigotiposalon IN ('.$C_TipoSalon.')
                    '.$Condicion.'
                    AND
                    x.codigoestado = 100
                    AND
                    e.PermitirAsignacion=1
                    AND 
                    "'.$fecha.'" BETWEEN D.FechaInicioVigencia and D.FechaFinVigencia 
                    
                    ) xx 
                    INNER JOIN ClasificacionEspacios cp ON xx.ClasificacionEspacionPadreId=cp.ClasificacionEspaciosId
                    '.$Inner_Condicion_Disponible.'
                    
                    WHERE
                    
                    cp.codigoestado = 100  AND cp.ClasificacionEspacionPadreId="'.$Sede.'"
                    '.$Condicion_Disponible.'
                    
                    ORDER BY cp.Nombre,CAST(xx.CapacidadEstudiantes AS SIGNED)';
                     
                    //echo '<br><br> Fecha ...1 <br><br>'.$SQL.'<br>';
                        
                     
                     if($AulasTipoMax=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL Disponibilida de Espacios Por tipo Sede Y capacidad En un Fecha Unica...<br><br>'.$SQL;
                        die;
                     }   
             
                
             $this->ViewEspacios($db,1,$AulasTipoMax,'#C6F4D1',$max,'',$op,$fecha,$hora_1,$hora_2,'Aulas Disponibles',$url); 
             
             /*********************************************************************/
             $InnerCondicon_Other = '';
             $Condicion_Other     = '';
             
          if($RolEspacioFisico==2){
             $InnerCondicon_Other = ' INNER JOIN ResponsableEspacioFisico r ON r.EspaciosFisicosId=xx.EspaciosFisicosId AND r.CodigoTipoSalon=xx.codigotiposalon';
             $Condicion_Other     = ' AND r.UsuarioId="'.$userid.'" AND r.CodigoEstado=100';
          }else if($RolEspacioFisico==5){
             $InnerCondicon_Other = ' INNER JOIN ResponsableClasificacionEspacios z ON z.ClasificacionEspaciosId= xx.ClasificacionEspaciosId';
             $Condicion_Other     = ' AND z.CodigoEstado=100 AND z.idusuario="'.$userid.'"';
          } 
           
          $SQL='SELECT
                    xx.ClasificacionEspaciosId AS id,
                    CAST(xx.CapacidadEstudiantes AS SIGNED),
                    cp.Nombre,
                    xx.EspaciosFisicosId,
	                xx.Nombre AS Nombre_Espacio,
                    xx.codigotiposalon
                FROM(
                    SELECT
                            x.ClasificacionEspaciosId, 
                            x.ClasificacionEspacionPadreId,
                            x.CapacidadEstudiantes,
                            x.EspaciosFisicosId,
                            e.Nombre,
                            x.codigotiposalon
                    FROM 
                            ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                                    INNER JOIN DetalleClasificacionEspacios D ON D.ClasificacionEspaciosId=x.ClasificacionEspaciosId
                                                   
                    WHERE x.ClasificacionEspaciosId not in (
                            SELECT 
                                eventos.ClasificacionEspaciosId 
                            FROM (
                            		SELECT
            							a.AsignacionEspaciosId,
            							a.FechaAsignacion AS fecha,
            							a.HoraInicio AS horainicio,
            							a.HoraFin AS horafinal,
            							c.ClasificacionEspaciosId,
            							c.Nombre AS Salon
            						FROM
            							AsignacionEspacios a
            						INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
            						INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
            						WHERE
            							a.FechaAsignacion = "'.$fecha.'"
            						AND a.HoraInicio <>"'.$hora_2.'"
                                    AND a.HoraFin<> "'.$hora_1.'"
            						AND a.codigoestado = 100
                                    AND c.codigoestado = 100
            						AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
            						AND "'.$fecha_horaFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
            						AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
  								    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                    OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                    OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'") 
                                    OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$fecha_horaFin.'")) 
                            		) eventos
                            		WHERE 
                                        "'.$Fecha_horaIni.'" <> CONCAT(fecha," ",horafinal) 
                      		            AND 
                                        "'.$fecha_horaFin.'" <> CONCAT(fecha," ",horainicio) 
                            		    AND (
                            		("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                            		OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                            		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  ) 
                            		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  )
                   	         )
                    ) 
                    AND
                    x.codigotiposalon NOT IN ('.$C_TipoSalon.')
                    '.$Condicion.'
                    AND
                    x.codigoestado = 100
                    AND
                    e.PermitirAsignacion=1
                    AND 
                    "'.$fecha.'" BETWEEN D.FechaInicioVigencia and D.FechaFinVigencia
                    ) xx 
                    INNER JOIN ClasificacionEspacios cp ON xx.ClasificacionEspacionPadreId=cp.ClasificacionEspaciosId 
                    '.$InnerCondicon_Other.'
                    
                    
                    WHERE
                    
                     cp.codigoestado = 100 
                     
                     '.$Condicion_Other.'
                     
                     AND cp.ClasificacionEspacionPadreId="'.$Sede.'"
                    
                    
                    ORDER BY cp.Nombre, CAST(xx.CapacidadEstudiantes AS SIGNED)';
                        
                    //echo '<br><br> Otro tipo...<br><br>'.$SQL.'<br>';
                     
                     if($AulasMax=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL Disponibilida de Espacios Por tipo Sede Y capacidad En un Fecha Unica...<br><br>'.$SQL;
                        die;
                     }     
                     
            $this->ViewEspacios($db,2,$AulasMax,'#FBFBC0',$max,'',$op,$fecha,$hora_1,$hora_2,'Aulas Disponibles Diferente Tipo',$url); 
            
            /********************************Consulta de aulas Ocupadas******************************************************/
            
        $SQL='SELECT
                    xx.ClasificacionEspaciosId AS id,
                    CAST(xx.CapacidadEstudiantes AS SIGNED),
                    cp.Nombre
                FROM(
                    SELECT
                            x.ClasificacionEspaciosId, 
                            x.ClasificacionEspacionPadreId,
                            x.CapacidadEstudiantes
                    FROM 
                            ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                                    INNER JOIN DetalleClasificacionEspacios D ON D.ClasificacionEspaciosId=x.ClasificacionEspaciosId
                                                    
                    WHERE x.ClasificacionEspaciosId  in (
                            SELECT 
                                eventos.ClasificacionEspaciosId 
                            FROM (
                            		SELECT
            							a.AsignacionEspaciosId,
            							a.FechaAsignacion AS fecha,
            							a.HoraInicio AS horainicio,
            							a.HoraFin AS horafinal,
            							c.ClasificacionEspaciosId,
            							c.Nombre AS Salon
            						FROM
            							AsignacionEspacios a
            						INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
            						INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
            						WHERE
            							a.FechaAsignacion = "'.$fecha.'"
            						AND a.HoraInicio <>"'.$hora_2.'"
                                    AND a.HoraFin<> "'.$hora_1.'"
            						AND a.codigoestado = 100
                                    AND c.codigoestado = 100
            						AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
            						AND "'.$fecha_horaFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
            						AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
  								    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                    OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                    OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'") 
                                    OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$fecha_horaFin.'"))                                          
                            		
                            		) eventos
                            		WHERE 
                                        "'.$Fecha_horaIni.'" <> CONCAT(fecha," ",horafinal) 
                      		            AND 
                                        "'.$fecha_horaFin.'" <> CONCAT(fecha," ",horainicio) 
                            		    AND (
                            		("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                            		OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                            		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  ) 
                            		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  )
                   	         )
                    ) 
                    
                    '.$Condicion.'
                    AND
                    x.codigoestado = 100
                    AND
                    e.PermitirAsignacion=1
                    AND 
                    "'.$fecha.'" BETWEEN D.FechaInicioVigencia and D.FechaFinVigencia 
                    
                    ) xx INNER JOIN ClasificacionEspacios cp ON xx.ClasificacionEspacionPadreId=cp.ClasificacionEspaciosId  AND cp.codigoestado = 100 AND cp.ClasificacionEspacionPadreId="'.$Sede.'"
                    
                    ORDER BY cp.Nombre, CAST(xx.CapacidadEstudiantes AS SIGNED)';
                    
                     //echo '<br><br> Ocupadas...<br><br>'.$SQL.'<br>';
                    
                 if($AulasOcupadas=&$db->Execute($SQL)===false){
                    echo 'Error en el SQl de las Aulas Ocupadas....<br><br>'.$SQL;
                    die;
                 }  
                 
              $this->ViewEspacios($db,3,$AulasOcupadas,'#F7BBBB',$max,1,$op,$fecha,$hora_1,$hora_2,'Aulas Ocupadas',$url);     
          }    
    }//public function Disponibilidad
    public function Horas($Hora_1,$Hora_2){
        //echo 'Hora->'.$Hora_1;
        $C_Horaini = explode(' ',$Hora_1);//Dessarmar la Hora Inicial
        
        if($C_Horaini[1]=='AM' || $C_Horaini[1]=='am' || $C_Horaini[1]=='A.M.' || $C_Horaini[1]=='a.m.'){
            $Horaini = $C_Horaini[0];
        }else{
            $H_inicial = explode(':',$C_Horaini[0]);
            
            if($C_Horaini[1]=='PM' || $C_Horaini[1]=='pm' || $C_Horaini[1]=='P.M.' || $C_Horaini[1]=='p.m.'){
                if($H_inicial[0]==12){  
                    $Horaini = $H_inicial[0].':'.$H_inicial[1];
                }else{ 
                    $H = $H_inicial[0]+12;
                    $Horaini = $H.':'.$H_inicial[1];
                }
            }
        }//if hora Inicial
        
        $C_Horafin = explode(' ',$Hora_2);//Dessarmar la Hora final
      
        if($C_Horafin[1]=='AM' || $C_Horafin[1]=='am' || $C_Horaini[1]=='A.M.' || $C_Horaini[1]=='a.m.'){
            $Horafin = $C_Horafin[0];
        }else{
            $H_final = explode(':',$C_Horafin[0]);
            
            if($C_Horafin[1]=='PM' || $C_Horafin[1]=='pm' || $C_Horafin[1]=='P.M.' || $C_Horafin[1]=='p.m.'){ 
                if($H_final[0]==12){ 
                    $Horafin = $H_final[0].':'.$H_final[1];
                }else{
                    $H = $H_final[0]+12;
                    $Horafin = $H.':'.$H_final[1];
                }
            }
        }//if hora final
        
        $C_Result = array();
        
        /*echo '<br>$Horaini->'.$Horaini;
        echo '<br>$Horafin->'.$Horafin;*/
        
        $C_Result['Horaini']  = $Horaini;
        $C_Result['Horafin']  = $Horafin;
        
        return $C_Result;
    }//public function Horas()
    public function ViewEspacios($db,$origen,$Data,$Color,$max,$op='',$tittle='',$Fecha='',$hora_1='',$hora_2='',$Titulo,$url=''){
        
        if(!$Data->EOF){
            if(!$op){
                $Style='width: 5%;';
                $Style_2='width: 10%;';
            }else{
                $Style = 'width: 5%;';
                $Style_2='';
            }
            ?>
            <div>
                <table style="width: 100%;">
                    <?PHP 
                   
                    
                    if($tittle){
                        if($op==1){
                            $Columnas = 14;
                        }else{
                            $Columnas = 8;
                        }
                        
                       $HoraView = $this->HorasInversa($hora_1,$hora_2);
                       
                      ?>
                        <tr>
                            <th colspan="<?PHP echo $Columnas?>"><?PHP echo $Titulo?></th>
                             <div id="VentanaNew"></div>
                        </tr>
                        <tr style="background: #C0E7FB;">
                            <td colspan="<?PHP echo $Columnas?>">
                                <?PHP 
                                $Dia = $this->DiasSemana($Fecha,'Nombre');
                                
                                echo $Dia .' '.$Fecha.'&nbsp;&nbsp;&nbsp;Hora Inicial: &nbsp;'.$HoraView['inicial'].'&nbsp;&nbsp;&nbsp;Hora Final: &nbsp;'.$HoraView['final'];
                                ?>
                            </td>&nbsp;
                        </tr>
                        <?PHP
                    }
                    ?>
                    <tr style="background: #C0E7FB;">
                        <td style="<?PHP echo $Style?>">N&deg; 
                        <input type="hidden" id="EspacioCheck_<?PHP echo $tittle?>" name="EspacioCheck[]" /></td>  
                        <td style="<?PHP echo $Style_2?>">Nombre Espacio</td>
                        <td style="<?PHP echo $Style_2?>">Capacidad Espacio</td>
                        <td style="<?PHP echo $Style_2?>">Sobrecupo</td>
                        <td style="<?PHP echo $Style_2?>">Capacidad Total</td>
                        <td style="<?PHP echo $Style_2?>">Tipo Aula</td>
                        <td style="<?PHP echo $Style_2?>">Acceso a Discapacitados</td>
                        <?PHP 
                        if($op==1){
                            ?>
                            <td>Fecha</td>
                            <td>Hora Inicial</td>
                            <td>Hora Final</td>
                            <td>Nombre Grupo</td>
                            <td>Nombre Materia</td>
                            <td>Ocupantes</td>
                            <?PHP
                        }
                        if($op!=1){
                            ?>
                            <td style="<?PHP echo $Style_2?>">Solicitud Sobrecupo</td>
                            <?PHP
                        }
                        ?>
                    </tr>
            <?PHP 
            $i=0;
            while(!$Data->EOF){
                /*********************************************************************/
                  $SQL='SELECT
                        *
                        FROM
                        ( SELECT 
 
                        c.Nombre,
                        c.CapacidadEstudiantes AS maxi,
                        t.nombretiposalon,
                        c.AccesoDiscapacitados,
                        d.Sobrecupo AS SobreCupo,
                        IF(SUM( d.Sobrecupo+c.CapacidadEstudiantes ) is NULL,c.CapacidadEstudiantes,SUM( d.Sobrecupo+c.CapacidadEstudiantes )) as CupoMax

                        
                        FROM ClasificacionEspacios c  INNER JOIN tiposalon t ON c.codigotiposalon=t.codigotiposalon
                                                      INNER JOIN SobreCupoClasificacionEspacios d ON c.ClasificacionEspaciosId = d.ClasificacionEspacioId
                        
                        WHERE 
                        
                        c.ClasificacionEspaciosId="'.$Data->fields['id'].'"
                        AND
                        c.codigoestado = 100
                        AND 
                        d.EstadoAprobacion=1) x

                        WHERE
                        
                        x.CupoMax>='.$max.'';
                        
                     if($Info=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL De la Informacion...<br><br>'.$SQL;
                        die;
                     }  
                  if(!$Info->EOF){   
                     if($Info->fields['AccesoDiscapacitados']==1){
                        $Acceso = 'Si';
                     }else{
                        $Acceso = 'No';
                     } 
                     
                     if(!$Info->fields['SobreCupo']){
                            $SobreCupo = 0;
                        }else{
                            $SobreCupo = $Info->fields['SobreCupo'];
                        }  
                        
                        
                  
                  if($op==1){
                    $SQL_D='SELECT

                                    a.AsignacionEspaciosId,
                                    a.FechaAsignacion AS fecha,
                                    a.HoraInicio AS horainicio,
                                    a.HoraFin AS horafinal,
                                    g.nombregrupo AS grupos,
                                    m.nombremateria,
                                    g.matriculadosgrupo,
                                    c.ClasificacionEspaciosId,
                                    c.Nombre AS Salon
                                    
                                    FROM
                                    
                                    AsignacionEspacios a INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                										 INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                										 INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                										 INNER JOIN grupo g ON g.idgrupo=sg.idgrupo
                										 INNER JOIN materia m ON m.codigomateria=g.codigomateria
                                    
                                    WHERE  c.ClasificacionEspaciosId="'.$Data->fields['id'].'" AND a.FechaAsignacion="'.$Fecha.'" 
                                    AND (a.HoraInicio BETWEEN "'.$hora_1.'" AND "'.$hora_2.'" OR a.HoraFin BETWEEN "'.$hora_1.'" AND "'.$hora_2.'")  
                                    AND a.HoraInicio <>"'.$hora_2.'" AND a.HoraFin<> "'.$hora_1.'"  AND c.codigoestado = 100';
                                    
                                    /*
                                    INNER JOIN SolicitudAsignacionEspaciostiposalon st ON s.SolicitudAsignacionEspacioId=st.SolicitudAsignacionEspacioId
                                    INNER JOIN tiposalon t ON t.codigotiposalon=st.codigotiposalon
                					*/
                            
                        if($Detalle=&$db->Execute($SQL_D)===false){
                            echo 'Error en el SQL Detalle View.....<br><br>'.$SQL_D;
                            die;
                        }  
                        
                        
                  }   
                     
                ?>
                <tr style="background:<?PHP echo $Color?>;">
                    
                    <td style="text-align: left;">
                        <?PHP echo $i+1;?>
                        <div style="text-align: right;">
                        <?PHP 
                        if(!$op){
                         $class = 'Disponible_'.$tittle.'_'.$Fecha;
                        ?>
                        <input type="checkbox" name="AulaSelecionada" id="AulaSelecionada_<?PHP echo $i.'_'.$origen.'_'.$tittle.'_'.$Fecha?>"  class="<?PHP echo $class?>"  onclick="Inavilita('<?PHP echo $class?>','<?PHP echo $i.'_'.$origen.'_'.$tittle.'_'.$Fecha?>','<?PHP echo $tittle?>','<?PHP echo $Data->fields['id']?>');" />
                        <?PHP 
                        }
                        ?>
                        </div>
                    </td>
                    <td style="text-align: center;"><?PHP echo $Info->fields['Nombre'];?></td>
                    <td style="text-align: center;"><?PHP echo $Info->fields['maxi'];?></td>
                    <td style="text-align: center;"><?PHP echo $SobreCupo;?></td>
                    <td style="text-align: center;"><?PHP echo $Info->fields['CupoMax'];?></td>
                    <td style="font-size: 12px;"><?PHP echo $Info->fields['nombretiposalon'];?></td>
                    <td style="text-align: center;"><?PHP echo $Acceso;?></td>
                    <?PHP 
                        if($op==1){ 
                            ?>
                            <td><?PHP echo $Detalle->fields['fecha']?></td>
                            <td><?PHP echo $Detalle->fields['horainicio']?></td>
                            <td><?PHP echo $Detalle->fields['horafinal']?></td>
                            <td style="font-size: 12px;"><?PHP echo $Detalle->fields['grupos']?></td>
                            <td style="font-size: 9px;"><?PHP echo $Detalle->fields['nombremateria']?></td>
                            <td style="text-align: center;"><?PHP echo $Detalle->fields['matriculadosgrupo']?></td>
                            <?PHP
                        }
                    if($op!=1){
                        ?>
                        <td>
                            <img src="<?PHP echo $url?>../imagenes/group_add.png" title="Solicitar Sobrecupo" style="cursor: pointer;" onclick="SolicitarSobreCupo('<?PHP echo $Data->fields['id']?>')" />
                           
                        </td> 
                        <?PHP
                    }    
                    ?>    
                </tr>
                <?PHP
                /*********************************************************************/
                $i++;
                }
                $Data->MoveNext();
            }//while
            ?>
                </table>
            </div>
            <?PHP
        }else{
            ?>
            <br />
            <div style="background-color: white;">
                <span style="color:<?PHP echo $Color?>;">No Hay Inforamcion de <?PHP echo $Titulo?>...</span>
            </div>
            <br />
            <?PHP 
        }
        
    }//public function ViewEspacios
    public function DisponibilidadMultiple($db,$Data,$view,$Url){
        /****************************************************************/
        //echo '<pre>';print_r($Data);die;
        /*
            [NumEstudiantes] => 41
            [Acceso] => on
            [Campus] => 4
            [TipoSalon] => 01
            [FechaIni] => 2014-07-14
            [FechaFin] => 2014-07-25
            [numIndices] => 1
            [DiaSemana] => Array
                (
                    [0] => 1
                    [1] => 3
                    [2] => 5
                )
        
            [HoraInicial_0]
            [HoraFin_0]
        */
        $Max          = $Data['NumEstudiantes'];
        $Acceso       = $Data['Acceso'];
        if($Acceso=='on' || $Acceso==1){
            $Acceso = 1;
        }else{
            $Acceso = 0;
        }
        $Sede        = $Data['Campus'];
        $TipoSalon   = $Data['TipoSalon'];
        $FechaIni    = $Data['FechaIni'];
        $FechaFin    = $Data['FechaFin'];
        $DiaSemana   = $Data['DiaSemana'];
        $numIndices  = $Data['numIndices'];
        
        //var_dump(is_file($Url.'Solicitud/SolicitudEspacio_class.php'));die;
        
        include_once($Url.'Solicitud/SolicitudEspacio_class.php');  
         
        $C_SolicitudEspacio = new SolicitudEspacio();
        
        $Result = $C_SolicitudEspacio->FechasFuturas('35',$FechaIni,$FechaFin,$DiaSemana);
        //echo '<pre>';print_r($Result);die;
        $Horas = array();
        
        for($l=0;$l<count($DiaSemana);$l++){
            for($h=0;$h<=$numIndices;$h++){
                
                /******************************************************/
                $x          = $DiaSemana[$l]-1;
                $Horaini    = $Data['HoraInicial_'.$h][$x];
                $Horafin    = $Data['HoraFin_'.$h][$x];
                
                $C_H['inicial'][$l][]    = $Horaini;      
                $C_H['final'][$l][]      = $Horafin;      
                
                //$HorasFormato = $this->Horas($Horaini,$Horafin);
                
                /*$Horas['inicial'][$l][]    = $HorasFormato['Horaini'];
                $Horas['final'][$l][]      = $HorasFormato['Horafin']; */
                $Horas['inicial'][$l][]    = $Horaini;
                $Horas['final'][$l][]      = $Horafin; 
                
                
                /******************************************************/
            }//for            
        }//for
        
        //echo '<pre>';print_r($Horas['inicial']);die;
        
        for($l=0;$l<count($DiaSemana);$l++){
           $n = 0;
           for($j=0;$j<count($Result[$l]);$j++){
                for($x=0;$x<count($Horas['inicial'][$l]);$x++){
                /*********************************************************/
                    if($Horas['inicial'][$l][$x]){
                        
                        //echo '<br><br>l->'.$l.'-'.$x;
                        
                        $X_Result[$DiaSemana[$l]][$n][] = $Result[$l][$j].' '.$Horas['inicial'][$l][$x];
                        $X_Result[$DiaSemana[$l]][$n][] = $Result[$l][$j].' '.$Horas['final'][$l][$x];
                        $n++;
                        
                        $Feha_inicial = $Result[$l][$j];
                        $Feha_final   = $Result[$l][$j];
                        if($view=='pintar'){
                        $this->Disponibilidad($db,$Sede,$TipoSalon,$Feha_inicial,$Feha_final,$Horas['inicial'][$l][$x],$Horas['final'][$l][$x],$Acceso,$Max,$n);
                        }
                    }
                   /************************************************/
                }//for
            }//for
        }//for
        /****************************************************************/
        if($view=='arreglo'){
            return $X_Result;
        }
       //echo '<pre>';print_r($X_Result);
    }//public function DisponibilidadMultiple
     public function DisponibilidadMultipleSolicitud($db,$Data,$view,$Url){
        /****************************************************************/
        //echo '<pre>';print_r($Data);die;
        /*
            [NumEstudiantes] => 41
            [Acceso] => on
            [Campus] => 4
            [TipoSalon] => 01
            [FechaIni] => 2014-07-14
            [FechaFin] => 2014-07-25
            [numIndices] => 1
            [DiaSemana] => Array
                (
                    [0] => 1
                    [1] => 3
                    [2] => 5
                )
        
            [HoraInicial_0]
            [HoraFin_0]
        */
        $Max          = $Data['NumEstudiantes'];
        $Acceso       = $Data['Acceso'];
        if($Acceso=='on' || $Acceso==1){
            $Acceso = 1;
        }else{
            $Acceso = 0;
        }
        $Sede        = $Data['Campus'];
        $TipoSalon   = $Data['TipoSalon'];
        $FechaIni    = $Data['FechaIni'];
        $FechaFin    = $Data['FechaFin'];
        $DiaSemana   = $Data['DiaSemana'];
        $numIndices  = $Data['numIndices'];
        
        //var_dump(is_file($Url.'Solicitud/SolicitudEspacio_class.php'));die;
        
        include_once($Url.'Solicitud/SolicitudEspacio_class.php');  
         
        $C_SolicitudEspacio = new SolicitudEspacio();
        
        $Result = $C_SolicitudEspacio->FechasFuturas('35',$FechaIni,$FechaFin,$DiaSemana);
         
          //echo '<pre>';print_r($Result);die;
        
        if($view=='arreglo'){
            return $Result;
        }
      
    }//public function DisponibilidadMultipleSolicitud
    public function DiasSemana($Fecha,$op){
        if($op=='Nombre'){
            $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');    
        }else if($op=='Codigo'){
            $dias = array('','1','2','3','4','5','6','7');    
        }
        
        $fecha = $dias[date('N', strtotime($Fecha))]; 
        
        return $fecha;
    }// public function DiasSemana
    public function HorasInversa($hora_1,$hora_2){
        
        $C_Horaini = explode(':',$hora_1);//Dessarmar la Hora Inicial
        
        if($C_Horaini[0]>=12){
            $Formato = 'PM';
            
            if($C_Horaini[0]==12){
                $Hora['inicial']  = $C_Horaini[0].':'.$C_Horaini[1].' '.$Formato;   
             }else{
                $H = $C_Horaini[0]-12;
                
                $Hora['inicial']  = $H.':'.$C_Horaini[1].' '.$Formato;
            }
        }else{
            $Formato = 'AM';
            
            $Hora['inicial']  = $C_Horaini[0].':'.$C_Horaini[1].' '.$Formato;   
        }//Hora Inicial 
        
        $C_Horafin = explode(':',$hora_2);//Dessarmar la Hora final
        
        if($C_Horafin[0]>=12){
            $Formato = 'PM';
            
            if($C_Horafin[0]==12){
                $Hora['final']  = $C_Horafin[0].':'.$C_Horafin[1].' '.$Formato;   
             }else{
                $H = $C_Horafin[0]-12;
                
                $Hora['final']  = $H.':'.$C_Horafin[1].' '.$Formato;
            }
        }else{
            $Formato = 'AM';
            
            $Hora['final']  = $C_Horafin[0].':'.$C_Horafin[1].' '.$Formato;   
        }//Hora final
        
        return $Hora; 
    }//public function HorasInversa
    
    public function AsignacionAutoamtica($db,$Data,$Rol='',$userid=''){ // echo '<pre>';print_r($Data);
        
        include_once('SolicitudEspacio_class.php'); $C_SolicitudEspacio = new SolicitudEspacio();
         
        $Resultado = $C_SolicitudEspacio->CalcularFechasArray($Data); //echo '<pre>';print_r($Resultado);die;
        
        $numIndices   = $Data['I'];
        //echo '<pre>';print_r($numIndices);die;
        $FechasData   = array();
        
        for($i=0;$i<$numIndices;$i++){
            
            $TipoSalon[]     = $Data['TipoSalon_'.$i];
            /**************************************************/
            for($j=0;$j<count($Resultado[$i]);$j++){
                /**********************************************/
                $F_resultado = $Resultado[$i][$j];
                
                for($x=0;$x<count($Data['FechaAsignacion_'.$i]);$x++){
                    /**************************************************/
                    $F_Existe    = $Data['FechaAsignacion_'.$i][$x];
                    $Campus      = $Data['Campus_'.$i][$x];
                    
                    if($Campus){
                        $FechasData['Campus'][$i][]          = $Campus;    
                    }
                  //  echo '<br><br>'.$F_resultado.'=='.$F_Existe;
                    if($F_resultado==$F_Existe){
                        //echo 'entro...';die;
                        $FechasData['id'][$i][]            = $Data['idAsignacion_'.$i.'_'.$x][0];
                        $FechasData['fecha'][$i][]         = $F_Existe;
                        $FechasData['hora_ini'][$i][]      = $Data['HoraInicial_'.$i][$x];
                        $FechasData['hora_fin'][$i][]      = $Data['HoraFin_'.$i][$x];
                    }
                    /**************************************************/
                }//for
                /**********************************************/
            }//for
            /**************************************************/
        }//for
        /***********************************/
        //echo '<pre>';print_r($FechasData);die;
        
        $Acceso        = $Data['Acceso'];
        $min           = $Data['NumEstudiantes'];
        $Porcentaje    = $this->Porcentaje($db);
        $Carrera       = $Data['Carrera'];
        $id_Soli       = $Data['id_Soli'];
        /***********************************/
     //  echo '<pre>';print_r($FechasData);
        $Result = $this->AulasAutomatica($db,$TipoSalon,$Acceso,$min,$Porcentaje,$FechasData,$Carrera,$id_Soli,$Rol,$userid);
        
        return $Result;
        
    }//public function AsignacionAutoamtica
    public function Porcentaje($db){
        /************************************************/
         $Periodo = $this->Periodo($db);
         
          $SQL='SELECT
                
                Porcentaje
                
                FROM
                
                PorcentajeEspacio
                
                WHERE  
                
                codigoestado=100
                AND
                codigoperiodo="'.$Periodo.'"';
                
          if($Porcentaje=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Porcentaje....'.$SQL;
            die;
          }    
          
          Return $Porcentaje->fields['Porcentaje'];  
        /************************************************/
    }//public function Porcentaje
    public function Periodo($db){
        /**************************************************/
          $SQL='SELECT

                codigoperiodo
                
                FROM
                
                periodo
                
                WHERE
                
                codigoestadoperiodo IN ("1","3")';
                
           if($Perido=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Periodo....<br><br>'.$SQL;
            die;
           }  
           
          Return $Perido->fields['codigoperiodo'];   
        /**************************************************/
    }//public function Periodo
    public function AulasAutomatica($db,$TipoSalon,$Acceso,$min,$Porcentaje,$Data,$Carrera,$Padre,$Rol='',$userid=''){ 
        
        $max  = number_format(($min+(($min*$Porcentaje)/100)));
        
        if($Acceso==1){
            $Condicion = ' AND  x.AccesoDiscapacitados="'.$Acceso.'"';
        }else{
            $Condicion = '';
        }
        
        $SQL_P='SELECT
                	a.SolicitudAsignacionEspaciosId
                FROM
                	AsociacionSolicitud a
                INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                WHERE
                	s.codigoestado = 100
                AND a.SolicitudPadreId = "'.$Padre.'"';
                
          if($DatosHijo=&$db->Execute($SQL_P)===false){
            echo 'Error en el Sistema...';die;
          }
      while(!$DatosHijo->EOF){
        
       $id_Soli = $DatosHijo->fields['SolicitudAsignacionEspaciosId'];
       
       $SQL='SELECT 

                idgrupo
                
                FROM 
                
                SolicitudEspacioGrupos
                
                WHERE
                
                SolicitudAsignacionEspacioId="'.$id_Soli.'"'; 
                
                if($Grupo=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL del Grupo....<br><br>'.$SQL;
                    die;
                }
       
       $Grupo   = $Grupo->fields['idgrupo'];
         
         $NumFecha =count($Data['fecha']);
         
        for($i=0;$i<$NumFecha;$i++){ 
            $numFechaDetalle = count($Data['fecha'][$i]);
            /**********************************************************************/
            for($j=0;$j<$numFechaDetalle;$j++){ 
                /******************************************************************/
                $C_AulaSize = '';
                $Other_Aula = '';
                $fecha  = $Data['fecha'][$i][$j];
                $hora_1 = $Data['hora_ini'][$i][$j];                
                $hora_2 = $Data['hora_fin'][$i][$j];
                $Sede   = $Data['Campus'][$i][0];
                 
                $Fecha_horaIni = $fecha.' '.$hora_1;
                $fecha_horaFin = $fecha.' '.$hora_2;
                //echo '<pre>';print_r($Data);
                $id = $Data['id'][$i][$j];
                
                 /******************************************************************/
                 $Resultado = $this->ValidacionGrupoEspacio($db,$Grupo,$fecha,$hora_1,$hora_2);
                 
                if($Resultado['val']==true){ 
                /******************************************************************/
              //  echo '<pre>';print_r($TipoSalon);die;
                
                if($TipoSalon){
                    $C_TipoSalon = $TipoSalon[$i][0];
                }else{                
                    $C_TipoSalon = $_POST['TipoSalon_'.$i][0];
                }    
               
               
                $AulasPriorida = $this->ConsultarEspaciosPrivilegio($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Carrera,$Condicion,1,'',$Rol,$userid);
                       
                if(!$AulasPriorida->EOF){//if Prioridad Aula   
                      $Cambio = 0;
                             while(!$AulasPriorida->EOF){
                                /****************************************************************/
                                 $aula_id = $AulasPriorida->fields['ClasificacionEspaciosId'];
                                 
                                 $AulaSize = $this->SizeEspacioFisico($db,$aula_id,$min,$max);
                                 
                                  $Responsable = $this->EspacioResponsable($db,$userid,$id_Soli);
                
                                    if($Responsable){ 
                                        
                                        $Responsable_2 = $this->EspacioResponsable($db,$userid,'',$aula_id);
                                        
                                        if($Responsable_2){
                                        
                                    // echo 'line1024';echo '<pre>';print_r($AulaSize);
                                             if($AulaSize['val']==true){
                                                $Cambio=1;
                                                  
                                                 $AccesoTotal = $this->ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                 
                                                  if($AccesoTotal){
                                                     $this->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId']);  
                                                  }else{
                                                    $AccesoTotal = false;
                                                  }
                                               break;
                                            }
                                        }
                                    }
                                  $AulasPriorida->MoveNext();      
                                /****************************************************************/
                          }//while Prioridad Aula
                          
                          if($Cambio!=1){
                                $AulasPrioridaOther = $this->ConsultarEspaciosPrivilegio($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Carrera,$Condicion,0,'',$Rol,$userid);
                            
                                if(!$AulasPrioridaOther->EOF){ 
                                    $Cambio_1 = 0;
                                     while(!$AulasPrioridaOther->EOF){
                                    /****************************************************************/
                                     $aula_id = $AulasPrioridaOther->fields['ClasificacionEspaciosId'];
                                     
                                     $AulaSize = $this->SizeEspacioFisico($db,$aula_id,$min,$max);
                                          //echo 'line1044';echo '<pre>';print_r($AulaSize);
                                          
                                    $Responsable = $this->EspacioResponsable($db,$userid,$id_Soli);
                
                                    if($Responsable){ 
                                        
                                        $Responsable_2 = $this->EspacioResponsable($db,$userid,'',$aula_id);
                                        
                                        if($Responsable_2){     
                                             if($AulaSize['val']==true){
                                                 $Cambio_1 = 1;
                                                 
                                                 $AccesoTotal = $this->ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']); 
                                                 
                                                  if($AccesoTotal){
                                                    $this->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId']);  
                                                    }else{
                                                        $AccesoTotal=false;
                                                    }
                                               break;
                                               }
                                         }
                                       }
                                      $AulasPrioridaOther->MoveNext();      
                                    /****************************************************************/
                                    }//while Prioridad Aula Other
                                    if($Cambio_1!=1){ 
                                        
                                         $OtherAulas = $this->ConsultarEspacios($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Condicion,'','',$Rol,$userid);
                                    
                                            if(!$OtherAulas->EOF){
                                                $Cambio_2 = 0;
                                                 while(!$OtherAulas->EOF){
                                                /****************************************************************/
                                                $aula_id = $OtherAulas->fields['ClasificacionEspaciosId'];
                                                 
                                                 $AulaSize = $this->SizeEspacioFisico($db,$aula_id,$min,$max);
                                                     // echo 'line1063';echo '<pre>';print_r($AulaSize);
                                                     
                                                $Responsable = $this->EspacioResponsable($db,$userid,$id_Soli);
                
                                                if($Responsable){ 
                                                    
                                                    $Responsable_2 = $this->EspacioResponsable($db,$userid,'',$aula_id);
                                                    
                                                    if($Responsable_2){ 
                                                      
                                                         if($AulaSize['val']==true){
                                                          
                                                            if($Cambio_2!=1){
                                                                
                                                                 $Cambio_2 = 1;
                                                                 
                                                               $AccesoTotal = $this->ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                               
                                                               if($AccesoTotal){   
                                                                 
                                                                  $this->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                                  }else{
                                                                    $AccesoTotal=false;
                                                                  }  
                                                            }                                                        
                                                        }
                                                     }
                                                   }   
                                                  $OtherAulas->MoveNext();      
                                                /****************************************************************/
                                                }//while Aula Other
                                                if($Cambio_2!=1){
                                                    $a_vectt['NoHay']			= true;
                                                    $a_vectt['Msg']             = 'No Hay Espacios Disponibles...';                    
                                                }//if Cambio 2
                                            }
                                    }//if Cambio 1
                                }else{
                                    
                                    $OtherAulas = $this->ConsultarEspacios($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Condicion,'','',$Rol,$userid);
                                    
                                    if(!$OtherAulas->EOF){
                                        $Cambio_3 = 0;
                                         while(!$OtherAulas->EOF){
                                        /****************************************************************/
                                         $aula_id = $OtherAulas->fields['ClasificacionEspaciosId'];
                                         
                                         $AulaSize = $this->SizeEspacioFisico($db,$aula_id,$min,$max);
                                              //echo 'line1088';echo '<pre>';print_r($AulaSize);
                                              
                                          $Responsable = $this->EspacioResponsable($db,$userid,$id_Soli);
                
                                            if($Responsable){ 
                                                
                                                $Responsable_2 = $this->EspacioResponsable($db,$userid,'',$aula_id);
                                                
                                                if($Responsable_2){     
                                                     if($AulaSize['val']==true){
                                                        $Cambio_3 = 1;
                                                        
                                                        $AccesoTotal = $this->ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                       
                                                        if($AccesoTotal){ 
                                                         $this->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId']);  
                                                         }else{
                                                            $AccesoTotal=false;
                                                         }
                                                       break;
                                                    }
                                                 }
                                              }      
                                          $OtherAulas->MoveNext();      
                                        /****************************************************************/
                                        }//while Aula Other
                                        if($Cambio_3!=1){
                                            $a_vectt['NoHay']			= true;
                                            $a_vectt['Msg']             = 'No Hay Espacios Disponibles...'; 
                                        }//if Cambio 3
                                    }
                                }
                          }//if Cambio
                        }else{  
                             
                            $AulasPrioridaOther = $this->ConsultarEspaciosPrivilegio($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Carrera,$Condicion,0,'',$Rol,$userid);
                            
                            if(!$AulasPrioridaOther->EOF){
                                $Cambio_4 = 0;
                                 while(!$AulasPrioridaOther->EOF){
                                /****************************************************************/
                                 $aula_id = $AulasPrioridaOther->fields['ClasificacionEspaciosId'];
                                 
                                 $AulaSize = $this->SizeEspacioFisico($db,$aula_id,$min,$max);
                                      //echo 'line1115';echo '<pre>';print_r($AulaSize);
                                      
                                $Responsable = $this->EspacioResponsable($db,$userid,$id_Soli);
                                
                                if($Responsable){ 
                                    
                                    $Responsable_2 = $this->EspacioResponsable($db,$userid,'',$aula_id);
                                    
                                    if($Responsable_2){ 
                                      
                                             if($AulaSize['val']==true){
                                                 $Cambio_4 = 1;
                                                 $AccesoTotal = $this->ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                 
                                                 if($AccesoTotal){ 
                                                    $this->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                 }else{
                                                    $AccesoTotal=false;
                                                 }     
                                               break;
                                            }
                                        }
                                    }
                                  $AulasPrioridaOther->MoveNext();      
                                /****************************************************************/
                                }//while Prioridad Aula Other
                                if($Cambio_4!=1){
                                    
                                    $OtherAulas = $this->ConsultarEspacios($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Condicion,'','',$Rol,$userid);
                                
                                    if(!$OtherAulas->EOF){
                                        $Cambio_5 = 0;
                                         while(!$OtherAulas->EOF){
                                        /****************************************************************/
                                         $aula_id = $OtherAulas->fields['ClasificacionEspaciosId'];
                                         
                                         $AulaSize = $this->SizeEspacioFisico($db,$aula_id,$min,$max);
                                            //  echo 'line1134';echo '<pre>';print_r($AulaSize);
                                            
                                          $Responsable = $this->EspacioResponsable($db,$userid,$id_Soli);
                                
                                            if($Responsable){ 
                                                
                                                $Responsable_2 = $this->EspacioResponsable($db,$userid,'',$aula_id);
                                                
                                                if($Responsable_2){    
                                                     if($AulaSize['val']==true){
                                                         $Cambio_5 = 1;
                                                         $AccesoTotal = $this->ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                         
                                                            if($AccesoTotal){ 
                                                                $this->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId']); 
                                                            }else{
                                                                $AccesoTotal=false;
                                                            }      
                                                            break;
                                                    }
                                                }
                                            }        
                                          $OtherAulas->MoveNext();      
                                        /****************************************************************/
                                        }//while Aula Other
                                        if($Cambio_5!=1){
                                            $a_vectt['NoHay']			= true;
                                            $a_vectt['Msg']             = 'No Hay Espacios Disponibles...'; 
                                        }
                                    }
                                }
                            }else{ 
                                
                                $OtherAulas = $this->ConsultarEspacios($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Condicion,'','',$Rol,$userid);
                                
                                if(!$OtherAulas->EOF){
                                    $Cambio_6 = 0;
                                     while(!$OtherAulas->EOF){ 
                                    /****************************************************************/
                                     $aula_id = $OtherAulas->fields['ClasificacionEspaciosId'];
                                     
                                     $AulaSize = $this->SizeEspacioFisico($db,$aula_id,$min,$max);
                                        //  echo 'line1159';echo '<pre>';print_r($AulaSize);
                                        
                                        $Responsable = $this->EspacioResponsable($db,$userid,$id_Soli);
                                
                                            if($Responsable){ 
                                                
                                                $Responsable_2 = $this->EspacioResponsable($db,$userid,'',$aula_id);
                                                
                                                if($Responsable_2){ 
                                        
                                                     if($AulaSize['val']==true){
                                                         $Cambio_6 = 1;
                                                        // echo '<br><br>id->'.$id;
                                                         $AccesoTotal = $this->ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                         
                                                            if($AccesoTotal){  
                                                             $this->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId']);  
                                                            }else{
                                                                $AccesoTotal=false;
                                                            }  
                                                           break;
                                                    }
                                                }
                                                
                                             }         
                                      $OtherAulas->MoveNext();      
                                    /****************************************************************/
                                    }//while Aula Other
                                    if($Cambio_6!=1){
                                        $a_vectt['NoHay']			= true;
                                        $a_vectt['Msg']             = 'No Hay Espacios Disponibles...'; 
                                    }
                                }
                                
                                $AulasHistoricas = $this->ConsultaEspacioHistorico($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$Sede,'','',$Padre,'');
                                
                                if(!$AulasHistoricas->EOF){
                                    $Cambio_6 = 0;
                                     while(!$AulasHistoricas->EOF){ 
                                    /****************************************************************/
                                     $aula_id = $AulasHistoricas->fields['ClasificacionEspaciosId'];
                                     
                                     $AulaSize = $this->SizeEspacioFisico($db,$aula_id,$min,$max);
                                        //  echo 'line1159';echo '<pre>';print_r($AulaSize);
                                        
                                        $Responsable = $this->EspacioResponsable($db,$userid,$id_Soli);
                                
                                            if($Responsable){ 
                                                
                                                $Responsable_2 = $this->EspacioResponsable($db,$userid,'',$aula_id);
                                                
                                                if($Responsable_2){ 
                                        
                                                     if($AulaSize['val']==true){
                                                         $Cambio_6 = 1;
                                                        // echo '<br><br>id->'.$id;
                                                         $AccesoTotal = $this->ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                          
                                                            if($AccesoTotal){  
                                                             $this->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId']);  
                                                            }else{
                                                                $AccesoTotal=false;
                                                            }  
                                                           break;
                                                    }
                                                }
                                                
                                             }         
                                      $AulasHistoricas->MoveNext();      
                                    /****************************************************************/
                                    }//while Aula Other
                                }
                            }
                            
                  }//if Prioridad Aula                                                   
                /******************************************************************/
                }else{
                    $a_vectt['Existe']			= true;
                    $a_vectt['Msg']             = ' Pero se encontraron Inconsistencias...';
                    $a_vectt['Espacio']			= $Resultado['Nombre'];
                    $a_vectt['Texto'][$id]		= 'Ya Existe una Asigancion para Este Grupo en la fecha '.$Resultado['Fecha'].' y las siguientes horas '.$Resultado['Hora_1'].' -- '.$Resultado['Hora_2'];
                }//Validacion
            }//for
            /**********************************************************************/
        }//for
        
      
       $DatosHijo->MoveNext();
      }
    
       
         $a_vectt['val']			=true;
         $a_vectt['Complet']		=true;
         $a_vectt['descrip']		='Se ha Realizado la Asignacion Autmatica de Forma Correcta.';
        
        return $a_vectt;
        
    }//public function AulasAutomatica
    public function InsertAula($db,$Asignacion_id,$Aula_id,$idSoli=''){
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
        //
        if($idSoli){
            $Condicion = '  AND  SolicitudAsignacionEspacioId="'.$idSoli.'"';    
        }else{
            $Condicion = '';
        }
        
        
       $Update = 'UPDATE  AsignacionEspacios
        
                   SET     ClasificacionEspaciosId="'.$Aula_id.'",
                           UsuarioUltimaModificacion="'.$userid.'",
                           FechaultimaModificacion=NOW()
                           
                   WHERE   AsignacionEspaciosId="'.$Asignacion_id.'" AND codigoestado=100 AND EstadoAsignacionEspacio=1 AND  ClasificacionEspaciosId=212  '.$Condicion;
                   
      if($ModificaAula=&$db->Execute($Update)===false){
            echo 'Error en el SQL de Insertar el Aula de Forma Automatica...<br><br>'.$Update;
            die;
       }
        
      
                      
    }//public function InsertAula
    public function ValidacionGrupoEspacio($db,$Grupo,$Fecha,$Hora_1,$Hora_2){
        
        
         $SQL='SELECT

                a.AsignacionEspaciosId,
                c.ClasificacionEspaciosId,
                c.Nombre
                
                FROM
                
                SolicitudEspacioGrupos sg INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                						  INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                
                WHERE
                
                sg.idgrupo="'.$Grupo.'"
                AND
                a.codigoestado=100
                AND 
                c.codigoestado = 100
                AND
                a.FechaAsignacion="'.$Fecha.'"
                AND
                a.HoraInicio="'.$Hora_1.'"
                AND
                a.HoraFin="'.$Hora_2.'"
                AND 
                a.ClasificacionEspaciosId<>212';
                
            if($GrupoExpacio=&$db->Execute($SQL)===false){
                echo 'Error en el SQL.....<br><br>'.$SQL;
                die;
            }    
           
           $Result = array();
            
           if(!$GrupoExpacio->EOF){
                $Result['val']                      = false;
                $Result['AsignacionEspaciosId']     = $GrupoExpacio->fields['AsignacionEspaciosId'];
                $Result['ClasificacionEspaciosId']  = $GrupoExpacio->fields['ClasificacionEspaciosId'];
                $Result['Nombre']                   = $GrupoExpacio->fields['Nombre'];
                $Result['Grupoid']                  = $Grupo;
                $Result['Fecha']                    = $Fecha;
                $Result['Hora_1']                   = $Hora_1;
                $Result['Hora_2']                   = $Hora_2;
           }else{
                $Result['val']                      = true;
                
           } 
           
           Return $Result;
    }//public function ValidacionGrupoEspacio
    public function PirtarSalonGrupo($db,$datos){
        
        $Data   = $this->MultiConsultaData($db,$datos['Grupoid'],$datos['ClasificacionEspaciosId']);
        
        ?>
        <fieldset>
            <legend>Grupo con Espacio Asignado</legend>
            <table>
                <thead>
                    <tr>
                        <th>C&oacute;digo Grupo</th>
                        <th>Nombre Grupo</th>
                        <th>Materia</th>
                    </tr>
                    <tr>
                        <th><?PHP echo $Data['idgrupo']?></th><!--Grupoid-->
                        <th><?PHP echo $Data['nombregrupo']?></th><!--NombreGrupo-->
                        <th><?PHP echo $Data['nombremateria']?></th><!--Materia-->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" style="text-align: justify;">
                            El Grupo mencionado ya tiene asigando un espacio f&iacute;sico para la fecha <?PHP echo $datos['Fecha']?> en el intervalo de tiempo comprendido entre <?PHP echo $datos['Hora_1']?> y <?PHP echo $datos['Hora_2']?>
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre del Espacio F&iacute;sico</td>
                        <td>Bloque</td>
                        <td>Campus &oacute; Sede</td>
                    </tr>
                    <tr>
                        <td><?PHP echo $Data['Aula']?></td>
                        <td><?PHP echo $Data['Bloke']?></td>
                        <td><?PHP echo $Data['Campus']?></td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?PHP
    }//public function PirtarSalonGrupo
    public function MultiConsultaData($db,$Grupo,$Espacio){
        
        $SQL_1='SELECT

                g.idgrupo,
                m.nombremateria,
                g.nombregrupo
                
                FROM
                
                grupo g INNER JOIN materia m ON g.codigomateria=m.codigomateria
                
                WHERE
                
                g.idgrupo="'.$Grupo.'"';
                
                if($DataGrupo=&$db->Execute($SQL_1)===false){
                    echo 'Error en el SQL de Lada del Grupo...<br><br>'.$SQL_1;
                    die;
                }
                
        $SQL_2='SELECT
                
                c.ClasificacionEspaciosId AS id,
                c.Nombre as Aula,
                b.ClasificacionEspaciosId AS id_Bloke,
                b.Nombre AS Bloke,
                s.ClasificacionEspaciosId AS id_Campus,
                s.Nombre AS Campus
                
                FROM
                
                ClasificacionEspacios c INNER JOIN ClasificacionEspacios b ON c.ClasificacionEspacionPadreId=b.ClasificacionEspaciosId
                						INNER JOIN ClasificacionEspacios s ON b.ClasificacionEspacionPadreId=s.ClasificacionEspaciosId
                
                WHERE
                
                c.codigoestado=100
                AND
                c.ClasificacionEspaciosId="'.$Espacio.'"
                AND
                b.codigoestado=100
                AND
                s.codigoestado=100';
                
                if($DataEspacio=&$db->Execute($SQL_2)===false){
                    echo 'Error en el SQL de Data Espacio....<br><br>'.$SQL_2;
                    die;
                }   
                
            $Resultado = array();
            
            $Resultado['idgrupo']         = $DataGrupo->fields['idgrupo'];
            $Resultado['nombremateria']   = $DataGrupo->fields['nombremateria'];
            $Resultado['nombregrupo']     = $DataGrupo->fields['nombregrupo'];
            $Resultado['id']              = $DataEspacio->fields['id'];
            $Resultado['Aula']            = $DataEspacio->fields['Aula'];
            $Resultado['id_Bloke']        = $DataEspacio->fields['id_Bloke'];
            $Resultado['Bloke']           = $DataEspacio->fields['Bloke'];
            $Resultado['id_Campus']       = $DataEspacio->fields['id_Campus'];
            $Resultado['Campus']          = $DataEspacio->fields['Campus'];
            
            
            Return $Resultado;
                      
    }//public function MultiConsultaData
    public function HorasInactivas($db){
        
    }//public function HorasInactivas
    public function ConsultarEspaciosPrivilegio($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Carrera,$Condicion,$IN,$viewSQL='',$ROL='',$userid=''){
        
        if($IN=1){
            $CondiconSalon  = ' x.codigotiposalon IN ('.$C_TipoSalon.') ';
        }else{
            $CondiconSalon  = ' x.codigotiposalon NOT IN ('.$C_TipoSalon.') ';
        }
    
        $InnerCondicon_Pribilegio = '';
        $Condicion_Pribilegio     = '';
        
        if($ROL==2 || $ROL==4){
            $InnerCondicon_Pribilegio = ' INNER JOIN ResponsableEspacioFisico r ON r.EspaciosFisicosId=e.EspaciosFisicosId  AND r.CodigoTipoSalon=c.codigotiposalon';
            $Condicion_Pribilegio     = ' AND r.UsuarioId="'.$userid.'" AND r.CodigoEstado=100';
        }else if($ROL==5){
             $InnerCondicon_Pribilegio = ' INNER JOIN ResponsableClasificacionEspacios z ON z.ClasificacionEspaciosId=  pf.ClasificacionEspaciosId';
             $Condicion_Pribilegio       = ' AND z.CodigoEstado=100 AND z.idusuario="'.$userid.'"';
          } 
        
        
         $SQL='SELECT 

                pf.ClasificacionEspaciosId AS id
                	
                FROM PrioridadesRestricciones p 
                INNER JOIN PrioridadesRestriccionesEspaciosFisicos pf ON p.PrioridadesRestriccionesId=pf.PrioridadesRestriccionesId
                INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=pf.ClasificacionEspaciosId
                INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=c.EspaciosFisicosId
                '.$InnerCondicon_Pribilegio.'
                																	
                AND pf.ClasificacionEspaciosId IN(SELECT
                                                        xx.ClasificacionEspaciosId AS id
                                                    FROM(
                                                        SELECT
                                                                x.ClasificacionEspaciosId, 
                                                                x.ClasificacionEspacionPadreId,
                                                                x.CapacidadEstudiantes,
                                                                x.EspaciosFisicosId,
                                                                e.Nombre
                                                        FROM 
                                                                ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                                                                        INNER JOIN DetalleClasificacionEspacios D ON D.ClasificacionEspaciosId=x.ClasificacionEspaciosId
  
                                                        WHERE x.ClasificacionEspaciosId not in (
                                                                SELECT 
                                                                    eventos.ClasificacionEspaciosId 
                                                                FROM (
                                                                		SELECT
                                                							a.AsignacionEspaciosId,
                                                							a.FechaAsignacion AS fecha,
                                                							a.HoraInicio AS horainicio,
                                                							a.HoraFin AS horafinal,
                                                							c.ClasificacionEspaciosId,
                                                							c.Nombre AS Salon
                                                						FROM
                                                							AsignacionEspacios a
                                                						INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                                						INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
                                                						WHERE
                                                							a.FechaAsignacion = "'.$fecha.'"
                                                						AND a.HoraInicio <>"'.$hora_2.'"
                                                                        AND a.HoraFin<> "'.$hora_1.'"
                                                						AND a.codigoestado = 100
                                                                        AND c.codigoestado = 100
                                                						AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
                                                						AND "'.$fecha_horaFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
                                                						AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                      								    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                                                        OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                                                        AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                                                        OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'") 
                                                                        OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$fecha_horaFin.'"))                                      
                                                                		
                                                                		) eventos
                                                                		WHERE 
                                                                            "'.$Fecha_horaIni.'" <> CONCAT(fecha," ",horafinal) 
                                                          		            AND 
                                                                            "'.$fecha_horaFin.'" <> CONCAT(fecha," ",horainicio) 
                                                                		    AND (
                                                                		("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                                                                		OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                                                                		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  ) 
                                                                		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  )
                                                       	         )
                                                        ) 
                                                        
                                                        
                                                        AND
                                                        '.$CondiconSalon.$Condicion.'
                                                        AND
                                                        x.codigoestado = 100
                                                        AND
                                                        e.PermitirAsignacion=1
                                                        AND 
                                                        "'.$fecha.'" BETWEEN D.FechaInicioVigencia and D.FechaFinVigencia 
                                                        
                                                        ) xx INNER JOIN ClasificacionEspacios cp ON xx.ClasificacionEspacionPadreId=cp.ClasificacionEspaciosId AND cp.codigoestado = 100  AND cp.ClasificacionEspacionPadreId="'.$Sede.'"
                                                        
                                                        ORDER BY xx.ClasificacionEspaciosId ASC ) 
                                            AND 
                                            p.codigocarrera="'.$Carrera.'" 
                                            AND p.codigoestado=100 AND p.Estatus=1
                                            '.$Condicion_Pribilegio; 
    /********Consulta anterion 14-05-2015 *********/
      /**
 * $SQL='SELECT 

 *             pf.ClasificacionEspaciosId
 *             	
 *             FROM PrioridadesRestricciones p INNER JOIN PrioridadesRestriccionesEspaciosFisicos pf ON p.PrioridadesRestriccionesId=pf.PrioridadesRestriccionesId 
 *             																	
 *             AND pf.ClasificacionEspaciosId IN(SELECT
 *                                                     xx.ClasificacionEspaciosId AS id
 *                                                 FROM(
 *                                                     SELECT
 *                                                             x.ClasificacionEspaciosId, 
 *                                                             x.ClasificacionEspacionPadreId,
 *                                                             CAST(x.CapacidadEstudiantes AS SIGNED)
 *                                                     FROM 
 *                                                             ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
 *                                                                                     INNER JOIN DetalleClasificacionEspacios D ON D.ClasificacionEspaciosId=x.ClasificacionEspaciosId 
 *                                                     WHERE x.ClasificacionEspaciosId not in (
 *                                                             SELECT 
 *                                                                 eventos.ClasificacionEspaciosId 
 *                                                             FROM (
 *                                                             		SELECT
 *                                                 							a.AsignacionEspaciosId,
 *                                                 							a.FechaAsignacion AS fecha,
 *                                                 							a.HoraInicio AS horainicio,
 *                                                 							a.HoraFin AS horafinal,
 *                                                 							c.ClasificacionEspaciosId,
 *                                                 							c.Nombre AS Salon
 *                                                 						FROM
 *                                                 							AsignacionEspacios a
 *                                                 						INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
 *                                                 						INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
 *                                                 						WHERE
 *                                                 							a.FechaAsignacion = "'.$fecha.'"
 *                                                 						AND a.HoraInicio <>"'.$hora_2.'"
 *                                                                         AND a.HoraFin<> "'.$hora_1.'"
 *                                                 						AND a.codigoestado = 100
 *                                                                         AND c.codigoestado = 100
 *                                                 						AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
 *                                                 						AND "'.$fecha_horaFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
 *                                                 						AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
 *                                       								    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
 *                                                                         OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
 *                                                                         AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
 *                                                                         OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'") 
 *                                                                         OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$fecha_horaFin.'"))                                      
 *                                                                 		                                    
 *                                                             		
 *                                                             		) eventos
 *                                                             		WHERE 
 *                                                                         "'.$Fecha_horaIni.'" <> CONCAT(fecha," ",horafinal) 
 *                                                       		            AND 
 *                                                                         "'.$fecha_horaFin.'" <> CONCAT(fecha," ",horainicio) 
 *                                                             		    AND (
 *                                                             		("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
 *                                                             		OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
 *                                                             		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  ) 
 *                                                             		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  )
 *                                                    	         )
 *                                                     ) 
 *                                                     AND
 *                                                    '.$CondiconSalon.$Condicion.'
 *                                                     AND
 *                                                     x.codigoestado = 100
 *                                                     AND
 *                                                     e.PermitirAsignacion=1
 *                                                     AND 
 *                                                     "'.$fecha.'" BETWEEN D.FechaInicioVigencia and D.FechaFinVigencia 
 *                                                     
 *                                                     ORDER BY  CAST(x.CapacidadEstudiantes AS SIGNED) ASC
 *                                                     
 *                                                     ) xx INNER JOIN ClasificacionEspacios cp ON xx.ClasificacionEspacionPadreId=cp.ClasificacionEspaciosId  AND cp.ClasificacionEspacionPadreId="'.$Sede.'"  AND cp.codigoestado = 100
 *                                                     
 *                                                     ORDER BY xx.ClasificacionEspaciosId ASC ) 
 *                                         AND 
 *                                         p.codigocarrera="'.$Carrera.'" 
 *                                         AND 
 *                                         p.codigoestado=100 
 *                                         AND 
 *                                         p.Estatus=1';
 */
          
           if($viewSQL){
                echo '<br><br>'.$SQL.'<br><br>';die;
            } 
                            
            if($AulasPriorida=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de Aulas con Prioridad....<br><br>'.$SQL;
                die;
            }      
            
                                 
            
           return $AulasPriorida; 
           
    }//public function ConsultarEspaciosPrivilegio
    public function ConsultaEspacioHistorico($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$Sede,$id='',$viewSQL='',$Padre,$C_TipoSalon=''){
     if($C_TipoSalon!='' && $C_TipoSalon!=null){
        
        switch($C_TipoSalon){
            case '"0"' :{
                 $SQL='SELECT
                    codigotiposalon
                    FROM
                    tiposalon
                    WHERE
                    EspaciosFisicosId=5
                    AND
                    codigoestado=100
                    AND   
                    codigotiposalon<>"0"';
                    
            if($TiposAulas=&$db->Execute($SQL)===false){
                echo 'Error del Sistema...<br>'.
                die;
            }   
            $OtherAulas = '';
            while(!$TiposAulas->EOF){
                
                if($OtherAulas){
                    $OtherAulas = $OtherAulas.','.'"'.$TiposAulas->fields['codigotiposalon'].'"';
                }else{
                    $OtherAulas = '"'.$TiposAulas->fields['codigotiposalon'].'"';
                }
                
                $TiposAulas->MoveNext();
            }   
            
            $condicion = ' AND c.codigotiposalon IN ('.$OtherAulas.')';  
            }break;
            default:{
                 $condicion = ' AND c.codigotiposalon IN ('.$C_TipoSalon.')';
            }break;
        }
        
        
        $inner = '  INNER JOIN ClasificacionEspacios c On c.ClasificacionEspaciosId=asg.ClasificacionEspaciosId';
     }else{
        $condicion = '';
        $inner = '';
     }
     
           $SQL='SELECT
                	asg.ClasificacionEspaciosId
                FROM
                	AsociacionSolicitud a
                INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                INNER JOIN AsignacionEspacios asg ON asg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                '.$inner.'
                WHERE
                	a.SolicitudPadreId ="'.$Padre.'"
                AND s.codigoestado = 100
                AND asg.codigoestado = 100
                AND asg.ClasificacionEspaciosId <> 212
                '.$condicion.' 
                GROUP BY
                	asg.ClasificacionEspaciosId';
        
        if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Historico....'.$SQL;
            die;
        }
        
        if(!$Data->EOF){
            $i=1;
            while(!$Data->EOF){
                    if($i==1){
                        $Aulas = '"'.$Data->fields['ClasificacionEspaciosId'].'"';
                    }else{
                        $Aulas = $Aulas.',"'.$Data->fields['ClasificacionEspaciosId'].'"';
                    }
                $Data->MoveNext();
                $i++;
            }//while    
        
        
       // echo '<br><br>Aulas->'.$Aulas.'...id--->'.$id;
        
              $SQL='SELECT
                        xx.ClasificacionEspaciosId ,
                        CAST(xx.CapacidadEstudiantes AS SIGNED) as Num
    
                    FROM(
                        SELECT
                                x.ClasificacionEspaciosId, 
                                x.ClasificacionEspacionPadreId,
                                x.CapacidadEstudiantes
                        FROM 
                                ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                                        INNER JOIN DetalleClasificacionEspacios d ON d.ClasificacionEspaciosId=x.ClasificacionEspaciosId
                                                         
                        WHERE x.ClasificacionEspaciosId not in (
                                SELECT 
                                    eventos.ClasificacionEspaciosId 
                                FROM (
                                			SELECT
                    							a.AsignacionEspaciosId,
                    							a.FechaAsignacion AS fecha,
                    							a.HoraInicio AS horainicio,
                    							a.HoraFin AS horafinal,
                    							c.ClasificacionEspaciosId,
                    							c.Nombre AS Salon
                    						FROM
                    							AsignacionEspacios a
                    						INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                    						INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
                    						WHERE
                    							a.FechaAsignacion = "'.$fecha.'"
                    						AND a.HoraInicio <>"'.$hora_2.'"
                                            AND a.HoraFin<> "'.$hora_1.'"
                    						AND a.codigoestado = 100
                                            AND c.codigoestado = 100
                    						AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
                    						AND "'.$fecha_horaFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
                    						AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
          								    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                            OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                            AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                            OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'") 
                                            OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$fecha_horaFin.'"))                                                                            
                                		
                                		) eventos
                                		WHERE 
                                            "'.$Fecha_horaIni.'" <> CONCAT(fecha," ",horafinal) 
                          		            AND 
                                            "'.$fecha_horaFin.'" <> CONCAT(fecha," ",horainicio) 
                                		    AND (
                                		("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                                		OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                                		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  ) 
                                		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  )
                       	         )
                        ) 
                        
                        AND
                        x.codigoestado = 100
                        AND
                        e.PermitirAsignacion=1
                        AND 
                        "'.$fecha.'" BETWEEN d.FechaInicioVigencia and d.FechaFinVigencia 
                        
                        ) xx INNER JOIN ClasificacionEspacios cp ON xx.ClasificacionEspacionPadreId=cp.ClasificacionEspaciosId AND cp.codigoestado = 100  AND cp.ClasificacionEspacionPadreId="'.$Sede.'"
                        
                        WHERE xx.ClasificacionEspaciosId IN ('.$Aulas.')
                        
                        ORDER BY CAST(xx.CapacidadEstudiantes AS SIGNED) ASC'; 
                        
                         if($HitoricoAula=&$db->Execute($SQL)===false){
                            echo 'Error en el SQl de  Aulas Historico ....<br><br>'.$SQL;
                            die;
                        }
          
           if($viewSQL){
                echo '<br><br>'.$SQL.'<br><br>';
            }  
            
            Return $HitoricoAula;
        
        }else{
            return 1;
        }
        
    
    }//public function ConsultaEspacioHistorico
    public function ConsultarEspacios($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Condicion,$viewSQL='',$Condicion2='',$Rol='',$userid=''){
        
        if($Condicion2==1){
            $Salones = 'x.codigotiposalon  IN ('.$C_TipoSalon.')';
        }else{
            $Salones = 'x.codigotiposalon  NOT IN ('.$C_TipoSalon.')';
        }
        
             $InnerCondicon_Other = '';
             $Condicion_Other     = '';
             
          if($Rol==2 || $ROL==4){
             $InnerCondicon_Other = ' INNER JOIN ResponsableEspacioFisico r ON r.EspaciosFisicosId=xx.EspaciosFisicosId AND r.CodigoTipoSalon=xx.codigotiposalon';
             $Condicion_Other     = ' AND r.UsuarioId="'.$userid.'" AND r.CodigoEstado=100';
          }else if($Rol==5){
             $InnerCondicon_Other = ' INNER JOIN ResponsableClasificacionEspacios z ON z.ClasificacionEspaciosId= xx.ClasificacionEspaciosId';
             $Condicion_Other     = ' AND z.CodigoEstado=100 AND z.idusuario="'.$userid.'"';
          } 
        
                       $SQL='SELECT
                                    xx.ClasificacionEspaciosId ,
                                    CAST(xx.CapacidadEstudiantes AS SIGNED) as Num,
                                    cp.Nombre,
                                    xx.EspaciosFisicosId,
                	                xx.Nombre AS Nombre_Espacio,
                                    xx.codigotiposalon

                                FROM(
                                    SELECT
                                            x.ClasificacionEspaciosId, 
                                            x.ClasificacionEspacionPadreId,
                                            x.CapacidadEstudiantes,
                                            x.EspaciosFisicosId,
                                            e.Nombre,
                                            x.codigotiposalon
                                    FROM 
                                            ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                                                    INNER JOIN DetalleClasificacionEspacios d ON d.ClasificacionEspaciosId=x.ClasificacionEspaciosId
                                                                     
                                    WHERE x.ClasificacionEspaciosId not in (
                                            SELECT 
                                                eventos.ClasificacionEspaciosId 
                                            FROM (
                                            			SELECT
                                							a.AsignacionEspaciosId,
                                							a.FechaAsignacion AS fecha,
                                							a.HoraInicio AS horainicio,
                                							a.HoraFin AS horafinal,
                                							c.ClasificacionEspaciosId,
                                							c.Nombre AS Salon
                                						FROM
                                							AsignacionEspacios a
                                						INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                						INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
                                						WHERE
                                							a.FechaAsignacion = "'.$fecha.'"
                                						AND a.HoraInicio <>"'.$hora_2.'"
                                                        AND a.HoraFin<> "'.$hora_1.'"
                                						AND a.codigoestado = 100
                                                        AND c.codigoestado = 100
                                						AND "'.$Fecha_horaIni.'" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
                                						AND "'.$fecha_horaFin.'" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
                                						AND (("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                      								    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                                        OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                                        AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                                        OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'") 
                                                        OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "'.$Fecha_horaIni.'" AND "'.$fecha_horaFin.'"))                                                                            
                                            		
                                            		) eventos
                                            		WHERE 
                                                        "'.$Fecha_horaIni.'" <> CONCAT(fecha," ",horafinal) 
                                      		            AND 
                                                        "'.$fecha_horaFin.'" <> CONCAT(fecha," ",horainicio) 
                                            		    AND (
                                            		("'.$Fecha_horaIni.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                                            		OR ("'.$fecha_horaFin.'" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                                            		OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  ) 
                                            		OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "'.$Fecha_horaIni.'"  AND "'.$fecha_horaFin.'"  )
                                   	         )
                                    ) 
                                    AND
                                    '.$Salones.$Condicion.'
                                    AND
                                    x.codigoestado = 100
                                    AND
                                    e.PermitirAsignacion=1
                                    AND 
                                    "'.$fecha.'" BETWEEN d.FechaInicioVigencia and d.FechaFinVigencia 
                                    
                                    ) xx 
                                    
                                    INNER JOIN ClasificacionEspacios cp ON xx.ClasificacionEspacionPadreId=cp.ClasificacionEspaciosId 
                                    '.$InnerCondicon_Other.'
                                    
                                    WHERE
                                    
                                     cp.codigoestado = 100 
                                     
                                     '.$Condicion_Other.'
                                    
                                     AND cp.codigoestado = 100 
                                     AND cp.ClasificacionEspacionPadreId="'.$Sede.'"
                                    
                                    ORDER BY CAST(xx.CapacidadEstudiantes AS SIGNED) ASC'; 
                                    
                                    
          if($viewSQL){
                echo '<br><br>'.$SQL.'<br><br>';die;
          }                           
                                    
          if($AulasOthers=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de Otras Aulas ....<br><br>'.$SQL;
                die;
            }
         
          return $AulasOthers;              
    }//public function ConsultarEspacios
    public function SizeEspacioFisico($db,$aula_id,$min,$max,$ViewSQl=''){
        
        if($min==$max){
            $Condicion = '';
        }else{
           $Condicion = ' AND x.CupoMax <='.$max.'';
        }
        
        $SQL_size='SELECT
                    	*
                    FROM
                    	(
                    		SELECT
                    			c.Nombre,
                    			c.CapacidadEstudiantes AS maxi,
                    			t.nombretiposalon,
                    			c.AccesoDiscapacitados,
                    			d.Sobrecupo AS SobreCupo,
                                
                    
                    		IF (
                    			SUM(
                    				d.Sobrecupo + c.CapacidadEstudiantes
                    			) IS NULL,
                    			c.CapacidadEstudiantes,
                    			SUM(
                    				d.Sobrecupo + c.CapacidadEstudiantes
                    			)
                    		) AS CupoMax,
                                c.ClasificacionEspaciosId
                    		FROM
                    			ClasificacionEspacios c
                    		INNER JOIN tiposalon t ON c.codigotiposalon = t.codigotiposalon
                    	    INNER JOIN SobreCupoClasificacionEspacios d ON c.ClasificacionEspaciosId = d.ClasificacionEspacioId
                    		WHERE
                    			c.ClasificacionEspaciosId = "'.$aula_id.'"
                    		AND d.EstadoAprobacion = 1
                            AND c.codigoestado = 100
                    	) x
                    WHERE
                    	x.CupoMax >='.$min.''.$Condicion;
                    
             if($AulaSize=&$db->Execute($SQL_size)===false){
                echo 'Error en el SQL del size del aula...<br><br>'.$SQL_size;
                die;
             } 
             
             if($ViewSQl==1){
                echo '<br><br>'.$SQL_size.'<br><br>';
             }
             
             $Resultado = array();
             
             if(!$AulaSize->EOF){
                
                $C_AulaSize = $AulaSize->GetArray();
                //echo '<pre>';print_r($C_AulaSize);
                $Resultado['val']  = true;
                $Resultado['Data'] = $C_AulaSize;   
             }else{
                $Resultado['val']  = false;
             }
             
            return $Resultado; 
              
    }//public function SizeEspacioFisico
    
    public function EspacioResponsable($db,$userid,$Soli='',$Aula=''){
        if($Soli){
          $SQL='SELECT
                r.CodigoTipoSalon
                FROM
                ResponsableEspacioFisico r INNER JOIN SolicitudAsignacionEspaciostiposalon s ON s.codigotiposalon=r.CodigoTipoSalon
                
                WHERE
                r.UsuarioId="'.$userid.'"
                AND
                r.CodigoEstado=100
                AND
                s.SolicitudAsignacionEspacioId="'.$Soli.'"';
         }else{
            $SQL='SELECT
                r.CodigoTipoSalon
                FROM
                ResponsableEspacioFisico r INNER JOIN ClasificacionEspacios c ON c.codigotiposalon = r.CodigoTipoSalon
                
                WHERE
                r.UsuarioId="'.$userid.'"
                AND
                r.CodigoEstado=100
                AND
                c.ClasificacionEspaciosId="'.$Aula.'"';
         }       
                
         if($Responsable=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Responsabilida ...<br><br>'.$SQL;
            die;
         } 
         
         
         if(!$Responsable->EOF){
            return true;
         }else{
            return false;
         }      
  }//function EspacioResponsable
  public function ValidaTipoSalonFinal($db,$TipoSalon,$Espacio){
    switch($TipoSalon){
            case '"0"' :{
                 $SQL='SELECT
                    codigotiposalon
                    FROM
                    tiposalon
                    WHERE
                    EspaciosFisicosId=5
                    AND
                    codigoestado=100
                    AND
                    codigotiposalon<>"0"';
                    
            if($TiposAulas=&$db->Execute($SQL)===false){
                echo 'Error del Sistema...<br>'.
                die;
            }   
            $OtherAulas = '';
            while(!$TiposAulas->EOF){
                
                if($OtherAulas){
                    $OtherAulas = $OtherAulas.','.'"'.$TiposAulas->fields['codigotiposalon'].'"';
                }else{
                    $OtherAulas = '"'.$TiposAulas->fields['codigotiposalon'].'"';
                }
                
                $TiposAulas->MoveNext();
            }   
            
            $condicion = '  c.codigotiposalon IN ('.$OtherAulas.')';  
            }break;
            default:{
                 $condicion = '  c.codigotiposalon IN ('.$TipoSalon.')';
            }break;
        }
      $SQL='SELECT
                ClasificacionEspaciosId
            FROM
                ClasificacionEspacios c            
            WHERE
            
                c.ClasificacionEspaciosId="'.$Espacio.'"
                AND
                c.codigoestado=100
                AND
                '.$condicion; 
                
       if($ValidacionTipoSalon=&$db->Execute($SQL)===false){
         echo 'Error del Sistema ...<br><br>';
         die;
       }    
       
       if(!$ValidacionTipoSalon->EOF){
         return true;
       }else{
        return false;
       }     
  }// public function ValidaTipoSalonFinal
  public function ValidaFechaQuemada($fecha){
    $FechaQuemada[]='2016-03-21';
    $FechaQuemada[]='2016-03-22';
    $FechaQuemada[]='2016-03-23';
    $FechaQuemada[]='2016-03-24';
    $FechaQuemada[]='2016-03-25';
    $FechaQuemada[]='2016-10-03';
    $FechaQuemada[]='2016-10-04';
    $FechaQuemada[]='2016-10-05';
    $FechaQuemada[]='2016-10-06';
    $FechaQuemada[]='2016-10-07';
    
    $Fecha_1 = explode('-',$fecha);
    $Fecha_1[0];//año
    $Fecha_1[1];//mes
    $Fecha_1[2];//día
    for($i=0;$i<count($FechaQuemada);$i++){
        $Fecha_2 = explode('-',$FechaQuemada[$i]);
        
        if($Fecha_1[0]==$Fecha_2[0]){//valida año
            if($Fecha_1[1]==$Fecha_2[1]){//valida mes
                if($Fecha_1[2]==$Fecha_2[2]){//valida día
                    return true;
                }
            }
        }
    }
    return false;
  }//public function ValidaFechaQuemada
}//class

?>
