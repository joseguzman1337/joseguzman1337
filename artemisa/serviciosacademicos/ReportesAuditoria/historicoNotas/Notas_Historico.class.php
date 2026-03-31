<?PHP 
class Notas_Historico{
	
	public function Principal(){#public function Principal()
		
		global $userid,$db;
		
		?>
        <!--  Space loading indicator  -->
        <script src="<?php echo HTTP_ROOT; ?>/sala/assets/js/spiceLoading/pace.min.js"></script>

        <!--  loading cornerIndicator  -->
        <link href="<?php echo HTTP_ROOT; ?>/sala/assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">
        <fieldset style="width:98%;">
            	<legend>Reporte Historico Notas.</legend>
            	<table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Modalidad Académica</strong></td>
                        <td><input type="text"  id="Modalidad" name="Modalidad" autocomplete="off" placeholder="Digite Modalidad Académica"  style="text-align:center;width:90%;" size="70" onClick="ResetModalidad();" onKeyPress="autoCompleModalidad()" /><input type="hidden" id="id_modalidad" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Periodo Inicial</strong></td>
                        <td><?PHP $this->PeriodoInicial()?></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Carrera</strong></td>
                        <td><input type="text"  id="carrera" name="carrera" autocomplete="off" placeholder="Digite la Carrera" style="text-align:center;width:90%;" size="70" onClick="ResetCarrera();" onkeypress="autoCompleteCarrera()" /><input type="hidden" id="id_carrera"  />&nbsp;&nbsp;<strong>Todas</strong><input type="checkbox" id="TodasCarreras" onclick="Activar()" title="Todas las Carreras" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Periodo Final</strong></td>
                        <td><?PHP $this->PeriodoFinal()?></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Materia</strong></td>
                        <td><input type="text"  id="Materia" name="Materia" autocomplete="off" placeholder="Digite el Nombre o Codigo de la Materia" style="text-align:center;width:90%;" size="70" onClick="ResetMateria();" onkeypress="autoCompleteMateria()" /><input type="hidden" id="id_Materia"  />&nbsp;&nbsp;<strong>Todas</strong><input type="checkbox" id="TodasMaterias" onclick="ActivarMateria()" title="Todas las Materias" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Tipo Nota</strong></td>
                        <td><?PHP $this->TipoNota()?></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="4" align="center"><input type="button" id="Buscar" onclick="Buscar()" value="Buscar" style="cursor:pointer" /></td>
                        <td align="center"><img src="../../mgi/images/Office-Excel-icon.png" title="Exportar a Exel" id="Imoportar" width="40" style="cursor:pointer" onclick="ExportarExel()" /></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div id="DivReporte" align="center" style="overflow:scroll;width:100%; height:500; overflow-x:hidden;" ></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
		<?PHP
		}#public function Principal()
	public function PeriodoInicial(){
		
		global $userid,$db;
			
		$SQL_Periodo='SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';
		
			if($Periodo=&$db->Execute($SQL_Periodo)===false){
					echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
					die;
				}
			?>
            <select id="Periodoini" name="Periodoini" style="width:100%; text-align:center">
            	<option value="-1">Selecionar</option>
                <?PHP 
					while(!$Periodo->EOF){
						?>
                        <option value="<?PHP echo $Periodo->fields['codigoperiodo']?>"><?PHP echo $Periodo->fields['codigoperiodo']?></option>
                        <?PHP	
						$Periodo->MoveNext();
					}
				?>    
            </select>
            <?PHP	
		}
	public function PeriodoFinal(){
		
		global $userid,$db;
			
		$SQL_Periodo='SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';
		
			if($Periodo=&$db->Execute($SQL_Periodo)===false){
					echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
					die;
				}
			?>
            <select id="Periodofin" name="Periodofin" style="width:100%; text-align:center">
            	<option value="-1">Selecionar</option>
                <?PHP 
					while(!$Periodo->EOF){
						?>
                        <option value="<?PHP echo $Periodo->fields['codigoperiodo']?>"><?PHP echo $Periodo->fields['codigoperiodo']?></option>
                        <?PHP	
						$Periodo->MoveNext();
					}
				?>
            </select>
            <?PHP	
		}	
	public function TipoNota(){
		
		global $userid,$db;
		
			 $SQL_TipoNota='SELECT 

							codigotiponotahistorico,   
							nombretiponotahistorico
							
							FROM tiponotahistorico';
		
		if($Tipo_Nota=&$db->Execute($SQL_TipoNota)===false){
				echo 'Error en el SQL Tipo Nota...<br>'.$SQL_TipoNota;
				die;
			}
			
			?>
            <select id="Tipo_Nota" name="Tipo_Nota" style="width:100%; text-align:center">
            	<option value="-1">Selecionar</option>
                <option value="0">Todos</option>
                <?PHP 
					while(!$Tipo_Nota->EOF){
						?>
                        <option value="<?PHP echo $Tipo_Nota->fields['codigotiponotahistorico']?>"><?PHP echo $Tipo_Nota->fields['nombretiponotahistorico']?></option>
                        <?PHP
						$Tipo_Nota->MoveNext();
						}
				?>
            </select>
            <?PHP
		}
	public function Buscar($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota,$id_Materia,$Nom_Materia){
			
			global $userid,$db;
			
			//echo $id_carrera.'==Carrera && '.$Tipo_Nota.'==Nota && '.$id_Materia.'Materia';
			
			if($id_carrera==0 && $Tipo_Nota!=0 && $id_Materia!=0){
					/*Todas las Carreras*/
					$this->DetalleTodasCarreras($id_modalidad,$Periodoini,$Periodofin,$Tipo_Nota,$id_Materia,$Nom_Materia);
				}
				
			if($Tipo_Nota==0 && $id_carrera!=0 && $id_Materia!=0){
					/*Todas las Notas*/
					$this->DetalleTodasNotas($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$id_Materia);
				}	
			
			if($id_carrera!=0 && $Tipo_Nota!=0 && $id_Materia!=0){
					/*Una Carrera especifica y una Nota Especifica*/
					$this->DetalleGenral($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota,$id_Materia);
				}
			
			if($id_Materia==0 && $id_carrera!=0 && $Tipo_Nota!=0){
					/*Todas las Materias*/
					
					$this->DeatlleTodasMaterias($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota);
				}
			
			if($id_Materia==0 && $id_carrera==0 && $Tipo_Nota!=0){
					/*Todas las Materias y Todas las Carreras*/
					
					$this->TodasMateriasCarreras($id_modalidad,$Periodoini,$Periodofin,$Tipo_Nota);
				}
							
			if($id_Materia==0 && $id_carrera!=0 && $Tipo_Nota==0){
					/*Todas las Materias Y todas las Notas*/
					
					$this->TodasMateriasNotas($id_modalidad,$Periodoini,$Periodofin,$id_carrera);
				}
				
			if($id_Materia!=0 && $id_carrera==0 && $Tipo_Nota==0){
					/*Todas la Carreras Y todas Las Notas*/
					
					$this->TodasCarrerasNotas($id_modalidad,$Periodoini,$Periodofin,$id_Materia);
				}	
			
			if($id_Materia==0 && $id_carrera==0 && $Tipo_Nota==0){
					/*Todos de Todos*/
					$this->TodasTodos($id_modalidad,$Periodoini,$Periodofin);
				}
				
		}
	public function DetalleTodasCarreras($id_modalidad,$Periodoini,$Periodofin,$Tipo_Nota,$id_Materia,$Nom_Materia){
			
			global $userid,$db;
			
			/*
			
			//->Busca Datos De todas las Carreras con Un Tipo de nota Unico y  una materia especifica
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
		$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
                                        INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                        INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral 
                                        INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
                                        INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						m.nombremateria="'.$Nom_Materia.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						t.codigotiponotahistorico="'.$Tipo_Nota.'"
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}		
			
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombresestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['apellidosestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombrecarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretiponotahistorico']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['observacionnotahistorico']?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP
			
		}				
	public function DetalleTodasNotas($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$id_Materia){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De todas las Notas Con Carrera y Materia Unica
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
                                                                                                                INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico 
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						m.codigomateria="'.$id_Materia.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						c.codigocarrera="'.$id_carrera.'"
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombresestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['apellidosestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombrecarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretiponotahistorico']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['observacionnotahistorico']?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
		
		}
	public function DetalleGenral($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota,$id_Materia){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todos los datos con datos Especificos
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico 
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						m.codigomateria="'.$id_Materia.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						c.codigocarrera="'.$id_carrera.'"
						AND
						t.codigotiponotahistorico="'.$Tipo_Nota.'"
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombresestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['apellidosestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombrecarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretiponotahistorico']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['observacionnotahistorico']?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
		}
	public function DeatlleTodasMaterias($id_modalidad,$Periodoini,$Periodofin,$id_carrera,$Tipo_Nota){
			
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Materias Con Carrera Unica Y un Tipo de Nota UNico
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						c.codigocarrera="'.$id_carrera.'"
						AND
						t.codigotiponotahistorico="'.$Tipo_Nota.'"
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombresestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['apellidosestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombrecarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretiponotahistorico']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['observacionnotahistorico']?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
		} 
	public function TodasMateriasCarreras($id_modalidad,$Periodoini,$Periodofin,$Tipo_Nota){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Materias con todas las Carreras Y un Tipo de Nota UNico
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
                        trf.nombretipoestudianterecursofinanciero
						
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						t.codigotiponotahistorico="'.$Tipo_Nota.'"
						
						ORDER BY e.nombresestudiantegeneral'; 
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombresestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['apellidosestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombrecarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretiponotahistorico']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['observacionnotahistorico']?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
			
		}
	public function TodasMateriasNotas($id_modalidad,$Periodoini,$Periodofin,$id_carrera){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Materias con todas las Notas y unica Carrera
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
                        trf.nombretipoestudianterecursofinanciero
						FROM 
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
						INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                        INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
						INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
						INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						n.codigoestadonotahistorico=100
						AND
						c.codigocarrera="'.$id_carrera.'"
						
						
						ORDER BY e.nombresestudiantegeneral';

				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombresestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['apellidosestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombrecarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretiponotahistorico']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo @$Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['observacionnotahistorico']?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
	
		}	
	public function TodasCarrerasNotas($id_modalidad,$Periodoini,$Periodofin,$id_Materia){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Carreras y Todas las Notas con Una Materia Definidad
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						m.codigomateria="'.$id_Materia.'"
						AND
						n.codigoestadonotahistorico=100
						
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombresestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['apellidosestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombrecarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretiponotahistorico']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['observacionnotahistorico']?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();   
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
		}
		public function TodasTodos($id_modalidad,$Periodoini,$Periodofin){
		
			global $userid,$db;
			
			/*
			
			//->Busca Datos De Todas las Carreras y Todas las Notas con Una Materia Definidad
			
				Datos a Buscar
				
				*Nombre y Apellido Estudiante
				*N° documento
				*Materia
				*Nota definitiva 
				*Tipo Nota
				
			*/
			
			$SQL_Datos='SELECT 

						n.idnotahistorico,
						n.codigoperiodo,
						m.codigomateria,
						m.nombremateria,
						c.codigocarrera,
						c.nombrecarrera,
						n.codigoestudiante,
						e.idestudiantegeneral,
						e.nombresestudiantegeneral,
						e.apellidosestudiantegeneral,
						e.numerodocumento,
						n.notadefinitiva,
						t.codigotiponotahistorico,
						t.nombretiponotahistorico,
                        n.observacionnotahistorico,
						trf.nombretipoestudianterecursofinanciero
						FROM 
						
						notahistorico n INNER JOIN materia m ON m.codigomateria=n.codigomateria
														INNER JOIN estudiante est ON est.codigoestudiante=n.codigoestudiante
                                                                                                                INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=est.idestudiantegeneral
														INNER JOIN tiponotahistorico t ON t.codigotiponotahistorico=n.codigotiponotahistorico
														INNER JOIN carrera c ON c.codigocarrera=est.codigocarrera
						INNER JOIN estudianterecursofinanciero erf on e.idestudiantegeneral = erf.idestudiantegeneral
                        INNER JOIN tipoestudianterecursofinanciero trf on erf.idtipoestudianterecursofinanciero = trf.idtipoestudianterecursofinanciero
						
						WHERE
						
						n.codigoperiodo BETWEEN "'.$Periodoini.'" AND "'.$Periodofin.'"
						AND
						n.codigoestadonotahistorico=100
						
						
						ORDER BY e.nombresestudiantegeneral';
						
				if($Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL Datos......<br>'.$SQL_Datos;
						die;
					}	
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Nombre</strong></th>
                    <th class="Titulos"><strong>Apellido</strong></th>
                    <th class="Titulos"><strong>N&deg; Documento</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Nota Definitiva</strong></th>
                    <th class="Titulos"><strong>Tipo de Nota</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
                    <th class="Titulos"><strong>R. financiero</strong></th>
                    <th class="Titulos"><strong>Observación</strong></th>
               </tr>     
            <?PHP
			/**************************************************************************************/
			
				if(!$Datos->EOF){
					$i=1;
					while(!$Datos->EOF){
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombresestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['apellidosestudiantegeneral']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['numerodocumento']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombrecarrera']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $Datos->fields['notadefinitiva']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretiponotahistorico']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['codigoperiodo']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombretipoestudianterecursofinanciero']?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['observacionnotahistorico']?></td>
                        </tr>
                        <?PHP
						$i++;
						$Datos->MoveNext();   
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="10" align="center" class="Borde_td"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			
			/**************************************************************************************/
			?>
            </table>	
            <?PHP			
			
		}	
	}#Fin Class
function esPar($numero){ 
   $resto = $numero%2; 
   if (($resto==0) && ($numero!=0)) { 
        return 1 ;#true
   }else{ 
        return 0; #false
   } 
}
	
?>