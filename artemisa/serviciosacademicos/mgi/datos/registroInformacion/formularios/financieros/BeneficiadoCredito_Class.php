<?PHP
class BeneficiadoCredito{
	
		public function Principal(){
			global $userid,$db;
		?>
        <span class="mandatory">* Son campos obligatorios</span>
        	<form id="zzzz" name="zzzz">
              <fieldset>   
                <legend>Estudiantes que se han beneficiado por créditos</legend>
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
									$this->selectModalidadd($db);
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
		public function Campos($i,$Progama_Name,$Campo_1,$Campo_2,$Campo_3,$Programa_id,$Value,$Valor_1,$Valor_2,$Valor_3,$j,$valorCampo1,$valorCampo2,$valorCampo3,$valorCampo4,$valorCampo5,$valorCampo6){
		?>
        <tr>
            <td style="border:#000 solid 1px" lass="column center"><?PHP echo $i?></td>
            <td style="border:#000 solid 1px" lass="column center" colspan="2"><?PHP echo $Progama_Name?><input type="hidden" id="<?PHP echo $Programa_id?>" value="<?PHP echo $Value?>"></td>
            <td style="border:#000 solid 1px" lass="column center"><input type="text" id="<?PHP echo $Campo_1?>" name="<?PHP echo $Campo_1?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number" onkeypress="return isNumberKey(event)" value="<?php if(!$valorCampo1){ echo "0"; } else{ echo $valorCampo1; } ?>"/></td>
            <td style="border:#000 solid 1px" lass="column center"><input type="text" id="<?PHP echo $Valor_1?>" name="<?PHP echo $Valor_1?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number" onkeypress="return isNumberKey(event)" value="<?php if(!$valorCampo2){ echo "0"; } else{ echo $valorCampo2; } ?>"/></td>
            <td style="border:#000 solid 1px" lass="column center"><input type="text" id="<?PHP echo $Campo_2?>" name="<?PHP echo $Campo_2?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number" onkeypress="return isNumberKey(event)" value="<?php if(!$valorCampo3){ echo "0"; } else{ echo $valorCampo3; } ?>"/></td>
            <td style="border:#000 solid 1px" lass="column center"><input type="text" id="<?PHP echo $Valor_2?>" name="<?PHP echo $Valor_2?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number" onkeypress="return isNumberKey(event)" value="<?php if(!$valorCampo4){ echo "0"; } else{ echo $valorCampo4; } ?>"/></td>
            <td style="border:#000 solid 1px" lass="column center"><input type="text" id="<?PHP echo $Campo_3?>" name="<?PHP echo $Campo_3?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number" onkeypress="return isNumberKey(event)" value="<?php if(!$valorCampo5){ echo "0"; } else{ echo $valorCampo5; } ?>"/></td>
            <td style="border:#000 solid 1px" lass="column center"><input type="text" id="<?PHP echo $Valor_3?>" name="<?PHP echo $Valor_3?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number" onkeypress="return isNumberKey(event)" value="<?php if(!$valorCampo6){ echo "0"; } else{ echo $valorCampo6; } ?>"/></td>
            <!--<td style="border:#000 solid 1px" lass="column center"><input type="checkbox" id="Validar_<?PHP //echo $j?>" name="Validar_<?PHP //echo $j?>" /></td>-->
        </tr>
        <?PHP
		}
	public function AutoComplet($Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre){
			?>
            <input type="text"  id="<?PHP echo $Nombre?>" name="<?PHP echo $Nombre?>" autocomplete="off" placeholder="<?PHP echo $Descripcion?>"  style="text-align:center;width:90%;" size="70" onClick="<?PHP echo $Onclick?>();" onKeyPress="<?PHP echo $Funcion?>()" /><input type="hidden" id="<?PHP echo $id_Nombre?>" />
            <?PHP
		}
	public function selectModalidadd($db){
		$SQL_Modalidadd='SELECT 

						codigomodalidadacademica  AS id,
						nombremodalidadacademica  AS Nombre 
						
						 FROM modalidadacademica
						
						WHERE
						codigomodalidadacademica in (200,300)
						and codigoestado=100';

        if($modalidadConsultaa = &$db->Execute($SQL_Modalidadd)===false){
				echo 'Error en el SQL de consultar modalidad....<br>'.$SQL_Modalidadd;
				die;
			}
		
		?>
		<select id="id_Modalidad" name="id_Modalidad" onchange="dataNew();">
			<option value="-1"></option>
			<?php
				while(!$modalidadConsultaa->EOF) {
					?>
					<option value="<?php echo $modalidadConsultaa->fields['id'] ?>"><?php echo $modalidadConsultaa->fields['Nombre'] ?></option>
					<?PHP
					$modalidadConsultaa->MoveNext();
				}
			?>
		</select>
		<?php
	}
	public function DibujaTabla($id,$id_periodo){
		global $userid,$db;
		
		 $SQL_Carrera='SELECT 
						
						codigocarrera as id,
						nombrecarrera 
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademica="'.$id.'"
						AND
						now() between fechainiciocarrera and fechavencimientocarrera 
						AND
						codigocarrera  NOT IN (1, 2) 
						order by nombrecarrera';
						
				if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL de Completar Carrera...<br>'.$SQL_Carrera;
						die;
					}
		?>
        <table width="92%"  border="0" align="center" class="formData" >
            <thead>
                <tr>
                    <th class="column" style="border:#000 solid 1px"><strong>N&deg;</strong></th>
                    <th class="column" colspan="2" style="border:#000 solid 1px"><strong>Programa</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Entidad Financiera</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Valor Entidad Financiera</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>ICETEX</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Valor ICETEX</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Crédito de la Universidad</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Valor Crédito de la Universidad</strong></th>
                    <!--<th class="column" style="border:#000 solid 1px"><strong>Validacion Dato</strong></th>-->
                </tr>
                <?PHP 
				$i=0;
					while(!$D_Carrera->EOF){
					
						$SQL_datoBeneficio='Select EntidadFinaciera,valorEntidad,icetex,valorIcetex,CreUniversidad,valorUniversidad 
						FROM beneficiocredito
                                                where 
                                                periodo="'.$id_periodo.'"
                                                and carrera_id="'.$D_Carrera->fields['id'].'"
                                                and modalidadsic_id="'.$id.'"
                                                and codigoestado=100
                                                ';
                                                if($D_Becas=&$db->Execute($SQL_datoBeneficio)===false){
						  echo 'Error en el SQL de Completar Carrera...<br>'.$SQL_datoBeneficio;
						  die;
                                                }
                                                $row_bene = $D_Becas->FetchRow();
					
						/******************************************************************************/
						$Name_Programa	= $D_Carrera->fields['nombrecarrera'];
						$Campo_1		= 'EntidadFinaciera_'.$i;
						$Campo_2		= 'Icetex_'.$i;
						$Campo_3		= 'CreUniversidad_'.$i;
						$Programa_id	= 'CodigoCarrera_'.$i;
						$Value			= $D_Carrera->fields['id'];
						$Valor_1		= 'V_Finaciera_'.$i;
						$Valor_2		= 'V_Icetex_'.$i;
						$Valor_3		= 'V_Universidad_'.$i;
						
						$valorCampo1=$row_bene['EntidadFinaciera'];
						$valorCampo2=$row_bene['valorEntidad'];
						$valorCampo3=$row_bene['icetex'];
						$valorCampo4=$row_bene['valorIcetex'];
						$valorCampo5=$row_bene['CreUniversidad'];
						$valorCampo6=$row_bene['valorUniversidad'];
						
						$this->Campos($i+1,$Name_Programa,$Campo_1,$Campo_2,$Campo_3,$Programa_id,$Value,$Valor_1,$Valor_2,$Valor_3,$i,$valorCampo1,$valorCampo2,$valorCampo3,$valorCampo4,$valorCampo5,$valorCampo6);#$i,$Progama_Name,$Campo_1,$Campo_2,$Campo_3,$Campo_4,$Programa_id,$Value
						/******************************************************************************/
						$i++;
						$D_Carrera->MoveNext();
						}
				?>
                <input type="hidden" id="index" value="<?PHP echo $i?>" />
            </thead>
        </table>
        
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
                <legend>Estudiantes que se han beneficiado por créditos</legend>
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
	public function Reporte($CodigoPeriodo,$Modalidad,$id_Modalidad){
		global $userid,$db;
		
		#$CodigoPeriodo	=20131;
		
		
		$this->Consulta($CodigoPeriodo,$id_Modalidad,$Modalidad);
		/*$this->Consulta($CodigoPeriodo,'300','Especialización');
		$this->Consulta($CodigoPeriodo,'301','Maestría');
		$this->Consulta($CodigoPeriodo,'302','Doctorado');*/
		
		
		}
	public function Consulta($CodigoPeriodo,$Modalidad,$titulo){
		global $userid,$db;
		
		 $SQL_Consulta='SELECT 

								beneficiocredito_id AS id,
								modalidadsic_id,
								carrera_id,
								EntidadFinaciera,
								icetex,
								CreUniversidad,
								periodo
						
						FROM 
						
								beneficiocredito
						
						WHERE
						
								codigoestado=100
								AND
								periodo="'.$CodigoPeriodo.'"
								AND
								modalidadsic_id="'.$Modalidad.'"';
								
				if($Resultado=&$db->Execute($SQL_Consulta)===false){
						echo 'Error en el SQL .....<br>'.$SQL_Consulta;
						die;
					}		
			
			if(!$Resultado->EOF){
					$this->Tabla($Resultado,$CodigoPeriodo,$titulo);
				}				
		
		}
	public function Tabla($Consulta,$CodigoPeriodo,$titulo){
		global $userid,$db;	
		
		include_once ('../../../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
		
		$C_ObteberData = new obtener_datos_matriculas($db,$CodigoPeriodo);
		
		?>
         <table width="92%"  border="0" align="center" class="formData" >
            <thead>
                <tr>
                    <th class="column" style="border:#000 solid 1px"><strong>N&deg;</strong></th>
                    <th class="column" colspan="2" style="border:#000 solid 1px"><strong>Programa <?PHP echo $titulo?></strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Entidad Financiera</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>ICETEX</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Crédito de la Universidad</strong></th>
                </tr>
            </thead>
            <tbody>
            <?PHP 
			$i=1;
				while(!$Consulta->EOF){
					/**********************************************************************************/
						$CodigoCarrera	= $Consulta->fields['carrera_id'];
						$Num_Entidad	= $Consulta->fields['EntidadFinaciera'];
						$Num_icetex		= $Consulta->fields['icetex'];
						$Num_Univer		= $Consulta->fields['CreUniversidad'];
						
						$Nombre		 = $this->Carrera($CodigoCarrera);
						
						$Dato = $C_ObteberData->obtener_total_matriculados($CodigoCarrera,'conteo');
						
										
						/********************************/
						$Result_Entidad	= $this->Formato($Num_Entidad/$Dato);
						$Result_icetex	= $this->Formato($Num_icetex/$Dato);
						$Result_Univer	= $this->Formato($Num_Univer/$Dato);
						
						$this->Label($i,$Nombre,$Result_Entidad,$Result_icetex,$Result_Univer);
						
					/**********************************************************************************/
					$Consulta->MoveNext();	
					$i++;
					}
			?>	
            </tbody>    
       </table>
       <br /><br />     
        <?PHP
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
	public function Formato($Dato){
			
			$Numero = number_format($Dato,'2','.',',');
			
			return $Numero;
			
		}
	public function Label($i,$Nombre,$Dato_1,$Dato_2,$Dato_3){
		?>
        <tr>
        	<td style="border:#000 solid 1px" lass="column center"><?PHP echo $i?></td>
            <td style="border:#000 solid 1px" lass="column center" colspan="2"><strong><?PHP echo $Nombre?></strong></td>
            <td style="border:#000 solid 1px" lass="column center"><?PHP echo $Dato_1?></td>
            <td style="border:#000 solid 1px" lass="column center"><?PHP echo $Dato_2?></td>
            <td style="border:#000 solid 1px" lass="column center"><?PHP echo $Dato_3?></td>
        </tr>
        <?PHP
		}				
	}#class
?>