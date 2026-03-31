<?PHP
class PoblacionEspecial_EstratoBajo{
	
		public function Principal(){
			global $userid,$db;
		?>
        <span class="mandatory">* Son campos obligatorios</span>
        	<form id="qqqq" name="qqqq">
              <fieldset>   
                <legend>Estudiantes admitidos por programas y convenios de poblaciones especiales y estratos bajos </legend>
                	<table width="50%"  border="0" align="left">
                        <thead>
                            <tr>
                                <th style="border:#FFFFFF solid 1px"><label for="Periodo" class="fixedLabel">Periodo<span class="mandatory">(*)</span></label></th>
                                <th style="border:#FFFFFF solid 1px">
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
                            <tr>
                                <th style="border:#FFFFFF solid 1px"><label for="modalidad" class="fixedLabel">Modalidad Académica: <span class="mandatory">(*)</span></label></th>
                                <th style="border:#FFFFFF solid 1px">
                                <?PHP 
									// $this->AutoComplet('Modalidad','Digite la Modalidad a Buscar','FormatModalidad','AutocompletModalidad','id_Modalidad');#$Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre
									$this->selectModalidad($db);
								?>
                                </th>
                            </tr>
                            <tr>
                                <th style="border:#FFFFFF solid 1px"><label for="Programa" class="fixedLabel">Programa Académico: <span class="mandatory">(*)</span></label></th>
                                <th  style="border:#FFFFFF solid 1px" id= "th_programa">
                                <?PHP 
									// $this->AutoComplet('Carrera','Digite la Programa a Buscar','FormatCarrera','AutocompletCarrera','id_Carrera');#$Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre
                                	// $this->consultarCarrera($db);
								?>
                                </th>
                            </tr>
                            
                        </thead>
                    </table>
                    <br>
                    <input type="hidden" id="Cadena" >
                    <div id="CargarInfo"></div>
                    
              </fieldset>
              <input type="button" id="Guarda" value="Guardar Datos" class="submit first" onclick="Save()" style="display:none" />
            </form>    
        <?PHP
			}#public function Principal
		public function Campos($Campo_1,$Campo_2,$valorCampo1,$valorCampo2,$valorCampo3){
		?>
        <tr>
            <td style="border:#000 solid 1px" lass="column center"><input type="text" id="<?PHP echo $Campo_1?>" name="<?PHP echo $Campo_1?>" style="text-align:center" autocomplete="off" class="required number" onkeypress="return isNumberKey(event)" value="<?php if($valorCampo1){ echo $valorCampo1; } ?>" /></td>
            <td style="border:#000 solid 1px" lass="column center"><input type="text" id="<?PHP echo $Campo_2?>" name="<?PHP echo $Campo_2?>" style="text-align:center" autocomplete="off" class="required number" onkeypress="return isNumberKey(event)" value="<?php if($valorCampo2){ echo $valorCampo2; } ?>"/></td>
            <td><input type="checkbox" id="CheckValidador" name="CheckValidador" <?php if($valorCampo3 == 1){ echo "checked"; } ?>/></td>
        </tr>
        <?PHP
		}
	public function AutoComplet($Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre){
			?>
            <input type="text"  id="<?PHP echo $Nombre?>" name="<?PHP echo $Nombre?>" autocomplete="off" placeholder="<?PHP echo $Descripcion?>"  style="text-align:center;width:90%;" size="70" onClick="<?PHP echo $Onclick?>();" onKeyPress="<?PHP echo $Funcion?>()" /><input type="hidden" id="<?PHP echo $id_Nombre?>" />
            <?PHP
		}
	public function selectModalidad($db){

		$SQL_Modalidad='SELECT 

						codigomodalidadacademicasic  AS id,
						nombremodalidadacademicasic  AS Nombre 
						
						 FROM modalidadacademicasic
						
						WHERE
						
						codigoestado=100';

        if($modalidadConsulta = &$db->Execute($SQL_Modalidad)===false){
				echo 'Error en el SQL de consultar modalidad....<br>'.$SQL_Modalidad;
				die;
			}

		?>
		<select id="id_Modalidad" name="id_Modalidad" onchange="buscarCarrera();">
			<option value="-1"></option>
			<?php
				while(!$modalidadConsulta->EOF) {
					?>
					<option value="<?php echo $modalidadConsulta->fields['id'] ?>"><?php echo $modalidadConsulta->fields['Nombre'] ?></option>
					<?PHP
					$modalidadConsulta->MoveNext();
				}
			?>
		</select>
		<?php
	}
	public function selectCarrera($modalidad){
		global $db;
		$SQL_consultaCarrera='SELECT

						codigocarrera,
						nombrecarrera
						
						FROM 
						carrera
						WHERE
						codigomodalidadacademica ="'.$modalidad.'"
						AND
						now() between fechainiciocarrera and fechavencimientocarrera 
						AND
						codigocarrera  NOT IN (1, 2) 
						order by nombrecarrera';
						
				if($consultaCarrera=&$db->Execute($SQL_consultaCarrera)===false){
						echo 'Error en el SQL Carrera...<br>'.$SQL_Carrera;
						die;
					}
				?>
				<select id="id_carrera" name="id_carrera" onchange="buscarDatos();">
					<option value="-1"></option>
					<?php
						while(!$consultaCarrera->EOF) {
							?>
							<option value="<?php echo $consultaCarrera->fields['codigocarrera'] ?>"><?php echo $consultaCarrera->fields['nombrecarrera'] ?></option>
							<?PHP
							$consultaCarrera->MoveNext();
						}
					?>
				</select>
				<?php

	}
	public function DibujaTabla($id,$id_periodo,$idcarrera){
		global $userid,$db;
		
		
		 $SQL_datoEst='Select numespeciales,numbajos, Validado 
						FROM poblacionespcialbajos
                                                where 
                                                periodo="'.$id_periodo.'"
                                                and carrera_id="'.$idcarrera.'"
                                                and modalidad_id="'.$id.'"
                                                and codigoestado=100
                                                ';
                                                if($D_Becas=&$db->Execute($SQL_datoEst)===false){
						  echo 'Error en el SQL de Completar Carrera...<br>'.$SQL_datoEst;
						  die;
                                                }
                                                $row_Est = $D_Becas->FetchRow();
                                                
                                                $valorCampo1=$row_Est['numespeciales'];
						$valorCampo2=$row_Est['numbajos'];
						$valorCampo3=$row_Est['Validado'];
		
		?>
        <table width="92%"  border="0" align="center" class="formData" >
            <thead>
                <tr>
                    <th class="column" style="border:#000 solid 1px"><strong>N&deg; de estudiantes admitidos por convenio de poblaciones especiales</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>N&deg; de estudiantes admitidos por convenio de estratos bajos</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Validar Dato</strong></th>
                </tr>
                <?PHP 
						
				$this->Campos('num_Especiales','Num_Bajos',$valorCampo1,$valorCampo2,$valorCampo3);#$Campo_1,$Campo_2
						/******************************************************************************/
				?>
                <input type="hidden" id="index" value="<?PHP echo $i?>" />
            </thead>
        </table>
        
        <?PHP
		}
	public function Reporte($codigoperiodo,$Modalidad,$id_Modalidad){
		global $userid,$db;
		
		 
		
						
						#echo '<br>$codigoperiodo->'.$codigoperiodo.'<br>'.$i;
						
						#$C_ObteberData = new obtener_datos_matriculas($db,$codigoperiodo);
						
						/************************************************************************/	
							  $SQL_Registros = 'SELECT

												poblacionespcialbajos_id as id,
												modalidad_id,
												carrera_id,
												numbajos,
												numespeciales,
												periodo
												
												FROM
												
												poblacionespcialbajos
												
												WHERE
												
												periodo="'.$codigoperiodo.'"
												AND
												codigoestado=100
												AND
												modalidad_id="'.$id_Modalidad.'"';
												
								if($RegistroPregrados=&$db->Execute($SQL_Registros)===false){
										echo 'Error en el SQL De los Datos de LA talba de Poblacion de BAjos recurso Y estratos Bajos.....<br>'.$SQL_Registros;
										die;
									}				
							
							      $SQL_RSuma = 'SELECT

												poblacionespcialbajos_id as id,
												modalidad_id,
												carrera_id,
												SUM(numbajos) AS TotalBajo,
												SUM(numespeciales) AS TotalEsp,
												periodo
												
												FROM
												
												poblacionespcialbajos
												
												WHERE
												
												periodo="'.$codigoperiodo.'"
												AND
												codigoestado=100
												AND
												modalidad_id="'.$id_Modalidad.'"';		
												
									if($SumaPregrado=&$db->Execute($SQL_RSuma)===false){
											echo 'Error en el SQL De la Suma de Los Pregrados...<br>'.$SQL_RSuma;
											die;
										}			
						/**************************************Programas de Pregrado************************************/
							if(!$RegistroPregrados->EOF){			
									
									$TotalBajo  = $SumaPregrado->fields['TotalBajo'];
									$TotalEsp   = $SumaPregrado->fields['TotalEsp'];
									
									$this->Tabla($codigoperiodo,'Programas de '.$Modalidad,$RegistroPregrados,$TotalBajo,$TotalEsp);	
										
							}
						/***********************************************************************************************/
		
		}
	public function Carrera($dato){
		
		global $userid,$db;
		
		  $SQL_Carrera='SELECT

						codigocarrera,
						nombrecarrera
						
						FROM 
						
						carrera
						
						WHERE
						
						codigocarrera="'.$dato.'"';
						
				if($Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL Carrera...<br>'.$SQL_Carrera;
						die;
					}		
					
			return $Carrera->fields['nombrecarrera'];		
		
		}		
	public function Tabla($codigoperiodo,$titulo,$Consulta,$TotalBajo,$TotalEsp){
		?>
        <table width="92%"  border="0" align="center" class="formData" >
            <thead>
                <tr>
                    <th class="column" style="border:#000 solid 1px" colspan="4"><?PHP echo $codigoperiodo?></th>
                </tr>
                <tr>
                    <th class="column" style="border:#000 solid 1px">N&deg;</th>
                    <th class="column" style="border:#000 solid 1px"><?PHP echo $titulo?></th>
                    <th class="column" style="border:#000 solid 1px"><strong>N&deg; de estudiantes admitidos por convenio de poblaciones especiales</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>N&deg; de estudiantes admitidos por convenio de estratos bajos</strong></th>
                </tr>
            </thead>
            <tbody>    
                 <?PHP
                    $j=1;
                    while(!$Consulta->EOF){
                        
                        /********************************************************************/
                            #$Datos = $C_ObteberData->obtener_total_matriculados($CodigoCarrera,'conteo');
                        
                        $Nombre 		= $this->Carrera($Consulta->fields['carrera_id']);	
                        $Num_Especial 	= $Consulta->fields['numespeciales'];
                        $Num_Bajos		= $Consulta->fields['numbajos'];	
                        ?>	
                            <tr>
                            	<td align="left" style="border:#000 solid 1px" lass="column center"><?PHP echo $j?></td>
                                <td align="left" style="border:#000 solid 1px" lass="column center"><?PHP echo $Nombre?></td>
                                <td align="center" style="border:#000 solid 1px" lass="column center"><?PHP echo $Num_Especial?></td>
                                <td align="center" style="border:#000 solid 1px" lass="column center"><?PHP echo $Num_Bajos?></td>
                            </tr>	
                        <?PHP	
                        /********************************************************************/
                        $Consulta->MoveNext();
                        $j++;
                        }
				?>
                <tr>
                	<th class="column" style="border:#000 solid 1px" colspan="2" align="center">Total</th>
                    <td align="center" style="border:#000 solid 1px" lass="column center"><?PHP echo $TotalEsp?></td>
                    <td align="center" style="border:#000 solid 1px" lass="column center"><?PHP echo $TotalBajo?></td>
                </tr>		
			 </tbody>     
         </table>
         <br /><br />			
        <?PHP
		}
	public function ViewReporte(){
		global $userid,$db;
		
		 $SQL_Periodo='SELECT 

									codigoperiodo as id,
									codigoperiodo,
									date(fechavencimientoperiodo),
									codigoestadoperiodo
						
						FROM 
						
									periodo
						
						WHERE
						
						(codigoestadoperiodo=1 OR fechavencimientoperiodo< "'.date('Y-m-d').'")
						
						ORDER BY codigoperiodo DESC';
						
				if($Periodo=&$db->Execute($SQL_Periodo)===false){
						echo 'Error en el SQL del Peridod....<br>'.$SQL_Periodo;
						die;
					}
		?>
        <fieldset>   
                <legend>Estudiantes admitidos por programas y convenios de poblaciones especiales y estratos bajos </legend>
                 <table width="50%"  border="0" align="left" >
                	<thead>
                    	<tr>
                        	<th style="border:#FFF solid 1px">Modalidad</th>
                            <th style="border:#FFF solid 1px">
                             <?PHP 
							$this->AutoComplet('Modalidad','Digite la Modalidad a Buscar','FormatModalidad','AutoModalidad','id_Modalidad');#$Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre
								?>
                            </th>
                        </tr>
                    	<tr>
                        	<th style="border:#FFF solid 1px">Periodo</th>
                            <th style="border:#FFF solid 1px">
                            	<select id="Periodo_Reporte" name="Periodo_Reporte" onchange="VerReporte()">
                                    <option value="-1"></option>
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
                <br /><br />
                <div id="CargarReporte"></div>              
        </fieldset>        
        <?PHP	
		}		
	}#class
?>