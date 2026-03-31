<?PHP
class PlanTrabjoDocente{
	public function Principal($id_docente,$Periodo=''){
		global $db,$userid; //echo '<br>$id_docente->'.$id_docente;
        
        //$id_docente ='1340';
		
        if(!$Periodo){
             
            $CodigoPeriodo	= $this->Periodo();
            
            $Periodo = $CodigoPeriodo['CodigoPeriodo'];
            
        }
        
        
        $SQL='SELECT 

                codigoestadoperiodo
                
                FROM 
                
                periodo 
                
                WHERE codigoperiodo="'.$Periodo.'"';
                
           if($EstadoPeriodo=&$db->Execute($SQL)===false){
                echo 'Error en el SQL ....<br>'.$SQL;
                die;
           }     
		 
         
         if($EstadoPeriodo->fields[0]==2){
            $Disable = 'display: none;';
         }else{
            $Disable = '';
         }
         
		$D_Docente	= $this->DatosDocente($id_docente);
        
        
               
                ?>

		<!-- Plan de trabajo semestral. Durante el semestre puedo subir experiencias significativas: Portafolio. Evidenciaas de que estoy
		haciendo bien mi tarea. Al final va a poder abrir la herramienta y hacer autoevaluación para que el decano y docente

		Soy significativo
		Instrumento Significativo

		Planeación significativa
		Experiencias Académicas Significativas en Línea -->
<div id="Data" ><!--Contenedor Principal-->


<div id="encabezado" >
	<div class="cajon">
		<img id="logo" src="img/logotipo_negativo.png" />
        <input type="hidden" id="Docente_id" value="<?PHP echo $id_docente?>" />
			<?PHP
			$this->TablaDatos($D_Docente,$Periodo);
			?>
	</div>
</div>



<div id="cuerpo" ><!--cuerpo-->
	<div id="grueso"><!--grueso-->
		<div id="tabs" class="dontCalculate"><!--tabs-->
			<div style="background:#7f7f7f;">
				<div class="cajon">
					<ul>
						<li><a href="#tabs-1"></a></li>
						<li><a href="#tabs-2">Enseñanza - Aprendizaje</a></li>
						<li><a href="#tabs-3">Descubrimiento</a></li>
						<li><a href="#tabs-4">Compromiso</a></li>
						<li><a href="#tabs-5">Gestion Academica</a></li>
                        <li><a href="#tabs-6">Resumen</a></li>
					</ul>
				</div>
			</div>
            
			<!-- primera pestaña -->
			<div id="tabs-1" class="tab">
				<div class="cajon">
					<img id="sombrilla" src="img/sombrilla.png" />
					<div id="introduccion">
						<div id="titulo">
							<span>Planeación de</span>
							<span>Actividades</span>
							<span>Académicas</span>
						</div>
						<p>Como académico en la Universidad El Bosque usted puede desarrollar su actividad a través de cuatro orientaciones complementarias no excluyentes:</p>
						<ul>
							<li><span>Enseñanza-Aprendizaje:</span> Se enfoca en la formación del estudiante y se centra en el aprendizaje de este.</li>
							<li><span>Descubrimiento:</span> Se concentra en la generación y desarrollo de conocimiento a través de la investigación.</li>
							<li><span>Compromiso:</span> Aplica el conocimiento a través del servicio mediante relaciones para la colaboración.</li>
							<li><span>Gesti&oacute;n Academica:</span> conecta las diferentes disciplinas y demas vocaciones en busca de un bien común.</li>
						</ul>
						<p>Esta herramienta le permitirá llevar un registro de su actividad en cualquiera de las cuatro orientaciones e identificar oportunidades de mejora para el desarrollo de su curso.</p>
                        <ul>
                            <li><span style="color: yellow;">Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</span></li>
                        </ul>
					</div>
                                        
				</div>
			</div>
           
			<!-- segunda pestaña -->
			<div id="tabs-2" class="tab">
				<div class="cajon">
					<form id="TabUno" name="TabUno">
						<?PHP 
						$this->PrimeraTabla($Periodo,$D_Docente['Documento'],'TabUno',$id_docente,$Disable);
						?>
					</form>
				</div>
			</div>
             
			<!-- tercera pestaña -->
			<div id="tabs-3" class="tab">
				<div class="cajon">
					<form id="TabDos" name="TabDos">
						<?PHP
						$this->TablaSegunda('TabDos',$Disable,$id_docente);
						?>
					</form>
				</div>
			</div>
            
			<!-- cuarta pestaña -->
			<div id="tabs-4" class="tab">
				<div class="cajon">
					<form id="TabTres" name="TabTres">
						<?PHP
						$this->TablaTres('TabTres',$Disable,$id_docente);
						?>
					</form>
				</div>
			</div>
           
			<div id="tabs-5" class="tab">
				<div class="cajon">
					<form id="TabCua" name="TabCua">
						<?PHP 
						$this->TablaCuatro('TabCua',$Disable,$id_docente);
						?>
					</form>
				</div>
			</div><!--Div 5-->
            <div id="tabs-6" class="tab">
            <?PHP 
            $SQL_Horas='SELECT 

                                hora,
                                hora_trabajo,
                                docente_id
                        
                        FROM 
                        
                                accionesplandocente_temp
                        
                        WHERE
                        
                                docente_id="'.$id_docente.'"
                                AND
                                codigoestado=100
                                AND
                                codigoperiodo="'.$Periodo.'"';
                                
                        if($Horas_Academica=&$db->Execute($SQL_Horas)===false){
                            echo 'Error en el SQL de las Horas Academicas....<br><br>'.$SQL_Horas;
                            die;
                        } 
                 
                 $horasClase = 0;
                 $horasEvaluacion = 0;
                        
                 while(!$Horas_Academica->EOF){
                    
                        $horasClase       = $horasClase+$Horas_Academica->fields['hora'];
                        $horasEvaluacion  = $horasEvaluacion+$Horas_Academica->fields['hora_trabajo'];
                    
                    $Horas_Academica->MoveNext();
                 }  
                 /**********************************************************************************************/
                    $SQL_Otras='SELECT 

                                        horas,
                                        id_vocacion,
                                        tipo 
                                
                                FROM 
                                
                                        plandocente 
                                
                                WHERE
                                
                                        id_docente="'.$id_docente.'"
                                        AND
                                        codigoestado=100
                                        AND
                                        codigoperiodo="'.$Periodo.'"';
                                        
                     if($OtrasHoras=&$db->Execute($SQL_Otras)===false){
                        echo'Error en el SQl <br><br> Otras horas...<br><br>'.$SQL_Otras;
                        die;
                     }
                     
                     $Horas_2_1 = 0;
                     $Horas_2_2 = 0;
                     $Horas_2_3 = 0;
                     $Horas_3_1 = 0;
                     $Horas_3_2 = 0;
                     $Horas_3_3 = 0;
                     $Horas_4 = 0;
                     
                     while(!$OtrasHoras->EOF){
                        if($OtrasHoras->fields['id_vocacion']==2){
                            if($OtrasHoras->fields['tipo']==1){
                               $Horas_2_1  = $Horas_2_1+$OtrasHoras->fields['horas']; 
                            }else if($OtrasHoras->fields['tipo']==2){
                                  $Horas_2_2  = $Horas_2_2+$OtrasHoras->fields['horas'];
                            }else if($OtrasHoras->fields['tipo']==3){
                                    $Horas_2_3  = $Horas_2_3+$OtrasHoras->fields['horas'];
                            }
                        }else if($OtrasHoras->fields['id_vocacion']==3){
                            if($OtrasHoras->fields['tipo']==1){
                               $Horas_3_1  = $Horas_3_1+$OtrasHoras->fields['horas'];
                            }else if($OtrasHoras->fields['tipo']==2){
                                  $Horas_3_2  = $Horas_3_2+$OtrasHoras->fields['horas'];
                            }else if($OtrasHoras->fields['tipo']==3){
                                    $Horas_3_3  = $Horas_3_3+$OtrasHoras->fields['horas'];
                            }
                        }else if($OtrasHoras->fields['id_vocacion']==4){
                            $Horas_4  = $Horas_4+$OtrasHoras->fields['horas'];
                        }
                        $OtrasHoras->MoveNext();
                     }                   
                 /**********************************************************************************************/
                 $total  = 0;
                 
                 $total  = $horasClase+$horasEvaluacion+$Horas_2_1+$Horas_2_2+$Horas_2_3+$Horas_3_1+$Horas_3_2+$Horas_3_3+$Horas_4;            
            ?>
				<div class="cajon"><!--cajon-->
					<div id="reporteDedicacionAcademico" style="margin-top:15px;"><!--reporteDedicacionAcademico-->
                        <table align="center" class="formData last" width="92%" >
                            <thead>            
                                <tr class="dataColumns">
                                    <th class="column" colspan="4" style="background-color:#D03AC0;"><span>Dedicación del académico por actividades</span></th>                                    
                                </tr>
                                <tr class="dataColumns category">
                                    <th class="column borderR" colspan="2" style="background-color:#FFFC0B;"><span>Clase De Actividades</span></th> 
                                    <th class="column " style="background-color:#FFFC0B;"><span>Horas Semanales</span></th> 
                                </tr>
                            </thead>
                            <tbody style="background-color:#fff;">
                                        <tr class="dataColumns">
                                            <td class="column borderR" rowspan="2" >Vocación Enseñanza-Aprendizaje (Docencia)</td>
                                            <td class="column borderR">horas presenciales por semana</td>
                                            <td class="column center"><?php echo $horasClase; ?></td>
                                        </tr>   
                                        <tr class="dataColumns">
                                            <td class="column borderR">horas de preparación , evaluación y/o asesoría académica</td>
                                            <td class="column center"><?php echo $horasEvaluacion; ?></td>
                                        </tr>  
                                        <tr class="dataColumns">
                                            <td class="column borderR" rowspan="2" >Vocación de Descubrimiento (Investigación)</td>
                                            <td class="column borderR">Formativa</td>
                                            <td class="column center"><?PHP echo $Horas_2_1?></td>
                                        </tr>   
                                        <tr class="dataColumns">
                                            <td class="column borderR">Investigación propiamente dicha</td>
                                            <td class="column center"><?PHP echo $Horas_2_2?></td>
                                        </tr> 
                                        <tr class="dataColumns">
                                            <td class="column borderR"></td>
                                            <td class="column borderR">Creación artística e innovación</td>
                                            <td class="column center"><?PHP echo $Horas_2_3?></td>
                                        </tr>  
                                        <tr class="dataColumns">
                                            <td class="column borderR" rowspan="3" >Vocación de Compromiso (Extensión)</td>
                                            <td class="column borderR">Consultoría</td>
                                            <td class="column center"><?PHP echo $Horas_3_1?></td>
                                        </tr>   
                                        <tr class="dataColumns">
                                            <td class="column borderR">Práctica (Empresarial, clínica social y/o internados)</td>
                                            <td class="column center"><?PHP echo $Horas_3_2?></td>
                                        </tr>   
                                        <tr class="dataColumns">
                                            <td class="column borderR">Educación continuada</td>
                                            <td class="column center"><?PHP echo $Horas_3_3?></td>
                                        </tr>    
                                        <tr class="dataColumns">
                                            <td class="column borderR" colspan="2">Gesti&oacute;n Academica</td>
                                            <td class="column center"><?PHP echo $Horas_4?></td>
                                        </tr>   
                            </tbody>
                            <tfoot style="background-color:#fff;">
                                <tr>
                                    <td class="column borderR" colspan="2" style="text-align:right;">Total</td>
                                    <td class="center"><?php echo $total; ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <ul>
                            <li><span style="color: yellow;">Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</span></li>
                        </ul>          
                    </div><!--reporteDedicacionAcademico-->
				</div><!--cajon-->
			</div><!--Div 6-->
		</div><!--tabs-->
	</div><!--grueso-->
</div><!--cuerpo-->

    <div id="pie"><!--pie-->
    	<div class="cajon">
    		<a href="http://www.uelbosque.edu.co/sites/default/files/pdf/institucional/politicas/politica-planeacion_calidad_talento_academico.pdf" target="_blank">
    			Descubra más información en la Política de Gestión del Talento Humano Académico »
    			<img src="img/politica-icon.png" />
    		</a>
    	</div>
    </div><!--Fin pie-->

</div><!--Fin Contenedor Principal-->
	
		<?PHP
		
		
		}//public function Principal
	public function DatosDocente($id_docente){
		global $db,$userid;
			
			 $SQL_Docente='SELECT 

									pro.iddocente,
									pro.apellidodocente,
									pro.nombredocente,
									pro.numerodocumento,
									pro.tipodocumento,
									doc.nombredocumento
							
							FROM 
							
									docente pro INNER JOIN documento doc ON pro.tipodocumento=doc.tipodocumento
							
							WHERE
							
									pro.iddocente="'.$id_docente.'"
									AND
									pro.codigoestado=100
									AND
									doc.codigoestado=100';
									
						if($Datos_Docente=&$db->Execute($SQL_Docente)===false){
								echo 'Error en el SQL de los Datos del Docente ...<br>'.$SQL_Docente;
								die;
							}
							
				$Docente	= array();
				
				$Docente['id_docente']		=	$Datos_Docente->fields['iddocente'];
				$Docente['Apellidos']		=	$Datos_Docente->fields['apellidodocente'];
				$Docente['Nombres']			=	$Datos_Docente->fields['nombredocente'];
				$Docente['Documento']		=	$Datos_Docente->fields['numerodocumento'];	
				$Docente['TipoDocumento']	=	$Datos_Docente->fields['nombredocumento'];	
				
				return $Docente;					
						
		
		}//public function DatosDocent0e	
	public function TablaDatos($D_Docente,$Periodo){
		//$CodigoPeriodo	= $this->Periodo();
        
        $arrayP = str_split($Periodo, strlen($Periodo)-1);
                
        $P = $arrayP[0].'-'.$arrayP[1];
        
		?>
		<div id="id">
			<div id="nombre">
				<?PHP echo $D_Docente['Nombres']?> <?PHP echo $D_Docente['Apellidos']?>
			</div>
			<div id="tipodoc">
				<?PHP echo $D_Docente['TipoDocumento']?>: <?PHP echo $D_Docente['Documento']?><input type="hidden" id="NumDocumento" value="<?PHP echo $D_Docente['Documento']?>" />
			</div>
			<div id="periodo" style="cursor: pointer;" onclick="CambiarPeriodo()" title="Click Para Cambiar el Periodo">
				<?PHP echo $P?>
			</div>
            <input type="hidden" id="Periodo_id" value="<?PHP echo $Periodo?>" />
            <div id="DivPeriodo"></div>
		</div>
	
	   <br /> 
		<?PHP
		}//public function TablaDatos	
	public function DatosMateria($NumDocumento,$CodigoPeriodo,$CodigoPrograma,$tipo,$CodigoMateria=''){
		global $db,$userid;
		
		if($tipo==1){
				$GroupBy	= '';//GROUP BY  g.codigomateria
				$Consulta	= '';
			}else{
					$GroupBy	= '';
					$Consulta	= ' AND g.codigomateria="'.$CodigoMateria.'" ';
				}
		
		/*
			g.idgrupo,
			g.nombregrupo,
			g.codigomateria,
			g.codigoperiodo,
			g.numerodocumento,
			g.maximogrupo,
			g.matriculadosgrupo,
			m.codigomateria as id,
			m.nombremateria  as Nombre,
			m.numerocreditos,
			m.numerosemana,
			m.numerohorassemanales,
			m.codigocarrera
		*/
			 $SQL_DatosMateria='SELECT 

											g.codigomateria, 
											g.codigoperiodo, 
											g.numerodocumento, 
											g.matriculadosgrupo AS Matriculados, 
											CONCAT(m.codigomateria,"-",g.idgrupo) as id, 
											CONCAT(m.nombremateria," - ",g.nombregrupo) as Nombre, 
											m.numerohorassemanales as HorasSemana,
											m.codigocarrera,
                                            g.idgrupo
                                            
								
								FROM 
								
											grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
												
								
								WHERE
								
											g.codigoestadogrupo=10
											AND
											g.numerodocumento="'.$NumDocumento.'"
											AND
											g.codigoperiodo="'.$CodigoPeriodo.'"
											AND
											m.codigoestadomateria=01
											AND
											m.codigocarrera="'.$CodigoPrograma.'" '.$Consulta.$GroupBy;
											
							if($DatosMateria=&$db->Execute($SQL_DatosMateria)===false){
									echo 'Error en el SQL de los Datos de las MAterias...<br>'.$SQL_DatosMateria;
									die;
								}
		/*********************************************************************************************************/						
				$SQL_H='SELECT 
				
								idcontenidoprogramatico,
								codigomateria,
								codigoperiodo,
								horastrabajoindependiente
						
						FROM 
						
								contenidoprogramatico
						
						WHERE
						
								codigoestado=100
								AND
								codigomateria="'.$CodigoMateria.'"
								AND
								codigoperiodo="'.$CodigoPeriodo.'"';	
								
						if($HorasT=&$db->Execute($SQL_H)===false){
								echo 'Error en el eSQL De Horas de Trabajo...<br>'.$SQL_H;
								die;
							}	
			/*****************************************************************************************************/				
			
				$SQL_S='SELECT

								p.idplanestudio,
								dp.semestredetalleplanestudio as Semestre
						
						FROM
						
								planestudio p INNER JOIN detalleplanestudio dp ON p.idplanestudio=dp.idplanestudio
						
						WHERE
						
								dp.codigomateria="'.$CodigoMateria.'"
								AND
								p.codigocarrera="'.$CodigoPrograma.'"';
								
								
						if($Semestre=&$db->Execute($SQL_S)===false){
								echo 'Error en el eSQL De Semestre MAteria..<br>'.$SQL_S;
								die;
							}
                            
                 	 $query_pertenecemateria="SELECT 
                                                            m.codigomateria,
                                                            m.nombremateria, 
                                                            m.numerohorassemanales, 
                                                            m.numerosemana, 
                                                            c.nombrecarrera, 
                                                            f.nombrefacultad, 
                                                            t.nombretipomateria, 
                                                            t.codigotipomateria, 
                                                            p.nombreplanestudio, 
                                                            p.idplanestudio, 
                                                            coalesce(d.numerocreditosdetalleplanestudio,m.numerocreditos) as numerocreditosdetalleplanestudio, 
                                                            d.semestredetalleplanestudio, 
                                                            m.porcentajeteoricamateria, 
                                                            m.porcentajepracticamateria        			
                                                            
                                                   FROM 
                                                            materia m  left join detalleplanestudio d on m.codigomateria=d.codigomateria
            			                                               left join planestudio p on d.idplanestudio = p.idplanestudio 
                                                                       and 
                                                                       p.codigoestadoplanestudio = '100' 
                                                                       and 
                                                                       p.codigocarrera = (
                                                                       select codigocarrera from materia where codigomateria='".$CodigoMateria."'), 
                                                                       carrera c , 
                                                                       facultad f , 
                                                                       tipomateria t        			
                                                                       
                                                  where 
                                                  m.codigomateria='".$CodigoMateria."'        			
                                                  and 
                                                  m.codigocarrera=c.codigocarrera
                                                  and 
                                                  c.codigofacultad=f.codigofacultad            			
                                                  and 
                                                  m.codigotipomateria=t.codigotipomateria
                                                                			
                                                  group by semestredetalleplanestudio";   
                        
                        if($Resultado=&$db->Execute($query_pertenecemateria)===false){
                            echo 'Error en el SQl ...<br><br>'.$query_pertenecemateria;
                            die;
                        }        		
												
								
			if($tipo==0){
				
				$Grupos		= $this->NumGrupo($NumDocumento,$CodigoPeriodo,$CodigoPrograma,$CodigoMateria);
								
				$Materia	= array();
				
				$Materia['codigomateria']			= $CodigoMateria;
				$Materia['Matriculados']			= $DatosMateria->fields['Matriculados'];
				$Materia['codigomateria']			= $DatosMateria->fields['id'];
				$Materia['nombremateria']			= $DatosMateria->fields['Nombre'];
				$Materia['HorasSemana']				= $Resultado->fields['numerohorassemanales'];
				$Materia['codigocarrera']			= $DatosMateria->fields['codigocarrera'];	
				$Materia['NumGrupos']				= $Grupos;
				$Materia['HorasTrabjo']				= $HorasT->fields['horastrabajoindependiente'];
				$Materia['Semestre']				= $Semestre->fields['semestredetalleplanestudio'];
				return $Materia;
				
			}else{
			 
                    if($DatosMateria->EOF){
                        
                          $SQL='SELECT 

                                m.codigomateria,
                                m.nombremateria,
                                g.idgrupo,
                                g.nombregrupo,
                                CONCAT(m.codigomateria,"-",g.idgrupo) as id,
                                CONCAT(m.nombremateria," - ",g.nombregrupo) as Nombre
                                
                                
                                FROM materia m INNER JOIN grupo g ON g.codigomateria=m.codigomateria
                                
                                WHERE
                                
                                m.codigocarrera="'.$CodigoPrograma.'"
                                AND
                                g.codigoperiodo="'.$CodigoPeriodo.'"
                                and
                                g.codigoestadogrupo=10
                                and
                                m.codigoestadomateria=01';
                                
                             if($DatosMateria=&$db->Execute($SQL)===false){
									echo 'Error en el SQL de los Datos de las MAterias...<br>'.$SQL;
									die;
								}   
                        
                    }
				
					return $DatosMateria;
				
				}
		
		}//public function DatosMaterias
	public function DatosFaculta($NumDocumento,$CodigoPeriodo){
		global $db,$userid;
		
		 $SQL_Facultad='SELECT
										
										
									c.codigofacultad as id,
									f.nombrefacultad as Nombre
																	
							FROM 
																	
									grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
											INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
											INNER JOIN facultad f ON f.codigofacultad=c.codigofacultad

							
							WHERE
							
									g.codigoestadogrupo=10
									AND
									g.numerodocumento="'.$NumDocumento.'"
									AND
									g.codigoperiodo="'.$CodigoPeriodo.'"
									AND
									m.codigoestadomateria=01		
							
							GROUP BY m.codigocarrera';
							
					if($Facultad=&$db->Execute($SQL_Facultad)===false){
							echo 'Error en el SQl de los Datos de la Facultad...<br>'.$SQL_Facultad;
							die;
						}
                        
            if($Facultad->EOF){
                
            
                
              $SQL='SELECT 
                    
                    codigofacultad as id,
                    nombrefacultad as Nombre
                    
                    FROM facultad
                    
                    ORDER BY  nombrefacultad';
                    
                    
                	if($Facultad=&$db->Execute($SQL)===false){
							echo 'Error en el SQl de los Datos de la Facultad...<br>'.$SQL;
							die;
						} 
                
            }            		
						
			return $Facultad;	
					
		}//public function DatosFaculta
	public function DatosCarrera($NumDocumento,$CodigoPeriodo,$CodigoFacultad){
		global $db,$userid;
			
			   $SQL_Carrera='SELECT
										
									m.codigocarrera as id,
									c.nombrecarrera as Nombre
							
							FROM 
							
									grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
											INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
							
							WHERE
							
									g.codigoestadogrupo=10
									AND
									g.numerodocumento="'.$NumDocumento.'"
									AND
									g.codigoperiodo="'.$CodigoPeriodo.'"
									AND
									m.codigoestadomateria=01		
									AND
									c.codigofacultad="'.$CodigoFacultad.'"
							
							GROUP BY m.codigocarrera';
							
					if($Carrera=&$db->Execute($SQL_Carrera)===false){
							echo 'Error en el SQL Carrera ...<br>'.$SQL_Carrera;
							die;
						}		
				
                if($Carrera->EOF){
                    
                      $SQL='SELECT 
                        
                            codigocarrera as id,
                            nombrecarrera as Nombre
                            
                            FROM carrera
                            
                            WHERE
                            
                            codigofacultad="'.$CodigoFacultad.'"
                            AND
                            codigomodalidadacademica IN (200,300)';
                            
                        
                        if($Carrera=&$db->Execute($SQL)===false){
							echo 'Error en el SQL Carrera ...<br>'.$SQL;
							die;
						}    
                    
                }
                
				return $Carrera;			
							
		}//public function DatosCarrera
	public function Periodo($op=''){
		global $db,$userid;
        
        
        if($op==1){
            
             $SQL_Periodo='SELECT 

										codigoperiodo,
										date(fechainicioperiodo) as Fecha
							
							FROM 
							
										periodo
							
						    ORDER BY codigoperiodo DESC';
							
					if($Periodo=&$db->Execute($SQL_Periodo)===false){
							echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
							die;
						}
                        
          /**************************************************/
          
          ?>
          <select id="PeliodoSelect" name="PeliodoSelect" onchange="PintarPeriodo()">
            <?PHP 
            while(!$Periodo->EOF){
                
                $arrayP = str_split($Periodo->fields['codigoperiodo'], strlen($Periodo->fields['codigoperiodo'])-1);
                
                $P = $arrayP[0].'-'.$arrayP[1];
                
                ?>
                <option value="<?PHP echo $Periodo->fields['codigoperiodo']?>"><?PHP echo $P?></option>
                <?PHP
                $Periodo->MoveNext();
            } 
            ?>
          </select>
          <?PHP        
          /**************************************************/  
          exit();
        }
		
			
                        
                      
                    $SQL_Periodo='SELECT 

										codigoperiodo,
										date(fechainicioperiodo) as Fecha
							
							FROM 
							
										periodo
							
							WHERE
							
							codigoestadoperiodo=1';
							
					if($Periodo=&$db->Execute($SQL_Periodo)===false){
							echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
							die;
						}
                        
                    $CodigoPeriodo	= $Periodo->fields['codigoperiodo'];
				
        				$Fecha			= $Periodo->fields['Fecha'];
        				
        				$C_Fecha		= explode('-',$Fecha);
        				
        				/*
        					[0] => 2013
        					[1] => 01
        					[2] => 01
        				*/
        				
        				$Year	= $C_Fecha[0];
        				
        				if($C_Fecha[1]==01){
        						$Num	= 1;
        					}else{
        							$Num	= 2;
        						}
        						
        			$CodigoPerido	= array();	
        			
        			$CodigoPerido['CodigoPeriodo']		= $CodigoPeriodo;
        			$CodigoPerido['Formato']			= $Year.'-'.$Num;	
        				
        			return $CodigoPerido;	    
                        
                    
               
						
						
		
		}
	public function CajaSelect($Consulta,$Name,$Funcion,$NameHidden=''){
		?>
		<select name="<?PHP echo $Name?>" id="<?PHP echo $Name?>" class="Plan" style="width:100%" onchange="<?PHP echo $Funcion?>('<?PHP echo $NameHidden?>')">
			<option value="-1"></option>
			<?PHP 
				while(!$Consulta->EOF){
					?>
					<option value="<?PHP echo $Consulta->fields['id']?>"><?PHP echo $Consulta->fields['Nombre']?></option>
					<?PHP
					$Consulta->MoveNext();
					}
			?>
		</select>
		<?PHP
		}//public function CajaSelect	
	public function Programa($CodigoFacultad,$NumDocumento,$CodigoPeriodo){
		global $db,$userid;
		
		$Carrera	= $this->DatosCarrera($NumDocumento,$CodigoPeriodo,$CodigoFacultad);
		
		$this->CajaSelect($Carrera,'Programa_id','Materias');
		
		}//public function Programa	
	public function Materia($CodigoPrograma,$NumDocumento,$CodigoPeriodo){
		global $db,$userid;
		
		$Materia	= $this->DatosMateria($NumDocumento,$CodigoPeriodo,$CodigoPrograma,1);
		
		$this->CajaSelect($Materia,'Materia_id','InfoMateria(),VerAcionesTemp','CadenaTableUno');
		
		}//public function Materia		
	public function InfoMaterias($CodigoPrograma,$NumDocumento,$CodigoPeriodo,$CodigoMateria){
		global $db,$userid;
		
		$Materia	= $this->DatosMateria($NumDocumento,$CodigoPeriodo,$CodigoPrograma,0,$CodigoMateria);
        
        $Hora       = $this->HorasPreparacioEvaluacion($NumDocumento,$CodigoPeriodo,$CodigoPrograma,$CodigoMateria);
		
		//echo '<pre>';print_r($Materia);
		?>
		<!-- tab2. selector datos con datos -->
		<!--<fieldset style="width:100%; text-align:center" class="Curvas" >-->
		<!--	El docente a cargo de-->
			<!--<span class="dato"><?PHP //echo $Materia['nombremateria']?></span> tiene-->
			<!--<span class="dato"><?PHP //echo $Materia['NumGrupos']?></span> grupo(s) a cargo, con-->
			<!--<span class="dato"><?PHP //echo $Materia['Matriculados']?></span> estudiantes en total.--><!--<br /> Una intensidad de-->
			<!--<span class="dato"><?PHP //echo $Materia['HorasSemana']; ?></span> horas presenciales por semana y-->
			<!--<span class="dato"><?php //if($Materia['HorasTrabjo']!=null){ echo $Materia['HorasTrabjo']; } else { echo "0"; } ?></span> horas de preparación y evaluación para un total de-->
			<!--<span class="dato"><?php //echo ($Materia['HorasSemana']+$Materia['HorasTrabjo']); ?></span> horas semanales. <br />Se dicta en
			<!--<span class="dato"><?PHP //echo $Materia['Semestre']?><!--°</span> Semestre.-->
            <br />
            <table border="0" aling="left" style="width:45%;margin-left: 550px;">
                <thead>
                    <tr>
                        <td>
                            <strong>horas presenciales por semana</strong><span style="color:#FF0000">*</span></strong><input type="text"  style="text-align: center;" value="<?PHP echo $Hora['hora']?>" size="5" id="HorasSemana_<?PHP echo $CodigoMateria?>" name="HorasSemana_<?PHP echo $CodigoMateria?>"  size="5"  onkeypress="return isNumberKey(event);" onchange="Suma('<?PHP echo $CodigoMateria?>')" />
                        </td>
                    </tr>
                    <!--<tr>
                        <td>
                            <strong># Grupos</strong><input type="text" readonly="readonly" style="text-align: center;" value="<?PHP //echo $Materia['NumGrupos']; ?>" size="5" id="Num_Grupos" name="Num_Grupos" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Total de horas del docente en la asignatura</strong><input type="text" readonly="readonly" style="text-align: center;" value="<?PHP //echo $T_horas= ($Materia['NumGrupos']*$Materia['HorasSemana']); ?>" size="5" id="T_HorasAsigna" name="T_HorasAsigna" />
                        </td>
                    </tr>-->
                    <tr>
                        <td>
                            <strong>horas de preparación , evaluación y/o asesoría académica</strong><span style="color:#FF0000">*</span><input type="text" style="text-align: center;" value="<?PHP echo $Hora['horaTrabajo']?>" size="5"  onkeypress="return isNumberKey(event);" onchange="Suma('<?PHP echo $CodigoMateria?>')" id="H_Preparacio_<?PHP echo $CodigoMateria?>" name="H_Preparacio_<?PHP echo $CodigoMateria?>"  />
                        </td>
                    </tr>
                    <?PHP 
                    $C_Thoras = $Hora['horaTrabajo']+$Hora['hora'];
                    ?>
                    <tr>
                        <td>
                            <strong>Total horas semanales</strong><input type="text" readonly="readonly" style="text-align: center;" value="<?php echo $C_Thoras; ?>" size="5" id="T_horas"  name="T_horas" /><input type="hidden" id="Plan_<?PHP echo $CodigoMateria?>" name="Plan_<?PHP echo $CodigoMateria?>" value="<?PHP echo $Hora['id_plan']?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label>Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</label></td>
                    </tr>
                </thead>
            </table>
		<!--</fieldset>-->
		<?PHP
		}//public function InfoMaterias	
	public function Tablelabel(){
		?>
		<!-- tab2 selector datos vacio -->
		<!--<fieldset style="width:100%; text-align:center" class="Curvas" >-->
			Seleccione una asignatura para ver sus generalidades y acceder al plan de trabajo.
		<!--</fieldset>-->
		<?PHP
		}	
	public function NumGrupo($NumDocumento,$CodigoPeriodo,$CodigoPrograma,$CodigoMateria){
		global $db,$userid;
		
			$SQL_Grupo='SELECT 

						count(g.idgrupo) AS NumGrupo
						
						FROM 
						
						grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria 
						
						WHERE 
						g.codigoestadogrupo=10
						AND
						g.numerodocumento="'.$NumDocumento.'"
						AND
						g.codigoperiodo="'.$CodigoPeriodo.'"
						AND
						m.codigoestadomateria=01
						AND
						m.codigocarrera="'.$CodigoPrograma.'"
						AND 
						g.codigomateria="'.$CodigoMateria.'"';
						
				if($NumGrupos=&$db->Execute($SQL_Grupo)===false){
						echo 'Error en el SQL Del Numero de Grupos ...<br>'.$SQL_Grupo;
						die;
					}
					
			$Grupos		= $NumGrupos->fields['NumGrupo'];	
			
			return $Grupos;
						
		}
	public function PrimeraTabla($CodigoPeriodo,$CedulaDoccente,$Form,$id_docente,$Disable=''){
		global $db,$userid;
        
        
		
		$Facultad		= $this->DatosFaculta($CedulaDoccente,$CodigoPeriodo);
		
		$Name_1		= 'menuEditor1';
		$Accion_1	= 'Accion';
		/******************************/
		$Name_2		= 'menuEditor2';
		$Accion_2	= 'Auto';
        $Div_Auto   = 'Div_Auto';
		/******************************/
		$Name_3		= 'menuEditor3';
		$Accion_3	= 'Consolidado';
        $Div_Con    = 'Div_Consolidado'; 
		/****************************/
		$Name_4		= 'menuEditor4';
		$Accion_4	= 'Mejora';
        $Div_Mej    = 'Div_Mejora';
		
		$Porcentaje	= 'PorcentajeUno';
		?>
		
		<!-- tab2 selector -->
		<div class="orientacion">
			<img src="img/orientacion-ensenanza.png" />
			<p>La Vocación de la Enseñanza-Aprendizaje se orienta a la actividad formativa con un enfoque centrado en el aprendizaje y en el estudiante en contraste con los enfoques centrados en la enseñanza y transmisión de contenidos desde el profesor. El carácter Académico se sustenta en la actitud de “pensamiento sobre la actividad docente misma y la evidencia del aprendizaje del estudiante como problemas a ser investigados, analizados, representados y debatidos” y la evidencia de éste pensamiento en productos académicos y una mejora continua y sustentada en el quehacer docente.</p>
		</div>
		<table class="selector">
			<thead>
				<tr>
                    <th><input type="hidden" id="Docente_id" name="Docente_id" value="<?PHP echo $id_docente?>" /><h2>Facultad</h2></th>
                  	<th><h2>Programa académico</h2></th>
					<th><h2>Asignatura</h2></th>
				</tr>
			</thead>
			<tbody>
                <tr>
					<td><?PHP $this->CajaSelect($Facultad,'Facultad_id','Programa')?></td>
					<td><div id="Div_Programa"><select disabled="disabled"></select></div></td>
					<td><div id="DivMateria"><select disabled="disabled"></select></div></td>
				</tr>
               	
				<tr id="selector_info">
					<td colspan="3" id="Datos">
							<?PHP $this->Tablelabel()?>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="planes" id="Acci_Temp" class="Curvas" style="display:none;">
			<h2>Plan de Trabajo</h2>
			<div id="AcionesTemp"></div>
		</div>
  
		<br />
		<div id="CaragarEvidenciaTemp" style="display:none"></div>
		<br />
		<div id="TablaDinamic">
		<?PHP $this->TablaDianmica($Name_1,$Accion_1,$Form,'1','CadenaTableUno',$id_docente,$Disable)?>
		</div>
		<?PHP $this->Autoevaluacion($Name_2,$Accion_2,$Porcentaje,$Div_Auto,$id_docente)?>
		<br />
		<?PHP $this->PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4,$Div_Con,$Div_Mej)?>
		<table width="100%" align="center" border="0">
			<tr>
				<td align="right" class="blanco">
					<input type="button" class="first"  <?PHP echo $Disable?> id="PimeraSave" name="PimeraSave" style="font-size:24px; <?PHP echo $Disable?>" value="Guardar" onclick="Guardar('PimeraSave','1')" />
				</td>
			</tr>
		</table>
		<?PHP
		}
	public function TextArea($Div,$Name,$width,$Div_Ver=''){//792
		?>
        <script src="ckeditor/ckeditor.js"></script>    
      <style>

		.cke_focused,
		.cke_editable.cke_focused
		{
			outline: 3px dotted blue !important;
			*border: 3px dotted blue !important;	/* For IE7 */
		}

	</style>
    <script>

	     CKEDITOR.replace('<?PHP echo $Name?>');

	</script>

        <div id="<?PHP echo $Div_Ver?>"></div>
		<!--<div id="<?PHP echo $Div?>" style="width:<?PHP echo $width?>;"></div>-->
		<textarea class="ckeditor" id="<?PHP echo $Name?>" name="<?PHP echo $Name?>" rows="30" cols="90" placeholder="" class="grid-8-12" style="width:<?PHP echo $width?>; height: 360px;"></textarea>
		
		<?PHP
		}
		
	public function CheckBox($name,$Label,$Chk,$Dbl){
		if($Chk==0){
			$Checked ='';
			}else{
					$Checked ='checked="checked"';
				}
				
		if($Dbl==0){
				$Disable = '';
			}else{
				$Disable	= 'disabled="disabled"';
				}		
		?>
		<input type="checkbox" id="<?PHP echo $name?>" name="<?PHP echo $name?>" <?PHP echo $Checked?> <?PHP echo $Disable?> />&nbsp;&nbsp;<strong><?PHP echo $Label?></strong>
		<?PHP
		}	
	public function Evidencias($id_PlanTrabajo,$i){
		?>
        <tr>
            <td colspan="5" class="blanco">
            <?PHP 
            $Index  = $this->AvancesPlantrabajo($id_PlanTrabajo);
            ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="blanco">
                <hr />
            </td>
        </tr>
		<tr>
			<td colspan="5" class="blanco"><input type="hidden" id="id_PlanTrabajo_<?PHP echo $i?>" value="<?PHP echo $id_PlanTrabajo?>" />
				<table border="0" align="center" width="100%" id="Evidencias_Table">
					<thead>
						<tr>
							<!--<th class="blanco">Acciones  del Plan de Trabajo&nbsp;&nbsp;<span style="color:#FF0000">*</span></th>-->
							<td align="left" class="blanco"><strong>Avances y/o Soportes </strong>&nbsp;&nbsp;<span style="color:#FF0000">*</span></td>
							<td align="left" class="blanco"><strong>Fecha</strong>&nbsp;&nbsp;<span style="color:#FF0000">*</span></td>
                            <td align="left" class="blanco"><strong>Archivo de soporte </strong>&nbsp;&nbsp;</td>
							<td align="left" class="blanco"><img src="../../serviciosacademicos/mgi/images/add.png" title="Adicionar una Celda Nueva." onclick="AgregarFila(<?PHP echo $id_PlanTrabajo?>)" width="30" style="cursor: pointer;" /></td>
                        </tr>
					</thead>
					<tbody>
						<tr align="center"><?PHP $this->CamposEvidencia($Index,$id_PlanTrabajo,$i)?></tr>
					</tbody>
				</table>
				<input type="hidden" id="Index_<?PHP echo $id_PlanTrabajo?>" name="Index_<?PHP echo $id_PlanTrabajo?>" value="<?PHP echo $Index;?>" /><input type="hidden" id="Cadena_Evidencias_<?PHP echo $id_PlanTrabajo?>" /><input type="hidden" id="inicio_<?PHP echo $id_PlanTrabajo?>" value="<?PHP echo $Index?>" />
			</td>
		</tr>
        <tr>
            <td colspan="5" class="blanco">
                <hr />
            </td>
        </tr>
		<?PHP
		}
	public function CamposEvidencia($i,$plan,$j){
		?>
		<td class="blanco"  align="center" ><input type="text" id="Evidencia_<?PHP echo $i?>_<?PHP echo $plan?>" name="Evidencia_<?PHP echo $i?>_<?PHP echo $plan?>" style="text-align:center" autocomplete="off" onclick="FormatBoxEvidencia('Evidencia_<?PHP echo $i?>_<?PHP echo $plan?>')"  /></td>
		<td class="blanco"  align="center"><input type="text" name="Fecha_<?PHP echo $i?>_<?PHP echo $plan?>" size="12" id="Fecha_<?PHP echo $i?>_<?PHP echo $plan?>" title="" maxlength="12" tabindex="7" placeholder="" autocomplete="off" value="" readonly /></td>
		<td class="blanco"  align="center">
            <div id="ArchivosCargados_div_<?PHP echo $i?>_<?PHP echo $plan?>" >
                <img src="../PlantrabajoDocente/img/actualizar.png"  align="right" width="16" onclick="Refresh('<?PHP echo $i?>_<?PHP echo $plan?>','<?PHP echo $j?>')" style="cursor: pointer;" title="Actualizar">
                <div id="Refesh_Div_<?PHP echo $i?>_<?PHP echo $plan?>" style="display: none;"></div>
            </div>
            <br />
            <img src="../PlantrabajoDocente/img/upload_folder.png"  align="right" width="30" onclick="GargarArchivo('<?PHP echo $i?>','<?PHP echo $plan?>')" style="cursor: pointer;" title="Click Cargar Archivos">
            </td>
         <td>&nbsp;&nbsp;</td>   
		
		 <script>
		$(document).ready(function() {
		
					$("#Fecha_<?PHP echo $i?>_<?PHP echo $plan?>").datepicker({ 
						changeMonth: true,
						changeYear: true,
						showOn: "button",
						buttonImage: "../../../serviciosacademicos/css/themes/smoothness/images/calendar.gif",
						buttonImageOnly: true,
						dateFormat: "yy-mm-dd"
					});
					$('#ui-datepicker-div').hide();
					$('.ui-datepicker').hide();
				 });
		</script>
		<?PHP
		}
	public function Autoevaluacion($Name_2,$Accion_2,$Porcentaje,$Div_ver=''){
		?>

		<!-- carga de planes de autoevaluacion -->
		<fieldset style="width:100%" class="Curvas" >
			<div id="titulo_cajon">
				<span class="minitag">Autoevaluación</span>
				<a class="ayuda">
					<img class="interrogante" src="img/ayuda.png" />
					<div class="respuesta">
						<h3 align="center">Autoevaluación</h3>
						<p align="justify" class="Margen">
							<strong>1.Autoevaluación.</strong> El plan de trabajo es una herramienta donde no sólo se programan las actividades a desarrollar, sino que en él también se consignan las acciones de autoevaluación que el académico realiza con el reconocimiento del cumplimiento de las actividades planeadas, las oportunidades de consolidación y mejora y la manera como fueron realizadas. Así mismo, la percepción de los estudiantes en relación con el desempeño del académico. Se espera que el académico lleve a cabo esta autoevaluación con todos los insumos que recibe de sus estudiantes y de la dirección de la facultad o programa. Está diseñado para que el académico se retroalimente de estos insumos y adquiera compromisos consigo mismo y con la comunidad académica frente al desarrollo de sus competencias como académico, y a su desempeño de acuerdo a las diferentes vocaciones.<br /><br />
							Al <strong>cierre del semestre</strong> se debe consignar la autoevaluación que el académico realiza con el reconocimiento del cumplimiento de: las actividades planeadas, las metas y logros, las evidenciadas recopiladas y las oportunidades de consolidación y mejora. Así mismo, tendrá en cuenta la percepción de los estudiantes en relación con el desempeño del académico y de la dirección de la facultad o programa. Está diseñado para que el profesor se retroalimente de estos insumos y adquiera compromisos consigo mismo y con la comunidad académica frente al desarrollo de sus competencias como académico, y a su desempeño.
						</p>
					</div>
				</a>
			</div>
            <table border="0" style="border: black solid 1px;">
                <tr>
                    <td>
                    <?PHP $this->TextArea($Name_2,$Accion_2,'792px',$Div_ver)?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Porcentaje de Cumplimiento</strong></td>
                </tr>
                <tr>
                    <td>
                        <select id="<?PHP echo $Porcentaje?>" name="<?PHP echo $Porcentaje?>" class="Plan">
            				<option value="-1"></option>
            				<?PHP 
            				for($p=0;$p<=100;$p++){
            					?>
            					<option value="<?PHP echo $p?>"><?PHP echo $p?><strong>%</strong></option>
            					<?PHP
            				}
            				?>
            			</select>
                    </td>
                </tr>
            </table>

		</fieldset>
		<?PHP
		}	
	public function PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4,$Div_ver='',$Div_ver_1=''){
		?>


		<!-- carga de planes de trabajo -->
		<fieldset style="width:100%" class="Curvas" >
			<div id="titulo_cajon">
				<span class="minitag">Plan de mejora</span>
				<a class="ayuda">
					<img class="interrogante" src="img/ayuda.png" />
					<div class="respuesta">
						<h3 align="center">Plan de mejora</h3>
						<p align="justify" class="Margen">
							A partir de los resultados de la evaluación realizada se identificarán las oportunidades de consolidación y mejora, en el ejercicio de las competencias básicas y vocaciones académicas, con el fin de diseñar e implementar estrategias individuales y grupales que permitan atender aquellos aspectos identificados como débiles. El proceso podría contemplar a nivel individual llamado de atención sobre: sus relaciones personales, recomendación de cursos de actualización o complementación, trabajo en equipo, perfeccionamiento de sus prácticas docentes. A nivel grupal pueden incluirse: cursos de formación a nivel disciplinar, pedagógico o investigación, actividades de autoformación, entre otras.<br /><br />
							A partir de los resultados de la evaluación realizada se identificarán las oportunidades de consolidación y mejora, con el fin de diseñar e implementar estrategias individuales y grupales que le permitan atender aquellos aspectos identificados como débiles el siguiente periodo académico.
						</p>
					</div>
				</a>
			</div>
			<table border="0" align="center" width="100%">
				<tr>
					<td class="blanco" align="justify">
						<strong>Oportunidades de Consolidación </strong>&nbsp;&nbsp;<span style="color:#FF0000">*</span>
                        <br />
                        <p>Actividades relacionadas con los procesos, docencia, investigaci&oacute;n, servicio y todos aquellos procesos de apoyo que permiten consolidar las fortalezas identificadas a trav&eacute;s del plan de trabajo, el seguimiento y autoevaluaci&oacute;n del mismo y surgen para el periodo inmediatamente siguiente como parte del plan de mejoramiento</p>
					</td>
               </tr>
               <tr>
                    <td class="blanco" align="center">
						<?PHP $this->TextArea($Name_3,$Accion_3,'600px',$Div_ver)?>
					</td>
               </tr>
               <tr>     
					<td class="blanco" align="justify">
						<strong>Oportunidades de Mejora</strong>&nbsp;&nbsp;<span style="color:#FF0000">*</span>
                        <br />
                        <p>Actividades relacionadas con los procesos, docencia, investigaci&oacute;n, servicio y todos aquellos procesos de apoyo que permiten mejorar aquellas debilidades  identificadas a trav&eacute;s del plan de trabajo, el seguimiento y autoevaluaci&oacute;n del mismo y surgen para el periodo inmediatamente siguiente como parte del plan de mejoramiento</p>
					</td>
				</tr> 
				<tr>
					
					<td class="blanco" align="center">
						<?PHP $this->TextArea($Name_4,$Accion_4,'600px',$Div_ver_1)?>
					</td>
				</tr>
			</table>
		</fieldset>


		<fieldset style="width:100%" class="Curvas" >
			</fieldset>
		<?PHP
		}
	public function Acciones($Name_1,$Accion_1){
		?>
		<!-- campo para subida de planes de trabajo -->
		<table>
			<tr>
				<td class="blanco">
					<?PHP $this->TextArea($Name_1,$Accion_1,'792px')?>
				</td>
			</tr>
		</table>
		<?PHP
		}
	public function AccionesExistentes($Facultad_id,$Carrera_id,$Materia_id,$Periodo_id,$NameHidden,$Docente_id){
		global $db,$userid;
		//echo '$NameHidden->'.$NameHidden;
        
        $C_Materia  = explode('-',$Materia_id);
        
        $SQL='SELECT 

                codigoestadoperiodo
                
                FROM 
                
                periodo 
                
                WHERE codigoperiodo="'.$Periodo_id.'"';
                
           if($EstadoPeriodo=&$db->Execute($SQL)===false){
                echo 'Error en el SQL ....<br>'.$SQL;
                die;
           }     
		 
         
         if($EstadoPeriodo->fields[0]==2){
            $Disable = 'display: none;';
         }else{
            $Disable = '';
         }
        
		 $SQL='SELECT 
				
				id_accionesplandocentetemp AS id,
				descripcion
				
				FROM 
				
				accionesplandocente_temp
				
				WHERE
				
				codigoestado=100
				AND
				docente_id="'.$Docente_id.'"
				AND
				facultad_id="'.$Facultad_id.'"
				AND
				carrera_id="'.$Carrera_id.'"
				AND
				materia_id="'.$C_Materia[0].'"
				AND
				codigoperiodo="'.$Periodo_id.'"
                AND
                grupo_id="'.$C_Materia[1].'"';
				
			if($AcionesTemp=&$db->Execute($SQL)===false){
					echo 'Error en el SQL de Las Acciones Temporales.....<br>'.$SQL;
					die;
				}	
		$id=-1;
		if(!$AcionesTemp->EOF){
			?>
		 <!---->   
			   <ul id="planes">
			<?PHP
			$i	= 1;
			
			$Cadena_id	= '';
            
			while(!$AcionesTemp->EOF){
				/*********************************************/
				$Text	 = substr($AcionesTemp->fields['descripcion'], 0, 300);
				$id = $AcionesTemp->fields['id'];
                                ?>
				<li id="Accion_<?PHP echo $i?>" onmouseover="Color(<?PHP echo $i?>)" onmouseout="SinColor(<?PHP echo $i?>)" onclick="Visualizar(<?PHP echo $AcionesTemp->fields['id']?>,'<?PHP echo $i?>')">
					<!--<span class="minitag">Accion N&deg; <?PHP //echo $i?></span>!--><p><?PHP echo $Text."..."; ?></p>
				</li>
				<?php	
				
				$Cadena_id	=	$AcionesTemp->fields['id'];
				/*********************************************/
				$i++;
				$AcionesTemp->MoveNext();
				}
			?>
			   </ul> 
                 <script type="text/javascript">
                  Visualizar(<?php echo $id; ?>,'1','<?PHP echo $Docente_id?>','<?PHP echo $Disable?>');
                  BuscaMasData('<?php echo $id; ?>','<?PHP echo $Docente_id?>');
                  $("#TablaDinamic").css("display","none");
                  //$("#Acci_Temp").css("display","none");
                 </script>
			   
			   <input type="hidden" id="<?PHP echo $NameHidden?>" name="<?PHP echo $NameHidden?>" value="<?PHP echo $Cadena_id?>"/>
			<?PHP	
			}else{
			 ?>
              <script type="text/javascript">
                  $("#Acci_Temp").css("display","none");
                  Close();
                  $("#TablaDinamic").css("display","inline");
                 </script>
             <?PHP
			}
		}								
	public function TablaDianmica($Name_1,$Accion_1,$Form,$op,$NameHidden,$id_docente,$Disable){
		global $db,$userid;
		?>

		<!-- carga de planes de trabajo -->
		<fieldset style="width:100%" class="Curvas" >
			<div id="titulo_cajon">
				<span class="minitag">Plan de trabajo</span>
				<a class="ayuda">
					<img class="interrogante" src="img/ayuda.png" />
					<div class="respuesta">
						<h3 align="center">PLANES DE TRABAJO</h3>
						<p align="justify" class="Margen">
							El plan de trabajo orienta la acción del académico de acuerdo a la vocación académica. Propone metas precisas y logros esperados por parte de los académicos que sean susceptibles de ser mensurados, controlados, seguidos y evaluados, lo que significa que es dinámico y susceptible de ajustes. Al iniciar el Periodo académico en el plan de trabajo se deben describir las acciones, metas precisas y logros esperados que usted espera desarrollar alineados al Plan de Desarrollo Institucional y Plan Desarrollo Facultad, y al propio plan de Mejoramiento identificado en el periodo académico inmediatamente anterior por usted. A continuación en el espacio en blanco por favor describa las acciones a emprender para el periodo académico.
						</p>
					</div>
				</a>
			</div>
			<div id="Aciones"><?PHP $this->Acciones($Name_1,$Accion_1)?></div>
			
                <input type="button" id="guardar" name="save" class="first" title="Guardar Plan Trabajo" style="font-size:18px;<?PHP echo $Disable?>" onclick="SaveTemp(<?PHP echo $op?>,'<?PHP echo $NameHidden?>','<?PHP echo $id_docente?>')" value="Guardar" />
           
		</fieldset>
		<?PHP
		}	
	public function VisualizarTemp($id,$i,$Docente_id,$Disable){
		global $userid,$db;
		
		$SQL_Visualiza='SELECT 

						id_accionesplandocentetemp as id,
						descripcion
						
						
						FROM 
						
						accionesplandocente_temp
						
						WHERE
						
						id_accionesplandocentetemp="'.$id.'"
						AND
						codigoestado=100';
						
				if($VisualizaTemp=&$db->Execute($SQL_Visualiza)===false){
						echo 'Error en el SQL Visualizar Temp...<br>'.$SQL_Visualiza;
						die;
					}	
						
					
		?>

		<!-- plan -->
      <script src="ckeditor/ckeditor.js"></script>    
      <style>

		.cke_focused,
		.cke_editable.cke_focused
		{
			outline: 3px dotted blue !important;
			*border: 3px dotted blue !important;	/* For IE7 */
		}

	</style>
    <script>

	     CKEDITOR.replace('Edit_<?PHP echo $id?>');

	</script>
		<fieldset style="width:100%" id="plan_abierto" >
			<div id="titulo_plan">
				<span class="minitag">Plan de Trabajo <?PHP //echo $i?></span>
				<img src="img/cerrar.png" onClick="Close()" style="cursor:pointer">
				<a class="ayuda portafolio">
					<img class="interrogante" src="img/ayuda.png" />
					<div class="respuesta">
						<h3 align="center">PORTAFOLIO DE SEGUIMIENTO</h3>
						<p align="justify" class="Margen">
							Puede definirse como una recopilación de evidencias, entendidas como el conjunto de pruebas que demuestran que se ha cubierto satisfactoriamente un requerimiento, una norma o parámetro de desempeño, una competencia o un resultado de aprendizaje. El portafolio no es una simple y exhaustiva recopilación de los documentos y los materiales que afectan a la actuación educativa, sino una información seleccionada sobre las actividades relacionadas en el plan de trabajo y una sólida evidencia de su efectividad. El Portafolio de Seguimiento permite, organizadamente, registrar <strong>durante semestre</strong>, las evidencias que usted ha seleccionado como aquellas experiencias significativas de ejecución de su desempeño, por lo tanto a través de la ejecución de sus actividades, por favor registre las evidencias describiendo brevemente en que consistió cada una de ellas y la fecha de elaboración de la misma.
						</p>
					</div>
				</a>
			</div>
            <table border="0" width="100%">
                <tr>
                    <td>
                        <div id="texto_plan" align="justify" style="width:100%">
                        <img src="../PlantrabajoDocente/img/document_edit.png" id="EditPng_<?PHP echo $id?>"  align="right" width="16" onclick="EditText('EditTxt_Div_','<?PHP echo $id?>','View_Div_')" style="cursor: pointer;" title="Editar Texto.">  
                        <img src="../PlantrabajoDocente/img/Save.png" id="SavePng_<?PHP echo $id?>" align="right" width="16" onclick="UpdateText('EditTxt_Div_','<?PHP echo $id?>','View_Div_')" style="cursor: pointer; display: none;" title="Save Texto.">
                            <div id="EditTxt_Div_<?PHP echo $id?>"  style="width:100%; display: none;">
                                <textarea class="ckeditor" rows="30" cols="90" id="Edit_<?PHP echo $id?>" style="width: 95%; text-align: justify;">
                                    <?PHP echo $VisualizaTemp->fields['descripcion']?>
                                </textarea>
                                	
                            </div>
                            <br />
            				<div id="View_Div_<?PHP echo $id?>" align="justify" style="width:100%">
                                <?PHP echo $VisualizaTemp->fields['descripcion']?>
                            </div>
            			</div>
                    </td>
                </tr>
                
            </table>
			
            <br />
              
			<?PHP $this->Evidencias($id,$i)?>
			<button type="button" id="guardar" name="save" style="<?PHP echo $Disable?>" class="first" title="Guardar Acion" onclick="EvidenciaSaveTemp('<?PHP echo $VisualizaTemp->fields['id'] ?>','<?PHP echo $i?>')">Guardar</button>
		   
		</fieldset>
		<?PHP
        /*****************/
        
          $SQL='SELECT 
                
                        id_plandocente,
                        autoevaluacion,
                        porcentaje,
                        consolidacion,
                        mejora
                
                FROM 
                
                        plandocente
                
                WHERE
                
                        id_docente="'.$Docente_id.'"
                        AND
                        plantrabajo_id="'.$id.'"
                        AND
                        id_vocacion=1
                        AND
                        codigoestado=100';
                        
               if($Datos=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL ....<br><br>'.$SQL;
                    die;
               }
           ?>
                    
        <?PHP
		}	
	public function TablaSegunda($id_Form,$Disable,$id_docente){
		global $userid,$db;
		
		$Name_1		= 'menuEditor5';
		$Accion_1	= 'AccionPd';
		/******************************/
		$Name_2		= 'menuEditor6';
		$Accion_2	= 'AutoPd';
		/******************************/
		$Name_3		= 'menuEditor7';
		$Accion_3	= 'ConsolidadoPd';
		/****************************/
		$Name_4		= 'menuEditor8';
		$Accion_4	= 'MejoraPd';
		
		$Porcentaje	= 'PorcentajeDos';
		?>

		<!-- contenido pestaña 2 -->
			<div class="orientacion">
				<img src="img/orientacion-investigacion.png" />
				<p>La Vocación del Descubrimiento se concentra en la generación y desarrollo de conocimiento y la innovación. Se orienta bien en la disciplina particular, en el quehacer de los procesos de enseñanza aprendizaje o en los procesos de transferencia de conocimiento. Sustenta su carácter Académico en la reflexión permanente sobre la propia actividad investigativa y su impacto en los procesos formativos y sobre el entorno.</p>
			 </div>
			<input id="id_CampoDos" type="hidden"  />  
			<table class="selector">
                 <tr>
                    <td colspan="2"><input type="hidden" id="Plan_Descubrimiento" />
                        <table border="0" width="100%">
                            <tr>
                                <td>
                                    <div id="Descubrimiento_Div" style="text-align: right; font-size: 0.8 em; color: #0080FF;">
                                        <span  style="cursor: pointer;" onclick="RefreshPlanes('RefeshDescubrimineto_Div','2')">Visualizar Planes Existentes.</span>
                                        <img src="../PlantrabajoDocente/img/search_plus_blue.png"  align="right" width="25" onclick="RefreshPlanes('RefeshDescubrimineto_Div','2')" style="cursor: pointer;" title="Visualizar Planes Existentes.">
                                        <div id="RefeshDescubrimineto_Div" style="display: none;"></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                 </tr>
				 <?PHP $this->CajaTexto('Nombre del Proyecto','NomProyecto','70',$id_Form,'AutoCompleteProyecto()')?>
				 <tr>
					<td valign="top"><h2>Tipo</h2></td>
					<td valign="top">
						<select id="TipoProyectoInv" name="TipoProyectoInv" class="Plan" >
							<option value="-1"></option>
							<option value="1">Formativa</option>
							<option value="2">Investigación propiamente dicha</option>
                            <option value="3">Creación artística e innovación</option>
						</select>
					</td>
				 </tr>
				 <tr id="Tr_OtroType" style="visibility:collapse">
					<td valign="top"><h2>Cual:</h2></td>
					<td valign="top">
						<input type="text"  id="OtroType" name="OtroType" style="text-align:center; border:#88AB0C solid 1px;" size=""  onclick="FormatBox('OtroType','<?PHP echo $id_Form?>')"/>
					</td>
				 </tr>
				 <?PHP $this->CajaTexto('Total horas semanales de dedicacion','Thsemana','5',$id_Form,'return isNumberKey(event)','UpdateHoras()')?>
			</table>
		<div id="Acci_TempDos" class="planes" style="display: none;">
			<h2>Plan de Trabajo</h2>
			<div id="AcionesTempDos"></div>
		</div>
		<br />
		<div id="CaragarEvidenciaTempDos" style="display:none"></div> 
		<br />
		<div id="TablaDinamic_Dos">
		<?PHP $this->TablaDianmica($Name_1,$Accion_1,'','2','CadenaTableDos',$id_docente,$Disable)?>
		</div>
		<br />
		<?PHP $this->Autoevaluacion($Name_2,$Accion_2,$Porcentaje)?>
		<br />
		<?PHP $this->PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4)?>
		<table width="100%" align="center" border="0">
			<tr>
				<td align="right" class="blanco">
					<input type="button" class="first" id="DosSave" name="DosSave" style="font-size:24px;<?PHP echo $Disable?>" value="Guardar" onclick="Guardar('DosSave','2')" />
				</td>
			</tr>
		</table>
		<?PHP
		}
	public function TablaTres($id_Form,$Disable,$id_docente){
		global $userid,$db;
		
		$Name_1		= 'menuEditor9';
		$Accion_1	= 'AccionPt';
		/******************************/
		$Name_2		= 'menuEditor10';
		$Accion_2	= 'AutoPt';
		/******************************/
		$Name_3		= 'menuEditor11';
		$Accion_3	= 'ConsolidadoPt';
		/****************************/
		$Name_4		= 'menuEditor12';
		$Accion_4	= 'MejoraPt';
		
		$Porcentaje	= 'PorcentajeTres';
		?>
		
		<!-- tab2 selector -->
		<div class="orientacion">
			<img src="img/orientacion-compromiso.png" />
			<p>La Vocación del Compromiso comprende la aplicación del conocimiento. Sin embargo va más allá de una aplicación de conocimiento con un flujo unidireccional (Universidad-Sociedad). También comprende el servicio, pero transforma el servicio comunitario en una actividad de construcción conjunta y no de índole asistencial. La Vocación de Compromiso enfatiza la colaboración genuina en que la enseñanza y aprendizaje ocurren en la Universidad y en la Sociedad. El carácter Académico se sustenta en la reflexión sobre las relaciones con el estudiante, con la comunidad y sienta las bases para la Investigación Centrada en la Comunidad propia del enfoque Biopsicosocial.</p>
		</div>
        <input type="hidden" id="Campo_id_Tres" />
		<table class="selector">
            <tr>
                <td colspan="2"><input type="hidden" id="PlanCompromiso" />
                    <table border="0" width="100%">
                        <tr>
                            <td>
                                <div id="Compromiso_Div" style="text-align: right; font-size: 0.8 em; color: #0080FF;" >
                                    <span  style="cursor: pointer;" onclick="RefreshPlanes('RefeshCompromiso_Div','3')">Visualizar Planes Existentes.</span>
                                    <img src="../PlantrabajoDocente/img/search_plus_blue.png"  align="right" width="25" onclick="RefreshPlanes('RefeshCompromiso_Div','3')" style="cursor: pointer;" title="Visualizar Planes Existentes.">
                                    <div id="RefeshCompromiso_Div" style="display: none;"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			<?PHP $this->CajaTexto('Nombre del Proyecto ','NomProyecto_tres','70',$id_Form,'AutoCompleteTres()')?>
			<tr>
				<td class="blanco"><h2>Tipo:</h2></td>
				<td class="blanco">
					<select id="TipoProyectoCompromiso" name="TipoProyectoCompromiso" class="Plan" onchange="CajaVer()">
						<option value="-1"></option>
						<option value="1">Prácticas (Empresariales, clínicas, sociales, internados, etc.)</option>
                        <option value="2">Consultorías</option>
						<option value="3">Educación Continuada</option>
					</select>
				</td>
			 </tr>
			 <tr id="Tr_CualType" style="visibility:collapse">
				<td class="blanco"><strong>Cual:</strong></td>
				<td class="blanco">
					<input type="text"  id="CualType" name="CualType" style="text-align:center; border:#88AB0C solid 1px;" size=""  onclick="FormatBox('CualType','<?PHP echo $id_Form?>')"/>
				</td>
			 </tr>
			 <?PHP $this->CajaTexto('Total horas semanales de dedicacion al proyecto','Thsemana_Tres','5',$id_Form,'return isNumberKey(event)','UpdateHoras()')?>
			</table>
		<br />
        <div id="Acci_TempTres" class="planes" style="display: none;">
			<h2>Plan de Trabajo</h2>
			<div id="AcionesTempTres"></div>
		</div>
		<br />
		<div id="CaragarEvidenciaTempTres" style="display:none"></div> 
		<br />
		<div id="TablaDinamic_Tres">
		<?PHP $this->TablaDianmica($Name_1,$Accion_1,'','3','CadenaTableTres',$id_docente,$Disable)?>
		</div>
		<br />
		<?PHP $this->Autoevaluacion($Name_2,$Accion_2)?>
		<br />
		<?PHP $this->PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4)?>
		<table width="100%" align="center" border="0">
			<tr>
				<td align="right" class="blanco">
					<input type="button" class="first" id="TresSave" name="TresSave" style="font-size:24px;<?PHP echo $Disable?>" value="Guardar" onclick="Guardar('TresSave','3')" />
				</td>
			</tr>
		</table>
		<?PHP
		}
	public function TablaCuatro($id_Form,$Disable,$id_docente){
		global $userid,$db;
		
		$Name_1		= 'menuEditor13';
		$Accion_1	= 'AccionPc';
		/******************************/
		$Name_2		= 'menuEditor14';
		$Accion_2	= 'AutoPc';
		/******************************/
		$Name_3		= 'menuEditor15';
		$Accion_3	= 'ConsolidadoPc';
		/****************************/
		$Name_4		= 'menuEditor16';
		$Accion_4	= 'MejoraPc';
		
		$Porcentaje	= 'PorcentajeCuatro';
		?>

		<div class="orientacion">
			<img src="img/orientacion-admin.png" />
			<p>La Gesti&oacute;n acad&eacute;mico administrativa se orienta principalmente a la organizaci&oacute;n acad&eacute;mica, al desarrollo de procesos administrativos, a la gesti&oacute;n de recursos humanos y financieros y la mejora de la administraci&oacute;n de la informaci&oacute;n institucional</p>
		</div>
        <input type="hidden" id="Campo_Cuatro_id" />
		<table class="selector">
            <tr>
                <td colspan="2"><input type="hidden" id="PlanGestion" />
                    <table border="0" width="100%">
                        <tr>
                            <td>
                                <div id="Gestion_Div" style="text-align: right; font-size: 0.8 em; color: #0080FF;" >
                                    <span  style="cursor: pointer;" onclick="RefreshPlanes('RefeshGestion_Div','4')">Visualizar Planes Existentes.</span>
                                    <img src="../PlantrabajoDocente/img/search_plus_blue.png"  align="right" width="25" onclick="RefreshPlanes('RefeshGestion_Div','4')" style="cursor: pointer;" title="Visualizar Planes Existentes.">
                                    <div id="RefeshGestion_Div" style="display: none;"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			<?PHP $this->CajaTexto('Actividades de gestión académica','AADesarrolladas','70',$id_Form,'AutoCompletDesarrollo()')?>
			<?PHP $this->CajaTexto('Total Horas semanales','Thsemana_Des','5',$id_Form,'return isNumberKey(event)','UpdateHoras()')?>
		</table>
        <br />
        <div id="Acci_TempCuatro" class="planes" style="display: none;">
			<h2>Plan de Trabajo</h2>
			<div id="AcionesTempCuatro"></div>
		</div>
		<br />
		<div id="CaragarEvidenciaTempCuatro" style="display:none"></div> 
		<br />
		<div id="TablaDinamic_Cuatro">
		<?PHP $this->TablaDianmica($Name_1,$Accion_1,'','4','CadenaTableCuatro',$id_docente,$Disable)?>
		</div>
		<br />
		<?PHP $this->Autoevaluacion($Name_2,$Accion_2,$Porcentaje,'')?>
		<br />
		<?PHP $this->PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4)?>
		<table width="100%" align="center" border="0">
			<tr>
				<td align="right" class="blanco">
					<input type="button" class="first" id="CuatroSave" name="CuatroSave" style="font-size:24px;<?PHP echo $Disable?>" value="Guardar" onclick="Guardar('CuatroSave','4')" />
				</td>
			</tr>
		</table>
		<?PHP
		}
	public function CajaTexto($LabelTitulo,$Campo,$size,$id_Form,$OnkeyPress='',$onchange=''){
		global $db,$userid;
		?>
		<tr>
			<td valign="top"><h2><?PHP echo $LabelTitulo?></h2></td>
			<td valign="top" colspan="4"><input type="text" autocomplete="off"  id="<?PHP echo $Campo?>" name="<?PHP echo $Campo?>" size="<?PHP echo $size?>"  onclick="FormatBox('<?PHP echo $Campo?>','<?PHP echo $id_Form?>')" onkeypress="<?PHP echo $OnkeyPress; ?>" onchange="<?PHP echo $onchange?>" /></td>
		</tr>   
		<?PHP
		}
	public function AcionesDinamic($id,$CodigoPerido){
		global $db,$userid;
		
       
        
		  echo $SQL='SELECT 

				id_accionesplandocentetemp as id,
				
				descripcion 
				
				FROM accionesplandocente_temp
				
				WHERE
				
				
			
				codigoperiodo="'.$CodigoPerido.'"
				AND
				codigoestado=100
                AND
                id_accionesplandocentetemp="'.$id.'"
                ';
				
			if($ListaAcion=&$db->Execute($SQL)===false){
					echo 'Error en El SQl .....<br><br>'.$SQL;
					die;
				}	
		
			if(!$ListaAcion->EOF){
				$i=1
				?>
				<ul>
				<?PHP
				while(!$ListaAcion->EOF){
					/********************************************/
					$Text	 = substr($ListaAcion->fields['descripcion'], 0, 100);
					?>
					<li id="Accion_<?PHP echo $i?>" style="cursor:pointer" onmouseover="Color(<?PHP echo $i?>)" onmouseout="SinColor(<?PHP echo $i?>)">
						Accion N&deg; <?PHP echo $i?><br /><?PHP echo $Text?>
					</li>
					<?PHP	
					$i++;
					/********************************************/
					$ListaAcion->MoveNext();
					}
				?>
				</ul>
                <script type="text/javascript">
                  VisualizarDos(<?php echo $id; ?>,'2','<?PHP echo $Docente_id?>');
                  $("#TablaDinamic_Dos").css("display","none");
                  //$("#Acci_Temp").css("display","none");
                 </script>
				<?PHP	
				}else{
					?>
					
					<?PHP
					}
		}	
    public function Archivos($PlanTrabajo,$index){
        global $db,$userid;
        /*******************************************************/
        
        $CodigoPeriodo	= $this->Periodo();
        //echo '<pre>';print_r($CodigoPeriodo);
        
          $SQL='SELECT 

                d.id_documento,
                a.id_archivodocumento,
                a.tipo_documento,
                a.nombre_archivo
                
                FROM 
                
                doc_evidenciaplantrabajo d INNER JOIN archivos_evidenciaplantrabajo a ON a.doc_evidenciaplantrabajo_id=d.id_documento
                
                WHERE
                
                d.codigoestado=100
                AND
                a.codigoestado=100
                AND
                d.codigoperiodo="'.$CodigoPeriodo['CodigoPeriodo'].'"
                AND
                d.plantrabajo_id="'.$PlanTrabajo.'"
                AND
                d.evidencia_index="'.$index.'"';
                
             if($Archivos=&$db->Execute($SQL)===false){
                echo 'Error en el SQl del los Archivos ...<br><br>'.$SQL;
                die;
             }
             
           ?>
           <table border="0" align="center">
                <tr>
                    <?PHP 
                    while(!$Archivos->EOF){
                        #####Office-Word.png##########pdf.png############################
                        if($Archivos->fields['tipo_documento']=='pdf'){
                            $Imagen = '../PlantrabajoDocente/img/pdf.png';
                        }else{
                             $Imagen = '../PlantrabajoDocente/img/Office-Word.png';
                        }
                        ?>
                        <td>
                            <img src="<?PHP echo $Imagen?>"  align="right" width="16" title="<?PHP echo $Archivos->fields['nombre_archivo']?>" style="cursor: pointer;">
                        </td>
                        <?PHP
                        ###########################################
                        $Archivos->MoveNext();
                    }
                    ?>
                </tr>
           </table>
           <?PHP     
        /*******************************************************/
    }    
    
   public function AcionesDinamicTres($id,$CodigoPerido){
		global $db,$userid;
		
       
        
		  $SQL='SELECT 

				id_accionesplandocentetemp as id,
				
				descripcion 
				
				FROM accionesplandocente_temp
				
				WHERE
				
				
			
				codigoperiodo="'.$CodigoPerido.'"
				AND
				codigoestado=100
                AND
                id_accionesplandocentetemp="'.$id.'"
                ';
				
			if($ListaAcion=&$db->Execute($SQL)===false){
					echo 'Error en El SQl .....<br><br>'.$SQL;
					die;
				}	
		
			if(!$ListaAcion->EOF){
				$i=1
				?>
				<ul>
				<?PHP
				while(!$ListaAcion->EOF){
					/********************************************/
					$Text	 = substr($ListaAcion->fields['descripcion'], 0, 100);
					?>
					<li id="Accion_<?PHP echo $i?>" style="cursor:pointer" onmouseover="Color(<?PHP echo $i?>)" onmouseout="SinColor(<?PHP echo $i?>)">
						Accion N&deg; <?PHP echo $i?><br /><?PHP echo $Text?>
					</li>
					<?PHP	
					$i++;
					/********************************************/
					$ListaAcion->MoveNext();
					}
				?>
				</ul>
                <script type="text/javascript">
                  VisualizarTres(<?php echo $id; ?>,'3','<?PHP echo $Docente_id?>');
                  $("#TablaDinamic_Tres").css("display","none");
                  //$("#Acci_Temp").css("display","none");
                 </script>
				<?PHP	
				}else{
					?>
					
					<?PHP
					}
		}//
       public function AcionesDinamicCuatro($id,$CodigoPerido){
		global $db,$userid;
		
       
        
		  $SQL='SELECT 

				id_accionesplandocentetemp as id,
				
				descripcion 
				
				FROM accionesplandocente_temp
				
				WHERE
				
				
			
				codigoperiodo="'.$CodigoPerido.'"
				AND
				codigoestado=100
                AND
                id_accionesplandocentetemp="'.$id.'"
                ';
				
			if($ListaAcion=&$db->Execute($SQL)===false){
					echo 'Error en El SQl .....<br><br>'.$SQL;
					die;
				}	
		
			if(!$ListaAcion->EOF){
				$i=1
				?>
				<ul>
				<?PHP
				while(!$ListaAcion->EOF){
					/********************************************/
					$Text	 = substr($ListaAcion->fields['descripcion'], 0, 100);
					?>
					<li id="Accion_<?PHP echo $i?>" style="cursor:pointer" onmouseover="Color(<?PHP echo $i?>)" onmouseout="SinColor(<?PHP echo $i?>)">
						Accion N&deg; <?PHP echo $i?><br /><?PHP echo $Text?>
					</li>
					<?PHP	
					$i++;
					/********************************************/
					$ListaAcion->MoveNext();
					}
				?>
				</ul>
                <script type="text/javascript">
                  VisualizarCuatro(<?php echo $id; ?>,'4','<?PHP echo $Docente_id?>');
                  $("#TablaDinamic_Cuatro").css("display","none");
                  //$("#Acci_Temp").css("display","none");
                 </script>
				<?PHP	
				}else{
					?>
					
					<?PHP
					}
		} 
  public function AvancesPlantrabajo($id_PlanTrabajo){
    global $db;
    
    $Codigoperiodo  = $this->Periodo();
    
    //echo '<pre>';print_r($Codigoperiodo);
    
    $SQL_Evidencia='SELECT 

                    id_evidenciaplandocente,
                    evidencia,
                    fecha
                    
                    FROM 
                    evidenciaplandocente 
                    
                    WHERE 
                    
                    id_plantrabajo="'.$id_PlanTrabajo.'"
                    AND 
                    codigoestado=100
                    AND
                    codigoperiodo="'.$Codigoperiodo['CodigoPeriodo'].'"';
                    
           if($Evidencias=&$db->Execute($SQL_Evidencia)===false){
                echo 'Error en el SQL <br><br>'.$SQL_Evidencia;
                die;
           }
         
        if(!$Evidencias->EOF){
            /*************************************************/
            ?>
            <table border="0" width="100%">
            <?PHP 
            $i=0;
               while(!$Evidencias->EOF){
                    /*********************************************/
                    $Evidencia_id   = $Evidencias->fields['id_evidenciaplandocente'];
                    $Evidencia_Text = $Evidencias->fields['evidencia'];
                    $Fecha          = $Evidencias->fields['fecha']; 
                    
                    ?>
                    <tr>
                        <td><?PHP echo $i+1;?><input type="hidden" id="id_Evidencia_<?PHP echo $i?>" value="<?PHP echo $Evidencia_id?>" /></td>
                        <td><?PHP echo $Evidencia_Text?></td>
                        <td><?PHP echo $Fecha?></td>
                        <td>
                        <?PHP 
                           $SQL_Documentos='SELECT 

                                            d.id_documento,
                                            a.id_archivodocumento,
                                            a.nombre_archivo,
                                            a.tipo_documento,
                                            a.Ubicaicion_url
                                            
                                            FROM 
                                            
                                            doc_evidenciaplantrabajo d INNER JOIN archivos_evidenciaplantrabajo a ON a.doc_evidenciaplantrabajo_id=d.id_documento
                                            
                                            WHERE 
                                            
                                            d.plantrabajo_id="'.$id_PlanTrabajo.'" 
                                            AND 
                                            d.codigoperiodo="'.$Codigoperiodo['CodigoPeriodo'].'" 
                                            AND 
                                            d.codigoestado=100
                                            AND
                                            a.codigoestado=100                                            
                                            AND
                                            d.evidencia_id="'.$Evidencia_id.'"';
                                            
                                 if($Documentos=&$db->Execute($SQL_Documentos)===false){
                                    echo 'Error en el SQL De los Documentos de las Evidencias...<br><br>'.$SQL_Documentos;
                                    die;
                                 }      
                                 
                           if(!$Documentos->EOF){
                            ?>
                            <table border="0" width="100%">
                                <tr>
                                <?PHP
                                while(!$Documentos->EOF){
                                    
                                    if($Documentos->fields['tipo_documento']=='pdf'){
                                        $Imagen = '../PlantrabajoDocente/img/pdf.png';
                                    }else{
                                         $Imagen = '../PlantrabajoDocente/img/Office-Word.png';
                                    }
                                    ?>
                                    <td>
                                        <img src="<?PHP echo $Imagen?>"  align="right" width="16" title="<?PHP echo $Documentos->fields['nombre_archivo']?>" style="cursor: pointer;">
                                    </td>
                                    <?PHP
                                    $Documentos->MoveNext();
                                }//while
                                ?>
                                </tr>
                            </table>
                            <?PHP
                           }else{
                            ?>
                            &nbsp;&nbsp;
                            <?PHP
                           }           
                        ?>
                        </td>
                    </tr>
                    <?PHP
                    $i++;
                    /*********************************************/
                    $Evidencias->MoveNext();
                }//while 
            ?>
            <input type="hidden" id="indi" value="<?PHP echo $i+1?>" />
            </table>
            <?PHP
            /*************************************************/
        }//if          
    return $i+1;
  }//public function AvancesPlantrabajo
  public function HorasPreparacioEvaluacion($NumDocumento,$CodigoPeriodo,$id_Programa,$id_Materia){
    global $db;
    
    $C_Materias  = explode('-',$id_Materia);
    
    $SQL_hora='SELECT 

                a.hora,
                a.hora_trabajo,
                a.id_accionesplandocentetemp as id
                
                FROM 
                
                accionesplandocente_temp a INNER JOIN docente d ON d.iddocente=a.docente_id AND d.numerodocumento="'.$NumDocumento.'"
                
                WHERE
                
                a.carrera_id="'.$id_Programa.'"
                AND
                a.materia_id="'.$C_Materias[0].'"
                AND
                a.codigoestado=100
                AND
                a.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                a.grupo_id="'.$C_Materias[1].'"';
                
           if($Hora=&$db->Execute($SQL_hora)===false){
                echo 'Error en el SQL hora ...<br><br>'.$SQL_hora;
                die;
           }     
             
           $C_Hora  = array();  
                
           if(!$Hora->EOF){

                $C_Hora['hora']=$Hora->fields['hora'];
                $C_Hora['Disabled']='disabled="disabled"';
                $C_Hora['horaTrabajo']=$Hora->fields['hora_trabajo'];
                $C_Hora['id_plan']=$Hora->fields['id'];
                
           }else{
                $C_Hora['hora']='0';
                $C_Hora['Disabled']='';
                $C_Hora['horaTrabajo']='0';
                $C_Hora['id_plan']='';
           }  
           
        return $C_Hora;      
  }//public function HorasPreparacioEvaluacion  
  public function PlanesTrabjoView($Docente_id,$Vocacion,$C_Periodo){
    global $db;
    
    //$C_Periodo  = $this->Periodo();
    
    $SQL_Planes='SELECT 

                        id_plandocente,
                        plantrabajo_id,
                        horas,
                        autoevaluacion,
                        porcentaje,
                        consolidacion,
                        mejora,
                        proyecto_nom,
                        tipo
                
                FROM 
                
                        plandocente 
                
                WHERE
                
                        id_docente="'.$Docente_id.'"
                        AND
                        id_vocacion="'.$Vocacion.'"
                        AND
                        codigoestado=100
                        AND
                        codigoperiodo="'.$C_Periodo.'"';
                        
             if($PlanesTrabajo=&$db->Execute($SQL_Planes)===false){
                echo 'Error en el SQL de los planes de trabajo....<br><br>'.$SQL_Planes;
                die;
             } 
             
        if(!$PlanesTrabajo->EOF){
            ?>
            <ul>
                <?PHP
                $i=0;
                while(!$PlanesTrabajo->EOF){
                    /*******************************************/
                    ?>
                    <li id="Plan_<?PHP echo $i?>" style="cursor: pointer;" onmouseover="ColorDinamic(<?PHP echo $i?>,'Plan_')" onmouseout="SinColorDinamic(<?PHP echo $i?>,'Plan_','<?PHP echo $Vocacion?>')" onclick="CargarPlanDinamic('<?PHP echo $PlanesTrabajo->fields['id_plandocente']?>','<?PHP echo $Vocacion?>')"><?PHP echo $PlanesTrabajo->fields['proyecto_nom']?></li>
                    <?PHP
                    /*******************************************/
                    $i++;
                    $PlanesTrabajo->MoveNext();
                }
                ?>
            </ul>
            <?PHP
        }                     
    
  }//public function PlanesTrabjoView    
  public function DisplaDecanos(){
    global $db,$userid;
    
    
    
  }/*public function DisplaDecanos*/	 	
}//Class
 
?>
