<?PHP 
class MovilidadAcademica{
	 public function Principal($id){
		global $userid,$db;
                
		?>
        <span class="mandatory">* Son campos obligatorios</span>
                <br />
            <form id="xxxxx" name="xxxxx">
              <fieldset>   
                <legend>Estudiantes con movilidad según al país al que viajan y el tipo de actividad o movilidad </legend>
                    	<table width="80%"  border="0" align="left">
                        	<thead>
                            	<tr>
                                    <th style="border:#FFFFFF solid 1px;">
                                        <div class="formModalidad">
                                            <?php $rutaModalidad = "./_elegirProgramaAcademico.php";
												 if(!is_file($rutaModalidad)){
													$rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
												 }
												include($rutaModalidad); ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                	<th style="border:#FFFFFF solid 1px"><label for="Periodo" class="fixedLabel">Periodo<span class="mandatory">(*)</span></label>
                                        <?PHP
                                    	  $SQL_Periodo='SELECT 

														codigoperiodo as id,
														codigoperiodo,
														date(fechavencimientoperiodo),
														codigoestadoperiodo
														
														FROM periodo
														
														WHERE
														
														(codigoestadoperiodo=1 OR fechavencimientoperiodo< "'.date('Y-m-d').'")
														
														ORDER BY codigoperiodo DESC';
														
												if($Periodo=&$db->Execute($SQL_Periodo)===false){
														echo 'Error en el SQL del Peridod....<br>'.$SQL_Periodo;
														die;
													}		
									?>
                                    	<select name="Periodo" id="Periodo" class="required" style='font-size:0.8em;width:auto'>
                                            <option value="-1" selected></option>
                                            <?PHP 
												while(!$Periodo->EOF){
													?>
                                                    <option value="<?PHP echo $Periodo->fields['id']?>"><?PHP echo $Periodo->fields['codigoperiodo']?></option>
                                                    <?PHP
													$Periodo->MoveNext();
													}
											?>
                                        </select>
                                        
                                        
                                        </th>
                                    
                                </tr>
                            </thead>
                        </table>
                
                <div class="vacio"></div>
            
                <input type="button" value="Cargar archivo de soporte" name="uploadFile" onClick="if($('#xxxxx #Periodo').val()==='-1'){alert('Debe elegir un periodo para adjuntar un archivo de soporte.')} else {popup_cargarDocumento(9,7,$('#xxxxx #Periodo').val(),$('#xxxxx #unidadAcademica').val())}" class="small" style="float:right;margin-bottom:10px;margin-right:4%;"/>  

                <input type="button" value="Ver archivos de soporte" name="seeFile" onClick="if($('#xxxxx #Periodo').val()==='-1'){alert('Debe elegir un periodo para ver los archivos de soporte adjuntos.')} else {popup_verDocumentos(9,7,$('#xxxxx #Periodo').val(),$('#xxxxx #unidadAcademica').val())}" class="small" style="float:right;margin-bottom:10px;margin-right:0;"/>  

                <div class="vacio"></div>
             
                
                        <table width="92%"  border="0" align="center" class="formData" >
                            <thead>   
                                <tr class="dataColumns">
                                    <th rowspan="2" class="column" colspan="2" style="border:#000 solid 1px"><span>País al que viaja</span></th>
                                    <th class="column" colspan="5" ><span>Tipo de movilidad</span></th>
                                </tr>
                                <tr class="dataColumns">
                                    <th class="column center" style="border:#000 solid 1px" ><span>Internado</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Pasantía</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Práctica</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Semestre académico</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Doble titulación</span></th>
                                </tr>
                                <?PHP $this->Campos('América Latina y Centro América','Intervalo_Uno','Pasantia_uno','Practica_Uno','Semestre_Uno','Doble_uno'); ?>
                                <?PHP $this->Campos('Europa','Intervalo_Dos','Pasantia_Dos','Practica_Dos','Semestre_Dos','Doble_Dos'); ?>
                                <?PHP $this->Campos('Asia','Intervalo_Tres','Pasantia_Tres','Practica_Tres','Semestre_Tres','Doble_Tres'); ?>
                                <?PHP $this->Campos('Estados Unidos','Intervalo_Cuatro','Pasantia_Cuatro','Practica_Cuatro','Semestre_Cuatro','Doble_Cuatro'); ?>
                            </thead>
                    	</table>
                </fieldset>
             </form>
             <br /><br />
             <span class="mandatory">* Son campos obligatorios</span>
            <form id="DatosFormulario" name="DatosFormulario">
              <fieldset>   
                <legend>Estudiantes de Otras Universidades que vienen a la Universidad </legend>
                    	<table width="92%"  border="0" align="center" class="formData" >
                            <thead>   
                                <tr class="dataColumns">
                                    <th rowspan="2" class="column" colspan="2" style="border:#000 solid 1px"><span>País del cual proviene</span></th>
                                    <th class="column" colspan="5" ><span>Tipo de movilidad</span></th>
                                </tr>
                                <tr class="dataColumns">
                                    <th class="column center" style="border:#000 solid 1px" ><span>Internado</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Pasantía</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Práctica</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Semestre académico</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Doble titulación</span></th>
                                </tr>
                                 <?PHP $this->Campos('América Latina y Centro América','Intervalo_Cinco','Pasantia_Cinco','Practica_Cinco','Semestre_Cinco','Doble_Cinco'); ?>
                                <?PHP $this->Campos('Europa','Intervalo_Seis','Pasantia_Seis','Practica_Seis','Semestre_Seis','Doble_Seis'); ?>
                                <?PHP $this->Campos('Asia','Intervalo_Siete','Pasantia_Siete','Practica_Siete','Semestre_Siete','Doble_Siete'); ?>
                                <?PHP $this->Campos('Estados Unidos','Intervalo_Ocho','Pasantia_Ocho','Practica_Ocho','Semestre_Ocho','Doble_Ocho'); ?>
                            </thead>
                    	</table>
                </fieldset>
                <input type="button" id="Guardar" value="Guardar Datos" class="submit first" onclick="Save()" />
             </form>     
         <?PHP    
		}
	public function Campos($Titulo,$Campo_1,$Campo_2,$Campo_3,$Campo_4,$Campo_5){
		?>
        <tr class="dataColumns">
            <td class="column center" colspan="2" style="border:#000 solid 1px" ><span><?PHP echo $Titulo?></span></td>
            <td class="column center" style="border:#000 solid 1px"><input type="text" id="<?PHP echo $Campo_1?>" name="<?PHP echo $Campo_1?>" style="text-align:center" autocomplete="off" class="required number" onkeypress="return isNumberKey(event)" value="0" /></td>
            <td class="column center" style="border:#000 solid 1px"><input type="text" id="<?PHP echo $Campo_2?>" name="<?PHP echo $Campo_2?>" style="text-align:center" autocomplete="off" class="required number" onkeypress="return isNumberKey(event)" value="0" /></td>
            <td class="column center" style="border:#000 solid 1px"><input type="text" id="<?PHP echo $Campo_3?>" name="<?PHP echo $Campo_3?>" style="text-align:center" autocomplete="off" class="required number" onkeypress="return isNumberKey(event)" value="0" /></td>
            <td class="column center" style="border:#000 solid 1px"><input type="text" id="<?PHP echo $Campo_4?>" name="<?PHP echo $Campo_4?>" style="text-align:center" autocomplete="off" class="required number" onkeypress="return isNumberKey(event)" value="0" /></td>
            <td class="column center" style="border:#000 solid 1px"><input type="text" id="<?PHP echo $Campo_5?>" name="<?PHP echo $Campo_5?>" style="text-align:center" autocomplete="off" class="required number" onkeypress="return isNumberKey(event)" value="0" /></td>
        </tr>
        <?PHP
		}
	public function Reporte($id){
			global $userid,$db;
			
			
			 
			?>
           <form id="R_View" name="R_View">
            <fieldset>   
                    	<table width="50%"  border="0" align="left">
                        	<thead>
                            	<tr>
                                	<div class="formModalidad">
                                            <?php $rutaModalidad = "./_elegirProgramaAcademico.php";
												 if(!is_file($rutaModalidad)){
													$rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
												 }
												include($rutaModalidad); ?>
                                        </div>
                                </tr>
                                <tr>
                                	<th style="border:#FFFFFF solid 1px"><label for="Periodo" class="fixedLabel">Periodo<span class="mandatory">(*)</span></label>
                                    
                                    <?PHP
                                    	  $SQL_Periodo='SELECT 

														codigoperiodo as id,
														codigoperiodo,
														date(fechavencimientoperiodo),
														codigoestadoperiodo
														
														FROM periodo
														
														WHERE
														
														(codigoestadoperiodo=1 OR fechavencimientoperiodo< "'.date('Y-m-d').'")
														
														ORDER BY codigoperiodo DESC';
														
												if($Periodo=&$db->Execute($SQL_Periodo)===false){
														echo 'Error en el SQL del Peridod....<br>'.$SQL_Periodo;
														die;
													}		
									?>
                                    	<select name="Periodo" id="Periodo" class="required" style='font-size:0.8em;width:auto' onchange="Buscar()">
                                            <option value="" selected></option>
                                            <?PHP 
												while(!$Periodo->EOF){
													?>
                                                    <option value="<?PHP echo $Periodo->fields['id']?>"><?PHP echo $Periodo->fields['codigoperiodo']?></option>
                                                    <?PHP
													
													$Periodo->MoveNext();
													}
											?>
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                       </fieldset> 
                        <div id="CargarData"></div> 
             </form>   
			<?PHP
		}		
	public function ViewData($Titulo,$Dato_1,$Dato_2,$Dato_3,$Dato_4,$Dato_5,$Suma_T){
		?>
        <tr class="dataColumns">
            <td class="column center" colspan="2" style="border:#000 solid 1px" ><span><?PHP echo $Titulo?></span></td>
            <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_1?></strong></td>
            <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_2?></strong></td>
            <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_3?></strong></td>
            <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_4?></strong></td>
            <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_5?></strong></td>
            <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Suma_T?></strong></td>
        </tr>
        <?PHP  
		}
	public function Total($Dato_1,$Dato_2,$Dato_3,$Dato_4,$Dato_5){
			?>
            <tr class="dataColumns">
                <th class="column center" colspan="2" style="border:#000 solid 1px" ><span>Total</span></td>
                <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_1?></strong></td>
                <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_2?></strong></td>
                <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_3?></strong></td>
                <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_4?></strong></td>
                <td class="column center" style="border:#000 solid 1px" align="center"><strong><?PHP echo $Dato_5?></strong></td>
                <td class="column center" style="border:#000 solid 1px" align="center"><strong></strong></td>
            </tr> 
            <?PHP
		}
	public function DataResult($Modalidad,$carerra,$periodo){
			global $userid,$db;
			
			 $SQL_Datos='SELECT 

						idmovilidadacademica AS id,
						pais, 
						internado,
						pasantia,
						practica,
						semestreacademico,
						dobletitulacion
						
						FROM movilidadacademica
						
						WHERE
						
						codigoestado=100
						AND
						periodo="'.$periodo.'"
						AND
						tipo=1
						AND
						modalidad_id="'.$Modalidad.'"
						AND
						carrera_id="'.$carerra.'"
						
						ORDER BY pais ASC';
						
				if($C_Datos=&$db->Execute($SQL_Datos)===FALSE){
						echo 'Error en el SQL De Datos ....<br>'.$SQL_Datos;
						die;
					}	
					
					
					
         $SQL_Suma='SELECT 
					idmovilidadacademica AS id, 
					SUM(internado) as Sum_Inter,
					SUM(pasantia) as Sum_Pas,
					SUM(practica) as Sum_Pra,
					SUM(semestreacademico) as Sum_Sem,
					SUM(dobletitulacion) as Sum_Dobl
					
					FROM 
					
					movilidadacademica 
					
					WHERE 
					
					codigoestado=100 
					AND 
					tipo=1 
					AND
					periodo="'.$periodo.'"
					AND
					modalidad_id="'.$Modalidad.'"
					AND
					carrera_id="'.$carerra.'"
					
					ORDER BY pais ASC';
					
			if($Suma_D=&$db->Execute($SQL_Suma)===false){
					echo 'Error en el SQL Suma Datos....<br>'.$SQL_Suma;
					die;
				}

			?>
            <fieldset>
            <legend>Estudiantes con movilidad según al país al que viajan y el tipo de actividad o movilidad </legend>
                        <table width="92%"  border="0" align="center" class="formData" >
                            <thead>   
                                <tr class="dataColumns">
                                    <th rowspan="2" class="column" colspan="2" style="border:#000 solid 1px"><span>País al que viaja</span></th>
                                    <th class="column" colspan="6" ><span>Tipo de movilidad</span></th>
                                </tr>
                                <tr class="dataColumns">
                                    <th class="column center" style="border:#000 solid 1px" ><span>Internado</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Pasantía</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Práctica</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Semestre académico</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Doble titulación</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Total</span></th>
                                </tr>
                                <?PHP 
								while(!$C_Datos->EOF){
									/****************************************************/
										if($C_Datos->fields['pais']==1){
												$Titulo = 'América Latina y Centro América';	
											}
										
										if($C_Datos->fields['pais']==2){
												$Titulo = 'Europa';	
											}
											
										if($C_Datos->fields['pais']==3){
												$Titulo = 'Asia';	
											}
											
										if($C_Datos->fields['pais']==4){
												$Titulo = 'Estados Unidos';	
											}
										
										
										$Suma_T		= $C_Datos->fields['internado']+$C_Datos->fields['pasantia']+$C_Datos->fields['practica']+$C_Datos->fields['semestreacademico']+$C_Datos->fields['dobletitulacion'];
											
										$this->ViewData($Titulo,$C_Datos->fields['internado'],$C_Datos->fields['pasantia'],$C_Datos->fields['practica'],$C_Datos->fields['semestreacademico'],$C_Datos->fields['dobletitulacion'],$Suma_T); 				
									/****************************************************/
														
									/****************************************************/
									$C_Datos->MoveNext();
									}
									
								$this->Total($Suma_D->fields['Sum_Inter'],$Suma_D->fields['Sum_Pas'],$Suma_D->fields['Sum_Pra'],$Suma_D->fields['Sum_Sem'],$Suma_D->fields['Sum_Dobl']);
								?>
                            </thead>
                    	</table>
                </fieldset>
             <br /><br />
             <?PHP 
			 
			$SQL_Datos='SELECT 

						idmovilidadacademica AS id,
						pais, 
						internado,
						pasantia,
						practica,
						semestreacademico,
						dobletitulacion
						
						FROM movilidadacademica
						
						WHERE
						
						codigoestado=100
						AND
					    periodo="'.$periodo.'"
						AND
						modalidad_id="'.$Modalidad.'"
						AND
						carrera_id="'.$carerra.'"
						AND
						tipo=2
						ORDER BY pais ASC';
						
				if($C_DatosTwo=&$db->Execute($SQL_Datos)===FALSE){
						echo 'Error en el SQL De Datos ....<br>'.$SQL_Datos;
						die;
					}
					
				 $SQL_Suma='SELECT 
							idmovilidadacademica AS id, 
							SUM(internado) as Sum_Inter,
							SUM(pasantia) as Sum_Pas,
							SUM(practica) as Sum_Pra,
							SUM(semestreacademico) as Sum_Sem,
							SUM(dobletitulacion) as Sum_Dobl
							
							FROM 
							
							movilidadacademica 
							
							WHERE 
							
							codigoestado=100 
							AND 
							tipo=2 
							AND
							periodo="'.$periodo.'"
							AND
							modalidad_id="'.$Modalidad.'"
							AND
							carrera_id="'.$carerra.'"
							
							ORDER BY pais ASC';
							
					if($Suma_DTwo=&$db->Execute($SQL_Suma)===false){
							echo 'Error en el SQL Suma Datos....<br>'.$SQL_Suma;
							die;
						}			
			 ?>
             <span class="mandatory">* Son campos obligatorios</span>
            
              <fieldset>   
                <legend>Estudiantes de Otras Universidades que vienen a la Universidad </legend>
                    	<table width="92%"  border="0" align="center" class="formData" >
                            <thead>   
                                <tr class="dataColumns">
                                    <th rowspan="2" class="column" colspan="2" style="border:#000 solid 1px"><span>País del cual provienen</span></th>
                                    <th class="column" colspan="6" ><span>Tipo de movilidad</span></th>
                                </tr>
                                <tr class="dataColumns">
                                    <th class="column center" style="border:#000 solid 1px" ><span>Internado</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Pasantía</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Práctica</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Semestre académico</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Doble titulación</span></th>
                                    <th class="column center" style="border:#000 solid 1px" ><span>Total</span></th>
                                </tr>
                                  <?PHP 
								while(!$C_DatosTwo->EOF){
									/****************************************************/
										if($C_DatosTwo->fields['pais']==1){
												$Titulo = 'América Latina y Centro América';	
											}
										
										if($C_DatosTwo->fields['pais']==2){
												$Titulo = 'Europa';	
											}
											
										if($C_DatosTwo->fields['pais']==3){
												$Titulo = 'Asia';	
											}
											
										if($C_Datos->fields['pais']==4){
												$Titulo = 'Estados Unidos';	
											}
										
										$Suma		= $C_DatosTwo->fields['internado']+$C_DatosTwo->fields['pasantia']+$C_DatosTwo->fields['practica']+$C_DatosTwo->fields['semestreacademico']+$C_DatosTwo->fields['dobletitulacion'];
											
										$this->ViewData($Titulo,$C_DatosTwo->fields['internado'],$C_DatosTwo->fields['pasantia'],$C_DatosTwo->fields['practica'],$C_DatosTwo->fields['semestreacademico'],$C_DatosTwo->fields['dobletitulacion'],$Suma); 				
									/****************************************************/
									$C_DatosTwo->MoveNext();
									}
								$this->Total($Suma_DTwo->fields['Sum_Inter'],$Suma_DTwo->fields['Sum_Pas'],$Suma_DTwo->fields['Sum_Pra'],$Suma_DTwo->fields['Sum_Sem'],$Suma_DTwo->fields['Sum_Dobl']);	
								?>
                            </thead>
                    	</table>
                </fieldset>	
            <?PHP
		}		
	}#Fin Class
?>