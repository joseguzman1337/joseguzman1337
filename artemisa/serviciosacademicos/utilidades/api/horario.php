<?PHP
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usuario     = $_POST["idusuario"];
    $token       = $_POST["token"];
    $fechainicio = $_POST["fechainicio"];
    $fechafin    = $_POST["fechafin"];
    $carrera     = $_POST["carrera"];
    $idrol       = $_POST["idrol"];
    switch ($_POST["action"]){
        case 'horario_usuario':{
                include_once 'funcionesValidacion.php';
            	if(validarToken($usuario,$token)){
					$json = Horario($usuario,$fechainicio,$fechafin,$carrera,$idrol); 
				} else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
        }break;
        case 'horario_modificar':{
                include_once 'funcionesValidacion.php';
            	if(validarToken($usuario,$token)){
                include(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include(realpath(dirname(__FILE__)).'/../../EspacioFisico/Interfas/Cancelar_liberar_EspacioFisico_class.php'); 
                
                $C_Cancelar_liberar  = new Cancelar_liberar($db,$usuario);
            
					if($_POST['tipoaccion']==1){
					    /*Cancelar Clase*/
                        $variables   = array();
                        
                        $Observacion  = $_POST['observacion'];
                        $idasignacion = $_POST['idasignacion'];
                        
                        $variables[]  = "$Observacion";
                        $variables[]  = "$usuario";
                        $variables[]  = "$idasignacion";
                        
                        $EliminarLog = $C_Cancelar_liberar->Eliminar($variables);
                        
                        if($EliminarLog===false){
                            $json["result"]          ="ERROR";
                            $json["codigoresultado"] =1;
                            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                            echo json_encode($json);
                            exit;
                        }else{
                            $json["result"]          ="OK";
                            $json["codigoresultado"] =0;
                            $json["mensaje"]         ="Se ha Cancelado la Clase.";
                            $titulo                  = "Clase Cancelada...";
                        }
                        
					}else if($_POST['tipoaccion']==2){
					    /*Liberar Espacio*/
                        $variables   = array();
                        
                        $Observacion  = $_POST['observacion'];
                        $idasignacion = $_POST['idasignacion'];
                        
                        $variables[]  = "$Observacion";
                        $variables[]  = "$usuario";
                        $variables[]  = "0";
                        $variables[]  = "$idasignacion";
                        
                        $liberarLog = $C_Cancelar_liberar->Liberar($variables);
                        
                        if($liberarLog===false){
                            $json["result"]          ="ERROR";
                            $json["codigoresultado"] =1;
                            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                            echo json_encode($json);
                            exit;
                        }else{
                            $json["result"]          ="OK";
                            $json["codigoresultado"] =0;
                            $json["mensaje"]         ="Se ha Liberado el espacio físico.";
                            $titulo                  = "Clase Modificada...";
                        }
					}
            
                    $SQL_ID = 'SELECT
                                    SolicitudAsignacionEspacioId
                               FROM
                                    AsignacionEspacios
                               WHERE
                                    AsignacionEspaciosId = ?';  
            
                    $variables   = array();
            
                    $variables[] = "$idasignacion";

                    $Solicitud = $db->Execute($SQL_ID,$variables);                           
                    if($Solicitud===false){
                        $json["result"]          ="ERROR";
                        $json["codigoresultado"] =1;
                        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                        echo json_encode($json);
                        exit;
                    }
            
                    $ID_Solicitud = $Solicitud->fields['SolicitudAsignacionEspacioId'];  
                    
                   // $C_Cancelar_liberar->NotificarCambiosData($solicitud,$titulo,$Observacion);--->OJO TOCA HACER ESTO POR PAQUETES NO MAYOR 50
				} else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
        }break;    
    }
}    

echo json_encode($json);

function Horario($idUsuario,$fecha_1,$fecha_2,$carrera,$idrol){
    include(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
    $SQL_U='SELECT
            	numerodocumento,
            	codigorol,
            	codigotipousuario
            FROM
            	usuario
            WHERE
            	idusuario = "'.$idUsuario.'" AND codigorol="'.$idrol.'"';
    
    if($DataUser=&$db->GetAll($SQL_U)===false){
        $json["result"]   ="ERROR";
        $json["codigoresultado"] =1;
        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
        echo json_encode($json);
        exit;
    }
    
    $ValidaModalidadData = false;
    
    if($DataUser[0]['codigorol']==1){
        $tabla = 'eg';
        $Condicion = 'AND e.codigocarrera="'.$carrera.'"';
        
        $SQL='SELECT 
              e.codigoestudiante
              FROM
              estudiantegeneral ee 
              INNER JOIN estudiante e ON e.idestudiantegeneral=ee.idestudiantegeneral
              INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
              WHERE
              ee.numerodocumento="'.$DataUser[0]['numerodocumento'].'"
              AND
              c.codigomodalidadacademica=300';

          if($ValidaModalidad=&$db->Execute($SQL)===false){
            echo 'Error en el Sistema .....';
            die;
          } 

          if(!$ValidaModalidad->EOF){
            $ValidaModalidadData = true;
          } else{
            $ValidaModalidadData = false;
          }
        
    }else if($DataUser[0]['codigorol']==2){
        $tabla = 'g';
        $Condicion = ' AND m.codigocarrera="'.$carrera.'"';
    }else{
        $json["result"]   ="ERROR";
        $json["codigoresultado"] =1;
        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
        echo json_encode($json);
        exit; 
    }
    
       $SQL='SELECT 
                
                codigoperiodo AS id,
                codigoperiodo
                
                FROM periodo
                
                WHERE
                
                codigoestadoperiodo IN(1)';
                
            if($Periodos=&$db->Execute($SQL)===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            }  
            
      $Periodo = $Periodos->fields['id'];       
    
    if($ValidaModalidadData==false){
    
           $SQL='SELECT
                        p.idprematricula,
                        d.idgrupo,
                        x.codigodia,
                        x.nombredia,
                        m.nombremateria,
                        g.nombregrupo,
                        sg.SolicitudAsignacionEspacioId,
                        IF (c.Nombre IS NULL,"Falta Por Asignar",c.Nombre) AS Nombre,
                        a.FechaAsignacion,
                        IF (a.HoraInicio IS NULL,	h.horainicial,	a.HoraInicio) AS HoraInicio,
                        IF (a.HoraFin IS NULL,h.horafinal,a.HoraFin) AS HoraFin,
                        cc.Nombre AS Bloke,
                        ccc.Nombre AS Campus,
                        g.numerodocumento AS numDocente,
                        m.nombremateria,
                        CONCAT(dc.nombredocente," ",dc.apellidodocente) AS DocenteName,
                        p.idprematricula,
                        p.codigoestudiante,
                        CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) AS NameEstudiante,
                        eg.numerodocumento,
                        a.AsignacionEspaciosId
                FROM
                        prematricula p
                        INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula
                        INNER JOIN horario h ON h.idgrupo = d.idgrupo
                        INNER JOIN dia x ON x.codigodia = h.codigodia
                        INNER JOIN grupo g ON g.idgrupo = d.idgrupo
                        INNER JOIN materia m ON m.codigomateria = g.codigomateria
                        INNER JOIN estudiante e ON e.codigoestudiante = p.codigoestudiante
                        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
                        INNER JOIN docente dc ON dc.numerodocumento = g.numerodocumento
                        LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo = d.idgrupo
                        LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                        LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                        LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
                        LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
                        LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
                WHERE
                        '.$tabla.'.numerodocumento = "'.$DataUser[0]['numerodocumento'].'"
                        '.$Condicion.'
                        AND (	a.EstadoAsignacionEspacio = 1	OR a.EstadoAsignacionEspacio IS NULL)
                        AND d.codigoestadodetalleprematricula = 30
                        AND p.codigoestadoprematricula IN (40, 41)
                        AND p.codigoperiodo = "'.$Periodo.'"
                        AND (	sg.codigoestado = 100	OR sg.codigoestado IS NULL)
                        AND (	a.codigoestado = 100	OR a.codigoestado IS NULL)
                        AND (	a.FechaAsignacion BETWEEN "'.$fecha_1.'"	AND "'.$fecha_2.'"	OR a.FechaAsignacion IS NULL)
                        AND (	s.codigodia = h.codigodia	OR s.codigodia IS NULL)
                        AND s.codigoestado = 100
                GROUP BY
                    	x.codigodia,
                    	m.codigomateria,
                    	d.idgrupo,
                    	HoraInicio,
                    	HoraFin,
                    	a.FechaAsignacion
                ORDER BY
                    	x.codigodia,
                    	a.FechaAsignacion,
                    	a.HoraInicio,
                    	a.HoraFin';
        
        
    }else{
           $SQL='SELECT
                    p.idprematricula,
                    g.idgrupo,
                    x.codigodia,
                    x.nombredia,
                    m.nombremateria,
                    g.nombregrupo,
                    sg.SolicitudAsignacionEspacioId,

                IF (
                    c.Nombre IS NULL,
                    "Falta Por Asignar",
                    c.Nombre
                ) AS Nombre,
                 a.FechaAsignacion,


                    a.HoraInicio,
                    a.HoraFin,

                 cc.Nombre AS Bloke,
                 ccc.Nombre AS Campus,
                 g.numerodocumento AS numDocente,
                 m.nombremateria,

                 p.idprematricula,
                 p.codigoestudiante,
                 CONCAT(
                    ee.nombresestudiantegeneral,
                    " ",
                    ee.apellidosestudiantegeneral
                ) AS NameEstudiante,
                 ee.numerodocumento,
                 if(g.numerodocumento=1," "," ") AS DocenteName,
                 a.AsignacionEspaciosId
                 
                FROM
                estudiantegeneral ee 
                INNER JOIN estudiante e ON e.idestudiantegeneral=ee.idestudiantegeneral
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula
                INNER JOIN grupo g ON g.idgrupo=dp.idgrupo
                INNER JOIN materia m ON m.codigomateria=g.codigomateria
                LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo=dp.idgrupo
                LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId AND s.codigoestado = 100
                LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                LEFT JOIN AsociacionSolicitud aso ON aso.SolicitudAsignacionEspaciosId=s.SolicitudAsignacionEspacioId
                LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=a.ClasificacionEspaciosId
                LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
                LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
                LEFT JOIN dia x ON x.codigodia=s.codigodia 

                WHERE

                ee.numerodocumento="'.$DataUser[0]['numerodocumento'].'" 
                AND
                p.codigoperiodo="'.$Periodo.'"
                AND 
                dp.codigoestadodetalleprematricula = 30
                AND 
                p.codigoestadoprematricula IN (40, 41)
                AND (
                    sg.codigoestado = 100
                    OR sg.codigoestado IS NULL
                )
                AND (
                    a.codigoestado = 100
                    OR a.codigoestado IS NULL
                )
                AND (
                    a.FechaAsignacion BETWEEN "'.$fecha_1.'"  AND "'.$fecha_2.'"

                    OR a.FechaAsignacion IS NULL
                )

                GROUP BY 
                  x.codigodia,
                    m.codigomateria,
                    g.idgrupo,
                    a.HoraInicio,
                    a.HoraFin,
                    a.FechaAsignacion

                ORDER BY
                    x.codigodia,
                    a.FechaAsignacion,
                    a.HoraInicio,
                    a.HoraFin';
    }//fin 
                        
               if($Horario=&$db->GetAll($SQL)===false){
                    $json["result"]   ="ERROR";
                    $json["codigoresultado"] =1;
                    $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                    echo json_encode($json);
                    exit;
               }
            
           $json["result"]   ="OK";    
           $json["codigoresultado"] =0;
          $num = count($Horario);    
            if($num<1){
                    $json["horario"] []= ' ';
            }else{
               for($i=0;$i<$num;$i++){
                    $json["horario"][$i]['nombredia']        = $Horario[$i]['nombredia']; 
                    $json["horario"][$i]['idgrupo']          = $Horario[$i]['idgrupo'];
                    $json["horario"][$i]['nombregrupo']      = $Horario[$i]['nombregrupo'];
                    $json["horario"][$i]['nombremateria']    = $Horario[$i]['nombremateria'];
                    $json["horario"][$i]['Salon']            = utf8_encode($Horario[$i]['Nombre']);
                    $json["horario"][$i]['FechaAsignacion']  = $Horario[$i]['FechaAsignacion'];
                    $json["horario"][$i]['bloque']           = utf8_encode($Horario[$i]['Bloke']);
                    $json["horario"][$i]['instalacion']      = utf8_encode($Horario[$i]['Campus']);
                    $json["horario"][$i]['horainicio']       = $Horario[$i]['HoraInicio'];
                    $json["horario"][$i]['HoraFin']          = $Horario[$i]['HoraFin'];
                    $json["horario"][$i]['docente']          = $Horario[$i]['DocenteName'];
                    $json["horario"][$i]['idasignacion']     = $Horario[$i]['AsignacionEspaciosId'];
					
               }//for
            }
         
        // echo "<pre>";print_r( json_encode($json) );die;
          
    
  return $json;              
}//function Horario
?>