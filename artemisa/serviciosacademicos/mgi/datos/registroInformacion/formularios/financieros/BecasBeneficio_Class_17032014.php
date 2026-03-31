<?PHP 
class BecasBeneficio{
	
	public function Principal(){
		global $userid,$db;
		?>
        <span class="mandatory">* Son campos obligatorios</span>
        	<form id="xxxxx" name="xxxxx">
              <fieldset>   
                <legend>Estudiantes que se han beneficiado del programa de becas</legend>
                	<table width="50%"  border="0" align="left">
                        <thead>
                            <tr>
                                <th style="border:#FFFFFF solid 1px"><label for="modalidad" class="fixedLabel">Modalidad Académica: <span class="mandatory">(*)</span></label></th>
                                <th style="border:#FFFFFF solid 1px">
                                <?PHP 
									$this->AutoComplet('Modalidad','Digite la Modalidad a Buscar','FormatModalidad','AutocompletModalidad','id_Modalidad');#$Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre
								?>
                                </th>
                            </tr>
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
                        </thead>
                    </table>
                    <br>
                    <input type="hidden" id="Cadena" >
                    <div id="CargarData"></div>
                    
              </fieldset>
              <input type="button" id="Guardar" value="Guardar Datos" class="submit first" onclick="Save()" style="display:none" />
            </form>    
        <?PHP
		}#public function Principal
	public function Campos($i,$Progama_Name,$Campo_1,$Campo_2,$Campo_3,$Campo_4,$Programa_id,$Value,$j){
		?>
        <tr>
            <td style="border:#000 solid 1px" class="column center"><?PHP echo $i?></td>
            <td style="border:#000 solid 1px" class="column center" colspan="2"><?PHP echo $Progama_Name?><input type="hidden" id="<?PHP echo $Programa_id?>" value="<?PHP echo $Value?>"></td>
            <td style="border:#000 solid 1px" class="column center"><input type="text" id="<?PHP echo $Campo_1?>" name="<?PHP echo $Campo_1?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number disable" onkeypress="return isNumberKey(event)" readonly="readonly" /></td>
            <td style="border:#000 solid 1px" class="column center"><input type="text" id="<?PHP echo $Campo_2?>" name="<?PHP echo $Campo_2?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number disable" onkeypress="return isNumberKey(event)" readonly="readonly" /></td>
            <td style="border:#000 solid 1px" class="column center"><input type="text" id="<?PHP echo $Campo_3?>" name="<?PHP echo $Campo_3?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number disable" onkeypress="return isNumberKey(event)" readonly="readonly" /></td>
            <td style="border:#000 solid 1px" class="column center"><input type="text" id="<?PHP echo $Campo_4?>" name="<?PHP echo $Campo_4?>" style="text-align:center" autocomplete="off" class="grid-5-12 required number disable" onkeypress="return isNumberKey(event)"  readonly="readonly"/></td>
            <td style="border:#000 solid 1px" class="column center"><input type="checkbox" id="Validado_<?PHP echo $j?>" id="Validado_<?PHP echo $j?>" /></td>
        </tr>
        <?PHP
		}
	public function AutoComplet($Nombre,$Descripcion,$Onclick,$Funcion,$id_Nombre){
			?>
            <input type="text"  id="<?PHP echo $Nombre?>" name="<?PHP echo $Nombre?>" autocomplete="off" placeholder="<?PHP echo $Descripcion?>"  style="text-align:center;width:90%;" size="70" onClick="<?PHP echo $Onclick?>();" onKeyPress="<?PHP echo $Funcion?>()" /><input type="hidden" id="<?PHP echo $id_Nombre?>" />
            <?PHP
		}
	public function DibujaTabla($id){
		global $userid,$db;
		
		 $SQL_Carrera='SELECT 
						
						codigocarrera as id,
						nombrecarrera 
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademicasic="'.$id.'"
						AND
						codigocarrera  NOT IN (1, 2) ';
						
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
                    <th class="column" style="border:#000 solid 1px"><strong>Becas de excelencia académica</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Beca poblaciones especiales</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Beca Grado de Honor</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Beca graduandos (ECAES)</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Verificar Dato</strong></th>
                </tr>
                <?PHP 
				$i=0;
					while(!$D_Carrera->EOF){
						/******************************************************************************/
						$Name_Programa	= $D_Carrera->fields['nombrecarrera'];
						$Campo_1		= 'B_Academica_'.$i;
						$Campo_2		= 'B_Poblaciones_'.$i;
						$Campo_3		= 'B_Grado_'.$i;
						$Campo_4		= 'B_Graduandos_'.$i;
						$Programa_id	= 'CodigoCarrera_'.$i;
						$Value			= $D_Carrera->fields['id'];
						
						$this->Campos($i+1,$Name_Programa,$Campo_1,$Campo_2,$Campo_3,$Campo_4,$Programa_id,$Value,$i);#$i,$Progama_Name,$Campo_1,$Campo_2,$Campo_3,$Campo_4,$Programa_id,$Value
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
                <legend>Estudiantes que se han beneficiado del programa de becas</legend>
                <table width="50%"  border="0" align="left">
                	<thead>
                    	<tr >
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

						becasbeneficio_id,
						modalidadsic_id,
						carrera_id,
						academica,
						poblaciones,
						grado,
						graduandos,
						periodo
						
						FROM 
						
						becasbeneficio
						
						WHERE
						
						codigoestado=100
						AND
						modalidadsic_id="'.$Modalidad.'"
						AND
						periodo="'.$CodigoPeriodo.'"';
								
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
		
		//include_once ('../../../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
		
		//$C_ObteberData = new obtener_datos_matriculas($db,$CodigoPeriodo);
		
		?>
         <table width="92%"  border="0" align="center" class="formData" >
            <thead>
                <tr>
                    <th class="column" style="border:#000 solid 1px"><strong>N&deg;</strong></th>
                    <th class="column" colspan="2" style="border:#000 solid 1px"><strong>Programa <?PHP echo $titulo?></strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Becas de excelencia académica</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Beca poblaciones especiales</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Beca Grado de Honor</strong></th>
                    <th class="column" style="border:#000 solid 1px"><strong>Beca graduandos (ECAES)</strong></th>
                </tr>
            </thead>
            <tbody>
            <?PHP 
			$i=1;
				while(!$Consulta->EOF){
					/**********************************************************************************/
						$CodigoCarrera		= $Consulta->fields['carrera_id'];
						$Num_academica		= $Consulta->fields['academica'];
						$Num_poblaciones	= $Consulta->fields['poblaciones'];
						$Num_grado			= $Consulta->fields['grado'];
						$Num_graduandos		= $Consulta->fields['graduandos'];
						
						$Nombre		 = $this->Carrera($CodigoCarrera);
						
						$this->Label($i,$Nombre,$Num_academica,$Num_poblaciones,$Num_grado,$Num_graduandos);
						
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
	public function Label($i,$Nombre,$Dato_1,$Dato_2,$Dato_3,$Dato_4){
		?>
        <tr>
        	<td style="border:#000 solid 1px" lass="column center"><?PHP echo $i?></td>
            <td style="border:#000 solid 1px" lass="column center" colspan="2"><strong><?PHP echo $Nombre?></strong></td>
            <td style="border:#000 solid 1px" lass="column center"><?PHP echo $Dato_1?></td>
            <td style="border:#000 solid 1px" lass="column center"><?PHP echo $Dato_2?></td>
            <td style="border:#000 solid 1px" lass="column center"><?PHP echo $Dato_3?></td>
            <td style="border:#000 solid 1px" lass="column center"><?PHP echo $Dato_4?></td>
        </tr>
        <?PHP
		}					
	}#Class
?>