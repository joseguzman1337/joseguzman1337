<?PHP 
class Reporte_ValoresPecuniarios{#class Reporte_ValoresPecuniarios
	
	public function Principal(){#public function Principal()
			global $userid,$db;
			?>
            <fieldset style="width:98%;">
            	<legend>Reporte de Valores Pecuniarios.</legend>
            	<table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Modalidad Académica</strong></td>
                        <td><input type="text"  id="Modalidad" name="Modalidad" autocomplete="off" placeholder="Digite Modalidad Académica"  style="text-align:center;width:90%;" size="70" onClick="ResetModalidad();" onKeyPress="autoCompleModalidad();" /><input type="hidden" id="id_modalidad" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Periodo</strong></td>
                        <td><?PHP $this->Periodo()?></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Carrera</strong></td>
                        <td><input type="text"  id="carrera" name="carrera" autocomplete="off" placeholder="Digite la Carrera" style="text-align:center;width:90%;" size="70" onClick="ResetCarrera();" onkeypress="autoCompleteCarrera();" /><input type="hidden" id="id_carrera"  />&nbsp;&nbsp;<strong>Todas</strong><input type="checkbox" id="TodasCarreras" onclick="Activar();" title="Todas las Carreras" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Tipo Estudiante</strong></td>
                        <td><?PHP $this->TipoEstudiante()?></td>
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
	public function Periodo(){
		
		global $userid,$db;
			
		$SQL_Periodo='SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';
		
			if($Periodo=&$db->Execute($SQL_Periodo)===false){
					echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
					die;
				}
			?>
            <select id="Periodo" name="Periodo" style="width:100%; text-align:center">
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
	public function TipoEstudiante(){
		
		global $userid,$db;
		
		$SQL_TipoEstudiante='SELECT codigotipoestudiante as id, nombretipoestudiante as nombre FROM tipoestudiante';
		
		if($Tipo_Estudiante=&$db->Execute($SQL_TipoEstudiante)===false){
				echo 'Error en el SQL Tipo Estudiante...<br>'.$SQL_TipoEstudiante;
				die;
			}
			
			?>
            <select id="TipoEstudiante" name="TipoEstudiante" style="width:100%; text-align:center">
            	<option value="-1">Selecionar</option>
                <option value="0">Todos</option>
                <?PHP 
					while(!$Tipo_Estudiante->EOF){
						?>
                        <option value="<?PHP echo $Tipo_Estudiante->fields['id']?>"><?PHP echo $Tipo_Estudiante->fields['nombre']?></option>
                        <?PHP
						$Tipo_Estudiante->MoveNext();
						}
				?>
            </select>
            <?PHP
		
		}	
	public function Buscar($id_Movilidad,$Periodo,$TipoEstudiante,$id_carrera){
		
		global $userid,$db;
		
		
		if($id_carrera==0 && $TipoEstudiante!=0){
				##Buscar solo Por Todas las Carreras
				$this->TodasCarreras($id_Movilidad,$Periodo,$TipoEstudiante);
			}
		if($id_carrera==0 && $TipoEstudiante==0){
				##Buscar Por Todas las Careras Y todos los tipos de estudiante
				$this->TodosDeTodos($id_Movilidad,$Periodo);
			}	
		if($id_carrera!=0 && $TipoEstudiante==0){
				##Buscar Por todos Los tipo de Estudiante
				
				$this->TodosTiposEstudiantes($Periodo,$id_carrera);
			}	
		if($id_carrera!=0 && $TipoEstudiante!=0){
				##Busqueda Detallada
				$this->BuscarDetallada($id_Movilidad,$Periodo,$TipoEstudiante,$id_carrera);
			}	
		
		
		}	
	public function BuscarDetallada($id_Movilidad,$Periodo,$TipoEstudiante,$id_carrera){
			global $userid,$db;
			
			$SQL_Buscar='SELECT

						dvp.idvalorpecuniario as id
						
						FROM
						
						facturavalorpecuniario fvp INNER JOIN detallefacturavalorpecuniario dvp ON dvp.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
												   INNER JOIN valorpecuniario vp ON dvp.idvalorpecuniario=vp.idvalorpecuniario
						
						WHERE
						
						dvp.codigoestado=100
						AND
						dvp.codigotipoestudiante="'.$TipoEstudiante.'"
						AND
						fvp.codigocarrera="'.$id_carrera.'"
						AND
						fvp.codigoperiodo="'.$Periodo.'"
						AND
						vp.codigoestado=100';
						
				if($ResultadoDetallado=&$db->Execute($SQL_Buscar)===false){
						echo 'Error en el SQL Buscar Detallado...<br>'.$SQL_Buscar;
						die;
					}	
					
			?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Concepto</strong></th>
                    <th class="Titulos"><strong>Valor</strong></th>	
                </tr>
                <?PHP 
					if(!$ResultadoDetallado->EOF){
							
							$i=1;
							
							while(!$ResultadoDetallado->EOF){
								
								$SQL_Datos='SELECT 

											vp.idvalorpecuniario,
											vp.codigoconcepto,
											cp.codigoconcepto,
											cp.nombreconcepto,
											vp.valorpecuniario
											
											FROM 
											
											valorpecuniario vp INNER JOIN concepto cp ON cp.codigoconcepto=vp.codigoconcepto AND cp.codigoestado=100 AND vp.codigoestado=100 
											
											WHERE 
											
											vp.idvalorpecuniario="'.$ResultadoDetallado->fields['id'].'"';
											
										if($Datos=&$db->Execute($SQL_Datos)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Datos;
												die;
											}	
											
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
                                    	<td align="center" class="Borde_td"><?PHP echo $i?></td>
                                        <td class="Borde_td"><?PHP echo $Datos->fields['nombreconcepto']?></td>
                                        <td align="right" class="Borde_td"><?PHP echo number_format($Datos->fields['valorpecuniario'],0,',','.')?></td>
                                    </tr>
                                <?PHP
								$i++;
								$ResultadoDetallado->MoveNext();
								}
							
						}else{
							?>
                            <tr>
                            	<td align="center" colspan="3"><span style="color:#999">No Hay Informacion</span></td>
                            </tr>
                            <?PHP
							}
				?>
            </table>
            <?PHP			
		}	
	public function TodasCarreras($id_Movilidad,$Periodo,$TipoEstudiante){
			
			global $userid,$db;
			
			   $SQL_Buscar='SELECT
									dvp.iddetallefacturavalorpecuniario,
									dvp.idvalorpecuniario AS id,
									fvp.codigocarrera
							
							FROM
							
								 facturavalorpecuniario fvp INNER JOIN detallefacturavalorpecuniario dvp ON dvp.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
															INNER JOIN valorpecuniario vp ON dvp.idvalorpecuniario=vp.idvalorpecuniario INNER JOIN carrera c ON c.codigocarrera=fvp.codigocarrera
							
							WHERE
							
									dvp.codigoestado=100
									AND
									dvp.codigotipoestudiante="'.$TipoEstudiante.'"
									AND
									fvp.codigoperiodo="'.$Periodo.'"
									AND
									vp.codigoestado=100
									AND 
									c.codigomodalidadacademica="'.$id_Movilidad.'"
									
									ORDER BY fvp.codigocarrera';#
									
							if($DetalleTodasCarreras=&$db->Execute($SQL_Buscar)===false){
									echo 'Error en el SQL Todas LAs Carreras....<br>'.$SQL_Buscar;
									die;
								}		
			?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Concepto</strong></th>
                    <th class="Titulos"><strong>Valor</strong></th>	
                    <th class="Titulos"><strong>Carrera</strong></th>	
                </tr>
            <?PHP
				if(!$DetalleTodasCarreras->EOF){
					
					$i=1;
					
					while(!$DetalleTodasCarreras->EOF){
						
								$SQL_Datos='SELECT 

											vp.idvalorpecuniario,
											vp.codigoconcepto,
											cp.codigoconcepto,
											cp.nombreconcepto,
											vp.valorpecuniario
											
											FROM 
											
											valorpecuniario vp INNER JOIN concepto cp ON cp.codigoconcepto=vp.codigoconcepto AND cp.codigoestado=100 AND vp.codigoestado=100 
											
											WHERE 
											
											vp.idvalorpecuniario="'.$DetalleTodasCarreras->fields['id'].'"';
											
										if($Datos=&$db->Execute($SQL_Datos)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Datos;
												die;
											}
											
								  $SQL_Carrera='SELECT 

												codigocarrera,
												nombrecarrera
												
												FROM 
												
												carrera
												
												WHERE
												
												codigocarrera="'.$DetalleTodasCarreras->fields['codigocarrera'].'"';			
												
												
										if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Carrera;
												die;
											}	
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
                        	<td class="Borde_td" align="center"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombreconcepto']?></td>
                            <td class="Borde_td" align="right"><?PHP echo number_format($Datos->fields['valorpecuniario'],0,',','.')?></td>
                            <td class="Borde_td"><?PHP echo $D_Carrera->fields['nombrecarrera']?></td>
                        </tr>
                        <?PHP
						$i++;
						$DetalleTodasCarreras->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td align="center" colspan="4"><span style="color:#999999">NO Hay Informacion</span></td>
                        </tr>
                        <?PHP
						}
		?>
        </table>
        <?PHP				
		}	
	public function TodosTiposEstudiantes($Periodo,$id_carrera){
			
			global $userid,$db;
			
			   $SQL_Buscar='SELECT
									dvp.iddetallefacturavalorpecuniario,
									dvp.idvalorpecuniario AS id,
									dvp.codigotipoestudiante,
									fvp.codigocarrera
							
							FROM
							
									facturavalorpecuniario fvp INNER JOIN detallefacturavalorpecuniario dvp ON dvp.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
															   INNER JOIN valorpecuniario vp ON dvp.idvalorpecuniario=vp.idvalorpecuniario
							
							WHERE
							
									dvp.codigoestado=100
									AND
									fvp.codigoperiodo="'.$Periodo.'"
									AND
									fvp.codigocarrera="'.$id_carrera.'"  
									AND
									vp.codigoestado=100';
									
						if($DetalleTodosTipos=&$db->Execute($SQL_Buscar)===false){
								echo 'Error en el SQL Buscar Todos los Tipos De estudiante...<br>'.$SQL_Buscar;
								die;
							}
							
			?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Concepto</strong></th>
                    <th class="Titulos"><strong>Valor</strong></th>	
                    <th class="Titulos"><strong>Tipo Estudiante</strong></th>	
                </tr>
            <?PHP												
				
				if(!$DetalleTodosTipos->EOF){
					
					$i=1;
					
					while(!$DetalleTodosTipos->EOF){
						
						$SQL_Datos='SELECT 

											vp.idvalorpecuniario,
											vp.codigoconcepto,
											cp.codigoconcepto,
											cp.nombreconcepto,
											vp.valorpecuniario
											
											FROM 
											
											valorpecuniario vp INNER JOIN concepto cp ON cp.codigoconcepto=vp.codigoconcepto AND cp.codigoestado=100 AND vp.codigoestado=100 
											
											WHERE 
											
											vp.idvalorpecuniario="'.$DetalleTodosTipos->fields['id'].'"';
											
										if($Datos=&$db->Execute($SQL_Datos)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Datos;
												die;
											}
									
											
						$SQL_Tipo='SELECT 
									
									codigotipoestudiante,
									nombretipoestudiante
									
									FROM 
									
									tipoestudiante
									
									WHERE
									
									codigotipoestudiante="'.$DetalleTodosTipos->fields['codigotipoestudiante'].'"';					
									
								if($D_Tipo=&$db->Execute($SQL_Tipo)===false){
										echo 'Error en la Buscar  tipos estudiante de Datos...<br>'.$SQL_Tipo;
										die;
									}
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
                        	<td class="Borde_td" align="center"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombreconcepto']?></td>
                            <td class="Borde_td" align="right"><?PHP echo number_format($Datos->fields['valorpecuniario'],0,',','.')?></td>
                            <td class="Borde_td"><?PHP echo $D_Tipo->fields['nombretipoestudiante']?></td>
                        </tr>
                        <?PHP
						$i++;
						$DetalleTodosTipos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td align="center" colspan="4"><span style="color:#999999">NO Hay Informacion</span></td>
                        </tr>
                        <?PHP
						}
			?>
            </table>
            <?PHP			
			}	
		public function TodosDeTodos($id_Movilidad,$Periodo){
			
			global $userid,$db;
			
			   $SQL_Buscar='SELECT
							dvp.iddetallefacturavalorpecuniario,
							dvp.idvalorpecuniario AS id,
							dvp.codigotipoestudiante,
							fvp.codigocarrera
							
							FROM
							
							facturavalorpecuniario fvp INNER JOIN detallefacturavalorpecuniario dvp ON dvp.idfacturavalorpecuniario=fvp.idfacturavalorpecuniario
							INNER JOIN valorpecuniario vp ON dvp.idvalorpecuniario=vp.idvalorpecuniario INNER JOIN carrera c ON c.codigocarrera=fvp.codigocarrera
							
							WHERE
							
							dvp.codigoestado=100
							AND
							fvp.codigoperiodo="'.$Periodo.'"
							AND
							vp.codigoestado=100
							AND
							c.codigomodalidadacademica="'.$id_Movilidad.'"
							
							ORDER BY fvp.codigocarrera, dvp.codigotipoestudiante';
							
					if($DetalleTodosdeTodos=&$db->Execute($SQL_Buscar)===false){
							echo 'Error en el SQL Buscar Todos De Todos...<br>'.$SQL_Buscar;  
							die;
						}		
						
			?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="Borde_td">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Concepto</strong></th>
                    <th class="Titulos"><strong>Valor</strong></th>	
                    <th class="Titulos"><strong>Tipo Estudiante</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>	
                </tr>
            <?PHP			
				if(!$DetalleTodosdeTodos->EOF){
					
					$i=1;
					
					while(!$DetalleTodosdeTodos->EOF){
						
						$SQL_Datos='SELECT 

											vp.idvalorpecuniario,
											vp.codigoconcepto,
											cp.codigoconcepto,
											cp.nombreconcepto,
											vp.valorpecuniario
											
											FROM 
											
											valorpecuniario vp INNER JOIN concepto cp ON cp.codigoconcepto=vp.codigoconcepto AND cp.codigoestado=100 AND vp.codigoestado=100 
											
											WHERE 
											
											vp.idvalorpecuniario="'.$DetalleTodosdeTodos->fields['id'].'"';
											
										if($Datos=&$db->Execute($SQL_Datos)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Datos;
												die;
											}
									
											
						$SQL_Tipo='SELECT 
									
									codigotipoestudiante,
									nombretipoestudiante
									
									FROM 
									
									tipoestudiante
									
									WHERE
									
									codigotipoestudiante="'.$DetalleTodosdeTodos->fields['codigotipoestudiante'].'"';					
									
								if($D_Tipo=&$db->Execute($SQL_Tipo)===false){
										echo 'Error en la Buscar  tipos estudiante de Datos...<br>'.$SQL_Tipo;
										die;
									}
									
							      $SQL_Carrera='SELECT 

												codigocarrera,
												nombrecarrera
												
												FROM 
												
												carrera
												
												WHERE
												
												codigocarrera="'.$DetalleTodosdeTodos->fields['codigocarrera'].'"';			
												
												
										if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
												echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Carrera;
												die;
											}	
											
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
                        	<td align="center" class="Borde_td"><?PHP echo $i?></td>
                            <td class="Borde_td"><?PHP echo $Datos->fields['nombreconcepto']?></td>
                            <td align="right" class="Borde_td"><?PHP echo number_format($Datos->fields['valorpecuniario'],0,',','.')?></td>
                            <td class="Borde_td"><?PHP echo $D_Tipo->fields['nombretipoestudiante']?></td>
                            <td class="Borde_td"><?PHP echo $D_Carrera->fields['nombrecarrera']?></td>
                        </tr>
						<?PHP
						$i++;
						$DetalleTodosdeTodos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td align="center" colspan="5"><span style="color:#999999">NO Hay Informacion</span></td>
                        </tr>
                        <?PHP
						}
			?>
            </table>
            <?PHP			
			}		
	
	}#class Reporte_ValoresPecuniarios 
function esPar($numero){ 
   $resto = $numero%2; 
   if (($resto==0) && ($numero!=0)) { 
        return 1 ;#true
   }else{ 
        return 0; #false
   } 
}
	
?>