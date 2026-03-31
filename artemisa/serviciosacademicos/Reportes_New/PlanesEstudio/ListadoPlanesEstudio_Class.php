<?PHP 
class ListadoPlanesEstudio{
	
	 public function Principal($CodigoCarrera){
		global $userid,$db;
		
		#$CodigoCarrera = '';
		?>
        <fieldset>
        <legend>Listado Planes Estudio</legend>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                <thead>
                    <?PHP 
                    if($CodigoCarrera){
                    ?>
                    <tr>
                        <td><strong>Programa Academico:</strong></td>
                        <td><?PHP $this->PrintPrograma($CodigoCarrera)?><input type="hidden" id="id_Programa" value="<?PHP echo $CodigoCarrera?>" /></td>
                   </tr>
                   <tr>
                        <td colspan="2">&nbsp;</td>
                   </tr>     
                        <?PHP 
                        }else{
                        ?>
                    <tr>     
                        <td><strong>Modalidad Academica</strong></td>
                        <td><?PHP $this->Autocomplet('Movilidad','Digite Modalidad a Buscar','ResetModalidad','AutoCompletModalidad','id_Modalidad')?></td>
                   </tr>
                   <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                   <tr>     
                        <td><strong>Programa Academico</strong></td>
                        <td><?PHP $this->Autocomplet('Programa','Digite Programa a Buscar','ResetPrograma','AutoCompletPrograma','id_Programa')?></td>
                   </tr>     
                        <?PHP	
                        }
                        ?>
                   <tr>
                        <td colspan="2">
                        	<div id="Planes"><?PHP $this->PlanesEstudio($CodigoCarrera)?> </div>
                        </td>
                   </tr>     
                   <tr>
                        <td colspan="2">&nbsp;</td>
                   </tr>
                </thead>
                <tbody>
                	<tr>
                    	<td colspan="2">
                        	 <div id="CargarData"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?php    
		}#public function Principal
		
	public function Autocomplet($Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre){
		/*?>
        <input type="text"  id="<?PHP echo $Nombre?>" name="<?PHP echo $Nombre?>" autocomplete="off" placeholder="<?PHP echo $Descripcion?>"  style="text-align:center;width:90%;" size="70" onClick="<?PHP echo $Onclick?>();" onKeyPress="<?PHP echo $Funcion?>()" /><input type="hidden" id="<?PHP echo $id_Nombre?>" />
       
            <?php */
		}
	
	public function PrintPrograma($CodigoCarrera){
		global $userid,$db;
		
		$SQL_Carrera = 'SELECT 
						
						codigocarrera,
						nombrecarrera
						
						FROM carrera
						
						WHERE
						
						codigocarrera="'.$CodigoCarrera.'"';
						
				if($Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL De Carrera....<br><BR>'.$SQL_Carrera;
						die;
					}		
					
		?>			
		<strong><?PHP echo $Carrera->fields['nombrecarrera']?></strong>				
		<?PHP
		}	
	
	public function PlanesEstudio($CodigoCarrera){
		global $userid,$db;
		
		?>
        <table border="0" width="100%">
		<?PHP
		$SQL_Construcion = 'SELECT 
									c.nombrecarrera, 
									p.nombreplanestudio, 
									p.idplanestudio
							FROM 
									planestudio p, 
									carrera c
							WHERE 
									c.codigocarrera = p.codigocarrera
									AND 
									c.codigocarrera = "'.$CodigoCarrera.'"
									AND
									p.codigoestadoplanestudio = 101';
									
				if($PlanesConsttucion=&$db->Execute($SQL_Construcion)===false){
						echo 'Error en el SQL de Planes de Estudio en Construcion....<br><br>',$SQL_Construcion;
						die;
					}	
		
		/***************************************************************/							
		
			if(!$PlanesConsttucion->EOF){
			?>
				<tr>
                	<td><strong>PLANES DE ESTUDIO EN CONSTRUCCI&Oacute;N</strong></td>
                    <td>
                    	<select id="PlanesContrucion" name="PlanesContrucion" onchange="Cambio()">
                        	<option value="-1">Elige...</option>
                            <?PHP 
							while(!$PlanesConsttucion->EOF){
								/******************************************************/
								?>
                                <option value="<?PHP echo $PlanesConsttucion->fields['idplanestudio']?>" onclick="BuscarInfoContrucion()"><?PHP echo $PlanesConsttucion->fields['nombreplanestudio']?></option>
                                <?PHP
								/******************************************************/
								$PlanesConsttucion->MoveNext();
								}
							?>
                        </select>
                    </td>
                </tr>	
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
			<?PHP
			}#if(!$PlanesConsttucion->EOF
		/**********************************************************************/	
		
	   $SQL_Activos = 'SELECT 
								c.nombrecarrera, 
								p.nombreplanestudio, 
								p.idplanestudio

						FROM 
								planestudio p, 
								carrera c

						WHERE 
								c.codigocarrera = p.codigocarrera
								AND 
								c.codigocarrera = "'.$CodigoCarrera.'"
								AND 
								p.codigoestadoplanestudio = 100';
								
																
				if($PlanesActivos=&$db->Execute($SQL_Activos)===false){
						echo 'Error en el SQL de Planes de Estudio Activos....<br><br>',$SQL_Activos;
						die;
					}						
		?>
        
        <tr>
            <td><strong>PLANES DE ESTUDIO ACTIVOS</strong></td>
            <td>
                <select id="PlanesActivos" name="PlanesActivos" onchange="Recambio();BuscarInfo()" >
                    <option value="-1">Elige...</option>
                    <?PHP 
                    while(!$PlanesActivos->EOF){
                        /******************************************************/
                        ?>
                        <option value="<?PHP echo $PlanesActivos->fields['idplanestudio']?>" ><?PHP echo $PlanesActivos->fields['nombreplanestudio']?></option>
                        <?PHP
                        /******************************************************/
                        $PlanesActivos->MoveNext();
                        }
                    ?>
                </select>
            </td>
        </tr>
       </table> 	
		<?PHP
		}
	public function Resultado($CodigoCarrera,$PlanEstudio,$ver=''){
		global $userid,$db;
		
		$SQL_Datos='SELECT 
					p.idplanestudio, 
					p.nombreplanestudio, 
					p.fechacreacionplanestudio, 
					p.responsableplanestudio, 
					p.cargoresponsableplanestudio, 
					p.cantidadsemestresplanestudio, 
					c.nombrecarrera, 
					p.numeroautorizacionplanestudio, 
					t.nombretipocantidadelectivalibre, 
					p.cantidadelectivalibre, 
					p.fechainioplanestudio, 
					p.fechavencimientoplanestudio 
					
					FROM planestudio p, carrera c, tipocantidadelectivalibre t 
					
					WHERE 
					p.codigocarrera = c.codigocarrera 
					and 
					p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre 
					and 
					p.idplanestudio ="'.$PlanEstudio.'"';
					
			if($Datos=&$db->Execute($SQL_Datos)===false){
					echo 'Error en el SQL de los Datos Primarios ....<br><br>'.$SQL_Datos;
					die;
				}		
		
		if($ver==1){
		
		?>
        
        <div align="right"><img src="../../mgi/images/Office-Excel-icon.png" title="Exportar a Exel" id="Imoportar" width="40" style="cursor:pointer" onclick="ExportalExcel('<?PHP echo $CodigoCarrera?>','<?PHP echo $PlanEstudio?>')" /></div>
        <br />
        <?PHP
        }
		?>
        <table width="100%" class="Table">
        	<thead>
            	<tr>
                    <th class="Titulo" width="5%">Semestre</th>
                    <th class="Titulo" width="7%">Codigo Carrera</th>
                    <th class="Titulo" width="16%">Nombre Carrera</th>
                    <th class="Titulo" width="16%">Prerequisito</th>
                    <th class="Titulo" width="16%">Corequisito Doble</th>
                    <th class="Titulo" width="16%">Corequisito Sencillo</th>
                    <th class="Titulo" width="%">Equivalencia</th>
                    <th class="Titulo">&nbsp;</th>
                </tr>
            	<tr>
                	<th colspan="8">
                    <div id="DivReporte" align="center" style="overflow:scroll;width:100%; height:500; overflow-x:hidden;" >
             <table cellpadding="0" cellspacing="0" border="1" align="center"  width="100%" >
                <tbody>
                <?PHP 
					for($i=1;$i<=$Datos->fields['cantidadsemestresplanestudio'];$i++){
						/**************************************************************/
						$SQL_MateriasSemestre='SELECT
												 		d.codigomateria, 
														m.nombremateria, 
														m.numerohorassemanales, 
														d.numerocreditosdetalleplanestudio, 
														d.codigotipomateria 
											  FROM
											  			detalleplanestudio d, 
														materia m 
														
											  WHERE 
											  		
														d.idplanestudio ="'.$PlanEstudio.'"  
														AND 
														d.semestredetalleplanestudio ="'.$i.'"  
														AND 
														m.codigomateria = d.codigomateria';
														
										if($MateriaSemestre=&$db->Execute($SQL_MateriasSemestre)===false){
												echo 'Error en el SQL de las Materias Semestre ....<br><br>'.$SQL_MateriasSemestre;
												die;
											}
											
							while(!$MateriaSemestre->EOF){
								/*****************************************************************/
								?>
                                <tr>
                                    <td width="5%"><?PHP echo $i?></td>
                                    <td width="7%"><?PHP echo $MateriaSemestre->fields['codigomateria']?></td>
                                    <td width="16,9%"><?PHP echo $MateriaSemestre->fields['nombremateria']?></td>
                                    <td class="Prerequisitos" width="17%"><?PHP $this->Prerequisito($PlanEstudio,$MateriaSemestre->fields['codigomateria'])?></td>
                                    <td class="Correquisito" width="16%"><?PHP $this->CorequisitoDoble($PlanEstudio,$MateriaSemestre->fields['codigomateria'])?></td>
                                    <td width="16%"><?PHP $this->CorrequisitoSensillo($PlanEstudio,$MateriaSemestre->fields['codigomateria'])?></td>
                                    <td class="Equibalencia" width="%"><?PHP $this->Equibalencia($PlanEstudio,$MateriaSemestre->fields['codigomateria'])?></td>
                                </tr>
                                <?PHP
								/*****************************************************************/
								$MateriaSemestre->MoveNext();
								}								
						/**************************************************************/
						}#for
				?>
                	
                </tbody>
           </table>
           </div>
         </th>
         </tr>
         </thead>
         </table>  
        </div> 
        <br />
        <div id="Div_Linea">
			<?PHP $this->LineasProfundizacion($PlanEstudio)?>
        </div>       
        <?PHP	
		}
	public function Equibalencia($PlanEstudio,$CodigoMateria){
		global $userid,$db;
		
		$SQL_Equibalencia='SELECT 
									codigomateriareferenciaplanestudio as Codigo, 
									fechainicioreferenciaplanestudio, 
									fechavencimientoreferenciaplanestudio
									
						   FROM 
						   			referenciaplanestudio
									
						   WHERE 
						   			idplanestudio = "'.$PlanEstudio.'"
									and 
									codigomateria = "'.$CodigoMateria.'"
									and 
									idlineaenfasisplanestudio =1
									and 
									codigotiporeferenciaplanestudio = 300';	
									
					if($Equivalencias=&$db->Execute($SQL_Equibalencia)===false){
							echo 'Error en el SQL de las Equibalencias....<br><br>'.$SQL_Equibalencia;
							die;
						}					
			if(!$Equivalencias->EOF){
				?>
                <ul>
                <?PHP			
				while(!$Equivalencias->EOF){
					/*************************************************/
					
					$Carrera_Nom = $this->CarreraDatos($Equivalencias->fields['Codigo']);
					
								 
					?>
					<li><?PHP echo $Equivalencias->fields['Codigo']?> :: <?PHP echo $Carrera_Nom['Nombre']?></li>
					<?PHP
					/*************************************************/
					$Equivalencias->MoveNext();
					}
			?>
            </ul>
			<?PHP	
			}else{
				?>
                &nbsp;&nbsp;
                <?PHP
				}
									
		}	
	public function Prerequisito($PlanEstudio,$CodigoMateria){
		global $userid,$db;
		
		$SQL_Prerequesito='SELECT 
									codigomateriareferenciaplanestudio AS Codigo, 
									fechainicioreferenciaplanestudio, 
									fechavencimientoreferenciaplanestudio
						   FROM 
						   			referenciaplanestudio
									
						   WHERE 
						  			idplanestudio = "'.$PlanEstudio.'"
									AND 
									codigomateria = "'.$CodigoMateria.'"
									AND 
									idlineaenfasisplanestudio = 1 
									AND 
									codigotiporeferenciaplanestudio = 100';
									
						  if($Prerequisito=&$db->Execute($SQL_Prerequesito)===false){
							  	echo 'Error en el SQL Prerequisito...<br>'.$SQL_Prerequesito;
								die;
							  }
			if(!$Prerequisito->EOF){
				?>
                <ul>
                <?PHP				  
				while(!$Prerequisito->EOF){
					/****************************************************/
					
					$Carrera_Nom = $this->CarreraDatos($Prerequisito->fields['Codigo']);
					
					
					?>
					<li><?PHP echo $Prerequisito->fields['Codigo']?> :: <?PHP echo $Carrera_Nom['Nombre']?></li>
					<?PHP				 
					/****************************************************/
					$Prerequisito->MoveNext();
					}	
			?>
            	</ul>
            <?PHP		
			}else{
				?>
                &nbsp;&nbsp;
                <?PHP
				}
		}
	public function CorequisitoDoble($PlanEstudio,$CodigoMateria){
		global $userid,$db;
		
		$SQL_CorrequisitoDoble = 'SELECT 
											codigomateriareferenciaplanestudio AS Codigo, 
											fechainicioreferenciaplanestudio, 
											fechavencimientoreferenciaplanestudio		
								  FROM 
								  			referenciaplanestudio		
								
								  WHERE 
								  			idplanestudio = "'.$PlanEstudio.'"		
											AND 
											codigomateria = "'.$CodigoMateria.'" 		
											AND 
											idlineaenfasisplanestudio = 1 		
											AND 
											codigotiporeferenciaplanestudio = 200';
											
								if($CorrequisitoDoble=&$db->Execute($SQL_CorrequisitoDoble)===false){
										echo 'Error en el SQL Correquisito Doble....<br>'.$SQL_CorrequisitoDoble;
										die;
									}	
									
									
			if(!$CorrequisitoDoble->EOF){
				?>
                <ul>
                <?PHP						
					while(!$CorrequisitoDoble->EOF){
						/*******************************************************************/
							
							$Carrera_Nom = $this->CarreraDatos($CorrequisitoDoble->fields['Codigo']);
							
										
							?>
							<li><?PHP echo $CorrequisitoDoble->fields['Codigo']?> :: <?PHP echo $Carrera_Nom['Nombre']?></li>
							<?PHP			
						/*******************************************************************/
						$CorrequisitoDoble->MoveNext();
						}
			?>
            </ul>
            <?PHP			
			}else{
				?>
                &nbsp;&nbsp;
                <?PHP
				}
		
		}
	public function CorrequisitoSensillo($PlanEstudio,$CodigoMateria){
		global $userid,$db;
		
		$SQL_Corequisitosencillo = 'SELECT 
											codigomateriareferenciaplanestudio AS Codigo,
											fechainicioreferenciaplanestudio, 
											fechavencimientoreferenciaplanestudio		
									FROM 
											referenciaplanestudio		
									
									WHERE 
											idplanestudio = "'.$PlanEstudio.'"		
											AND 
											codigomateria = "'.$CodigoMateria.'"		  
											AND 
											idlineaenfasisplanestudio = 1		
											AND 
											codigotiporeferenciaplanestudio = 201';
											
								if($CorrequisitoSensillo=&$db->Execute($SQL_Corequisitosencillo)===false){
										echo 'Error en el SQL Correquisito Sensillo....<br>'.$SQL_Corequisitosencillo;
										die;
									}
									
			if(!$CorrequisitoSensillo->EOF){
				?>
                <ul>
                <?PHP
				while(!$CorrequisitoSensillo->EOF){
					/************************************************************/	
					      
						  $Carrera_Nom = $this->CarreraDatos($CorrequisitoSensillo->fields['Codigo']);
						  
						 									
							?>
							<li><?PHP echo $CorrequisitoSensillo->fields['Codigo']?> :: <?PHP echo $Carrera_Nom['Nombre']?></li>
							<?PHP		
					$CorrequisitoSensillo->MoveNext();		
					/************************************************************/
					}
				?>
                </ul>
                <?PHP	
				}else{
					?>
                    &nbsp;&nbsp;
                    <?PHP
					}						
		
		}	
	public function LineasProfundizacion($PlanEstudio){
		global $userid,$db;
		
		   $SQL_Lineas='SELECT 
		   						idlineaenfasisplanestudio AS id, 
								nombrelineaenfasisplanestudio
								
						FROM 
								lineaenfasisplanestudio
								
						WHERE 
								idplanestudio = "'.$PlanEstudio.'"
								AND 
								idlineaenfasisplanestudio not like "1"
								AND 
								codigoestadolineaenfasisplanestudio = 101';
								
				if($Lineas=&$db->Execute($SQL_Lineas)===false){
						echo 'Error en el SQL Lineas de Profundizacion....<br><br>'.$SQL_Lineas;
						die;
					}
			while(!$Lineas->EOF){#while
				?>
                <br />
                <br />
                <legend><?PHP echo $Lineas->fields['nombrelineaenfasisplanestudio']?></legend>
                 <table cellpadding="0" cellspacing="0" border="1" align="center" class="Table" width="100%" >
                    <thead>
                        <tr>
                            <th class="Titulo">Semestre</th>
                            <th class="Titulo">Codigo Carrera</th>
                            <th class="Titulo">Nombre Carrera</th>
                            <th class="Titulo">Prerequisito</th>
                            <th class="Titulo">Corequisito Doble</th>
                            <th class="Titulo">Corequisito Sensillo</th>
                            <th class="Titulo">Equivalencia</th>
                        </tr>
                    </thead>
                    <tbody>
                <?PHP
				$SQL_Datos='SELECT 
									p.idplanestudio, 
									p.nombreplanestudio, 
									p.fechacreacionplanestudio, 
									p.responsableplanestudio, 
									p.cargoresponsableplanestudio, 
									p.cantidadsemestresplanestudio, 
									c.nombrecarrera, 
									p.numeroautorizacionplanestudio, 
									t.nombretipocantidadelectivalibre, 
									p.cantidadelectivalibre, 
									p.fechainioplanestudio, 
									p.fechavencimientoplanestudio, 
									l.nombrelineaenfasisplanestudio 
							
							FROM 
									planestudio p, 
									carrera c, 
									tipocantidadelectivalibre t, 
									lineaenfasisplanestudio l 
							
							WHERE 
									p.codigocarrera = c.codigocarrera 
									AND 
									p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre 
									AND 
									l.idplanestudio = p.idplanestudio 
									AND 
									p.idplanestudio = "'.$PlanEstudio.'" 
									AND 
									l.idlineaenfasisplanestudio = "'.$Lineas->fields['id'].'"';
									
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos ....<br>';
						die;
					}					
				for($j=1;$j<=$Datos->fields['cantidadsemestresplanestudio'];$j++){
					/****************************************************************************/
					$SQL_Materia = 'SELECT 
											d.codigomateria, 
											m.nombremateria, 
											m.numerohorassemanales, 
											d.numerocreditosdetalleplanestudio, 
											d.codigotipomateria
											
									FROM 
											detalleplanestudio d, 
											materia m
											
									WHERE 
											d.idplanestudio = "'.$PlanEstudio.'"
											AND 
											d.semestredetalleplanestudio = "'.$j.'"
											AND 
											m.codigomateria = d.codigomateria';
							
							if($Materias=&$db->Execute($SQL_Materia)===false){
									echo 'Error en el SQL MAterias...<br><br>'.$SQL_Materia;
									die;
								}	
					while(!$Materias->EOF){
						
							if($Materias->fields['codigotipomateria']==5){
								/********************************************************************/
									  $SQL_MateriaHija='SELECT 
									  							d.codigomateriadetallelineaenfasisplanestudio AS Codigo,
																m.nombremateria,
																d.numerocreditosdetallelineaenfasisplanestudio, 
																d.codigotipomateria, 
																m.numerohorassemanales,
																d.semestredetallelineaenfasisplanestudio 
																
														FROM 
																detallelineaenfasisplanestudio d, 
																materia m 
																
														WHERE 
																d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria 
																AND 
																d.idlineaenfasisplanestudio ="'.$Lineas->fields['id'].'"  
																AND 
																d.idplanestudio = "'.$PlanEstudio.'" 
																AND
																d.codigomateria ="'.$Materias->fields['codigomateria'].'"';
																
										if($MateriasHijas=&$db->Execute($SQL_MateriaHija)===FALSE){
												echo 'Error en el SQL Materias Hijas....<br><br>'.$SQL_MateriaHija;
												die;
											}
										while(!$MateriasHijas->EOF){
											/********************************************************************/
											?>
                                            <tr>
                                            	<td><?PHP echo $j?></td>
                                                <td><?PHP echo $MateriasHijas->fields['Codigo']?></td>
                                                <td><?PHP echo $MateriasHijas->fields['nombremateria']?></td>
                                                <td class="Prerequisitos"><?PHP $this->PrerequisitoLinea($PlanEstudio,$MateriasHijas->fields['Codigo'],$Lineas->fields['id'])?></td>
                                                <td class="Correquisito"><?PHP $this->CorreDobleLinea($PlanEstudio,$MateriasHijas->fields['Codigo'],$Lineas->fields['id'])?></td>
                                                <td><?PHP $this->CoreqSencilloLinea($PlanEstudio,$MateriasHijas->fields['Codigo'],$Lineas->fields['id'])?></td>
                                                <td class="Equibalencia"><?PHP $this->EquivaLineal($PlanEstudio,$MateriasHijas->fields['Codigo'],$Lineas->fields['id'])?></td>
                                            </tr>
											<?PHP
                                            /********************************************************************/
											$MateriasHijas->MoveNext();
											}							
								/********************************************************************/
								}#IF
						$Materias->MoveNext();
						}#while						
					/****************************************************************************/
				}#For
			?>
            	</tbody>
            </table>
            <?PHP		
			$Lineas->MoveNext();	
			}#while 						
		
		}
	public function PrerequisitoLinea($PlanEstudio,$CodigoMateria,$Linea){
		global $userid,$db;
		
		$SQL_Prere='SELECT 
							codigomateriareferenciaplanestudio AS Codigo, 
							fechainicioreferenciaplanestudio, 
							fechavencimientoreferenciaplanestudio 
		
					FROM 	referenciaplanestudio 
					
					WHERE 
							idplanestudio = "'.$PlanEstudio.'" 
							AND 
							codigomateria = "'.$CodigoMateria.'" 
							AND 
							idlineaenfasisplanestudio = "'.$Linea.'" 
							AND 
							codigotiporeferenciaplanestudio = 100';
							
					if($PrereQuisitoLinea=&$db->Execute($SQL_Prere)===false){
							echo 'Error en el SQL Prerequisito Linea...<br>'.$SQL_Prere;
							die;
						}
				
				
			if(!$PrereQuisitoLinea->EOF){
				?>
                <ul>
                <?PHP	
				while(!$PrereQuisitoLinea->EOF){
					/*********************************************************/
					
						$Carrera_Nom = $this->CarreraDatos($PrereQuisitoLinea->fields['Codigo']);

						?>
                        <li><?PHP echo $PrereQuisitoLinea->fields['Codigo']?> :: <?PHP echo $Carrera_Nom['Nombre']?></li>
                        <?PHP
					/*********************************************************/
					$PrereQuisitoLinea->MoveNext();
					}
				?>
                </ul>
                <?PHP	
			}else{
				?>
                &nbsp;&nbsp;
                <?PHP
				}
		
		}				
	public function CarreraDatos($CodigoCarrera){
		global $userid,$db;
		
		$SQL_Carrera='select nombremateria
					 from materia
					 where codigomateria ="'.$CodigoCarrera.'"';
					 
				if($Carera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL de Carrera...<br>'.$SQL_Carrera;
						die;
					}
					
			$Carrera_Dato = array();
			
			$Carrera_Dato['Nombre'] = $Carera->fields['nombremateria'];		
			
			return $Carrera_Dato;
		
		}	
	public function CorreDobleLinea($PlanEstudio,$CodigoMateria,$Linea){
		global $userid,$db;
		
		$SQL_Corre='SELECT 
							codigomateriareferenciaplanestudio AS Codigo, 
							fechainicioreferenciaplanestudio, 
							fechavencimientoreferenciaplanestudio 
		
					FROM 
							referenciaplanestudio 
					
					WHERE 
							idplanestudio = "'.$PlanEstudio.'" 
							AND 
							codigomateria = "'.$CodigoMateria.'" 
							AND 
							idlineaenfasisplanestudio = "'.$Linea.'" 
							AND 
							codigotiporeferenciaplanestudio = 200';
							
					if($CorreDobleLinea=&$db->Execute($SQL_Corre)===false){
							echo 'Error en el SQL Carrequisito Doble Linea...<br>'.$SQL_Corre;
							die;
						}	
						
			
			if(!$CorreDobleLinea->EOF){
				?>
                <ul>
                <?PHP
				while(!$CorreDobleLinea->EOF){
					/*********************************************************/
					
					$Carrera_Nom = $this->CarreraDatos($CorreDobleLinea->fields['Codigo']);

						?>
                        <li><?PHP echo $CorreDobleLinea->fields['Codigo']?> :: <?PHP echo $Carrera_Nom['Nombre']?></li>
                        <?PHP			
					/*********************************************************/
					$CorreDobleLinea->MoveNext();
					}			
			?>
            </ul>
            <?PHP		
			}else{
				?>
                &nbsp;
                <?PHP 
				}
		}	
	public function CoreqSencilloLinea($PlanEstudio,$CodigoMateria,$Linea){
		global $userid,$db;
		
		$SQL_Sencillo = 'SELECT 
									codigomateriareferenciaplanestudio AS Codigo, 
									fechainicioreferenciaplanestudio, 
									fechavencimientoreferenciaplanestudio 
		
						FROM 
									referenciaplanestudio 
						
						WHERE 
						
									idplanestudio ="'.$PlanEstudio.'" 
									AND 
									codigomateria = "'.$CodigoMateria.'" 
									AND 
									idlineaenfasisplanestudio = "'.$Linea.'" 
									AND 
									codigotiporeferenciaplanestudio = 200';
									
						if($Sencillo=&$db->Execute($SQL_Sencillo)===false){
								echo 'Error en el SQl Carequisito Sencillo Linea... <br>'.$SQL_Sencillo;
								die;
							}		
			if(!$Sencillo->EOF){
				?>
                <ul>
                <?PHP				
				while(!$Sencillo->EOF){
					/************************************************/
					$Carrera_Nom = $this->CarreraDatos($Sencillo->fields['Codigo']);

						?>
                        <li><?PHP echo $Sencillo->fields['Codigo']?> :: <?PHP echo $Carrera_Nom['Nombre']?></li>
                        <?PHP
					/************************************************/
					$Sencillo->MoveNext();
					}	
				?>
                </ul>
                <?PHP			
			}else{
				?>
                &nbsp;
                <?PHP
				}
		}	
	public function EquivaLineal($PlanEstudio,$CodigoMateria,$Linea){
		global $userid,$db;
		
		 $SQL_Equi='SELECT 
		 					codigomateriareferenciaplanestudio AS Codigo, 
							fechainicioreferenciaplanestudio, 
							fechavencimientoreferenciaplanestudio 
		
					FROM 
							referenciaplanestudio 
					
					WHERE 
							idplanestudio = "'.$PlanEstudio.'" 
							AND 
							codigomateria = "'.$CodigoMateria.'" 
							AND 
							idlineaenfasisplanestudio = "'.$Linea.'" 
							AND 
							codigotiporeferenciaplanestudio = 300 ';
							
					
					if($EquivalLinea=&$db->Execute($SQL_Equi)===false){
							echo 'Error en el SQL De la Equivalencia Lineal...<br>'.$SQL_Equi;
							die;
						}	
						
						
			if(!$EquivalLinea->EOF){			
				?>
                <ul>
                <?PHP
				while(!$EquivalLinea->EOF){
					/**********************************************/
					$Carrera_Nom = $this->CarreraDatos($EquivalLinea->fields['Codigo']);

						?>
                        <li><?PHP echo $EquivalLinea->fields['Codigo']?> :: <?PHP echo $Carrera_Nom['Nombre']?></li>
                        <?PHP
					/**********************************************/
					$EquivalLinea->MoveNext();
					}			
				?>
                </ul>
                <?PHP		
			}else{
				?>
                &nbsp;
                <?PHP
				}
		
		
		}	
	}#Fin Class
?>