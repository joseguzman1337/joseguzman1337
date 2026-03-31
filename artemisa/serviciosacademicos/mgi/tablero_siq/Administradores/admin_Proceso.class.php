<?PHP 
class admin_Proceso{
	
		public function Principal(){
			
			#########################################
			global $userid,$db;
			
			?>
            
             <div id="container">
            
            <h1>Administracion de Perspectivas</h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Editar</span>
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span> 
                </button>
                <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Estructurar</span> 
                </button>              
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Nombre del Area</th>
                            <th>Fecha Última Modificación</th>
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div>
        </div>            
			<?PHP	
			#########################################
			}
		public function Editar($id){
			
				global $userid,$db;
				
				  $SQL_Proceso='SELECT 

										pro.idsiq_procesopecar,
										pro.nombre,
										p.nombre as Nom_pecar,
										p.idsiq_pecar
								
								FROM 
								
								siq_procesopecar  as pro INNER JOIN siq_pecar as p ON pro.id_pecar=p.idsiq_pecar 
								AND pro.codigoestado=100 
								AND p.codigoestado=100 
								AND pro.idsiq_procesopecar="'.$id.'"';
									
							if($Datos_proceso=&$db->Execute($SQL_Proceso)===false){
									echo 'Error al buscar el Nombre del Area....<br>'.$SQL_Area;
									die;
								}		
				?>
               
               <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Editar Prespectiva.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información de la Perspectiva</legend>
                     
                     	<table width="90%" border="0" cellpadding="0" cellspacing="0" class="Text">
                        	<tr>
                            	<td width="16%" align="left"  class="Border"><strong>Nombre de la Prescpectiva: <span class="mandatory">(*)</span></strong></td>
                                <td width="84%" align="left"  class="Border"><input type="text" id="nom_proceso" name="nom_proceso" style="text-align:center" size="80"  class="cajas" value="<?PHP echo $Datos_proceso->fields['nombre']?>" ><input type="hidden" id="id_proceso" name="id_proceso" value="<?PHP echo $id?>" /></td>
                            </tr>
                            <?PHP 
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
							?>
                            <tr>
                            	<td class="Border"><strong>Estrutura PECAR</strong></td>
                                <td class="Border">
                                	<select id="id_pecar" name="id_pecar" style="width: auto">
                                    	<option value="<?PHP echo $Datos_proceso->fields['idsiq_pecar']?>"><?PHP echo $Datos_proceso->fields['Nom_pecar']?></option>
                                        <?PHP 
											while(!$Pecar->EOF){
												if($Datos_proceso->fields['idsiq_pecar']!=$Pecar->fields['idsiq_pecar']){
												?>
                                                <option value="<?PHP echo $Pecar->fields['idsiq_pecar']?>"><?PHP echo $Pecar->fields['nombre']?></option>
												<?PHP
												}
												$Pecar->MoveNext();
												}
										?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2" rowspan="2"  class="Border">&nbsp;</td>
                            </tr>
                        </table>
                     </fieldset>
                     <br />
                  	<div align="center"><input type="button" align="bottom" class="first" value="Guardar Cambio." style="height:80%" onclick="Modificar_Proceso()"/></div>
                    <br />
                <?PHP
			}
			
		
		public function Nuevo_Proceso(){
			global $userid,$db;
				?>
                <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Nueva Perspectiva.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información de la Prespectiva</legend>
                     
                     	<table width="90%" border="0" cellpadding="0" cellspacing="0" class="Text">
                        	<tr>
                            	<td width="16%" align="left"  class="Border"><strong>Nombre de la Prespectiva: <span class="mandatory">(*)</span></strong></td>
                                <td width="84%" align="left"  class="Border"><input type="text" id="nom_proceso" name="nom_proceso" style="text-align:center" size="80"  class="cajas" ></td>
                            </tr>
                            <?PHP 
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
							?>
                            <tr>
                            	<td class="Border"><strong>Estrutura PECAR:<span class="mandatory">(*)</span></strong></td>
                                <td class="Border">
                                	<select id="id_pecar" name="id_pecar" style="width: auto">
                                    	<option value="-1">Elige...</option>
                                        <?PHP 
											while(!$Pecar->EOF){
												?>
                                                <option value="<?PHP echo $Pecar->fields['idsiq_pecar']?>"><?PHP echo $Pecar->fields['nombre']?></option>
												<?PHP
												$Pecar->MoveNext();
												}
										?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2" rowspan="2"  class="Border">&nbsp;</td>
                            </tr>
                        </table>
                     </fieldset>
                     <br />
                  	<div align="center"><input type="button" align="bottom" class="first" value="Guardar." style="height:80%" onclick="New_Proceso()"/></div>
                    <br />
                <?PHP
			}		
		public function Nuevo_SubProceso(){
			global $userid,$db;
			?>
            <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Nuevo Nivel.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información del Nivel</legend>
                     
                     	<table width="90%" border="0" cellpadding="0" cellspacing="0" class="Text">
                        	<tr>
                            	<td width="16%" align="left"  class="Border"><strong>Nombre del Nivel: <span class="mandatory">(*)</span></strong></td>
                                <td width="84%" align="left"  class="Border"><input type="text" id="nom_Sub" name="nom_Sub" style="text-align:center" size="80"  class="cajas" ></td>
                            </tr>
                            <?PHP 
								$SQL_SubProceso='SELECT 

															idsiq_procesopecar,
															nombre
												
												FROM 
												
															siq_procesopecar
												
												WHERE
												
															codigoestado=100
															AND
															id_padre=0';
															
											if($SubProceso=&$db->Execute($SQL_SubProceso)===false){
													echo 'Error en el SQL del SubProceso....<br>'.$SQL_SubProceso;
													die;
												}							
							?>
                            <tr>
                            	<td class="Border"><strong>Nombre de la Prespectiva: <span class="mandatory">(*)</span></strong></td>
                                <td class="Border">
                                	<select id="Proceso_id" name="Proceso_id" style="width:auto" class="cajas">
                                    	<option value="-1">Elige...</option>
                                        <?PHP 
											while(!$SubProceso->EOF){
												?>
                                                <option value="<?PHP echo $SubProceso->fields['idsiq_procesopecar']?>"><?PHP echo $SubProceso->fields['nombre']?></option>
												<?PHP
												$SubProceso->MoveNext();
												}
										?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2" rowspan="2"  class="Border">&nbsp;</td>
                            </tr>
                        </table>
                     </fieldset>
                     <br />
                  	<div align="center"><input type="button" align="bottom" class="first" value="Guardar." style="height:80%" onclick="New_SubProceso()"/></div>
                    <br />
            <?PHP
			}	
	
	public function EsturturaTablero(){
		global $userid,$db;
		?>
                 <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Generar Tablero Control.</strong></div>
                	
                	 <fieldset>
                     <legend>Tablero...</legend>
                     		<table border="0" cellpadding="0" cellspacing="0">
                            	<?PHP 
								    $SQL_falcutad='SELECT 
		
																codigofacultad as id,
																nombrefacultad
													
													FROM 
													
																facultad
													
													            ORDER BY nombrefacultad ASC';
																
																
												if($Facultad=&$db->Execute($SQL_falcutad)===false){
														echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
														die;
													}
													
													
											 
								?>
                            	<tr>
                                	<td class="Border">&nbsp;</td>
                                    <td class="Border"><input type="radio" name="Tablero" id="Institucional" onclick="Ocultar()" />&nbsp;<strong>Institucional.</strong></td>
                                    <td class="Border">&nbsp;</td>
                                    <td class="Border"><input type="radio" name="Tablero" id="Programa" onclick="VerFacultad()" />&nbsp;<strong>Programa.</strong></td>
                                    <td class="Border">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td class="Border">&nbsp;</td>   
                                    <td class="Border" id="label" style="display:none" ><strong>Facultad:</strong></td>
                                    <td class="Border">&nbsp;</td>
                                    <td class="Border" id="labelPrograma" style="display:none" ><strong>Programa:</strong></td>
                                    <td class="Border">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td class="Border">&nbsp;</td>
                                    <td class="Border" id="select" style="display:none" align="center">
                                    	<select id="Faculta_id" name="Faculta_id"  style="width:auto" class="cajas">
                                            <option value="-1">Elige...</option>
                                                <?PHP 
                                                    while(!$Facultad->EOF){
                                                            ?>
                                                            <option value="<?PHP echo $Facultad->fields['id']?>" onclick="VerPrograma(<?PHP echo $Facultad->fields['id']?>)"><?PHP echo $Facultad->fields['nombrefacultad']?></option>
                                                            <?PHP
                                                        $Facultad->MoveNext();	
                                                        }
                                                ?>
                                            </option>
                                        </select> 
                                    </td>
                                    <td class="Border">&nbsp;</td>
                                    <td class="Border" align="center" id="TdPrograma"></td>
                                    <td class="Border">&nbsp;</td>
                                </tr>
                            </table>
                     </fieldset>
                     <br /><br />
                     <div align="center"><input type="button" id="GenerarTablero" value="Ver Tablero..."  style="height:80%" class="first" onclick="VerTablero()"/></div>
                     <br />
                     
        <?PHP
		}
	
	public function EstructuraPecar(){
			global $userid,$db;
			?>
            <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Estructurar PECAR.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información del PECAR</legend>
                     	<table border="0" cellpadding="0" cellspacing="0" width="90%" style="font-family:'Times New Roman', Times, serif" align="center">
                        	<tr>
                            	<td class="Border" width="40%"><strong>Nombre Estructura PECAR:</strong></td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%">
                                	<input type="text"  id="Pecar" name="Pecar" autocomplete="off"  style="text-align:center;width:90%;" size="70" onClick="formReset();" onKeyPress="autocomplet()"  /><input type="hidden" id="Pecar_id" name="Pecar_id"/>
                                </td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="Border">
                                	<div id="Div_carga"></div>
                                </td>
                            </tr>
                             <tr>
                            	<td colspan="2" class="Border">&nbsp;<input type="hidden" id="Cadena_P" name="Cadena_P" />&nbsp;&nbsp;<input type="hidden" id="CadenaLibre" name="CadenaLibre" /></td>
                            </tr>
                            
                        </table>
                     </fieldset>
                      <br />
                  	<div align="center"><input type="button" align="bottom"  value="Guardar." style="height:80%" class="first" onclick="Save_AreasPecar()"/></div>
                    <br />
            <?PHP
		}
		
	 public function Cargar_Areas($id){
		 global $userid,$db;
		 
							 $SQL_areas='SELECT 

													idsiq_area,
													nombre
										
										
										FROM 
										
													siq_area
										
										WHERE
										
													id_pecar=0
													AND
													id_procesopecar=0
													AND
													codigoestado=100';
													
										if($Areas_list=&$db->Execute($SQL_areas)===false){
												echo 'Error en el lista de areas....<br>'.$SQL_areas;
												die;
											}			
    						?>
                           
                                	<table border="0" style="font-family:'Times New Roman', Times, serif">
                                    	<tr>
                                        	<td class="Border" align="left">
                                             <fieldset>
                                                <legend>Areas sin Relacionar:</legend>
                                                <div id="Contenedor_1" style="width:450px; height:400px; overflow: scroll;" >
                                                    <ul id="sortable1" class="connectedSortable">
                                                        <?PHP 
														
                                                            while(!$Areas_list->EOF){
                                                                ?>
                                                                <li class="ui-state-default" style="text-align:left; width:400px;cursor:pointer" id="<?PHP echo $Areas_list->fields['idsiq_area']?>"><?PHP echo $Areas_list->fields['nombre']?></li>
                                                                <?PHP
                                                                $Areas_list->MoveNext();
                                                                }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </fieldset>
                                            </td>
                                            <td class="Border" colspan="2">&nbsp;&nbsp;</td>
                                            <?PHP
											$SQL_areasP='SELECT 
				
																	idsiq_area,
																	nombre
														
														
														FROM 
														
																	siq_area
														
														WHERE
														
																	id_pecar="'.$id.'"
																	AND
																	codigoestado=100';
																	
														if($Areas_listPecar=&$db->Execute($SQL_areasP)===false){
																echo 'Error en el lista de areas....<br>'.$SQL_areasP;
																die;
															}			
											?>
                                            <td class="Border" align="right">
                                            <fieldset>
                                                <legend>Areas Relacionadas:</legend>
                                                <div id="Contenedor_2" style="width:450px; height:400px; overflow: scroll;" >
                                                    <ul id="sortable2" class="connectedSortable">
                                                        <li class="ui-state-highlight" style="text-align:left; width:400px">Arrastre Aqui....</li>
                                                        <?PHP 
															while(!$Areas_listPecar->EOF){
																?>
                                                                <li class="ui-state-default" style="text-align:left; width:400px;cursor:pointer" id="<?PHP echo $Areas_listPecar->fields['idsiq_area']?>"><?PHP echo $Areas_listPecar->fields['nombre']?></li>
																<?PHP
																$Areas_listPecar->MoveNext();
																}
														?>
                                                    </ul>
                                                </div> 
                                            </fieldset>           
                                            </td>
                                        </tr>
                                    </table>
                               
         <?PHP
		 }	
		
	public function EstructuraProceso($id){
			global $userid,$db;
			
				$SQL_Proceso='SELECT 

										pro.idsiq_procesopecar,
										pro.nombre,
										p.nombre as Nom_pecar,
										p.idsiq_pecar
								
								FROM 
								
										siq_procesopecar  as pro INNER JOIN siq_pecar as p ON pro.id_pecar=p.idsiq_pecar 
										AND pro.codigoestado=100 
										AND p.codigoestado=100 
										AND pro.idsiq_procesopecar="'.$id.'"';
														
					if($Proceso=&$db->Execute($SQL_Proceso)===false){
							echo 'Error al buscar el Nombre del Proceso....<br>'.$SQL_Proceso;
							die;
						}
			?>
            <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Estructurar Prespectiva.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información de la Prespectiva</legend>
                     	<table border="0" cellpadding="0" cellspacing="0" width="90%" style="font-family:'Times New Roman', Times, serif" align="center">
                        	<tr>
                            	<td class="Border" width="40%"><legend>Nombre de la Prespectiva:</legend></td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%">
                                	<?PHP echo $Proceso->fields['nombre']?><input type="hidden" id="Proceso_id" name="Proceso_id" value="<?PHP echo $id?>"/>
                                </td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%"><legend>Nombre PECAR :</legend></td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%">
                                	<?PHP echo $Proceso->fields['Nom_pecar']?><input type="hidden" id="pecar_id" name="pecar_id" value="<?PHP echo $Proceso->fields['idsiq_pecar']?>"/>
                                </td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="Border">
                                	<div id="Div_carga"><?PHP $this->Cargar_AreasPro($id)?></div>
                                </td>
                            </tr>
                             <tr>
                            	<td colspan="2" class="Border">&nbsp;<input type="hidden" id="Cadena_Pro" name="Cadena_Pro" />&nbsp;<input type="hidden" id="CadenaLibre" name="CadenaLibre" /></td>
                            </tr>
                            
                        </table>
                     </fieldset>
                      <br />
                  	<div align="center"><input type="button" align="bottom" class="first" value="Guardar." style="height:80%" onclick="Save_AreasPro()"/></div>
                    <br />
            <?PHP
		}	
		
	 public function Cargar_AreasPro($id){
		 global $userid,$db;
		 
							 $SQL_areas='SELECT 

													idsiq_area,
													nombre
										
										
										FROM 
										
													siq_area
										
										WHERE
										
													id_pecar=0
													AND
													id_procesopecar=0
													AND
													codigoestado=100';
													
										if($Areas_list=&$db->Execute($SQL_areas)===false){
												echo 'Error en el lista de areas....<br>'.$SQL_areas;
												die;
											}			
    						?>
                           
                                	<table border="0" style="font-family:'Times New Roman', Times, serif">
                                    	<tr>
                                        	<td class="Border" align="left">
                                             <fieldset>
                                                <legend>Areas sin Relacionar:</legend>
                                                <div id="Contenedor_1" style="width:450px; height:400px; overflow: scroll;" >
                                                    <ul id="sortable1" class="connectedSortable">
                                                        <?PHP 
														
                                                            while(!$Areas_list->EOF){
                                                                ?>
                                                                <li class="ui-state-default" style="text-align:left; width:400px; cursor:pointer" id="<?PHP echo $Areas_list->fields['idsiq_area']?>"><?PHP echo $Areas_list->fields['nombre']?></li>
                                                                <?PHP
                                                                $Areas_list->MoveNext();
                                                                }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </fieldset>
                                            </td>
                                            <td class="Border" colspan="2">&nbsp;&nbsp;</td>
                                            <?PHP
											$SQL_areasP='SELECT 
				
																	idsiq_area,
																	nombre
														
														
														FROM 
														
																	siq_area
														
														WHERE
														
																	id_procesopecar="'.$id.'"
																	AND
																	codigoestado=100';
																	
														if($Areas_listPecar=&$db->Execute($SQL_areasP)===false){
																echo 'Error en el lista de areas....<br>'.$SQL_areasP;
																die;
															}			
											?>
                                            <td class="Border" align="right">
                                            <fieldset>
                                                <legend>Areas Relacionadas:</legend>
                                                <div id="Contenedor_2" style="width:450px; height:400px; overflow: scroll;" >
                                                    <ul id="sortable2" class="connectedSortable">
                                                        <li class="ui-state-highlight" style="text-align:left; width:400px">Arrastre Aqui....</li>
                                                        <?PHP 
															while(!$Areas_listPecar->EOF){
																?>
                                                                <li class="ui-state-default" style="text-align:left; width:400px; cursor:pointer" id="<?PHP echo $Areas_listPecar->fields['idsiq_area']?>"><?PHP echo $Areas_listPecar->fields['nombre']?></li>
																<?PHP
																$Areas_listPecar->MoveNext();
																}
														?>
                                                    </ul>
                                                </div> 
                                            </fieldset>           
                                            </td>
                                        </tr>
                                    </table>
                               
         <?PHP
		 }	
	public function Programa_ajax($id){
		 global $userid,$db;
				 							 
											 
											 
											 $SQL='SELECT 

															codigocarrera as id,
															nombrecarrera
													
													FROM 
													
															carrera
															
													WHERE
															codigofacultad="'.$id.'"
															ORDER BY nombrecarrera ASC';
															
													if($Select_Option=&$db->Execute($SQL)===false){
														echo 'Error en el SQL Secte del Ajax...<br>'.$SQL;
														die;
													}
													
				?>
                	<select id="Programa_id" name="Programa_id" class="cajas" style="width:auto">
                    	<option value="-1">Elige...</option>
                        <?PHP 
							while(!$Select_Option->EOF){
								?>
                                <option value="<?PHP echo $Select_Option->fields['id']?>"><?PHP echo $Select_Option->fields['nombrecarrera']?></option>
                                <?PHP
								$Select_Option->MoveNext();
								}
						?>
                    </select>
                <?PHP										
		}	 		
	}
	function esPar($numero){ 
	   $resto = $numero%2; 
	   if (($resto==0) && ($numero!=0)) { 
			return 0;#true ->par
	   }else{ 
			return 1; #false -->Impar
	   }  
	}

?>
