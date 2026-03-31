<?PHP 
class Insturmneto{
	public function Facultad($type,$Ext){
		global $db;
		
		 $SQL_Facultad='SELECT 
						
						codigofacultad,
						nombrefacultad
						
						FROM 
						
						facultad
						
						WHERE
						
						codigofacultad<>10
						
						ORDER BY nombrefacultad';
						
				if($Facultad=&$db->Execute($SQL_Facultad)===false){
						echo 'Error en el SQL  Facultad....<br><br>'.$SQL_Facultad;
						die;
					}		
				?>
               <table border="0" width="100%">
               		<thead>
                    	<tr>
                            <?PHP 
							if($type=='Lista'){
							?>
                            <th>Facultad</th>
                            <td>
                            <select id="<?PHP echo $Name?>" name="<?PHP echo $Name?>" style="width:auto">
                                <option value="-1"></option>
                                <?PHP 
                                while(!$Facultad->EOF){
                                /*************************************/
                                ?>
                                <option value="<?PHP echo $Facultad->fields['codigofacultad']?>"><?PHP echo $Facultad->fields['nombrefacultad']?></option>
                                <?PHP
                                /*************************************/
                                $Facultad->MoveNext();
                                }
                                ?>
                                <option value="0"><strong>Todas</strong></option>
                            </select>
                            </td>
                            <?PHP }else if($type=='Check'){?>
                            <td>&nbsp;</td>
                            <td>
                            <fieldset style="width:98%;">
                            <legend>Facultad</legend>
                            <div style="overflow:scroll;width:100%;height:100;overflow-x:hidden">
                            	<table border="0" width="100%">
                                	 <?PHP
									$i=1; 
									while(!$Facultad->EOF){
										?>
										<tr id="Tr_F<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'F<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'F<?PHP echo $Ext?>','CheckFaculta_')" style="cursor:pointer">
                                            <td><?PHP echo $Facultad->fields['nombrefacultad']?></td>
                                            <td><input type="checkbox" id="CheckFaculta_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkFacultad<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoFaculta_<?PHP echo $Ext?>','CheckFaculta_<?PHP echo $Ext?>','F<?PHP echo $Ext?>','CadenaFacultad<?PHP echo $Ext?>')" /><input type="hidden" id="CodigoFaculta_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Facultad->fields['codigofacultad']?>"  /></td>
                                        </tr>
										<?PHP
										$i++;
										$Facultad->MoveNext();
										}
									?>
                                    <tr id="Tr_F<?PHP echo $Ext?><?PHP echo $i+1?>" onmouseover="Sombra(<?PHP echo $i+1?>,'F<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i+1?>,'F<?PHP echo $Ext?>')" style="cursor:pointer">
                                        <td><strong>Todas</strong></td>
                            			<td><input type="checkbox" id="TodasFacultades<?PHP echo $Ext?>" onclick="Inactivar('TodasFacultades<?PHP echo $Ext?>','ChkFacultad<?PHP echo $Ext?>',CadenaFacultad<?PHP echo $Ext?>)" title="Todas las Facultades" /></td>
                                    </tr>
                                </table>
                                <input type="hidden" id="CadenaFacultad<?PHP echo $Ext?>" />
                                <input type="hidden" id="index_<?PHP echo $Ext?>" value="<?PHP echo $i?>" />
                            </div>
                            </fieldset>
                            </td>
                            <?PHP }?>
                        </tr>
                    </thead>
               </table>
                <?PHP	
		}//Funtion Facultad
	public function Modalidad($modalidad,$carrera,$Carga,$type,$Cargamateria='',$Ext,$CodigoCarrera){
		global $db;
		
			
			/*$SQL_Modalidad='SELECT 
							
							codigomodalidadacademicasic AS id,
							nombremodalidadacademicasic as Nombre 
							
							FROM 
							
							modalidadacademicasic
							
							WHERE
							
							codigoestado=100
							AND
							codigomodalidadacademicasic NOT IN (100,400)';*/

			$SQL_Modalidad='SELECT 

							codigomodalidadacademica AS id,
							nombremodalidadacademica as Nombre 

							FROM modalidadacademica

							WHERE

							codigoestado=100
							AND
							codigomodalidadacademica NOT IN (400)';				
							
				if($Modalidad=&$db->Execute($SQL_Modalidad)===false){
						echo 'Error en el SQL Modalidad....<br><br>'.$SQL_Modalidad;
						die;
					}		
		?>
        <select id="<?PHP echo $modalidad?>" name="<?PHP echo $modalidad?>" style="width:auto" onchange="VerCarrera('<?PHP echo $modalidad?>','<?PHP echo $carrera?>','<?PHP echo $Carga?>','<?PHP echo $type?>','<?PHP echo $Cargamateria?>','<?PHP echo $Ext?>','<?PHP echo $CodigoCarrera?>')">
        	<option value="-1"></option>
            <?PHP
            while(!$Modalidad->EOF){
				?>
                <option value="<?PHP echo $Modalidad->fields['id']?>"><?PHP echo $Modalidad->fields['Nombre']?></option>
                <?PHP
				$Modalidad->MoveNext();
				}	
			?>
        </select>				
		<?PHP
		}
	public function Carrera($id,$CodigoCarrera,$type,$Cargamateria='',$Ext,$C_CarreraCodigo){
		global $db;
		
		  /*$SQL_Carrera='SELECT 
						
						codigocarrera,
						nombrecarrera
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademicasic="'.$id.'"
						
						ORDER BY nombrecarrera';*/

			$SQL_Carrera='SELECT 
						
						codigocarrera,
						nombrecarrera
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademica="'.$id.'"
						AND
                        fechavencimientocarrera>=NOW()
                        
						ORDER BY nombrecarrera';			
						
				if($Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL de la Carrera....<br><br>'.$SQL_Carrera;
						die;
					}		
					
		?>
        <table border="0" width="100%">
        	<thead>
            	<tr>
                	<?PHP 
					if($type=='Lista'){
					?>
                	<th>Carrera</th>
                    <th colspan="2">
                    <select id="<?PHP echo $CodigoCarrera?>" name="<?PHP echo $CodigoCarrera?>" style="width:300" onchange="VerMateria('<?PHP echo $CodigoCarrera?>','<?PHP echo $Cargamateria?>','<?PHP echo $Ext?>')">
                        <option value="-1"></option>
                        <?PHP 
                        while(!$Carrera->EOF){
                            ?>
                            <option value="<?PHP echo $Carrera->fields['codigocarrera']?>"><?PHP echo $Carrera->fields['nombrecarrera']?></option>
                            <?PHP
                            $Carrera->MoveNext();
                            }
                        ?>
                    </select>
                    </th>
                    <?PHP }else if($type=='Check'){?>
					 <td>&nbsp;</td>
                    <td colspan="2">
                    <fieldset style="width:98%;">
                    <legend>Carrera</legend>
                    <div style="overflow:scroll;width:100%;height:100;overflow-x:hidden">
                    	<table border="0" width="100%">
                        	<?PHP 
                            if($C_CarreraCodigo==0){
                                $attr   = '';
                                $ValueCadena   = '';
                            }else{
                                 $attr   = 'disabled="disabled"';
                                 $ValueCadena   = '::'.$C_CarreraCodigo;
                            }
                            
                            
							$i=1; 
							while(!$Carrera->EOF){
								?>
								<tr id="Tr_C<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'C<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'C<?PHP echo $Ext?>','CheckCarrera_<?PHP echo $Ext?>')" style="cursor:pointer">
									<td><?PHP echo $Carrera->fields['nombrecarrera']?></td>
                                    <?PHP 
                                        if($C_CarreraCodigo!=0){
                                             $attr   = 'disabled="disabled"';
                                            if($C_CarreraCodigo==$Carrera->fields['codigocarrera']){
                                                $attr   = '';
                                              ?>
                                                <td><input type="checkbox" <?PHP echo $attr?> id="CheckCarrera_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkCarrera<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoCarrera_<?PHP echo $Ext?>','CheckCarrera_<?PHP echo $Ext?>','C<?PHP echo $Ext?>','CadenaCarrera<?PHP echo $Ext?>')" /><input type="hidden" id="CodigoCarrera_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Carrera->fields['codigocarrera']?>" checked="checked"  /></td>
                                              <?PHP  
                                            }else{   
                                               ?>
                                               <td><input type="checkbox" <?PHP echo $attr?> id="CheckCarrera_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkCarrera<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoCarrera_<?PHP echo $Ext?>','CheckCarrera_<?PHP echo $Ext?>','C<?PHP echo $Ext?>','CadenaCarrera<?PHP echo $Ext?>')" /><input type="hidden" id="CodigoCarrera_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Carrera->fields['codigocarrera']?>"  /></td>
                                               <?PHP 
                                            }//fi
                                        }else{
                                            ?>
                                            <td><input type="checkbox" <?PHP echo $attr?> id="CheckCarrera_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkCarrera<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoCarrera_<?PHP echo $Ext?>','CheckCarrera_<?PHP echo $Ext?>','C<?PHP echo $Ext?>','CadenaCarrera<?PHP echo $Ext?>')" /><input type="hidden" id="CodigoCarrera_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Carrera->fields['codigocarrera']?>"  /></td>
                                            <?PHP
                                        }//if
                                    ?>
									
								</tr>
								<?PHP
								$i++;
								$Carrera->MoveNext();
								}
							?>
							<tr id="Tr_C<?PHP echo $Ext?><?PHP echo $i+1?>" onmouseover="Sombra(<?PHP echo $i+1?>,'C<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i+1?>,'C<?PHP echo $Ext?>')" style="cursor:pointer">
								<td><strong>Todas</strong></td>
								<td><input type="checkbox" <?PHP echo $attr?> id="TodasCarreras<?PHP echo $Ext?>" onclick="Inactivar('TodasCarreras<?PHP echo $Ext?>','ChkCarrera<?PHP echo $Ext?>','CadenaCarrera<?PHP echo $Ext?>')" title="Todas las Carreras" /></td>
							</tr>
						</table>
						<input type="hidden" id="CadenaCarrera<?PHP echo $Ext?>" value="<?PHP echo $ValueCadena?>" />
                    </div>
                    </fieldset>
					<?PHP }?>
                </tr>
            </thead>
        </table>	
        <?PHP
		}	
	public function DisplayDos($modalidad,$carrera,$Carga,$type,$Cargamateria='',$Ext,$CodigoCarrera){
			global $db;
		?>	
        <table border="0" width="100%">
        	<thead>
            	<tr>
                	<th>Modalidad Academica</th>
                    <th><?PHP $this->Modalidad($modalidad,$carrera,$Carga,$type,$Cargamateria,$Ext,$CodigoCarrera);?></th>
                    <th id="<?PHP echo $Carga?>" style="visibility:collapse" colspan="2"></th>
                    <th id="<?PHP echo $Cargamateria?>" style="visibility:collapse" colspan="2"></th>
                </tr>
            </thead>
        </table>
		<?PHP	
		}
	public function Materias($carrera,$Ext){
		global $db;
		
		  $SQL_Materia='SELECT
						
						codigomateria,
						nombremateria
						
						
						FROM 
						
						materia
						
						WHERE
						
						codigocarrera="'.$carrera.'"';
						
			if($Materias=&$db->Execute($SQL_Materia)===false){
					echo 'Error en el SQL del LAs Materias....<br><br>'.$SQL_Materia;
					die;
				}			
		?>
        <fieldset style="width:98%;">
            <legend>Materias</legend>
                <div style="overflow:scroll;width:100%;height:100;overflow-x:hidden">
                    <table border="0" width="100%">
                        <?PHP 
                        $i=1; 
                        while(!$Materias->EOF){
                            ?>
                            <tr id="Tr_M<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'M<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'M<?PHP echo $Ext?>','CheckMateria_<?PHP echo $Ext?>')" style="cursor:pointer">
                                <td><?PHP echo $Materias->fields['nombremateria']?></td>
                                <td><input type="checkbox" id="CheckMateria_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkMateria<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoMateria_<?PHP echo $Ext?>','CheckMateria_<?PHP echo $Ext?>','M<?PHP echo $Ext?>','CadenaMateria<?PHP echo $Ext?>')" /><input type="hidden" id="CodigoMateria_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Materias->fields['codigomateria']?>"  /></td>
                            </tr>
                            <?PHP
                            $i++;
                            $Materias->MoveNext();
                            }
                        ?>
                    </table>
                    <input type="hidden" id="CadenaMateria<?PHP echo $Ext?>" />
                </div>
        </fieldset>
        <?PHP
		}	
	/******************************************************************************/		
	public function ModalidaCarrera($modalidad,$carrera,$Carga,$type,$Cargamateria='',$Ext,$CodigoModalidad,$CadenaCarrera,$visible='',$Class){
			global $db;
		?>	
        <table border="0" width="100%">
        	<thead>
            	<tr>
                	<th>Modalidad Academica</th>
                    <th><?PHP $this->ModalidadUpdate($modalidad,$carrera,$Carga,$type,$Cargamateria,$Ext,$CodigoModalidad);?></th>
                    <th id="<?PHP echo $Carga?>" <?PHP echo $visible?> class="<?PHP echo $Class?>">
                    <?PHP $this->CarreraUpdate($CodigoModalidad,$carrera,$type,$Cargamateria,$Ext,$CadenaCarrera);?>
                    </th>
                    <th id="<?PHP echo $Cargamateria?>" <?PHP echo $visible?> class="<?PHP echo $Class?>"></th>
                </tr>
            </thead>
        </table>
		<?PHP	
		}
	public function ModalidaCarreraMateria($modalidad,$carrera,$Carga,$type,$Cargamateria='',$Ext,$visible='',$CodigoModalidad,$CodigoCarrera_id,$CadenaMateria,$Class){
			global $db;
			
			
		?>	
        <table border="0" width="100%">
        	<thead>
            	<tr>
                	<th>Modalidad Academica</th>
                    <th><?PHP $this->ModalidadUpdate($modalidad,$carrera,$Carga,$type,$Cargamateria,$Ext,$CodigoModalidad);?></th>
                    <th id="<?PHP echo $Carga?>" <?PHP echo $visible?>  class="<?PHP echo $Class?>">
                    <?PHP $this->CarreraUpdate($CodigoModalidad,$carrera,$type,$Cargamateria,$Ext,$CodigoCarrera_id);?>
                    </th>
                    <th id="<?PHP echo $Cargamateria?>" <?PHP echo $visible?>  class="<?PHP echo $Class?>">
                    <?PHP $this->MateriasUpdate($CodigoCarrera_id,$Ext,$CadenaMateria);?>
                    </th>
                </tr>
            </thead>
        </table>
		<?PHP	
		}	
	public function FacultadUpdate($type,$Ext,$CadenFacultad){
		global $db;
		
		//echo '$CadenFacultad->'.$CadenFacultad;
		
		 $SQL_Facultad='SELECT 
						
						codigofacultad,
						nombrefacultad
						
						FROM 
						
						facultad
						
						WHERE
						
						codigofacultad<>10
						
						ORDER BY nombrefacultad';
						
				if($Facultad=&$db->Execute($SQL_Facultad)===false){
						echo 'Error en el SQL  Facultad....<br><br>'.$SQL_Facultad;
						die;
					}
					
				
				?>
               <table border="0" width="100%">
               		<thead>
                    	<tr>
                            <?PHP 
							if($type=='Lista'){
							?>
                            <th>Facultad</th>
                            <td>
                            <select id="<?PHP echo $Name?>" name="<?PHP echo $Name?>" style="width:auto">
                                <option value="-1"></option>
                                <?PHP 
                                while(!$Facultad->EOF){
                                /*************************************/
                                ?>
                                <option value="<?PHP echo $Facultad->fields['codigofacultad']?>"><?PHP echo $Facultad->fields['nombrefacultad']?></option>
                                <?PHP
                                /*************************************/
                                $Facultad->MoveNext();
                                }
                                ?>
                                <option value="0"><strong>Todas</strong></option>
                            </select>
                            </td>
                            <?PHP }else if($type=='Check'){
								$C_Facultad		= explode('::',$CadenFacultad);		
								//echo '<pre>';print_r($C_Facultad);
								?>
                            <td>&nbsp;</td>
                            <td>
                            <fieldset style="width:98%;">
                            <legend>Facultad</legend>
                            <div style="overflow:scroll;width:100%;height:100;overflow-x:hidden">
                            	<table border="0" width="100%">
                                	 <?PHP
									$i=1; 
									while(!$Facultad->EOF){
										$Check_V= false;
										for($j=1;$j<count($C_Facultad);$j++){
												if($Facultad->fields['codigofacultad']==$C_Facultad[$j]){
														$Check_V	= true;
														$Check_F	= 'checked="checked"';
													?>
                                                    	<tr id="Tr_F<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'F<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'F<?PHP echo $Ext?>','CheckFaculta_')" style="cursor:pointer">
                                            <td><?PHP echo $Facultad->fields['nombrefacultad']?></td>
                                            <td><input type="checkbox" id="CheckFaculta_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkFacultad<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoFaculta_<?PHP echo $Ext?>','CheckFaculta_<?PHP echo $Ext?>','F<?PHP echo $Ext?>','CadenaFacultad<?PHP echo $Ext?>')" <?PHP echo $Check_F?> /><input type="hidden" id="CodigoFaculta_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Facultad->fields['codigofacultad']?>"  /></td>
                                        </tr>
                                                    <?PHP	
													}
											}//for
										if($Check_V==false){	
										?>
										<tr id="Tr_F<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'F<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'F<?PHP echo $Ext?>','CheckFaculta_')" style="cursor:pointer">
                                            <td><?PHP echo $Facultad->fields['nombrefacultad']?></td>
                                            <td><input type="checkbox" id="CheckFaculta_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkFacultad<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoFaculta_<?PHP echo $Ext?>','CheckFaculta_<?PHP echo $Ext?>','F<?PHP echo $Ext?>','CadenaFacultad<?PHP echo $Ext?>')" /><input type="hidden" id="CodigoFaculta_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Facultad->fields['codigofacultad']?>"  /></td>
                                        </tr>
										<?PHP
										}
										$i++;
										$Facultad->MoveNext();
										}
									?>
                                    <tr id="Tr_F<?PHP echo $Ext?><?PHP echo $i+1?>" onmouseover="Sombra(<?PHP echo $i+1?>,'F<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i+1?>,'F<?PHP echo $Ext?>')" style="cursor:pointer">
                                        <td><strong>Todas</strong></td>
                            			<td><input type="checkbox" id="TodasFacultades<?PHP echo $Ext?>" onclick="Inactivar('TodasFacultades<?PHP echo $Ext?>','ChkFacultad<?PHP echo $Ext?>','CadenaFacultad<?PHP echo $Ext?>')" title="Todas las Facultades" /></td>
                                    </tr>
                                </table>
                                <input type="hidden" id="CadenaFacultad<?PHP echo $Ext?>" value="<?PHP echo $CadenFacultad?>" />
                                <input type="hidden" id="index_<?PHP echo $Ext?>" value="<?PHP echo $i?>" />
                            </div>
                            </fieldset>
                            </td>
                            <?PHP }?>
                        </tr>
                    </thead>
               </table>
                <?PHP	
		}//Funtion Facultad	
	public function CarreraUpdate($id,$CodigoCarrera,$type,$Cargamateria='',$Ext,$CodigoCarrera_id){
		global $db;
		
		  /*$SQL_Carrera='SELECT 
						
						codigocarrera,
						nombrecarrera
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademicasic="'.$id.'"
						
						ORDER BY nombrecarrera';*/

			$SQL_Carrera='SELECT 
						
						codigocarrera,
						nombrecarrera
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademica="'.$id.'"
						
						ORDER BY nombrecarrera';	

				if($Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL de la Carrera....<br><br>'.$SQL_Carrera;
						die;
					}		
					
		?>
        <table border="0" width="100%">
        	<thead>
            	<tr>
                	<?PHP 
					if($type=='Lista'){
					?>
                	<th>Carrera</th>
                    <th>
                    <select id="<?PHP echo $CodigoCarrera?>" name="<?PHP echo $CodigoCarrera?>" style="width:70%" onchange="VerMateria('<?PHP echo $CodigoCarrera?>','<?PHP echo $Cargamateria?>','<?PHP echo $Ext?>')">
                        <option value="-1"></option>
                        <?PHP 
                        while(!$Carrera->EOF){
							if($Carrera->fields['codigocarrera']==$CodigoCarrera_id){
								$Selected	= 'selected="selected"';
								}else{
									$Selected	= '';
									}
                            ?>
                            <option value="<?PHP echo $Carrera->fields['codigocarrera']?>" <?PHP echo $Selected?>><?PHP echo $Carrera->fields['nombrecarrera']?></option>
                            <?PHP
                            $Carrera->MoveNext();
                            }
                        ?>
                    </select>
                    </th>
                    <?PHP }else if($type=='Check'){
					$C_Carrera	= explode('::',$CodigoCarrera_id);	
					?>
					 <td>&nbsp;</td>
                    <td>
                    <fieldset style="width:98%;">
                    <legend>Carrera</legend>
                    <div style="overflow:scroll;width:100%;height:100;overflow-x:hidden">
                    	<table border="0" width="100%">
                        	<?PHP 
							//echo '<pre>';print_r($C_Carrera);
							$i=1; 
							while(!$Carrera->EOF){
								$Check_V= false;
								for($j=1;$j<count($C_Carrera);$j++){
										if($Carrera->fields['codigocarrera']==$C_Carrera[$j]){
												$Check_C	= 'checked="checked"';
												$Check_V	= true;
											?>
                                            <tr id="Tr_C<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'C<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'C<?PHP echo $Ext?>','CheckCarrera_<?PHP echo $Ext?>')" style="cursor:pointer">
									<td><?PHP echo $Carrera->fields['nombrecarrera']?></td>
									<td><input type="checkbox" id="CheckCarrera_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkCarrera<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoCarrera_<?PHP echo $Ext?>','CheckCarrera_<?PHP echo $Ext?>','C<?PHP echo $Ext?>','CadenaCarrera<?PHP echo $Ext?>')" <?PHP echo $Check_C?>  /><input type="hidden" id="CodigoCarrera_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Carrera->fields['codigocarrera']?>"  /></td>
								</tr>
                                            <?PHP	
											}
									}//for
								if($Check_V==false){	
								?>
								<tr id="Tr_C<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'C<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'C<?PHP echo $Ext?>','CheckCarrera_<?PHP echo $Ext?>')" style="cursor:pointer">
									<td><?PHP echo $Carrera->fields['nombrecarrera']?></td>
									<td><input type="checkbox" id="CheckCarrera_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkCarrera<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoCarrera_<?PHP echo $Ext?>','CheckCarrera_<?PHP echo $Ext?>','C<?PHP echo $Ext?>','CadenaCarrera<?PHP echo $Ext?>')"  /><input type="hidden" id="CodigoCarrera_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Carrera->fields['codigocarrera']?>"  /></td>
								</tr>
								<?PHP
								}
								$i++;
								$Carrera->MoveNext();
								}
							?>
							<tr id="Tr_C<?PHP echo $Ext?><?PHP echo $i+1?>" onmouseover="Sombra(<?PHP echo $i+1?>,'C<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i+1?>,'C<?PHP echo $Ext?>')" style="cursor:pointer">
								<td><strong>Todas</strong></td>
								<td><input type="checkbox" id="TodasCarreras<?PHP echo $Ext?>" onclick="Inactivar('TodasCarreras<?PHP echo $Ext?>','ChkCarrera<?PHP echo $Ext?>','CadenaCarrera<?PHP echo $Ext?>')" title="Todas las Carreras" /></td>
							</tr>
						</table>
						<input type="hidden" id="CadenaCarrera<?PHP echo $Ext?>" value="<?PHP echo $CodigoCarrera_id?>" />
                    </div>
                    </fieldset>
					<?PHP }?>
                </tr>
            </thead>
        </table>	
        <?PHP
		}		
	public function ModalidadUpdate($modalidad,$carrera,$Carga,$type,$Cargamateria='',$Ext,$CodigoModalidad){
		global $db;
		
			
			/*$SQL_Modalidad='SELECT 
							
							codigomodalidadacademicasic AS id,
							nombremodalidadacademicasic as Nombre 
							
							FROM 
							
							modalidadacademicasic
							
							WHERE
							
							codigoestado=100
							AND
							codigomodalidadacademicasic NOT IN (100,400)';*/

			$SQL_Modalidad='SELECT 

							codigomodalidadacademica AS id,
							nombremodalidadacademica as Nombre 

							FROM modalidadacademica

							WHERE

							codigoestado=100
							AND
							codigomodalidadacademica NOT IN (400)';					
							
				if($Modalidad=&$db->Execute($SQL_Modalidad)===false){
						echo 'Error en el SQL Modalidad....<br><br>'.$SQL_Modalidad;
						die;
					}		
		?>
        <select id="<?PHP echo $modalidad?>" name="<?PHP echo $modalidad?>" style="width:auto" onchange="VerCarrera('<?PHP echo $modalidad?>','<?PHP echo $carrera?>','<?PHP echo $Carga?>','<?PHP echo $type?>','<?PHP echo $Cargamateria?>','<?PHP echo $Ext?>')">
        	<option value="-1"></option>
            <?PHP
            while(!$Modalidad->EOF){
				if($Modalidad->fields['id']==$CodigoModalidad){
					$Selected	= 'selected="selected"';
					}else{
						$Selected	= '';
						}
				?>
                <option value="<?PHP echo $Modalidad->fields['id']?>" <?PHP echo $Selected?>><?PHP echo $Modalidad->fields['Nombre']?></option>
                <?PHP
				$Modalidad->MoveNext();
				}	
			?>
        </select>				
		<?PHP
		}	
	public function MateriasUpdate($carrera,$Ext,$Cadenamateria){
		global $db;
		
		  $SQL_Materia='SELECT
						
						codigomateria,
						nombremateria
						
						
						FROM 
						
						materia
						
						WHERE
						
						codigocarrera="'.$carrera.'"';
						
			if($Materias=&$db->Execute($SQL_Materia)===false){
					echo 'Error en el SQL del LAs Materias....<br><br>'.$SQL_Materia;
					die;
				}	
				
		$C_Materia	= explode('::',$Cadenamateria);
		
		//echo '<pre>';print_r($C_Materia);				
		?>
        <fieldset style="width:98%;">
            <legend>Materias</legend>
                <div style="overflow:scroll;width:100%;height:100;overflow-x:hidden">
                    <table border="0" width="100%">
                        <?PHP 
                        $i=1; 
                        while(!$Materias->EOF){
							$Check_V= false;
							for($j=1;$j<count($C_Materia);$j++){
								
								//echo '<br>'.$Materias->fields['codigomateria'].'=='.$C_Materia[$j];
									if($Materias->fields['codigomateria']==$C_Materia[$j]){
											$Check_M	= 'checked="checked"';
											$Check_V	= true;
										?>
                                        <tr id="Tr_M<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'M<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'M<?PHP echo $Ext?>','CheckMateria_<?PHP echo $Ext?>')" style="cursor:pointer">
                                <td><?PHP echo $Materias->fields['nombremateria']?></td>
                                <td><input type="checkbox" id="CheckMateria_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkMateria<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoMateria_<?PHP echo $Ext?>','CheckMateria_<?PHP echo $Ext?>','M<?PHP echo $Ext?>','CadenaMateria<?PHP echo $Ext?>')" <?PHP echo $Check_M?> /><input type="hidden" id="CodigoMateria_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Materias->fields['codigomateria']?>"  /></td>
                            </tr>
                                        <?PHP	
										}
							}//for	
							//echo '<br>Valor->'.$Valor;	
							if($Check_V==false){	
                            ?>
                            <tr id="Tr_M<?PHP echo $Ext?><?PHP echo $i?>" onmouseover="Sombra(<?PHP echo $i?>,'M<?PHP echo $Ext?>')" onmouseout="SinSombra(<?PHP echo $i?>,'M<?PHP echo $Ext?>','CheckMateria_<?PHP echo $Ext?>')" style="cursor:pointer">
                                <td><?PHP echo $Materias->fields['nombremateria']?></td>
                                <td><input type="checkbox" id="CheckMateria_<?PHP echo $Ext?><?PHP echo $i?>" class="ChkMateria<?PHP echo $Ext?>" onclick="addDato(<?PHP echo $i?>,'CodigoMateria_<?PHP echo $Ext?>','CheckMateria_<?PHP echo $Ext?>','M<?PHP echo $Ext?>','CadenaMateria<?PHP echo $Ext?>')" /><input type="hidden" id="CodigoMateria_<?PHP echo $Ext?><?PHP echo $i?>" value="<?PHP echo $Materias->fields['codigomateria']?>"  /></td>
                            </tr>
                            <?PHP
							}
							
                            $i++;
                            $Materias->MoveNext();
                            }
                        ?>
                    </table>
                    <input type="hidden" id="CadenaMateria<?PHP echo $Ext?>" value="<?PHP echo $Cadenamateria?>" />
                </div>
        </fieldset>
        <?PHP
		}	
	/******************************************************************************/
    public function Mod_Docente($dato,$Cadena=''){
        global $db;
        
        if($dato==200){//Pregrado
        
        $C_Modalida = explode('::',$Cadena);
        
        //echo '<pre>';print_r($C_Modalida);
        $M_Check = array();
        
        for($i=1;$i<count($C_Modalida);$i++){
            
            if($C_Modalida[$i]==4){
                $M_Check['Adm_Pregrado']='checked="checked"';
            }
            if($C_Modalida[$i]==6){
                $M_Check['Pos_Pre']='checked="checked"';
            }
            if($C_Modalida[$i]==7){
                $M_Check['Pre']='checked="checked"';
            }
            
        }
        
            ?>
            <table border="0" width="100%">
                <tr>
                    <td><input type="checkbox" id="Adm_Pregrado" name="Adm_Pregrado" <?PHP echo $M_Check['Adm_Pregrado']?> /><strong>Administracion y Pregrado</strong></td>
                    <td><input type="checkbox" id="Pos_Pre" name="Pos_Pre"  <?PHP echo $M_Check['Pos_Pre']?> /><strong>Posgrado y Pregrado</strong></td>
                    <td><input type="checkbox" id="Pre" name="Pre"  <?PHP echo $M_Check['Pre']?> /><strong>Pregrado</strong></td>
                </tr>
            </table>
            <?PHP
        }else if($dato==300){//Posgrado
        
        $C_Modalida = explode('::',$Cadena);
        
        //echo '<pre>';print_r($C_Modalida);
        $M_Check = array();
        
        for($i=1;$i<count($C_Modalida);$i++){
            
            if($C_Modalida[$i]==2){
                $M_Check['AdmPosgrado']='checked="checked"';
            }
            if($C_Modalida[$i]==3){
                $M_Check['Adm_Posgrado']='checked="checked"';
            }
            if($C_Modalida[$i]==5){
                $M_Check['Pos']='checked="checked"';
            }
            if($C_Modalida[$i]==6){
                $M_Check['Pos_Pre']='checked="checked"';
            }
            
        }
        
             ?>
            <table border="0" width="100%">
                <tr>
                    <td><input type="checkbox" id="AdmPosgrado" name="AdmPosgrado" <?PHP echo $M_Check['AdmPosgrado']?> /><strong>Administracion Posgrado</strong></td>
                    <td><input type="checkbox" id="Adm_Posgrado" name="Adm_Posgrado" <?PHP echo $M_Check['Adm_Posgrado']?> /><strong>Administracion y Posgrado</strong></td>
                    <td><input type="checkbox" id="Pos_Pre" name="Pos_Pre"  <?PHP echo $M_Check['Pos_Pre']?>/><strong>Posgrado y Pregrado</strong></td>
                    <td><input type="checkbox" id="Pos" name="Pos" <?PHP echo $M_Check['Pos']?> /><strong>Posgrado</strong></td>
                </tr>
            </table>
            <?PHP
        }
        
    }//public function Mod_Docente
	}//class
?>