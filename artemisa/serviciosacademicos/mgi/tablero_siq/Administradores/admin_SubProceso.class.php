<?PHP 
class admin_SubProceso{
	
		public function Principal(){
			#########################################
			global $userid,$db;
			
			?>
            
             <div id="container">
            
                <h1>Administracion de Niveles</h1>
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
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
                        <thead>
                            <tr>                            
                                <th>Nombre del Sub-Proceso</th>
                                <th>Nombre Proceso</th>
                                <th>Pecar</th>
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
		
			$SQL_Datos='SELECT  
								subPro.idsiq_procesopecar,
								subPro.nombre,
								pro.nombre as nom_proceso,
								pro.idsiq_procesopecar as id_padre
								
						FROM 
								siq_procesopecar as subPro INNER JOIN siq_procesopecar as pro ON subPro.id_padre=pro.idsiq_procesopecar  
								AND subPro.codigoestado=100 
								AND pro.codigoestado=100 
								AND subPro.idsiq_procesopecar="'.$id.'"';
								
						
						if($Datos_SubProceso=&$db->Execute($SQL_Datos)===false){
								echo 'Error en el SQL Datos....<br>'.$SQL_Datos;
								die;
							}		
		
			?>
            <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Editar Nivele.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información del Nivel</legend>
                     
                     	<table width="90%" border="0" cellpadding="0" cellspacing="0" class="Text">
                        	<tr>
                            	<td width="16%" align="left"  class="Border"><strong>Nombre del Nivel: <span class="mandatory">(*)</span></strong></td>
                                <td width="84%" align="left"  class="Border"><input type="text" id="nom_Sub" name="nom_Sub" style="text-align:center" size="80"  class="cajas" value="<?PHP echo $Datos_SubProceso->fields['nombre']?>" ><input type="hidden" id="id_SubPro" name="id_SubPro" value="<?PHP echo $Datos_SubProceso->fields['idsiq_procesopecar']?>" /></td>
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
                            	<td class="Border"><strong>Nombre del Prespectiva: <span class="mandatory">(*)</span></strong></td>
                                <td class="Border">
                                	<select id="Proceso_id" name="Proceso_id" style="width:auto" class="cajas">
                                    	<option value="<?PHP echo $Datos_SubProceso->fields['id_padre']?>"><?PHP echo $Datos_SubProceso->fields['nom_proceso']?></option>
                                        <?PHP 
											while(!$SubProceso->EOF){
												if($Datos_SubProceso->fields['id_padre']!=$SubProceso->fields['idsiq_procesopecar']){
												?>
                                                <option value="<?PHP echo $SubProceso->fields['idsiq_procesopecar']?>"><?PHP echo $SubProceso->fields['nombre']?></option>
												<?PHP
												}
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
                  	<div align="center"><input type="button" align="bottom" class="first" value="Guaradar Cambio." style="height:80%" onclick="Edit_SubProceso()"/></div>
                    <br />
            <?PHP
			
		}		
	public function EstructuraSubProceso($id){
		include('admin_Proceso.class.php');
			global $userid,$db;
			
				$SQL_SubProceso='SELECT  
								subPro.idsiq_procesopecar,
								subPro.nombre,
								pro.nombre as nom_proceso,
								pro.idsiq_procesopecar as id_padre,
								p.nombre as nom_pecar
								
						FROM 
								siq_procesopecar as subPro INNER JOIN siq_procesopecar as pro ON subPro.id_padre=pro.idsiq_procesopecar INNER JOIN siq_pecar as p ON pro.id_pecar=p.idsiq_pecar  								AND p.codigoestado=100
								AND subPro.codigoestado=100 
								AND pro.codigoestado=100 
								AND subPro.idsiq_procesopecar="'.$id.'"';
														
					if($SubProceso=&$db->Execute($SQL_SubProceso)===false){
							echo 'Error al buscar el Nombre del SubProceso....<br>'.$SQL_SubProceso;
							die;
						}
			?>
            <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Estructurar Nivel.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información del Nivel</legend>
                     	<table border="0" cellpadding="0" cellspacing="0" width="90%" style="font-family:'Times New Roman', Times, serif" align="center">
                        	<tr>
                            	<td class="Border" width="40%"><legend>Nombre del Nivel :</legend></td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%">
                                	<?PHP echo $SubProceso->fields['nombre']?><input type="hidden" id="SubProceso_id" name="SubProceso_id" value="<?PHP echo $id?>"/>
                                </td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%"><legend>Nombre Prespectiva :</legend></td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%">
                                	<?PHP echo $SubProceso->fields['nom_proceso']?>
                                </td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%"><legend>Nombre PECAR :</legend></td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td class="Border" width="40%">
                                	<?PHP echo $SubProceso->fields['nom_pecar']?>
                                </td>
                                <td class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="Border">
                                	<div id="Div_carga"><?PHP admin_Proceso::Cargar_AreasPro($id)?></div>
                                </td>
                            </tr>
                             <tr>
                            	<td colspan="2" class="Border">&nbsp;<input type="hidden" id="Cadena_SubPro" name="Cadena_Pro" />&nbsp;<input type="hidden" id="CadenaLibre" name="CadenaLibre" /></td>
                            </tr>
                            
                        </table>
                     </fieldset>
                      <br />
                  	<div align="center"><input type="button" align="bottom" class="first" value="Guaradar." style="height:80%" onclick="Save_AreasSubPro()"/></div>
                    <br />
            <?PHP
		}		
}
?>
			