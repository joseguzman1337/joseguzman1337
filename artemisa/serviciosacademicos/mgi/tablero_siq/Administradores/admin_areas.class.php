<?PHP 
class admin_areas{
	
		public function Principal(){
			
			#########################################
			global $userid,$db;
			
			?>
            
             <div id="container">
            
            <h1>Administracion de Areas</h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Editar</span>
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span>  
                </button>              
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Nombre del Area</th>
                            <th>Fecha Última Modificación</th>
                            <th>Nombre Usuario</th>
                            <th>xxxxxxxxxxxx</th>
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
		public function Editar($id_area){
			
				global $userid,$db;
				
				$SQL_Area='SELECT 

									idsiq_area,
									nombre,
									disponible
							
							FROM 
							
									siq_area
							
							WHERE
							
									idsiq_area="'.$id_area.'"
									AND
									codigoestado=100';
									
							if($Nom_area=&$db->Execute($SQL_Area)===false){
									echo 'Error al buscar el Nombre del Area....<br>'.$SQL_Area;
									die;
								}		
				?>
               
                <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Editar Area.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información del Area</legend>
                     	<table width="90%" border="0" cellpadding="0" cellspacing="0" class="Text">
                        	<tr>
                            	<td width="16%" align="left"><strong>Nombre del Area: <span class="mandatory">(*)</span></strong></td>
                                <td width="84%" align="left"><input type="text" id="nom_area" name="nom_area" style="text-align:center" value="<?PHP echo $Nom_area->fields['nombre']?>" size="80"  class="cajas" ><input type="hidden" id="id_area" name="id_area" value="<?PHP echo $id_area?>" /></td>
                            </tr>
                            <?PHP 
								if($Nom_area->fields['disponible']==0){
										$RadioSi = 'checked="checked"';
										$RadioNo = '';
									}else{
											$RadioSi = '';
											$RadioNo = 'checked="checked"';
										}
							?>
                            <tr>
                            	<td colspan="2" class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td width="16%" align="left"><strong>Disponible: <span class="mandatory">(*)</span></strong></td>
                                <td width="84%" align="left"><input type="radio" id="si" name="disponible" <?PHP echo $RadioSi?>/><strong>Si.</strong>&nbsp;&nbsp;&nbsp;<input type="radio" id="no" name="disponible"  <?PHP echo $RadioNo?>/><strong>No.</strong></td>
                            </tr>
                            <tr>
                            	<td colspan="2" >&nbsp;</td>
                            </tr>
                        </table>
                     </fieldset>
                  	<div align="center"><input type="button" align="bottom" class="first" value="Guaradar Cambios." style="height:80%" onclick="Modificar_Area()"/></div>
                <?PHP
			}
			
		
		public function Nueva_area(){
				?>
                <br /><br />
                <div style="font-size:44px; font-family:'Times New Roman', Times, serif"><strong>Nueva Area.</strong></div>
                	<span class="mandatory">* Son campos obligatorios</span>
                	 <fieldset>
                     <legend>Información del Area</legend>
                     
                     	<table width="90%" border="0" cellpadding="0" cellspacing="0" class="Text">
                        	<tr>
                            	<td width="16%" align="left"  class="Border"><strong>Nombre del Area: <span class="mandatory">(*)</span></strong></td>
                                <td width="84%" align="left"  class="Border"><input type="text" id="nom_area" name="nom_area" style="text-align:center" size="80"  class="cajas" ></td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="Border">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td width="16%" align="left" class="Border"><strong>Disponible: <span class="mandatory">(*)</span></strong></td>
                                <td width="84%" align="left" class="Border"><input type="radio" id="si" name="disponible" /><strong>Si.</strong>&nbsp;&nbsp;&nbsp;<input type="radio" id="no" name="disponible" /><strong>No.</strong></td>
                            </tr>
                            <tr>
                            	<td colspan="2"  class="Border">&nbsp;</td>
                            </tr>
                        </table>
                     </fieldset>
                  	<div align="center"><input type="button" align="bottom" class="first" value="Guardar." style="height:80%" onclick="New_Area()"/></div>
                <?PHP
			}		
	
	}
?>