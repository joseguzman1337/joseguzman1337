<?PHP 
class Estructura_Tablero{
	
		public function Principal($id,$dato,$programa){
			
			#########################################
			global $userid,$db;
			
			if($dato==3){
					$Dato_programa='AND ind.idCarrera="'.$programa.'"';
				}else{
					$Dato_programa='';
					}
			
			  $SQL_Indicadores='SELECT 

								ind.idsiq_indicador,
								ind.idIndicadorGenerico,
								indGen.idsiq_indicadorGenerico,
								indGen.nombre,
								ind.idEstado
								
								FROM 
								
								siq_indicador as ind INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
								
								WHERE
								
								ind.discriminacion="'.$dato.'"
								AND
								indGen.area="'.$id.'"
								AND
								ind.codigoestado=100
								AND
								indGen.codigoestado=100
								'.$Dato_programa;
								
					if($Nombre_indicador=&$db->Execute($SQL_Indicadores)===false){
							echo 'Error en el SQL Indicador.......<br>'.$SQL_Indicadores;
							die;
						}			
			
			?>
            
           	<table border="0" width="90%" align="center">
            	<tr>
                	<td class="Border">
                    <fieldset>
                    	<legend>INDICADORES :</legend>
                        	<ul>
                            	<?PHP
									if($Nombre_indicador->EOF){
										?>
                                            <span style="color:#000; font-family:'Times New Roman', Times, serif; font-size:16px; text-align:center">No Hay Informaci&oacute;n</span>
                                         <?PHP
										
										} 
										while(!$Nombre_indicador->EOF){
											?>
											<li><?PHP echo $Nombre_indicador->fields['idsiq_indicador'].'<-->'.$Nombre_indicador->fields['nombre'].' :: '.$Nombre_indicador->fields['idEstado']?></li>
											<?PHP
											$Nombre_indicador->MoveNext();
											}
								?>
                           </ul>     
                    </fieldset>    
                    </td>
                </tr>
            </table>
			<?PHP	
			#########################################
			}
		public function TableroDinamico($dato,$Programa=''){
			
			?>
<link rel="stylesheet" href="../../css/style.css" type="text/css" />
 <link rel="stylesheet" href="../../css/TableroDinamico.css" type="text/css" />
         
        <!--Funciones  para pantalla emergente-->
<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>
  

        <?PHP
		global $userid,$db;
								$SQL_Pecar='SELECT 

														idsiq_pecar,
														nombre
											
											FROM 
											
														siq_pecar
											
											WHERE
											
														codigoestado=100';
														
											if($Pecar=&$db->Execute($SQL_Pecar)===false){
													echo 'Error al Buscar la Estrucutra del Pecar.....<br>'.$SQL_Pecar;
													die;
												}
												
					switch($dato){
							case 1:{$Titulo = 'Institucional';$ProgramSQL='';}break;
							case 3:{
											$SQL='SELECT 

															codigocarrera as id,
															nombrecarrera
													
													FROM 
													
															carrera
															
													WHERE
															codigocarrera="'.$Programa.'"
															';
															
													if($Programa_nom=&$db->Execute($SQL)===false){
														echo 'Error en el SQL Secte del Ajax...<br>'.$SQL;
														die;
													}
								$Titulo = 'Del Programa '.$Programa_nom->fields['nombrecarrera'];
								
								$ProgramSQL= ' AND	ind.idCarrera="'.$Programa.'"';
								}break;
						}		
				?>
                <br /><br />
                <div style="font-size:24px; font-family:'Times New Roman', Times, serif"><strong>Tablero Control <?PHP echo $Titulo?>.</strong><div align="right"><img src="../../images/category_item_select.png" title="Visualizar Semaforo" style="cursor:pointer" onclick="VerSemafor()" id="Semaforo_img"  /></div><input type="hidden" id="Semaforo_id" value="0" /></div>
                	 <fieldset>
                     <legend></legend>
                     <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                     	<tr>
                        	<td class="Border" align="center">
                            	<div id="accordion"  align="center" style="width:100%">
                                	<?PHP 
										while(!$Pecar->EOF){
												
												    $SQL_Area='SELECT 
													 			siq_area.idsiq_area, 
																siq_area.nombre 

																FROM 
																siq_area INNER JOIN siq_indicadorGenerico AS indGen ON (siq_area.idsiq_area=indGen.area OR siq_area.disponible=1)
																		 INNER JOIN siq_indicador AS ind ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico

																WHERE 
																siq_area.codigoestado=100 
																AND 
																indGen.codigoestado=100 
																AND 
																siq_area.id_pecar="'.$Pecar->fields['idsiq_pecar'].'"
																AND 
																ind.codigoestado=100 
																AND 
																ind.discriminacion="'.$dato.'"
																'.$ProgramSQL.' 
																

																GROUP BY siq_area.idsiq_area ';		
															
												  if($Areas_Pecar=&$db->Execute($SQL_Area)===false){
													  	echo 'Error en el SQL Area ....<br>'.$SQL_Area;
														die;
													  }			
													  
													####################
													$D_Areas = $Areas_Pecar->GetArray();
													#echo '<pre>';print_r($D_Areas);
													#echo 'count-->'.count($D_Areas);
													$Dato=esPar(count($D_Areas));
													switch($Dato){
															case 1:{
																	if(count($D_Areas)==1){
																			$Num=1;
																		}else{
																			$Num=count($D_Areas)/3;
																			}
																}break;
															case 0:{
																	if(count($D_Areas)>=4){
																			$Num = count($D_Areas)/4;
																		}
																}break;
														}
													####################		
															
												  $SQL_Proceso='SELECT 

																idsiq_procesopecar,
																nombre
																
																FROM 
																
																siq_procesopecar
																
																
																WHERE
																
																codigoestado=100
																AND
																id_pecar="'.$Pecar->fields['idsiq_pecar'].'"';
																
														if($Proceso_Pecar=&$db->Execute($SQL_Proceso)===false){
																echo 'Error en el SQL Proceso....<br>'.$SQL_Proceso;
																die;
															}
														
														switch($dato){
								
																case 1:{
																	##########################
																		
																		switch($Pecar->fields['idsiq_pecar']){
																			
																				case 1:{$Class='Planeacion';}break;
																				case 2:{$Class='Ejecucion';}break;
																				case 3:{$Class='Control';}break;
																				case 4:{$Class='Retro';}break;
																			}
																	##########################
																	}break;
																case 3:{
																	##########################
																		
																		switch($Pecar->fields['idsiq_pecar']){
																			
																				case 1:{$Class='PlaneacionPro';}break;
																				case 2:{$Class='EjecucionPro';}break;
																				case 3:{$Class='ControlPro';}break;
																				case 4:{$Class='RetroPro';}break;
																			}
																	##########################	
																	}break;
															}			
											
											?>
                                            	<h3 class="<?PHP echo $Class?>"><?PHP echo $Pecar->fields['nombre']?></h3>
                                            	<div class="<?PHP echo $Class?>">
                                        			<table border="0" align="center" width="95%">
                                                    <?PHP
														for($i=0;$i<count($D_Areas);$i++){
															?>
                                                            <tr>
                                                                <td class="Border" align="center" style="width:100%">
                                                                	<div>
                                                                    	<?PHP $this->Semaforo($D_Areas[$i]['idsiq_area'],$dato,$Programa)?>
                                                                        
                                                                        <div id="Area_<?PHP echo $D_Areas[$i]['idsiq_area']?>" class="AreaStyle" style="border:#FFF inset 1px; width:30%; cursor:pointer;" onclick="VerIndicador(<?PHP echo $D_Areas[$i]['idsiq_area']?>,'<?PHP echo $dato?>','<?PHP echo $Programa?>')">
                                                                            <?PHP echo $D_Areas[$i]['nombre']?>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?
															}
														while(!$Proceso_Pecar->EOF){
															?>
                                                            <tr>
                                                                <td class="Border" align="center">
                                                                	
                                                                	<div id="Proceso_<?PHP echo $Proceso_Pecar->fields['idsiq_procesopecar']?>" style="text-align:left; width:100%; border:#0000FF solid 1px" class="ProcesoStyle"><!--Div Contenedor Proceso-->
																		<h4 style="text-align:left"><?PHP echo $Proceso_Pecar->fields['nombre']?></h4>
                                                                        <?PHP 
																			 $SQL_Area='SELECT 
																						siq_area.idsiq_area, 
																						siq_area.nombre 
						
																						FROM 
																						siq_area INNER JOIN siq_indicadorGenerico AS indGen ON (siq_area.idsiq_area=indGen.area OR siq_area.disponible=1)
																								 INNER JOIN siq_indicador AS ind ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico
						
																						WHERE 
																						siq_area.codigoestado=100 
																						AND 
																						indGen.codigoestado=100 
																						AND 
																						siq_area.id_procesopecar="'.$Proceso_Pecar->fields['idsiq_procesopecar'].'"
																						AND 
																						ind.codigoestado=100 
																						AND 
																						ind.discriminacion="'.$dato.'" 
																						AND
																						ind.idCarrera="'.$Programa.'"
																						
																						GROUP BY siq_area.idsiq_area ';
																						
																			/*$SQL_Area='SELECT 

																						idsiq_area,
																						nombre
																						
																						FROM 
																						
																						siq_area
																						
																						WHERE
																						
																						codigoestado=100
																						AND
																						id_procesopecar="'.$Proceso_Pecar->fields['idsiq_procesopecar'].'"';*/
																						
																			  if($Areas_Pro=&$db->Execute($SQL_Area)===false){
																					echo 'Error en el SQL Area ....<br>'.$SQL_Area;
																					die;
																				  }	
																				  
																			$D_ProAreas = $Areas_Pro->GetArray();	
																			 
																			 $Dato=esPar(count($D_ProAreas));
																				
																				switch($Dato){
																						case 1:{
																								if(count($D_Areas)==1){
																										$Num=1;
																									}else{
																										$Num=count($D_Areas)/3;
																										}
																							}break;
																						case 0:{
																								if(count($D_Areas)>=4){
																										$Num = count($D_Areas)/4;
																									}
																							}break;
																					} 

																			for($j=0;$j<count($D_ProAreas);$j++){
																						
																				?>
                                                                                <?PHP $this->Semaforo($D_ProAreas[$j]['idsiq_area'],$dato,$Programa)?>
																				<div style="text-align:center; border:#00FF00 solid 1px; width:30%; float:left; margin:0 10px; cursor:pointer" id="Nom_Pro_<?PHP echo $j?>" onclick="VerIndicador(<?PHP echo $D_ProAreas[$j]['idsiq_area']?>,'<?PHP echo $dato?>','<?PHP echo $Programa?>')" class="AreaStyle"><?PHP echo $D_ProAreas[$j]['nombre']?></div>
																				<?PHP
																			}
																			
																			   $SQL_SubProceso='SELECT 

																								idsiq_procesopecar,
																								nombre
																								
																								FROM 
																								
																								siq_procesopecar
																								
																								
																								WHERE
																								
																								codigoestado=100
																								AND
																								id_padre="'.$Proceso_Pecar->fields['idsiq_procesopecar'].'"';
																								
																						if($SubProceso=&$db->Execute($SQL_SubProceso)===false){
																								echo 'Error en el SQl SubProceso....<br>'.$SQL_SubProceso;
																								die;
																							}		
																				?>
                                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                                <?PHP			
																				while(!$SubProceso->EOF){
																					?>
                                                                                    <tr>
                                                                                    	<td class="Border">
                                                                                    	<div  class="SubProcesoStyle" style="border:#60F solid 1px; width:90%; float:right; clear:both" id="Div_SubProceso_<?PHP echo $SubProceso->fields['idsiq_procesopecar']?>"><!--Contenedor SubProceso--->
                                                                                        	<h4><?PHP echo $SubProceso->fields['nombre']?></h4>
                                                                                            <?PHP
																						    
																							   $SQL_AreaSubPro='SELECT 
																												siq_area.idsiq_area, 
																												siq_area.nombre 
												
																												FROM 
																												siq_area INNER JOIN siq_indicadorGenerico AS indGen ON (siq_area.idsiq_area=indGen.area OR siq_area.disponible=1) 
																														 INNER JOIN siq_indicador AS ind ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico
												
																												WHERE 
																												siq_area.codigoestado=100 
																												AND 
																												indGen.codigoestado=100 
																												AND 
																												siq_area.id_procesopecar="'.$SubProceso->fields['idsiq_procesopecar'].'"
																												AND 
																												ind.codigoestado=100 
																												AND 
																												ind.discriminacion="'.$dato.'" 
																												AND
																												ind.idCarrera="'.$Programa.'"
																												
																												GROUP BY siq_area.idsiq_area';
                                                                                            	  
																								  
																								  /*$SQL_AreaSubPro='SELECT 

																													idsiq_area,
																													nombre
																													
																													FROM 
																													
																													siq_area
																													
																													WHERE
																													
																													codigoestado=100
																													AND
																													id_procesopecar="'.$SubProceso->fields['idsiq_procesopecar'].'"';*/
																													
																										  if($Areas_SubPro=&$db->Execute($SQL_AreaSubPro)===false){
																												echo 'Error en el SQL AreaSubPro ....<br>'.$SQL_AreaSubPro;
																												die;
																											  }	
																											  
																									$SubPro_Areas = $Areas_SubPro->GetArray();
																									
																									$n = 2;
																									
																									for($k=0;$k<count($SubPro_Areas);$k++){#Inicio For		
																									?>
                                                                                                    
                                                                                                     <?PHP $this->Semaforo($SubPro_Areas[$k]['idsiq_area'],$dato,$Programa)?>
																									<div style="text-align:center; border:#C485F7 solid 1px; width:30%; float:left; margin:0 10px; cursor:pointer" onclick="VerIndicador(<?PHP echo $SubPro_Areas[$k]['idsiq_area']?>,'<?PHP echo $dato?>','<?PHP echo $Programa?>')" class="AreaStyle"><?PHP echo $SubPro_Areas[$k]['nombre']?></div>		
                                                                                                    <br />
																									<?PHP
																											
																									}#fin del For		  
																							?>
                                                                                             <br />
                                                                                        </div><!--Fin del Contenedor SubProceso-->
                                                                                         </td>
                                                                                      </tr>   
                                                                                        <br />
                                                                                    <?PHP
																					$SubProceso->MoveNext();
																					}#Fin while			
																		?>
                                                                        </table>
                                                                        <div style="height:1px; clear:both"></div>
                                                                	</div><!---Fin del Contenedor Proceso-->
                                                                </td>
                                                            </tr>
                                                            <?PHP
															$Proceso_Pecar->MoveNext();
															}
													?>	
                                                    </table>
                                    			</div>
											<?PHP
											$Pecar->MoveNext();
											}
									?>
                                </div>
                            </td>
                        </tr>
                     </table>
                     </fieldset>
   <script type="text/javascript" language="javascript" src="../../js/jquery-3.6.0.js"></script>
   <script type="text/javascript" language="javascript" src="../../js/jquery-ui.js"></script>

    
                <?PHP
			}
	  public function Semaforo($id_area,$dato,$programa){

		  global $userid,$db;
		  
		  if($dato==3){
					$Dato_programa='AND ind.idCarrera="'.$programa.'"';
				}else{
					$Dato_programa='';
					}
				
				         $SQL_indTotal='SELECT 

										COUNT(ind.idEstado) as Num
										
										FROM 
										
										siq_indicador as ind INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
										
										WHERE
										
										ind.discriminacion="'.$dato.'"
										AND
										indGen.area="'.$id_area.'"
										AND
										ind.codigoestado=100
										AND
										indGen.codigoestado=100
										'.$Dato_programa;
										
										
								if($Num_indTotal=&$db->Execute($SQL_indTotal)===false){
										echo 'Error en el SQL Indicador.......<br>'.$SQL_indTotal;
										die;
									}		
						###########################
						$Num_indTotal->fields['Num'];
						###########################				
					
			    $SQL_IndDesactualizado='SELECT 

										COUNT(ind.idEstado) as Num,
										ind.idEstado
										
										FROM 
										
										siq_indicador as ind INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
										
										WHERE
										
										ind.discriminacion="'.$dato.'"
										AND
										indGen.area="'.$id_area.'"
										AND
										ind.codigoestado=100
										AND
										indGen.codigoestado=100
										'.$Dato_programa.'
										AND
										ind.idEstado=1
										
										GROUP BY ind.idEstado';
										
							if($Num_indDesactualizado=&$db->Execute($SQL_IndDesactualizado)===false){
									echo 'Error en el SQL Indicador.......<br>'.$SQL_IndDesactualizado;
									die;
								}
						
						###########################
						/*echo '<br>Num->'.$Num_indDesactualizado->fields['Num'];
						echo '<br>id-->'.$Num_indDesactualizado->fields['idEstado'];*/
						
						$PorcentajeDesactualizado = 0;
						$PorcentajeDesactualizado = ($Num_indDesactualizado->fields['Num']*100)/$Num_indTotal->fields['Num'];
						###########################
						
								
				       $SQL_IndProceso='SELECT 

										COUNT(ind.idEstado) as Num,
										ind.idEstado
										
										FROM 
										
										siq_indicador as ind INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
										
										WHERE
										
										ind.discriminacion="'.$dato.'"
										AND
										indGen.area="'.$id_area.'"
										AND
										ind.codigoestado=100
										AND
										indGen.codigoestado=100
										'.$Dato_programa.'
										AND
										(ind.idEstado=2 OR ind.idEstado=3)';
										
							if($Num_indProceso=&$db->Execute($SQL_IndProceso)===false){
									echo 'Error en el SQL Indicador.......<br>'.$SQL_IndProceso;
									die;
								}	
								
						###########################
						/*echo '<br>Num->'.$Num_indProceso->fields['Num'];
						echo '<br>id-->'.$Num_indProceso->fields['idEstado'];*/
						
						$PorcentajeProceso = 0;
						$PorcentajeProceso = ($Num_indProceso->fields['Num']*100)/$Num_indTotal->fields['Num'];
						###########################			
								
				   $SQL_IndActualizado='SELECT 

										COUNT(ind.idEstado) as Num,
										ind.idEstado
										
										FROM 
										
										siq_indicador as ind INNER JOIN siq_indicadorGenerico as indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
										
										WHERE
										
										ind.discriminacion="'.$dato.'"
										AND
										indGen.area="'.$id_area.'"
										AND
										ind.codigoestado=100
										AND
										indGen.codigoestado=100
										'.$Dato_programa.'
										AND
										ind.idEstado=4
										
										GROUP BY ind.idEstado';
										
							if($Num_indActualizado=&$db->Execute($SQL_IndActualizado)===false){
									echo 'Error en el SQL Indicador.......<br>'.$SQL_IndActualizado;
									die;
								}	
								
						###########################
						/*echo '<br>Num->'.$Num_indActualizado->fields['Num'];
						echo '<br>id-->'.$Num_indActualizado->fields['idEstado'];*/
						
						$PorcentajeActualizado = 0;
						$Porcentaje = 0;
						$PorcentajeActualizado = ($Num_indActualizado->fields['Num']*100)/$Num_indTotal->fields['Num'];
						
						$Porcentaje = $PorcentajeProceso+$PorcentajeActualizado;
						
						#echo '$PorcentajeDesactualizado->'.$PorcentajeDesactualizado.'<br>$Porcentaje->'.$PorcentajeProceso.'<br>$PorcentajeActualizado->'.$PorcentajeActualizado;
						
						$dividir  = $PorcentajeDesactualizado+$PorcentajeProceso+$PorcentajeActualizado;
						
						if($PorcentajeDesactualizado>50){
							$valor = 100-$PorcentajeDesactualizado;
							?>
								<hr style="border:#FF0000 solid 1px;width:30%;margin:0 10px 10px;cursor:pointer" class="Semaforo" title="<?PHP echo $valor?>%" />
                             <?PHP   
							}
							if($Porcentaje>50 && $PorcentajeActualizado!=100){
									
								?>
								<hr style="border:#eec840 solid 1px;width:30%;margin:0 10px 10px;cursor:pointer" class="Semaforo" title="<?PHP echo $Porcentaje?>%" />
                             <?PHP 
							}
							 if($PorcentajeActualizado==100){
								?>
								<hr style="border:#090 solid 1px;width:30%;margin:0 10px 10px; cursor:pointer" class="Semaforo" title="<?PHP echo $PorcentajeActualizado?>%" />
                             <?PHP 
							}	
						###########################											
			
				
		  }	
	
	}#Class
	function esPar($numero){ 
	   $resto = $numero%2; 
	   if (($resto==0) && ($numero!=0)) { 
			return 0;#true ->par
	   }else{ 
			return 1; #false -->Impar
	   }  
	}
?>