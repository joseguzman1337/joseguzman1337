<?PHP
class PlanTrabjoDocente{
	public function Principal($id_docente){
		global $db,$userid;
		$id_docente	= 1340;
		$CodigoPeriodo	= $this->Periodo();
		$D_Docente	= $this->DatosDocente($id_docente);
		?>

		<!-- pasar a head -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:700,700italic,300,300italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,400,400italic' rel='stylesheet' type='text/css'>

<div id="encabezado">
	<div class="cajon">
		<img id="logo" src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png" />
		<h1 id="documento">Política de Planeación y Calidad del Talento Humano Académico</h1>
	</div>
</div>
<div id="cuerpo">
	<div class="cajon">
		<?PHP
		$this->TablaDatos($D_Docente);
		?>
	</div>
</div>


        <div title="" style="width:auto;" align="center">
        <fieldset style="width:95%; text-align:center" class="Curvas" >
        	<legend style="margin-left:2%">La Vocación Académica</legend>
        	<p align="justify" class="Margen">
            	La Vocación Académica es el elemento que distingue a la Comunidad Universitaria. La Universidad El Bosque se encuentra comprometida en generar las condiciones que permitan la consolidación de ésta comunidad.<br /><br />El académico desarrolla su vocación académica en cuatro posibles orientaciones, complementarias y no excluyentes. Son ellas:<br /><br />
             <div align="left">   
                <ul>
                	<li>La Vocación de la Enseñanza-Aprendizaje</li>
                    <li>La Vocación del Descubrimiento</li>
                    <li>La Vocación del Compromiso</li>
                    <li>La Vocación de la Integración</li>
                </ul> 
             </div>
            </p>
        </fieldset>
        </div>    
        <div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="#tabs-1">VOCACIÓN ENSEÑANZA-APRENDIZAJE</a></li>
					<li><a href="#tabs-2">VOCACIÓN DESCUBRIMIENTO </a></li>
                    <li><a href="#tabs-3">VOCACIÓN COMPROMISO</a></li>
                    <li><a href="#tabs-4">ACTIVIDADES DE ADMINISTRACIÓN ACADÉMICA </a></li>
				</ul>
         	<div id="tabs-1">
            	<form id="TabUno" name="TabUno">
            	<?PHP 
					$this->PrimeraTabla($CodigoPeriodo['CodigoPeriodo'],$D_Docente['Documento'],'TabUno');
				?>
                </form>
            </div>
            <div id="tabs-2">
            	<form id="TabDos" name="TabDos">
            	<?PHP 
					$this->TablaSegunda('TabDos');
				?>
                </form>
            </div>
            <div id="tabs-3">
            	<form id="TabTres" name="TabTres">
            	<?PHP 
					$this->TablaTres('TabTres');
				?>
                </form>
            </div>
            <div id="tabs-4">
            	<form id="TabCua" name="TabCua">
            	<?PHP 
					$this->TablaCuatro('TabCua');
				?>
                </form>
            </div>
        </div>        

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
	public function TablaDatos($D_Docente){
		
		$CodigoPeriodo	= $this->Periodo();
		?>
        <br /><br />
        <div align="center">
        <fieldset style="width:95%; text-align:center" class="Curvas" >
        	<legend style="margin-left:2%">Información del Docente</legend>
            <table border="0" cellpadding="0" cellspacing="0" align="center" width="90%">
                <thead>
                    <tr>
                        <td align="left" class="blanco"><strong>Nombres:</strong></td>
                        <td align="left" class="blanco"><?PHP echo $D_Docente['Nombres']?></td>
                    </tr>
                    <tr>    
                        <td align="left" class="blanco"><strong>Apellidos:</strong></td>
                        <td align="left" class="blanco"><?PHP echo $D_Docente['Apellidos']?></td>
                    </tr>
                    <tr>    
                        <td align="left" class="blanco"><strong>N&deg; Documento:</strong></td>
                        <td align="left" class="blanco"><?PHP echo $D_Docente['Documento']?><input type="hidden" id="NumDocumento" value="<?PHP echo $D_Docente['Documento']?>" /></td>
                    </tr>    
                    <tr>
                        <td align="left" class="blanco"><strong>Tipo Documento:</strong></td>
                        <td class="blanco" align="left"><?PHP echo $D_Docente['TipoDocumento']?></td>
                    </tr>
                    <tr>
                        <td align="left" class="blanco"><strong>Periodo Academico:</strong></td>
                        <td align="left" class="blanco"><?PHP echo $CodigoPeriodo['Formato']?><input type="hidden" id="Periodo_id" value="<?PHP echo $CodigoPeriodo['CodigoPeriodo']?>" /></td>
                    </tr>
                </thead>
            </table>
       </fieldset>
       </div>
       <br /> 
        <?PHP
		}//public function TablaDatos	
	public function DatosMateria($NumDocumento,$CodigoPeriodo,$CodigoPrograma,$tipo,$CodigoMateria=''){
		global $db,$userid;
		
		if($tipo==1){
				$GroupBy	= 'GROUP BY  g.codigomateria';
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
											m.codigomateria as id, 
											m.nombremateria as Nombre, 
											m.numerohorassemanales as HorasSemana,
											m.codigocarrera 
								
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
												
								
			if($tipo==0){
				
				$Grupos		= $this->NumGrupo($NumDocumento,$CodigoPeriodo,$CodigoPrograma,$CodigoMateria);
								
				$Materia	= array();
				
				$Materia['codigomateria']			= $DatosMateria->fields['codigomateria'];
				$Materia['Matriculados']			= $DatosMateria->fields['Matriculados'];
				$Materia['codigomateria']			= $DatosMateria->fields['id'];
				$Materia['nombremateria']			= $DatosMateria->fields['Nombre'];
				$Materia['HorasSemana']				= $DatosMateria->fields['HorasSemana'];
				$Materia['codigocarrera']			= $DatosMateria->fields['codigocarrera'];	
				$Materia['NumGrupos']				= $Grupos;
				$Materia['HorasTrabjo']				= $HorasT->fields['horastrabajoindependiente'];
				$Materia['Semestre']				= $Semestre->fields['Semestre'];
				return $Materia;
				
			}else{
				
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
				
				return $Carrera;			
							
		}//public function DatosCarrera
	public function Periodo(){
		global $db,$userid;
		
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
		
		//echo '<pre>';print_r($Materia);
		?>
        <!--<fieldset style="width:100%; text-align:center" class="Curvas" >-->
            <table border="0" width="100%" align="center">
                <tr>
                    <td class="blanco"><strong>N° Grupos a Cargo</strong></td>
                    <td class="blanco"><?PHP echo $Materia['NumGrupos']?></td>
                    <td class="blanco" colspan="2">&nbsp;</td>
                    <td class="blanco"><strong>N° Estudiantes</strong></td>
                    <td class="blanco"><?PHP echo $Materia['Matriculados']?></td>
                </tr>
                <tr>
                    <td class="blanco"><strong>Horas presenciales / semana</strong></td>
                    <td class="blanco"><?PHP echo $Materia['HorasSemana']?></td>
                    <td class="blanco" colspan="2">&nbsp;</td>
                    <td class="blanco"><strong>Horas preparación y/o evaluación</strong></td>
                    <td class="blanco"><?PHP echo $Materia['HorasTrabjo']?></td>
                </tr>
                <tr>
                    <td class="blanco"><strong>Total Horas Semanal</strong></td>
                    <td class="blanco">&nbsp;</td>
                    <td class="blanco" colspan="2">&nbsp;</td>
                    <td class="blanco"><strong>Semestre</strong></td>
                    <td class="blanco"><?PHP echo $Materia['Semestre']?></td>
                </tr>
            </table>
        <!--</fieldset>-->
		<?PHP
		}//public function InfoMaterias	
	public function Tablelabel(){
		?>
        <!--<fieldset style="width:100%; text-align:center" class="Curvas" >-->
            <table border="0" width="100%">
                <tr>
                    <td class="blanco"><strong>N° Grupos a Cargo</strong></td>
                    <td class="blanco">&nbsp;</td>
                    <td class="blanco">&nbsp;</td>
                    <td class="blanco"><strong>N° Estudiantes</strong></td>
                    <td class="blanco">&nbsp;</td>
                </tr>
                <tr>
                    <td class="blanco"><strong>Horas presenciales / semana</strong></td>
                    <td class="blanco">&nbsp;</td>
                    <td class="blanco">&nbsp;</td>
                    <td class="blanco"><strong>Horas preparación y/o evaluación</strong></td>
                    <td class="blanco">&nbsp;</td>
                </tr>
                <tr>
                    <td class="blanco"><strong>Total Horas Semanal</strong></td>
                    <td class="blanco">&nbsp;</td>
                    <td class="blanco">&nbsp;</td>
                    <td class="blanco"><strong>Semestre</strong></td>
                    <td class="blanco">&nbsp;</td>
                </tr>
            </table>
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
	public function PrimeraTabla($CodigoPeriodo,$CedulaDoccente,$Form){
		global $db,$userid;
		
		$Facultad		= $this->DatosFaculta($CedulaDoccente,$CodigoPeriodo);
		
		$Name_1		= 'menuEditor1';
		$Accion_1	= 'Accion';
		/******************************/
		$Name_2		= 'menuEditor2';
		$Accion_2	= 'Auto';
		/******************************/
		$Name_3		= 'menuEditor3';
		$Accion_3	= 'Consolidado';
		/****************************/
		$Name_4		= 'menuEditor4';
		$Accion_4	= 'Mejora';
		
		$Porcentaje	= 'PorcentajeUno';
		?>
        
        <div align="left">
            <fieldset style="width:100%" class="Curvas" >
            <br />
            <div align="justify">
                    <h4>VOCACIÓN ENSEÑANZA-APRENDIZAJE</h4>
                    <p align="justify" class="Margen">
                    La Vocación de la Enseñanza-Aprendizaje se orienta a la actividad formativa con un enfoque centrado en el aprendizaje y en el estudiante en contraste con los enfoques centrados en la enseñanza y transmisión de contenidos desde el profesor. El carácter Académico se sustenta en la actitud de “pensamiento sobre la actividad docente misma y la evidencia del aprendizaje del estudiante como problemas a ser investigados, analizados, representados y debatidos” y la evidencia de éste pensamiento en productos académicos y una mejora continua y sustentada en el quehacer docente.
                    </p>
            </div>       
            <hr style=" width:95%" class="Plan" />
            <br />
                <table border="0" align="left" width="100%">
                	<thead>
                        <tr>
                            <th class="blanco">FACULTAD</th>
                            <th class="blanco">PROGRAMA ACADEMICO</th>
                            <th class="blanco">Nombre de la Asignatura</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                             <td class="blanco"><?PHP $this->CajaSelect($Facultad,'Facultad_id','Programa')?></td>
                            <td class="blanco"><div id="Div_Programa"><select disabled="disabled"></select></div></td>
                            <td class="blanco"><div id="DivMateria"><select disabled="disabled"></select></div></td>
                        </tr>
                        <tr>
                        	<td colspan="3" class="blanco">
                            	<div id="Datos">
									<?PHP $this->Tablelabel()?>
                                </div> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>
        <br />
        <fieldset style="width:100%;display:none" id="Acci_Temp" class="Curvas" >
        	<legend style="margin-left:2%">Plane de Trabajo</legend>
            <table width="100%" align="center">
                <tr>
                   <td class="blanco">
                    <div id="AcionesTemp" align="left" style="overflow:scroll;width:100%; height:200; overflow-x:hidden;"></div>
                   </td>
                </tr>
            </table>
        </fieldset>
        <br />
        <div id="CaragarEvidenciaTemp" style="display:none"></div>
        <br />
        <div id="TablaDinamic">
        <?PHP $this->TablaDianmica($Name_1,$Accion_1,$Form,'1','CadenaTableUno')?>
        </div>
        <?PHP $this->Autoevaluacion($Name_2,$Accion_2,$Porcentaje)?>
        <br />
        <?PHP $this->PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4)?>
        <table width="100%" align="center" border="0">
            <tr>
                <td align="right" class="blanco">
                    <input type="button" class="first" id="PimeraSave" name="PimeraSave" style="font-size:24px" value="Guardar" onclick="Guardar('PimeraSave','1')" />
                </td>
            </tr>
        </table>
        <?PHP
		}
	public function TextArea($Div,$Name,$width){//792
		?>
        <div id="<?PHP echo $Div?>" style="width:<?PHP echo $width?>;"></div>
        <textarea id="<?PHP echo $Name?>" name="<?PHP echo $Name?>" rows="30" cols="90" placeholder="" class="grid-8-12" style="width:<?PHP echo $width?>; height: 360px;"></textarea>
        <script>
         bkLib.onDomLoaded(function() {
	
		var myNicEditor = new nicEditor({fullPanel : true,iconsPath : '../../serviciosacademicos/mgi/images/nicEditorIcons.gif'});
		myNicEditor.setPanel('<?PHP echo $Div?>');
		myNicEditor.addInstance('<?PHP echo $Name?>');    
	 
	 	});
        </script>
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
	public function Evidencias(){
		?>
        <tr>
        	<td colspan="5" class="blanco">
            <div align="justify">
            	<h3 align="center">PORTAFOLIO DE SEGUIMIENTO</h3>
                <p align="justify" class="Margen">
                <strong>Portafolio de seguimiento.</strong> El portafolio puede definirse como una recopilación de evidencias, entendidas como el conjunto de pruebas que demuestran que se ha cubierto satisfactoriamente un requerimiento, una norma o parámetro de desempeño, una competencia o un resultado de aprendizaje. El portafolio no es una simple y exhaustiva recopilación de los documentos y los materiales que afectan a la actuación educativa, sino una información seleccionada sobre las actividades relacionadas en el plan de trabajo y una sólida evidencia de su efectividad. El Portafolio de Seguimiento permite, organizadamente, registrar <strong>durante semestre</strong>, las evidencias que usted ha seleccionado como aquellas experiencias significativas de ejecución de su desempeño, por lo tanto a través de la ejecución de sus actividades, por favor registre las evidencias describiendo brevemente en que consistió cada una de ellas y la fecha de elaboración de la misma.
                </p>
            </div>
            <hr />
            	<table border="0" align="center" width="100%" id="Evidencias_Table">
                	<thead>
                    	<tr>
                        	<th class="blanco">Acciones  del Plan de Trabajo&nbsp;&nbsp;<span style="color:#FF0000">*</span></th>
                            <th class="blanco">Evidencias &nbsp;&nbsp;<span style="color:#FF0000">*</span></th>
                            <th class="blanco">Fecha&nbsp;&nbsp;<span style="color:#FF0000">*</span></th>
                            <th class="blanco"><img src="../../serviciosacademicos/mgi/images/add.png" title="Adicionar una Celda Nueva." onclick="AgregarFila()" width="30" /></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<tr align="center"><?PHP $this->CamposEvidencia(1)?></tr>
                    </tbody>
                </table>
                <input type="hidden" id="Index" name="Index" value="1" />
            <hr />    
            </td>
        </tr>
        <?PHP
		}
	public function CamposEvidencia($i){
		?>
        <td class="blanco"><input type="text" id="Evidencia_<?PHP echo $i?>" name="Evidencia_<?PHP echo $i?>" style="text-align:center" autocomplete="off" onclick="FormatBoxEvidencia('Evidencia_<?PHP echo $i?>')"  /></td>
        <td class="blanco"><input type="text" id="Descrip_<?PHP echo $i?>" name="Descrip_<?PHP echo $i?>" style="text-align:center" autocomplete="off" onclick="FormatBoxEvidencia('Descrip_<?PHP echo $i?>')"  /></td>
        <td class="blanco"><input type="text" name="Fecha_<?PHP echo $i?>" size="12" id="Fecha_<?PHP echo $i?>" title="" maxlength="12" tabindex="7" placeholder="" autocomplete="off" value="" readonly /></td>
        
         <script>
        $(document).ready(function() {
		
 					$("#Fecha_<?PHP echo $i?>").datepicker({ 
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
	public function Autoevaluacion($Name_2,$Accion_2,$Porcentaje){
		?>
        <fieldset style="width:100%" class="Curvas" >
            <div align="justify">
            	<h3 align="center">AUTOEVALUACIÓN</h3>
                <p align="justify" class="Margen">
                <strong>1.Autoevaluación.</strong> El plan de trabajo es una herramienta donde no sólo se programan las actividades a desarrollar, sino que en él también se consignan las acciones de autoevaluación que el académico realiza con el reconocimiento del cumplimiento de las actividades planeadas, las oportunidades de consolidación y mejora y la manera como fueron realizadas. Así mismo, la percepción de los estudiantes en relación con el desempeño del académico. Se espera que el académico lleve a cabo esta autoevaluación con todos los insumos que recibe de sus estudiantes y de la dirección de la facultad o programa. Está diseñado para que el académico se retroalimente de estos insumos y adquiera compromisos consigo mismo y con la comunidad académica frente al desarrollo de sus competencias como académico, y a su desempeño de acuerdo a las diferentes vocaciones.<br /><br />
Al <strong>cierre del semestre</strong> se debe consignar la autoevaluación que el académico realiza con el reconocimiento del cumplimiento de: las actividades planeadas, las metas y logros, las evidenciadas recopiladas y las oportunidades de consolidación y mejora. Así mismo, tendrá en cuenta la percepción de los estudiantes en relación con el desempeño del académico y de la dirección de la facultad o programa. Está diseñado para que el profesor se retroalimente de estos insumos y adquiera compromisos consigo mismo y con la comunidad académica frente al desarrollo de sus competencias como académico, y a su desempeño.
                </p>
            </div>
            <table align="center" width="100%" border="0">
                <tr>
                    <td align="center" class="blanco">
						<?PHP $this->TextArea($Name_2,$Accion_2,'792px')?>
                    </td>
                </tr>
                <tr>
                	<td align="center" class="blanco">
                    	<table border="0" align="center">
                        	<tr>
                            	<td class="blanco" align="right"><strong>Porcentaje de Cumplimiento</strong></td>
                            </tr>
                            <tr>    
                    			<td class="blanco" align="center">
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
                                </td><!--<input type="text" id="Porcentaje" name="Porcentaje" style="text-align:center" autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="3" onclick="FormatBoxEvidencia('Porcentaje')" placeholder="Porcentaje de Cumplimiento"  />-->
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?PHP
		}	
	public function PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4){
		?>
        <fieldset style="width:100%" class="Curvas" >
            <div align="justify">
            	<h3 align="center">Plan de Mejora</h3>
                <p align="justify" class="Margen">
                A partir de los resultados de la evaluación realizada se identificarán las oportunidades de consolidación y mejora, en el ejercicio de las competencias básicas y vocaciones académicas, con el fin de diseñar e implementar estrategias individuales y grupales que permitan atender aquellos aspectos identificados como débiles. El proceso podría contemplar a nivel individual llamado de atención sobre: sus relaciones personales, recomendación de cursos de actualización o complementación, trabajo en equipo, perfeccionamiento de sus prácticas docentes. A nivel grupal pueden incluirse: cursos de formación a nivel disciplinar, pedagógico o investigación, actividades de autoformación, entre otras.<br /><br />
                A partir de los resultados de la evaluación realizada se identificarán las oportunidades de consolidación y mejora, con el fin de diseñar e implementar estrategias individuales y grupales que le permitan atender aquellos aspectos identificados como débiles el siguiente periodo académico.
                </p>
            </div>
            <table border="0" align="center" width="100%">
                <tr>
                    <td class="blanco" align="center">
                    	<strong>Oportunidades de Consolidación </strong>&nbsp;&nbsp;<span style="color:#FF0000">*</span>
                    </td>
                    <td class="blanco" align="center">
                    	<strong>Oportunidades de Mejora</strong>&nbsp;&nbsp;<span style="color:#FF0000">*</span>
                    </td>
                </tr> 
                <tr>
                    <td class="blanco">
						<?PHP $this->TextArea($Name_3,$Accion_3,'600px')?>
                    </td>
                    <td class="blanco">
						<?PHP $this->TextArea($Name_4,$Accion_4,'600px')?>
                   </td>
                </tr>
            </table>
        </fieldset>
        <?PHP
		}
	public function Acciones($Name_1,$Accion_1){
		?>
        <table align="center">
            <tr>
                <td align="center" class="blanco">
					<?PHP $this->TextArea($Name_1,$Accion_1,'792px')?>
                </td>
            </tr>
        </table>
        <?PHP
		}
	public function AccionesExistentes($Facultad_id,$Carrera_id,$Materia_id,$Periodo_id,$NameHidden){
		global $db,$userid;
		
		  $SQL='SELECT 
				
				id_accionesplandocentetemp AS id,
				descripcion
				
				FROM 
				
				accionesplandocente_temp
				
				WHERE
				
				codigoestado=100
				AND
				userid="'.$userid.'"
				AND
				facultad_id="'.$Facultad_id.'"
				AND
				carrera_id="'.$Carrera_id.'"
				AND
				materia_id="'.$Materia_id.'"
				AND
				codigoperiodo="'.$Periodo_id.'"';
				
			if($AcionesTemp=&$db->Execute($SQL)===false){
					echo 'Error en el SQL de Las Acciones Temporales.....<br>'.$SQL;
					die;
				}	
		
		if(!$AcionesTemp->EOF){
			?>
         <!---->   
               <ul>
            <?PHP
            $i	= 1;
			
			$Cadena_id	= '';
            while(!$AcionesTemp->EOF){
                /*********************************************/
                $Text	 = substr($AcionesTemp->fields['descripcion'], 0, 100);
                ?>
                <li id="Accion_<?PHP echo $i?>" style="cursor:pointer" onmouseover="Color(<?PHP echo $i?>)" onmouseout="SinColor(<?PHP echo $i?>)" onclick="Visualizar(<?PHP echo $AcionesTemp->fields['id']?>,'<?PHP echo $i?>')">
                    Accion N&deg; <?PHP echo $i?><br /><?PHP echo $Text?>
                </li>
                <?PHP	
				
				$Cadena_id	=	$Cadena_id.'::'.$AcionesTemp->fields['id'];
                /*********************************************/
                $i++;
                $AcionesTemp->MoveNext();
                }
            ?>
               </ul>
               
               <input type="text" id="<?PHP echo $NameHidden?>" name="<?PHP echo $NameHidden?>" value="<?PHP echo $Cadena_id?>" />
            <?PHP	
			}else{
		
		?>
        <table>
            <tr>
                <td align="center" class="blanco">
                    <span style="color:#999">No Hay Acciones Registradas..</span>
                </td>
            </tr>
        </table>
        <?PHP
			}
		}								
	public function TablaDianmica($Name_1,$Accion_1,$Form,$op,$NameHidden){
		global $db,$userid;
		?>
        <fieldset style="width:100%" class="Curvas" >
            <div align="justify">
               <h3 align="center">PLAN DE TRABAJO</h3>
               <p align="justify" class="Margen">
El <strong>plan de trabajo </strong>orienta la acción del académico de acuerdo a la vocación académica. Propone metas precisas y logros esperados por parte de los académicos que sean susceptibles de ser mensurados, controlados, seguidos y evaluados, lo que significa que es dinámico y susceptible de ajustes. <strong>Al iniciar el Periodo académico </strong>en el plan de trabajo se deben describir las acciones, metas precisas y logros esperados que usted espera desarrollar alineados al Plan de Desarrollo Institucional y Plan Desarrollo Facultad, y al propio plan de Mejoramiento identificado en el periodo académico inmediatamente anterior por usted. A continuación en el espacio en blanco por favor describa las acciones a emprender para el periodo académico
                </p>
            </div>
            <table border="0" align="center" width="100%">
                <tr>
                    <td class="blanco">
                        <div id="Aciones"><?PHP $this->Acciones($Name_1,$Accion_1)?></div>
                    </td>
                </tr>
                <tr>
                    <td class="blanco">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" class="blanco"><button type="button" id="save" name="save" class="first" title="Guardar Acion" style="font-size:18px" onclick="SaveTemp(<?PHP echo $op?>,'<?PHP echo $NameHidden?>')">Guardar&nbsp;&nbsp;&nbsp;<img src="../mgi/images/SaveNew.png" width="20" /></button></td>
                </tr>	
            </table>
        </fieldset>
        <?PHP
		}	
	public function VisualizarTemp($id,$i){
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
       
        <fieldset style="width:100%" class="Curvas" >
         <img src="../mgi/images/Close_Box_Red.png"  align="right" width="16" onClick="Close()" style="cursor:pointer">
        	<br />
           <table border="0" align="center" width="100%">
                <tr>
                    <td class="blanco">
                    	<fieldset style="width:100%; text-align:justify; border:#88AB0C solid 1px">
                        <legend>Accion <?PHP echo $i?></legend>	
                         <div id="ContenedorText" align="justify" style="width:100%">
							<?PHP echo $VisualizaTemp->fields['descripcion']?>
                        </div>
                        </fieldset>
                    </td>
                </tr>
                <?PHP $this->Evidencias()?>
                <tr>
                    <td class="blanco">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" class="blanco"><button type="button" id="save" name="save" class="first" title="Guardar Acion" style="font-size:18px" onclick="EvidenciaSaveTemp()">Guardar&nbsp;&nbsp;&nbsp;<img src="../mgi/images/SaveNew.png" width="20" /></button></td>
                </tr>	
            </table> 
        </fieldset>
        <?PHP
		}	
	public function TablaSegunda($id_Form){
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
        <br />
        <fieldset style="width:100%;" id="Acci_Temp" class="Curvas" >
       		<br />
            <div align="justify">
                <h4>VOCACIÓN DESCUBIRMIENTO</h4>
                    <p align="justify" class="Margen">
                    La Vocación del Descubrimiento se concentra en la generación y desarrollo de conocimiento y la innovación. Se orienta bien en la disciplina particular, en el quehacer de los procesos de enseñanza aprendizaje o en los procesos de transferencia de conocimiento. Sustenta su carácter Académico en la reflexión permanente sobre la propia actividad investigativa y su impacto en los procesos formativos y sobre el entorno.
                    </p>
             </div>
             <hr style=" width:95%" class="Plan" />
            <br />
            <input id="id_CampoDos" type="text"  />
            <table width="100%" align="center">
            	 <?PHP $this->CajaTexto('Nombre del Proyecto de Investigación','NomProyecto','70',$id_Form,'AutoCompleteProyecto')?>
                 <tr>
                 	<td class="blanco"><strong>Tipo:</strong></td>
                    <td class="blanco">
                    	<select id="TipoProyectoInv" name="TipoProyectoInv" class="Plan" onchange="OtroType()">
                        	<option value="-1"></option>
                            <option value="1">Proyectos de Investigación y Desarrollo</option>
                            <option value="2">Trabajo de grado y Tesis</option>
                            <option value="3">Publicación</option>
                            <option value="4">Productos</option>
                            <option value="5">Otro</option>
                        </select>
                    </td>
                 </tr>
                 <tr id="Tr_OtroType" style="visibility:collapse">
                 	<td class="blanco"><strong>Cual:</strong></td>
                    <td class="blanco">
                    	<input type="text"  id="OtroType" name="OtroType" style="text-align:center; border:#88AB0C solid 1px;" size=""  onclick="FormatBox('OtroType','<?PHP echo $id_Form?>')"/>
                    </td>
                 </tr>
                 <?PHP $this->CajaTexto('Total horas semanales de dedicacion','Thsemana','5',$id_Form)?>
            </table>
        </fieldset>
        <br />
        <fieldset style="width:100%;display:none" id="Acci_TempDos" class="Curvas" >
        	<legend style="margin-left:2%">Plan de Trabajo</legend>
            <table width="100%" align="center">
                <tr>
                   <td class="blanco">
                    <div id="AcionesTempDos" align="left" style="overflow:scroll;width:100%; height:200; overflow-x:hidden;"></div>
                   </td>
                </tr>
            </table>
        </fieldset>
        <br />
        <div id="CaragarEvidenciaTempDos" style="display:none"></div> 
        <br />
        <div id="TablaDinamic">
        <?PHP $this->TablaDianmica($Name_1,$Accion_1,'','2','CadenaTableDos')?>
        </div>
        <br />
        <?PHP $this->Autoevaluacion($Name_2,$Accion_2,$Porcentaje)?>
        <br />
        <?PHP $this->PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4)?>
        <table width="100%" align="center" border="0">
            <tr>
                <td align="right" class="blanco">
                    <input type="button" class="first" id="DosSave" name="DosSave" style="font-size:24px" value="Guardar" onclick="Guardar('DosSave','2')" />
                </td>
            </tr>
        </table>
        <?PHP
		}
	public function TablaTres($id_Form){
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
        
        <fieldset style="width:100%;" id="Acci_Temp" class="Curvas" >
            <br />
            <div align="justify">
                <h4>VOCACIÓN COMPROMISO</h4>
                    <p align="justify" class="Margen">
               La Vocación del Compromiso comprende la aplicación del conocimiento. Sin embargo va más allá de una aplicación de conocimiento con un flujo unidireccional (Universidad-Sociedad). También comprende el servicio, pero transforma el servicio comunitario en una actividad de construcción conjunta y no de índole asistencial. La Vocación de Compromiso enfatiza la colaboración genuina en que la enseñanza y aprendizaje ocurren en la Universidad y en la Sociedad. El carácter Académico se sustenta en la reflexión sobre las relaciones con el estudiante, con la comunidad y sienta las bases para la Investigación Centrada en la Comunidad propia del enfoque Biopsicosocial.
                </p>
            </div>
            <hr style=" width:95%" class="Plan" />
            <br />
            <table width="100%" align="center">
            	 <?PHP $this->CajaTexto('Nombre del Proyecto ','NomProyecto','70',$id_Form)?>
                 <tr>
                 	<td class="blanco"><strong>Tipo:</strong></td>
                    <td class="blanco">
                    	<select id="TipoProyectoCompromiso" name="TipoProyectoCompromiso" class="Plan" onchange="CajaVer()">
                        	<option value="-1"></option>
                            <option value="1">Prácticas Académicas</option>
                            <option value="2">Prácticas Sociales</option>
                            <option value="3">Consultorías</option>
                            <option value="4">Servicios Externos</option>
                            <option value="5">Proyección Científica y Tecnológica</option>
                            <option value="6">Otro</option>
                        </select>
                    </td>
                 </tr>
                 <tr id="Tr_CualType" style="visibility:collapse">
                 	<td class="blanco"><strong>Cual:</strong></td>
                    <td class="blanco">
                    	<input type="text"  id="CualType" name="CualType" style="text-align:center; border:#88AB0C solid 1px;" size=""  onclick="FormatBox('CualType','<?PHP echo $id_Form?>')"/>
                    </td>
                 </tr>
                 <?PHP $this->CajaTexto('Total horas semanales de dedicacion al proyecto','Thsemana','5',$id_Form)?>
            </table>
        </fieldset>
        <br />
        <div id="TablaDinamic">
        <?PHP $this->TablaDianmica($Name_1,$Accion_1,'','3','CadenaTableTres')?>
        </div>
        <br />
        <?PHP $this->Autoevaluacion($Name_2,$Accion_2)?>
        <br />
        <?PHP $this->PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4)?>
        <table width="100%" align="center" border="0">
            <tr>
                <td align="right" class="blanco">
                    <input type="button" class="first" id="TresSave" name="TresSave" style="font-size:24px" value="Guardar" onclick="Guardar('TresSave','3')" />
                </td>
            </tr>
        </table>
        <?PHP
		}
	public function TablaCuatro($id_Form){
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
        <br />
        <br />
        <fieldset style="width:100%;" id="Acci_Temp" class="Curvas" >
        	<div align="justify">
            	<p align="justify" class="Margen">
            	A continuación describa las actividades académico administrativas que usted desarrolla
                </p>
            </div>
            <hr style=" width:95%" class="Plan" />
            <br />
            <table width="100%" align="center">
            	 <?PHP $this->CajaTexto('Actividades  académico administrativas  desarrolladas','AADesarrolladas','70',$id_Form)?>
                 <?PHP $this->CajaTexto('Total Horas semanales','Thsemana','5',$id_Form)?>
            </table>
        </fieldset>
        <br />
        <div id="TablaDinamic">
        <?PHP $this->TablaDianmica($Name_1,$Accion_1,'','4','CadenaTableCuatro')?>
        </div>
        <br />
        <?PHP $this->Autoevaluacion($Name_2,$Accion_2)?>
        <br />
        <?PHP $this->PlanMejora($Name_3,$Accion_3,$Name_4,$Accion_4)?>
        <table width="100%" align="center" border="0">
            <tr>
                <td align="right" class="blanco">
                    <input type="button" class="first" id="CuatroSave" name="CuatroSave" style="font-size:24px" value="Guardar" onclick="Guardar('CuatroSave','4')" />
                </td>
            </tr>
        </table>
        <?PHP
		}
	public function CajaTexto($LabelTitulo,$Campo,$size,$id_Form,$OnkeyPress=''){
		global $db,$userid;
		?>
        <tr>
        	<td class="blanco"><strong><?PHP echo $LabelTitulo?></strong></td>
            <td class="blanco" colspan="4"><input type="text"  id="<?PHP echo $Campo?>" name="<?PHP echo $Campo?>" style="text-align:center; border:#88AB0C solid 1px;" size="<?PHP echo $size?>"  onclick="FormatBox('<?PHP echo $Campo?>','<?PHP echo $id_Form?>')" onkeypress="<?PHP echo $OnkeyPress?>()"/></td>
        </tr>   
        <?PHP
		}
	public function AcionesDinamic($id,$CodigoPerido){
		global $db,$userid;
		
		  $SQL='SELECT 

				id_accionesplandocentetemp as id,
				id_plandocente,
				descripcion 
				
				FROM accionesplandocente_temp
				
				WHERE
				
				id_plandocente="'.$id.'"
				AND
				codigoperiodo="'.$CodigoPerido.'"
				AND
				codigoestado=100';
				
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
                <?PHP	
				}else{
					?>
                    <table>
                        <tr>
                            <td align="center" class="blanco">
                                <span style="color:#999">No Hay Acciones Registradas..</span>
                            </td>
                        </tr>
                    </table>
                    <?PHP
					}
		}		
	}//Class
?>
