<?php 
function HistoricoNotas($usuario,$carrera,$db=null){
	if($db==null){
		include(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
	}
    include_once(realpath(dirname(__FILE__)).'/../../funciones/notas/redondeo.php');
	require_once(realpath(dirname(__FILE__)).'/../../funciones/notas/funcionequivalenciapromedio.php');
	
		include(realpath(dirname(__FILE__)).'/../../Connections/sala2.php');
    $SQL_U='SELECT
            	numerodocumento,
            	codigorol,
            	codigotipousuario
            FROM
            	usuario
            WHERE
            	idusuario = "'.$usuario.'"';
   
    if($DataUser=&$db->GetAll($SQL_U)===false){
        $json["result"]   ="ERROR";
        $json["codigoresultado"] =1;
        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
        echo json_encode($json);
        exit;
    }
    
    
     $SQL='SELECT
            	e.codigoestudiante,
            	eg.idestudiantegeneral
            FROM
            	estudiantegeneral eg INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
            WHERE
            	eg.numerodocumento ="'.$DataUser[0]['numerodocumento'].'"
            AND e.codigocarrera ="'.$carrera.'"';
            
       if($EstudianteCarrera=&$db->GetAll($SQL)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
       }     
       $codigoestudiante = $EstudianteCarrera[0]['codigoestudiante'];
      
       $query_historico = 'SELECT
                            	c.nombrecortocarrera,
                            	eg.expedidodocumento,
                            	ti.nombretitulo,
                            	eg.numerodocumento,
                            	eg.nombresestudiantegeneral,
                            	eg.apellidosestudiantegeneral,
                            	e.codigoestudiante,
                            	e.codigosituacioncarreraestudiante,
                            	doc.nombredocumento,
                            	e.codigotipoestudiante,
                            	e.codigocarrera,
                            	codigomodalidadacademica
                            FROM
                            	estudiante e,
                            	carrera c,
                            	titulo ti,
                            	documento doc,
                            	estudiantegeneral eg
                            WHERE
                            	e.idestudiantegeneral = eg.idestudiantegeneral
                            AND e.codigoestudiante = "'.$codigoestudiante.'"
                            AND eg.tipodocumento = doc.tipodocumento
                            AND e.codigocarrera = c.codigocarrera
                            AND c.codigotitulo = ti.codigotitulo';
                            
          if($SolicitudHistorico=&$db->GetAll($query_historico)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
          } 
          
            $query_historicoperiodos = 'SELECT DISTINCT
                                        	n.codigoperiodo,
                                        	p.nombreperiodo,
                                        	e.codigosituacioncarreraestudiante
                                        FROM
                                        	notahistorico n,
                                        	periodo p,
                                        	estudiante e,
                                        	carreraperiodo cp
                                        WHERE
                                        	n.codigoestudiante = "'.$codigoestudiante.'"
                                        AND e.codigoestudiante = n.codigoestudiante
                                        AND e.codigocarrera = cp.codigocarrera
                                        AND cp.codigoperiodo = p.codigoperiodo
                                        AND n.codigoperiodo = cp.codigoperiodo
                                        AND n.codigoestadonotahistorico LIKE "1%"
                                        ORDER BY
                                        	1';
                                            
         if($PeriodosHistorico=&$db->GetAll($query_historicoperiodos)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit; 
         }        
         $num = count($PeriodosHistorico);
         for($i=0;$i<$num;$i++){
             $query_historico ='SELECT
                                	n.idnotahistorico,
                                	n.codigoperiodo,
                                	m.nombremateria,
                                	m.codigomateria,
                                	n.codigomateriaelectiva,
                                	n.notadefinitiva,
                                	c.nombrecortocarrera,
                                	eg.expedidodocumento,
                                	ti.nombretitulo,
                                	t.nombretiponotahistorico,
                                	eg.nombresestudiantegeneral,
                                	eg.apellidosestudiantegeneral,
                                	e.codigoestudiante,
                                	eg.numerodocumento,
                                	(m.ulasa + m.ulasb + m.ulasc) AS total,
                                	m.codigoindicadorcredito,
                                	m.numerocreditos,
                                	pe.nombreperiodo,
                                	doc.nombredocumento,
                                	e.codigotipoestudiante,
                                	n.codigotiponotahistorico,
                                	m.codigotipocalificacionmateria
                                FROM
                                	notahistorico n,
                                	materia m,
                                	tiponotahistorico t,
                                	estudiante e,
                                	carrera c,
                                	titulo ti,
                                	periodo pe,
                                	documento doc,
                                	estudiantegeneral eg
                                WHERE
                                	e.idestudiantegeneral = eg.idestudiantegeneral
                                AND n.codigoestudiante = "'.$codigoestudiante.'"
                                AND n.codigoestadonotahistorico LIKE "1%"
                                AND n.codigoestudiante = e.codigoestudiante
                                AND n.codigotiponotahistorico = t.codigotiponotahistorico
                                AND eg.tipodocumento = doc.tipodocumento
                                AND e.codigocarrera = c.codigocarrera
                                AND m.codigomateria = n.codigomateria
                                AND pe.codigoperiodo = n.codigoperiodo
                                AND pe.codigoperiodo = "'.$PeriodosHistorico[$i]['codigoperiodo'].'"
                                AND c.codigotitulo = ti.codigotitulo
                                ORDER BY  1,2';
                                
                     if($NotasEstudiante=&$db->GetAll($query_historico)===false){
                        $json["result"]   ="ERROR";
                        $json["codigoresultado"] =1;
                        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                        echo json_encode($json);
                        exit; 
                     } 
                     
                 $periodosemestral = $PeriodosHistorico[$i]['codigoperiodo'];   
                  
                     
                 $promediosemestralperiodo = PeriodoSemestralTodo($codigoestudiante,$periodosemestral,'todo',$db->_connectionID, 1);
                 //$promedioacumulado = AcumuladoReglamento ($codigoestudiante,'todo',$db->_connectionID);die;
                 $Suma = $Suma+$promediosemestralperiodo;
                 $json["result"]          ="OK";    
                 $json["codigoresultado"] =0; 
                 $json["periodos"][$i]['periodo']           = $periodosemestral ;  
                 $json["periodos"][$i]["nombreperiodo"]     = $PeriodosHistorico[$i]['nombreperiodo'];
                 $json["periodos"][$i]["promedioperiodo"]   = $promediosemestralperiodo;
                 
                 
                 for($j=0;$j<count($NotasEstudiante);$j++){
                    $json["periodos"][$i]["materias"][$j]['nombremateria']  = utf8_encode($NotasEstudiante[$j]['nombremateria']);
                    $json["periodos"][$i]["materias"][$j]['notadefinitiva'] = $NotasEstudiante[$j]['notadefinitiva'];    
					
                 }//for
         }//for periodos historicos 
		 
		 
             $query_historico ='SELECT
                                	n.idnotahistorico,
                                	n.codigoperiodo,
                                	m.nombremateria,
                                	m.codigomateria,
                                	n.codigomateriaelectiva,
                                	n.notadefinitiva,
                                	c.nombrecortocarrera,
                                	eg.expedidodocumento,
                                	ti.nombretitulo,
                                	t.nombretiponotahistorico,
                                	eg.nombresestudiantegeneral,
                                	eg.apellidosestudiantegeneral,
                                	e.codigoestudiante,
                                	eg.numerodocumento,
                                	(m.ulasa + m.ulasb + m.ulasc) AS total,
                                	m.codigoindicadorcredito,
                                	m.numerocreditos,
                                	pe.nombreperiodo,
                                	doc.nombredocumento,
                                	e.codigotipoestudiante,
                                	n.codigotiponotahistorico,
                                	m.codigotipocalificacionmateria
                                FROM
                                	notahistorico n,
                                	materia m,
                                	tiponotahistorico t,
                                	estudiante e,
                                	carrera c,
                                	titulo ti,
                                	periodo pe,
                                	documento doc,
                                	estudiantegeneral eg
                                WHERE
                                	e.idestudiantegeneral = eg.idestudiantegeneral
                                AND n.codigoestudiante = "'.$codigoestudiante.'"
                                AND n.codigoestadonotahistorico LIKE "1%"
                                AND n.codigoestudiante = e.codigoestudiante
                                AND n.codigotiponotahistorico = t.codigotiponotahistorico
                                AND eg.tipodocumento = doc.tipodocumento
                                AND e.codigocarrera = c.codigocarrera
                                AND m.codigomateria = n.codigomateria
                                AND pe.codigoperiodo = n.codigoperiodo
                                AND c.codigotitulo = ti.codigotitulo
                                ORDER BY  1,2';
         
                     if($NotasEstudiante=&$db->GetAll($query_historico)===false){
                        $json["result"]   ="ERROR";
                        $json["codigoresultado"] =1;
                        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                        echo json_encode($json);
                        exit; 
                     }
					 $notasTotales = array();
					 //$materias = "";
					foreach($NotasEstudiante as $nota){
						
						if($materiapapaito = seleccionarequivalenciapapa($nota['codigomateria'],$codigoestudiante,$sala)) {
							$formato = " n.codigomateria = ";
							$row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
						} else {
							$row_mejornota["codigomateria"]=$nota["codigomateria"];
						}
						
						if($nota["notadefinitiva"]>$notasTotales[$nota["codigomateria"]]["nota"] && $row_mejornota["codigomateria"]==$nota["codigomateria"]){
							$notasTotales[$nota["codigomateria"]]["nota"] = $nota["notadefinitiva"];
							$notasTotales[$nota["codigomateria"]]["creditos"] = $nota["numerocreditos"];
							$notasTotales[$nota["codigomateria"]]["categoria"] = 1;
							if($nota["numerocreditos"]>20 || $nota["total"]>20){
								//ulas
							//$materias.="-".$nota["codigomateria"];
								$notasTotales[$nota["codigomateria"]]["categoria"] = 2;
								$notasTotales[$nota["codigomateria"]]["creditos"] = $nota["total"];
								if($nota["notadefinitiva"]>100){
									$notasTotales[$nota["codigomateria"]]["nota"] = $nota["notadefinitiva"]/100;
								}
							} 
						}
					}
					$sumaNota = 0;
					$sumaCreditos = 0;
					$sumaNotaUlas = 0;
					$sumaCreditosUlas = 0;
					foreach($notasTotales as $nota){
						if($nota["categoria"]==1){
							$sumaNota+=$nota["nota"]*$nota["creditos"];
							$sumaCreditos+=$nota["creditos"];
						}else {
							$sumaNotaUlas+=$nota["nota"]*$nota["creditos"];
							$sumaCreditosUlas+=$nota["creditos"];							
						}
					}
         //$json["promedioacumulado"] = round(($Suma/$num),1);  
		 $promedioA = ($sumaNota/$sumaCreditos);
		 if($sumaCreditosUlas>0){
			$promedioA = ($promedioA + ($sumaNotaUlas/$sumaCreditosUlas))/2;
		 }
		 //$json["promedioacumulado"] = $sumaCreditosUlas;  
		 $json["promedioacumulado"] = round($promedioA,1);  
        
   return $json;  
                               
}//function HistoricoNotas
function NotasSemestre($usuario,$carrera,$db=null){
    
	if($db==null){
    include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
	}
    include_once(realpath(dirname(__FILE__)).'/../../funciones/notas/redondeo.php');
    
    
    
    $SQL_U='SELECT
            	numerodocumento,
            	codigorol,
            	codigotipousuario
            FROM
            	usuario
            WHERE
            	idusuario = "'.$usuario.'"';
    
    if($DataUser=&$db->GetAll($SQL_U)===false){
        $json["result"]   ="ERROR";
        $json["codigoresultado"] =1;
        $json["mensaje"]         ="Error de Conexión del Sistema SALA...1";
        echo json_encode($json);
        exit;
    }
    
     $SQL='SELECT
            	e.codigoestudiante,
            	eg.idestudiantegeneral
            FROM
            	estudiantegeneral eg INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
            WHERE
            	eg.numerodocumento ="'.$DataUser[0]['numerodocumento'].'"
            AND e.codigocarrera ="'.$carrera.'"';
            
       if($EstudianteCarrera=&$db->GetAll($SQL)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA...2";
            echo json_encode($json);
            exit;
       }     
       
       $codigoestudiante = $EstudianteCarrera[0]['codigoestudiante'];
      
       $SQL='SELECT
                codigoperiodo, 
                codigoestadoperiodo
             FROM
                periodo
             WHERE
                codigoestadoperiodo IN(1,3)';
                
                
      if($PeriodoActivo=&$db->GetAll($SQL)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA...3";
            echo json_encode($json);
            exit;
       } 
       
       for($i=0;$i<count($PeriodoActivo);$i++){
        if($PeriodoActivo[$i]['codigoestadoperiodo']==3){
            $periodoActual = $PeriodoActivo[$i]['codigoperiodo'];
        }else{
            $periodoActual = $PeriodoActivo[$i]['codigoperiodo'];
        }
       }//for periodo 
      
    /**
     * @modified Nombre Autor <perezdavid@unbosque.edu.do>
     * Se añade la consulta de consulta evaluación docente antes de mostrar notas para obligar al estudiante a pasar por SALA y llenar la evaluación docente
     * Caso reportado por Ivan Quintero - Sistemas de información <quinteroivan@unbosque.edu.co> Fecha: 6 de Noviembre de 2018,  Caso Mesa 107081
     * @since Noviembre 6, 2018
    */

       $sqlConsultaEncuesta = 'SELECT
                                            FechaInicial,
                                            FechaFinal
                                    FROM
                                            EncuestaCarreras
                                    WHERE
                                            CodigoCarrera = '.$carrera.'
                                    AND CodigoPeriodo = '.$periodoActual.'
                                    AND NOW() BETWEEN FechaInicial
                                    AND FechaFinal';
       
       if($ConsultaEncuesta=&$db->GetAll($sqlConsultaEncuesta)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA...";
            echo json_encode($json);
            exit;
       }
       
       if(!empty($ConsultaEncuesta)){
           $sqlConsultaEncuestaDocente = 'SELECT
                                                idactualizacionusuario
                                        FROM
                                                actualizacionusuario
                                        WHERE
                                                id_instrumento = (
                                                        SELECT
                                                                idsiq_Ainstrumentoconfiguracion
                                                        FROM
                                                                siq_Ainstrumentoconfiguracion
                                                        WHERE
                                                                cat_ins = "EDOCENTES"
                                                        AND (
                                                                NOW() BETWEEN fecha_inicio
                                                                AND fecha_fin
                                                        )
                                                )
                                        AND usuarioid = '.$usuario.'
                                        AND estadoactualizacion = 3';
           
           if($ConsultaEncuestaDocente=&$db->GetAll($sqlConsultaEncuestaDocente)===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA...";
                echo json_encode($json);
                exit;
           }
           
           if(empty($ConsultaEncuestaDocente)){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Verifique sus encuestas activas en SALA..";
                echo json_encode($json);
                exit;
           }
           
       }
      // $periodoActual= 20142;
       
      $SQL_Materias='SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante,d.codigomateriaelectiva,
							IF(dpe.numerocreditosdetalleplanestudio IS NULL, m.numerocreditos, dpe.numerocreditosdetalleplanestudio) as creditos, p.semestreprematricula
                    	FROM prematricula p
						INNER JOIN detalleprematricula d ON p.idprematricula = d.idprematricula
						INNER JOIN materia m ON d.codigomateria = m.codigomateria
						INNER JOIN grupo g ON d.idgrupo = g.idgrupo
						LEFT JOIN planestudioestudiante pe on pe.codigoestudiante=p.codigoestudiante and pe.codigoestadoplanestudioestudiante like "1%"
						LEFT JOIN detalleplanestudio dpe on dpe.idplanestudio=pe.idplanestudio and dpe.codigomateria=m.codigomateria
                    	WHERE  p.codigoestudiante = "'.$codigoestudiante.'"
                    	AND m.codigoestadomateria = 01
                    	AND g.codigoperiodo = "'.$periodoActual.'"
                    	AND p.codigoestadoprematricula LIKE "4%"
                    	AND d.codigoestadodetalleprematricula LIKE "3%"';
       
       if($Materias=&$db->GetAll($SQL_Materias)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA...4";
            echo json_encode($json);
            exit;
       }      
	   
       $semestre = 0;
      if(count($Materias)>=1){
        
      
       
      for($m=0;$m<count($Materias);$m++){
        
        $materia = $Materias[$m]['codigomateria'];
        $semestre = $Materias[$m]['semestreprematricula'];
        /*$SQL_CorteMateria='SELECT
                            c.numerocorte,
                            c.porcentajecorte,
                            m.nombremateria,
                            dp.idprematricula,
                            dp.idgrupo,
                            c.idcorte,
                            n.nota
                          FROM
                            corte c
                            INNER JOIN materia m ON m.codigomateria = c.codigomateria
                            INNER JOIN detalleprematricula dp ON dp.codigomateria = m.codigomateria
                            INNER JOIN prematricula p ON p.idprematricula = dp.idprematricula 
                            INNER JOIN grupo g ON g.codigomateria=m.codigomateria AND g.idgrupo=dp.idgrupo
                            LEFT JOIN detallenota n ON n.idcorte = c.idcorte 
                            AND n.codigoestudiante = p.codigoestudiante
                            AND n.codigomateria = m.codigomateria
                          WHERE
                            c.codigomateria = "'.$materia.'"
                            AND c.codigoperiodo = "'.$periodoActual.'"
                            AND p.codigoestudiante = "'.$codigoestudiante.'"
                            AND p.codigoperiodo = "'.$periodoActual.'" 
                            AND dp.codigoestadodetalleprematricula = 30 
                            
                            GROUP BY c.numerocorte';  */
                            
             $SQL_CorteMateria='SELECT
                                	c.numerocorte,
                                	c.porcentajecorte,
                                	m.nombremateria,
                                	dp.idprematricula,
                                	dp.idgrupo,
                                	c.idcorte,
                                	dn.nota
                                FROM
                                detallenota dn 
                                INNER JOIN prematricula p ON p.codigoestudiante=dn.codigoestudiante
                                INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula AND dn.idgrupo=dp.idgrupo
                                INNER JOIN corte c ON c.idcorte=dn.idcorte
                                INNER JOIN grupo  g ON g.idgrupo=dn.idgrupo
                                INNER JOIN materia m ON m.codigomateria=g.codigomateria
                                
                                WHERE
                                dn.codigoestudiante= "'.$codigoestudiante.'"
                                AND dn.codigoestado=100
                                AND p.codigoestadoprematricula LIKE "4%"
                                AND p.codigoperiodo="'.$periodoActual.'"
                                AND m.codigomateria ="'.$materia.'"
                                AND dp.codigoestadodetalleprematricula=30
                                
                                GROUP BY c.numerocorte';   
         if($CorteMateria=&$db->Execute($SQL_CorteMateria)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA...5";
            echo json_encode($json);
            exit;
         }  
         
         if(!$CorteMateria->EOF){
            /*echo '<br>SQL_1';
            echo '<pre>'.$SQL_CorteMateria;*/
            $CorteNota = $CorteMateria->GetArray();
         }else{
             
             $SQL_CorteCarrera='SELECT
                                	c.numerocorte,
                                	c.porcentajecorte,
                                	m.nombremateria,
                                	g.idgrupo,
                                	n.nota
                                FROM
                                	corte c
                                INNER JOIN carrera k ON c.codigocarrera = k.codigocarrera
                                INNER JOIN materia m ON m.codigocarrera = k.codigocarrera
                                INNER JOIN grupo g ON g.codigomateria = m.codigomateria
                                INNER JOIN detalleprematricula dp ON dp.codigomateria = m.codigomateria
                                INNER JOIN prematricula p ON p.idprematricula = dp.idprematricula AND g.idgrupo=dp.idgrupo
                                LEFT JOIN detallenota n ON n.idcorte = c.idcorte 
                                AND n.idgrupo = g.idgrupo
                                AND n.codigoestudiante = p.codigoestudiante
                                WHERE
                                	c.codigoperiodo = "'.$periodoActual.'"
                                AND m.codigomateria = "'.$materia.'"
                                AND g.codigoperiodo = "'.$periodoActual.'"
                                AND p.codigoestudiante = "'.$codigoestudiante.'"
                                AND p.codigoperiodo = "'.$periodoActual.'"
                                
                                GROUP BY c.numerocorte';
                                    
             if($CorteNota=&$db->GetAll($SQL_CorteCarrera)===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA...6";
                echo json_encode($json);
                exit;
             }                                    
         }  
        
         $json["result"]          ="OK";    
         $json["codigoresultado"] =0;
		 $json["semestre"]          = convertirSemestre($semestre);  
         
         if($Materias[$m]['nombremateria']){
             $json['materia'][$m]['nombre']  = utf8_encode($Materias[$m]['nombremateria']);  
             $json['materia'][$m]['creditos'] = $Materias[$m]['creditos'];
         }             
         $json['materia'][$m]['periodo'] = $periodoActual;
         
         for($x=0;$x<count($CorteNota);$x++){
            if($CorteNota[$x]['numerocorte']){
                $json['materia'][$m]['nota'][$x]['corte']      = $CorteNota[$x]['numerocorte'];                
            }else{
                $json['materia'][$m]['nota'][$x]['corte']      = '';
            }
            if($CorteNota[$x]['porcentajecorte']){
                $json['materia'][$m]['nota'][$x]['porcentaje'] = $CorteNota[$x]['porcentajecorte'];                
            }else{
                $json['materia'][$m]['nota'][$x]['porcentaje'] = '';
            }
            if($CorteNota[$x]['nombremateria']){
                $json['materia'][$m]['nota'][$x]['materia']    = utf8_encode($CorteNota[$x]['nombremateria']);                
            }else{
                $json['materia'][$m]['nota'][$x]['materia']    = '';
            }
            if($CorteNota[$x]['nota']){
                $json['materia'][$m]['nota'][$x]['nota']       = $CorteNota[$x]['nota'];                
            }else{
                $json['materia'][$m]['nota'][$x]['nota']       = '';
            }
            
                
                
            
         }//for
      }//for materias 
     
     }else{
         $json["result"]          ="OK";    
         $json["codigoresultado"] =0;
      }
     return $json;                      
                                            
}//function NotasSemestre

function convertirSemestre($semestre){
	switch($semestre){
		case 1:
			$texto = "Primer semestre";
			break;
		case 2:
			$texto = "Segundo semestre";
			break;
		case 3:
			$texto = "Tercer semestre";
			break;
		case 4:
			$texto = "Cuarto semestre";
			break;
		case 5:
			$texto = "Quinto semestre";
			break;
		case 6:
			$texto = "Sexto semestre";
			break;
		case 7:
			$texto = "Séptimo semestre";
			break;
		case 8:
			$texto = "Octavo semestre";
			break;
		case 9:
			$texto = "Noveno semestre";
			break;
		case 10:
			$texto = "Décimo semestre";
			break;
		case 11:
			$texto = "Onceavo semestre";
			break;
		case 12:
			$texto = "Doceavo semestre";
			break;
		default:
			$texto="";
	}
	return $texto;
} //function convertirSemestre

function getNotaMateria($materia,$periodoActual,$codigoestudiante,$db){
        
        $SQL_CorteMateria='SELECT
                            c.numerocorte,
                            c.porcentajecorte,
                            m.nombremateria,
                            dp.idprematricula,
                            dp.idgrupo,
                            c.idcorte,
                            n.nota
                          FROM
                            corte c
                            INNER JOIN materia m ON m.codigomateria = c.codigomateria
                            INNER JOIN detalleprematricula dp ON dp.codigomateria = m.codigomateria
                            INNER JOIN prematricula p ON p.idprematricula = dp.idprematricula 
                            INNER JOIN grupo g ON g.codigomateria=m.codigomateria AND g.idgrupo=dp.idgrupo
                            LEFT JOIN detallenota n ON n.idcorte = c.idcorte 
                            AND n.codigoestudiante = p.codigoestudiante
                            AND n.codigomateria = m.codigomateria
                          WHERE
                            c.codigomateria = "'.$materia.'"
                            AND c.codigoperiodo = "'.$periodoActual.'"
                            AND p.codigoestudiante = "'.$codigoestudiante.'"
                            AND p.codigoperiodo = "'.$periodoActual.'"
                            AND dp.codigoestadodetalleprematricula = 30
                            
                            GROUP BY c.numerocorte';   
                         
         if($CorteMateria=&$db->Execute($SQL_CorteMateria)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA...5";
            echo json_encode($json);
            exit;
         }

		if(!$CorteMateria->EOF){
            $CorteNota = $CorteMateria->GetArray();
         }else{
             
             $SQL_CorteCarrera='SELECT
                                	c.numerocorte,
                                	c.porcentajecorte,
                                	m.nombremateria,
                                	g.idgrupo,
                                	n.nota
                                FROM
                                	corte c
                                INNER JOIN carrera k ON c.codigocarrera = k.codigocarrera
                                INNER JOIN materia m ON m.codigocarrera = k.codigocarrera
                                INNER JOIN grupo g ON g.codigomateria = m.codigomateria
                                INNER JOIN detalleprematricula dp ON dp.codigomateria = m.codigomateria
                                INNER JOIN prematricula p ON p.idprematricula = dp.idprematricula AND g.idgrupo=dp.idgrupo
                                LEFT JOIN detallenota n ON n.idcorte = c.idcorte 
                                AND n.idgrupo = g.idgrupo
                                AND n.codigoestudiante = p.codigoestudiante
                                WHERE
                                	c.codigoperiodo = "'.$periodoActual.'"
                                AND m.codigomateria = "'.$materia.'"
                                AND g.codigoperiodo = "'.$periodoActual.'"
                                AND p.codigoestudiante = "'.$codigoestudiante.'"
                                AND p.codigoperiodo = "'.$periodoActual.'"
                                AND dp.codigoestadodetalleprematricula=30 
                                GROUP BY c.numerocorte';
								
             if($CorteNota=&$db->GetAll($SQL_CorteCarrera)===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA...6";
                echo json_encode($json);
                exit;
             }                                    
         }  
         $json["result"]          ="OK";    
         $json["codigoresultado"] =0;               
         $json['materia']['periodo'] = $periodoActual;
         for($x=0;$x<count($CorteNota);$x++){
            $json['materia']['nota'][$x]['corte']      = $CorteNota[$x]['numerocorte'];
            $json['materia']['nota'][$x]['porcentaje'] = $CorteNota[$x]['porcentajecorte'];
            $json['materia']['nota'][$x]['materia']    = $CorteNota[$x]['nombremateria'];
            $json['materia']['nota'][$x]['nota']       = $CorteNota[$x]['nota'];
         }//for		 
		 
		 return $json;
}
?>