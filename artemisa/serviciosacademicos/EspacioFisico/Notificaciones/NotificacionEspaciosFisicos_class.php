<?php
class NotificacionEspaciosFisicos{
    public function EnviarCorreo($to, $asunto, $mensaje, $reportSend = false){
        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        

        // Cabeceras adicionales
        //$cabeceras .= 'To: ' .$to. "\r\n";
        $cabeceras .= 'From: Universidad El Bosque<NotificacionHoraio@unbosque.edu.co>' . "\r\n";
        //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
        
          // Enviamos el mensaje
          if (mail($to, $asunto, $mensaje, $cabeceras)) {
                $aviso = "Su mensaje fue enviado.";
                $succed = true;
          } else {
                $aviso = "Error de envío.";
                $succed = false;
          }
          if($reportSend){
            return array("mensaje" =>$aviso, "succes"=>$succed); 
          } else {
            return $aviso;
          }
    }//public function EnviarCorreo
   public function Alumnos($db,$id){
        $Periodo = $this->Periodo($db);
        
           $SQL='SELECT
                        ee.numerodocumento,
                        ee.nombresestudiantegeneral,
                        ee.apellidosestudiantegeneral,
                        ee.emailestudiantegeneral,
                        c.nombrecarrera,
                        e.codigoestudiante,
                        CONCAT(
                        u.usuario,
                        "@unbosque.edu.co"
                        ) AS Correo,
                        CONCAT(
                        ee.nombresestudiantegeneral,
                        ee.apellidosestudiantegeneral
                        ) AS NAME,
                        u.usuario
                FROM
                        estudiante e
                        INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera
                        INNER JOIN prematricula p ON p.codigoestudiante = e.codigoestudiante
                        INNER JOIN estudiantegeneral ee ON ee.idestudiantegeneral=e.idestudiantegeneral
                        INNER JOIN usuario u ON u.numerodocumento=ee.numerodocumento
                WHERE
                        c.codigomodalidadacademica = 200
                        AND p.codigoperiodo = "'.$Periodo.'"
                        AND p.codigoestadoprematricula like "4%"
                        AND u.codigotipousuario=600
                
                ORDER BY
                	c.nombrecarrera';
                
                if($EstudiantesCorreo=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL Estudiante Correo....<br><br>'.$SQL;
                    die;
                }
                
                $Data = $EstudiantesCorreo->GetArray();
                
                return $Data;
    }//public function Alumnos
    public function Docente($db,$id){
         $Periodo = $this->Periodo($db);
          $SQL='SELECT
                	d.numerodocumento,
                	d.emaildocente,
                    u.usuario,
                    CONCAT(u.usuario,"@unbosque.edu.co") AS Correo
                 
                FROM
                	docente d
                INNER JOIN grupo g ON g.numerodocumento=d.numerodocumento
                LEFT  JOIN usuario u ON u.numerodocumento=d.numerodocumento AND u.codigotipousuario LIKE "5%"
                
                WHERE
                
                g.codigoperiodo="'.$Periodo.'"
                AND 
                d.numerodocumento <> 1 
                AND
                d.numerodocumento <> " "
                
                GROUP BY d.numerodocumento';
                
                if($CorreoDocente=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Correo Docente....<br><br>'.$SQL;
                    die;
                }
                
              $Data = $CorreoDocente->GetArray();
              return $Data;  
    }//public function Docente
    public function HorarioEstudiante($db,$EstudiateCodigo,$Fecha_1,$Fecha_2){
        //echo '<pre>';print_r($db);die;
        $Periodo = $this->Periodo($db);
        
        $SQL='SELECT
 
                    p.idprematricula,
                    d.idgrupo,
                    x.codigodia,
                    x.nombredia,
                    m.nombremateria,
                    CONCAT (d.idgrupo," :: ",m.nombremateria) AS info,
                    sg.SolicitudAsignacionEspacioId,
                    c.Nombre AS Nombre,
                    a.FechaAsignacion,
                    a.HoraInicio  AS  HoraInicio,
                    a.HoraFin AS HoraFin,
                    c.ClasificacionEspaciosId,
                    k.Color,
                    m.codigocarrera
		 
                FROM
                        prematricula p INNER JOIN detalleprematricula d ON d.idprematricula=p.idprematricula
                        INNER JOIN horario h ON h.idgrupo=d.idgrupo
                        INNER JOIN dia x ON x.codigodia=h.codigodia
                        INNER JOIN grupo g ON g.idgrupo=d.idgrupo
                        INNER JOIN materia m ON m.codigomateria=g.codigomateria		
                        INNER JOIN SolicitudEspacioGrupos sg ON sg.idgrupo=g.idgrupo
                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                        INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId		
                        INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                        LEFT JOIN CarreraColor k ON k.CodigoCarrera=m.codigocarrera
		 
		      WHERE
                		p.codigoestudiante="'.$EstudiateCodigo.'"
                		AND
                		d.codigoestadodetalleprematricula=30
                		AND
                		sg.codigoestado=100 
                		AND
                		a.codigoestado=100 		
                		AND
                		a.FechaAsignacion BETWEEN "'.$Fecha_1.'" AND "'.$Fecha_2.'"
                		AND
                		s.codigodia=h.codigodia 
                		AND
                		p.codigoperiodo="'.$Periodo.'"
                		AND 
                		s.codigoestado=100 
		 
    		GROUP BY
    		x.codigodia,m.codigomateria,d.idgrupo,HoraInicio,HoraFin,a.FechaAsignacion
		
            UNION
            
            SELECT
             
            		p.idprematricula,
            		d.idgrupo,
            		x.codigodia,
            		x.nombredia,
            		m.nombremateria,
            		CONCAT (d.idgrupo," :: ",m.nombremateria) AS info,
            		"" AS SolicitudAsignacionEspacioId,
            		"Falta Por Asignar" AS Nombre,
            		"" AS FechaAsignacion,
            		h.horainicial AS  HoraInicio,
            		h.horafinal AS HoraFin,
            		"" AS ClasificacionEspaciosId,
            		k.Color,
                    m.codigocarrera
            		 
           	FROM
            		prematricula p INNER JOIN detalleprematricula d ON d.idprematricula=p.idprematricula
            		INNER JOIN horario h ON h.idgrupo=d.idgrupo
            		INNER JOIN dia x ON x.codigodia=h.codigodia
            		INNER JOIN grupo g ON g.idgrupo=d.idgrupo
            		INNER JOIN materia m ON m.codigomateria=g.codigomateria
            		INNER JOIN CarreraColor k ON k.CodigoCarrera=m.codigocarrera
            		
            		 
            WHERE
                    p.codigoestudiante="'.$EstudiateCodigo.'"
                    AND
                    d.codigoestadodetalleprematricula=30
                    AND
                    p.codigoperiodo="'.$Periodo.'"
                    AND d.idgrupo NOT IN(SELECT  sg.idgrupo
                                         
                                         FROM
                                         SolicitudEspacioGrupos sg
                                         INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                                         
                                         WHERE
                                        
                                            sg.codigoestado = 100
                                            AND a.codigoestado = 100
                                            AND a.FechaAsignacion BETWEEN "'.$Fecha_1.'" AND "'.$Fecha_2.'")
            			
            		GROUP BY
            		x.codigodia,m.codigomateria,d.idgrupo,HoraInicio,HoraFin
            		 
            		ORDER BY codigodia , HoraInicio ,HoraFin';
                
                if($HorarioEstudiante=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Horario Estudiante....<br><br>'.$SQL;
                    die;
                }
                
                $DataHorario = array();
                
                while(!$HorarioEstudiante->EOF){ 
                    /*********************************************************************************/
                    $Dia = $HorarioEstudiante->fields['codigodia'];
                    $idGrupo = $HorarioEstudiante->fields['idgrupo'];
                    $idSolicitud = $HorarioEstudiante->fields['SolicitudAsignacionEspacioId'];
                    $Fecha  = $HorarioEstudiante->fields['FechaAsignacion'];     
                    $Hora_1  = $HorarioEstudiante->fields['HoraInicio'];
                    $Hora_2  = $HorarioEstudiante->fields['HoraFin'];
                    $Espacio_id  = $HorarioEstudiante->fields['ClasificacionEspaciosId'];
                    $Nombre  = $HorarioEstudiante->fields['Nombre'];
                    $info  = $HorarioEstudiante->fields['info'];
                    $Carrera  = $HorarioEstudiante->fields['codigocarrera'];
                    $color  = $HorarioEstudiante->fields['Color'];
                    
                    $DataHorario[$Dia]['idGrupo'][] = $idGrupo;
                    $DataHorario[$Dia]['Solicitud_id'][] = $idSolicitud;
                    $DataHorario[$Dia]['Fecha'][] = $Fecha;
                    $DataHorario[$Dia]['hora_1'][] = $Hora_1;
                    $DataHorario[$Dia]['hora_2'][] = $Hora_2;
                    $DataHorario[$Dia]['Espacio_id'][] = $Espacio_id;
                    $DataHorario[$Dia]['Nombre'][] = $Nombre;
                    $DataHorario[$Dia]['Info'][] = $info;
                    $DataHorario[$Dia]['Carrera'][] = $Carrera;
                    $DataHorario[$Dia]['Kolor'][] = $color;
                    /*********************************************************************************/
                    $HorarioEstudiante->MoveNext();
                }//while
               // echo '<pre>';print_r($DataHorario);die;
           return $DataHorario;
    }//public function HorarioEstudiante
    public function HorarioDocente($db,$Docente,$Fecha_1,$Fecha_2){
        
        $SQL='SELECT
            	p.idprematricula,
            	d.idgrupo,
            	sg.SolicitudAsignacionEspacioId,
            	s.codigodia,
            	x.nombredia,
            	a.FechaAsignacion,
            	a.HoraInicio,
            	a.HoraFin,
            	a.ClasificacionEspaciosId,
            	c.Nombre,
            	CONCAT(
            		m.codigomateria,
            		" :: ",
            		m.nombremateria
            	) AS info,
            	m.codigocarrera,
            	k.Color
            FROM
            	prematricula p
            INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula
            INNER JOIN SolicitudEspacioGrupos sg ON sg.idgrupo = d.idgrupo
            INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
            INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
            INNER JOIN dia x ON x.codigodia = s.codigodia
            INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
            INNER JOIN grupo g ON g.idgrupo = sg.idgrupo
            INNER JOIN materia m ON m.codigomateria = g.codigomateria
            INNER JOIN CarreraColor k ON k.CodigoCarrera = m.codigocarrera
            
            
            
            WHERE
            g.numerodocumento="'.$Docente.'"
            AND sg.codigoestado = 100
            AND a.FechaAsignacion BETWEEN "'.$Fecha_1.'" AND "'.$Fecha_2.'"
            AND s.codigoestado = 100
            AND a.codigoestado = 100
            
            
            GROUP BY s.SolicitudAsignacionEspacioId
            
            ORDER BY
            	a.FechaAsignacion,
            	a.HoraInicio';
                
            if($DocenteHorario=&$db->Execute($SQL)===false){
                echo 'Error en el SQL Docentes Horario...<br><br>'.$SQL;
                die;
            }   
            
            $DataHorario = array();
                while(!$DocenteHorario->EOF){
                    /*********************************************************************************/
                    $Dia = $DocenteHorario->fields['codigodia'];
                    $idGrupo = $DocenteHorario->fields['idgrupo'];
                    $idSolicitud = $DocenteHorario->fields['SolicitudAsignacionEspacioId'];
                    $Fecha  = $DocenteHorario->fields['FechaAsignacion'];     
                    $Hora_1  = $DocenteHorario->fields['HoraInicio'];
                    $Hora_2  = $DocenteHorario->fields['HoraFin'];
                    $Espacio_id  = $DocenteHorario->fields['ClasificacionEspaciosId'];
                    $Nombre  = $DocenteHorario->fields['Nombre'];
                    $info  = $DocenteHorario->fields['info'];
                    $Carrera  = $DocenteHorario->fields['codigocarrera'];
                    $color  = $DocenteHorario->fields['Color'];
                    
                    $DataHorario[$Dia]['idGrupo'][] = $idGrupo;
                    $DataHorario[$Dia]['Solicitud_id'][] = $idSolicitud;
                    $DataHorario[$Dia]['Fecha'][] = $Fecha;
                    $DataHorario[$Dia]['hora_1'][] = $Hora_1;
                    $DataHorario[$Dia]['hora_2'][] = $Hora_2;
                    $DataHorario[$Dia]['Espacio_id'][] = $Espacio_id;
                    $DataHorario[$Dia]['Nombre'][] = $Nombre;
                    $DataHorario[$Dia]['Info'][] = $info;
                    $DataHorario[$Dia]['Carrera'][] = $Carrera;
                    $DataHorario[$Dia]['Kolor'][] = $color;
                    /*********************************************************************************/
                    $DocenteHorario->MoveNext();
                }//while
                
           return $DataHorario; 
    }//public function ForarioDocente
    public function Solicitudes($db){
        include_once('../Interfas/InterfazSolicitud_class.php'); $C_InterfazSolicitud = new InterfazSolicitud();
        
        $Fechas = $C_InterfazSolicitud->FechasPeriodo($db);
        
        if($Fechas['val']==true){
           
             $CondicionFecha = ' AND (s.FechaInicio>="'.$Fechas['FechaIni'].'" )';//AND s.FechaFinal<="'.$Fechas['FechaFin'].'"  OR  s.FechaInicio>="'.$Fechaini_2.'" AND s.FechaFinal<="'.$Fechafin_2.'"
             //$CondicionFecha = '';
        }else{
            $CondicionFecha = '';
        }
        $SQL='SELECT

                s.SolicitudAsignacionEspacioId AS id
                
                FROM
                
                SolicitudAsignacionEspacios s 
                
                WHERE
                
                s.codigoestado=100
                AND
                s.codigomodalidadacademica=001
                '.$CondicionFecha;
                
         if($Solicitudes=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de las Notificaciones Id Solicitud...'.$SQL;
            die;
         }  
         
         while(!$Solicitudes->EOF){
            /*******************************************************************/
            $C_Solicitudes[] = $Solicitudes->fields['id'];
            /*******************************************************************/
            $Solicitudes->MoveNext();
         }     
         
         return $C_Solicitudes;
    }//public function Solicitudes
    public function AlumnosSolicitudCambio($db,$id){
       
         $SQL='SELECT
                	p.codigoestudiante,
                    CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) AS FulName,
                    CONCAT(u.usuario,"@unbosque.edu.co") AS Correo,
                    TIME(a.FechaultimaModificacion) AS Tiempo
                FROM
                	AsignacionEspacios a
                        LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                        LEFT JOIN grupo g ON g.idgrupo=sg.idgrupo
                        LEFT JOIN detalleprematricula d ON d.idgrupo=g.idgrupo
                        LEFT JOIN prematricula p ON p.idprematricula=d.idprematricula
                        LEFT JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante
                        LEFT JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                        LEFT JOIN usuario u ON u.numerodocumento=eg.numerodocumento
                WHERE
                	a.SolicitudAsignacionEspacioId = "'.$id.'"
                    AND a.Modificado = 1
                    AND (sg.codigoestado=100 OR sg.codigoestado IS NULL)
                    AND d.codigoestadodetalleprematricula=30
                    AND a.Enviado=0
                    AND DATE(a.FechaultimaModificacion)=CURDATE()
                    
                    GROUP BY p.codigoestudiante'; 
                    
              if($Data=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Correos Cambios Solicitud...<br><br>'.$SQL;
                    die;
              }      
              
              $C_Data = $Data->GetArray();
              
              Return $C_Data;
    }//public function AlumnosSolicitudCambio
    public function InformacionCambioEstudiante($db,$id,$CodigoEstudiante,$Opcion='',$Op=''){
        
        
        if($Opcion==1){
            $Data = 'IF(a.codigoestado=100,"Clase Activa","Clase Cancelada") AS Tittle';
        }else if($Opcion==2){
            $Data = 'IF(a.EstadoAsignacionEspacio=1,"Clase en Aula","Nueva Observacion") AS Tittle';
        }else{
            $Data = 'IF(a.FechaAsignacion=a.FechaAsignacionAntigua,"Se ha Modificado","Se ha Cambiado la Fecha") AS Tittle';
        }
        
        if($Op==1){
            $Condicion = '';
        }else{
            $Condicion = '  AND  (a.FechaAsignacionAntigua=CURDATE() OR a.FechaAsignacion=CURDATE())';
        }
        
         $SQL='SELECT
                        a.AsignacionEspaciosId,
                        a.FechaAsignacion,
                        a.FechaAsignacionAntigua,
                        a.codigoestado,
                        a.HoraInicio,
                        a.HoraFin,
                        g.idgrupo,
                        g.nombregrupo,
                        m.nombremateria,                        
                        a.ClasificacionEspaciosId,
                        c.Nombre,
                        a.Observaciones,'.$Data.',
                        TIME(a.FechaultimaModificacion) AS Tiempo
                        
                FROM
                        AsignacionEspacios a
                        INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                        LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                        LEFT JOIN grupo g ON g.idgrupo=sg.idgrupo
                        LEFT JOIN detalleprematricula d ON d.idgrupo=g.idgrupo
                        LEFT JOIN prematricula p ON p.idprematricula=d.idprematricula
                        LEFT JOIN materia m ON m.codigomateria=g.codigomateria
                
                WHERE
                
                        a.Modificado=1
                        AND
                        a.SolicitudAsignacionEspacioId="'.$id.'"
                        AND
                        DATE(a.FechaultimaModificacion)=CURDATE()
                        '.$Condicion.'
                        AND
                        (sg.codigoestado=100 OR sg.codigoestado IS NULL)
                        AND
                        p.codigoestudiante="'.$CodigoEstudiante.'"
                        AND
                        a.Enviado=0';
                        
              if($Info=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Correos Cambios Solicitud...<br><br>'.$SQL;
                    die;
              }      
              
              $C_Info = $Info->GetArray();
              
              Return $C_Info;       
    }//public function InformacionCambioEstudiante
    public function InfoAlumnosCambios($db,$CodigoEstudiante){
        
        $Periodo = $this->Periodo($db);
        
          $SQL='SELECT
 
                p.idprematricula,
                d.idgrupo,
                x.codigodia,
                x.nombredia,
                m.nombremateria,
                CONCAT (d.idgrupo," :: ",m.nombremateria) AS info,
                sg.SolicitudAsignacionEspacioId,
                IF(c.Nombre IS NULL,"Falta Por Asignar",c.Nombre) AS Nombre,
                a.FechaAsignacion,
                if(a.HoraInicio IS NULL,h.horainicial,a.HoraInicio) AS  HoraInicio,
                IF(a.HoraFin IS NULL, h.horafinal,a.HoraFin) AS HoraFin,
                c.ClasificacionEspaciosId,
                k.Color,
                a.Modificado,
                a.Observaciones,
                a.codigoestado,
                a.EstadoAsignacionEspacio,
                if(a.codigoestado=100,"Activa","Clase Cancelada") AS Texto_1,
                if(a.EstadoAsignacionEspacio=1,"Se ha Modificado","Otra Actividad") AS Texto_2 
                
                FROM
                prematricula p INNER JOIN detalleprematricula d ON d.idprematricula=p.idprematricula
                INNER JOIN horario h ON h.idgrupo=d.idgrupo
                INNER JOIN dia x ON x.codigodia=h.codigodia
                INNER JOIN grupo g ON g.idgrupo=d.idgrupo
                INNER JOIN materia m ON m.codigomateria=g.codigomateria
                LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo=d.idgrupo
                LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                LEFT JOIN CarreraColor k ON k.CodigoCarrera=m.codigocarrera
                
                
                WHERE
                p.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                d.codigoestadodetalleprematricula=30
                AND
                (sg.codigoestado=100 OR sg.codigoestado IS NULL)
                AND
                p.codigoperiodo
                AND
                (s.codigodia=h.codigodia OR s.codigodia IS NULL)
                AND
                p.codigoperiodo="'.$Periodo.'"
                AND
                s.codigoestado=100
                AND
                a.Modificado=1
                AND
                a.Enviado=0
                
                GROUP BY x.codigodia,m.codigomateria,d.idgrupo,HoraInicio,HoraFin,a.FechaAsignacion
                
                ORDER BY a.codigoestado DESC, a.FechaAsignacion, a.HoraInicio ,a.HoraFin ';
                
                if($Info=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL Infomarcion Alumno CAmbios Solicitud....<br><br>'.$SQL;
                    die;
                }
           
           $Resultado = array();     
           $i=0;     
           while(!$Info->EOF){
            /********************************************************/
                $Resultado[$i]['idprematricula']               = $Info->fields['idprematricula'];
                $Resultado[$i]['idgrupo']                      = $Info->fields['idgrupo'];
                $Resultado[$i]['codigodia']                    = $Info->fields['codigodia'];
                $Resultado[$i]['nombredia']                    = $Info->fields['nombredia'];
                $Resultado[$i]['nombremateria']                = $Info->fields['nombremateria'];
                $Resultado[$i]['info']                         = $Info->fields['info'];
                $Resultado[$i]['SolicitudAsignacionEspacioId'] = $Info->fields['SolicitudAsignacionEspacioId'];
                $Resultado[$i]['Nombre']                       = $Info->fields['Nombre'];
                $Resultado[$i]['FechaAsignacion']              = $Info->fields['FechaAsignacion'];
                $Resultado[$i]['HoraInicio']                   = $Info->fields['HoraInicio'];
                $Resultado[$i]['HoraFin']                      = $Info->fields['HoraFin'];
                $Resultado[$i]['ClasificacionEspaciosId']      = $Info->fields['ClasificacionEspaciosId'];
                $Resultado[$i]['Color']                        = $Info->fields['Color'];
                $Resultado[$i]['Modificado']                   = $Info->fields['Modificado'];
                $Resultado[$i]['Observaciones']                = $Info->fields['Observaciones'];
                $Resultado[$i]['codigoestado']                 = $Info->fields['codigoestado'];
                $Resultado[$i]['EstadoAsignacionEspacio']      = $Info->fields['EstadoAsignacionEspacio'];
                $Resultado[$i]['Texto_1']                      = $Info->fields['Texto_1'];
                $Resultado[$i]['Texto_2']                      = $Info->fields['Texto_2'];                              
            /********************************************************/
            $i++;
            $Info->MoveNext();
           }//while     
           
           //echo '<pre>';print_r($Resultado);
           return $Resultado; 
    }//public function InfoAlumnosCambios
    public function InfoManualCambios($db,$id,$CodigoEstudiante){
        $SQL='SELECT
                a.AsignacionEspaciosId,
                a.FechaAsignacion,
                a.FechaAsignacionAntigua,
                a.codigoestado,
                a.HoraInicio,
                a.HoraFin,
                g.idgrupo,
                g.nombregrupo,
                m.nombremateria,                        
                a.ClasificacionEspaciosId,
                c.Nombre,
                a.Observaciones,
                a.EstadoAsignacionEspacio,
                IF(a.codigoestado=100,"Clase Activa","Clase Cancelada") AS Tittle,
                IF(a.EstadoAsignacionEspacio=1,"Clase en Aula","Nueva Observacion") AS Tittle2,
                IF(a.FechaAsignacion=a.FechaAsignacionAntigua,"Se ha Modificado","Se ha Cambiado la Fecha") AS Tittle3
                
                
             FROM
                AsignacionEspacios a
                INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                LEFT JOIN grupo g ON g.idgrupo=sg.idgrupo
                LEFT JOIN detalleprematricula d ON d.idgrupo=g.idgrupo
                LEFT JOIN prematricula p ON p.idprematricula=d.idprematricula
                LEFT JOIN materia m ON m.codigomateria=g.codigomateria
                
             WHERE
                
                a.Modificado=1
                AND
                a.SolicitudAsignacionEspacioId="'.$id.'"
                AND
                DATE(a.FechaultimaModificacion)=CURDATE()
                AND
                (sg.codigoestado=100 OR sg.codigoestado IS NULL)
                AND
                p.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                a.Enviado=0';
                
           if($Info=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de La informacion <br><br>'.$SQL;
                die;
           }  
           
           $Resultado = array();     
           $i=0;     
           while(!$Info->EOF){
            /********************************************************/
                $Resultado[$i]['AsignacionEspaciosId']               = $Info->fields['AsignacionEspaciosId'];
                $Resultado[$i]['FechaAsignacion']                      = $Info->fields['FechaAsignacion'];
                $Resultado[$i]['FechaAsignacionAntigua']                    = $Info->fields['FechaAsignacionAntigua'];
                $Resultado[$i]['codigoestado']                    = $Info->fields['codigoestado'];
                $Resultado[$i]['HoraInicio']                = $Info->fields['HoraInicio'];
                $Resultado[$i]['HoraFin']                         = $Info->fields['HoraFin'];
                $Resultado[$i]['idgrupo'] = $Info->fields['idgrupo'];
                $Resultado[$i]['nombregrupo']                       = $Info->fields['nombregrupo'];
                $Resultado[$i]['nombremateria']              = $Info->fields['nombremateria'];
                $Resultado[$i]['ClasificacionEspaciosId']                   = $Info->fields['ClasificacionEspaciosId'];
                $Resultado[$i]['Nombre']                      = $Info->fields['Nombre'];
                $Resultado[$i]['Observaciones']      = $Info->fields['Observaciones'];
                $Resultado[$i]['EstadoAsignacionEspacio']                        = $Info->fields['EstadoAsignacionEspacio'];
                $Resultado[$i]['Tittle']                        = $Info->fields['Tittle'];
                $Resultado[$i]['Tittle2']                   = $Info->fields['Tittle2'];
                $Resultado[$i]['Tittle3']                = $Info->fields['Tittle3'];                                       
            /********************************************************/
            $i++;
            $Info->MoveNext();
           }//while   
           
           return $Resultado;     
    }//public function InfoManualCambios
    public function CambiarAEnviado($db,$id,$Asignacion=''){
        if($Asignacion){
            for($i=0;$i<count($Asignacion[$id]);$i++){
                $Update='UPDATE AsignacionEspacios
                         SET    Enviado=1,
                                FechaultimaModificacion=NOW()
                         WHERE  SolicitudAsignacionEspacioId="'.$id.'" AND Modificado=1 AND DATE(FechaultimaModificacion)<=CURDATE() AND AsignacionEspaciosId="'.$Asignacion[$id][$i].'" AND  FechaAsignacion=CURDATE()';
                     
                if($Enviado=&$db->Execute($Update)===false){
                    echo 'Error al Cambiar estado a Enviado...'.$Update;
                    die;    
                }  
            }
        }else{
            $Update='UPDATE AsignacionEspacios
                     SET    Enviado=1,
                            FechaultimaModificacion=NOW()
                     WHERE  SolicitudAsignacionEspacioId="'.$id.'" AND Modificado=1 AND DATE(FechaultimaModificacion)<=CURDATE()';
                 
            if($Enviado=&$db->Execute($Update)===false){
                echo 'Error al Cambiar estado a Enviado...'.$Update;
                die;
            }  
        }
        
               
    }//public function CambiarAEnviado
    public function Periodo($db){
          $SQL='SELECT
                codigoperiodo
                FROM
                periodo
                WHERE
                codigoestadoperiodo=1';
           
          if($Periodo=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Periodo.....<br><br>'.$SQL;
            die;
          }      
          
          return $Periodo->fields['codigoperiodo'];
    }//public function Periodo
    public function LogNotificacion($db,$codigoestudiante,$userid,$tipo,$estado){
        
        $SQL='INSERT INTO LogNotificacionEspacioFisico(CodigoEstudiante,TipoNotificacion,FechaNotificacion,EstadoNotificacion,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$codigoestudiante.'","'.$tipo.'",NOW(),"'.$estado.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
        
        if($IsertLog=&$db->Execute($SQL)===false){
            echo '<br><br>Error del Sistema en los Log';
            return false;            
        }
        
        return true;
    }//public function LogNotificacion
}//class

?>