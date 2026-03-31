<?PHP 
class CortesPorcentaje{
	
	public function Principal(){#public function Principal()
		
		global $userid,$db;
		
		?>
        <fieldset style="width:98%;">
            	<legend>Informe Masivo de consulta de cortes de notas.</legend>
            	<table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Modalidad Académica</strong></td>
                        <td><input type="text"  id="Modalidad" name="Modalidad" autocomplete="off" placeholder="Digite Modalidad Académica"  style="text-align:center;width:90%;" size="70" onClick="ResetModalidad();" onKeyPress="autoCompleModalidad()" /><input type="hidden" id="id_modalidad" /></td>
                        <td>&nbsp;</td>
                        <td><strong>Periodo</strong></td>
                        <td><?PHP $this->PeriodoInicial()?></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Carrera</strong></td>
                        <td><input type="text"  id="carrera" name="carrera" autocomplete="off" placeholder="Digite la Carrera" style="text-align:center;width:90%;" size="70" onClick="ResetCarrera();" onkeypress="autoCompleteCarrera()" /><input type="hidden" id="id_carrera"  />&nbsp;&nbsp;<strong>Todas</strong><input type="checkbox" id="TodasCarreras" onclick="Activar()" title="Todas las Carreras" /></td>
                        <td colspan="3">&nbsp;</td>
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
	public function PeriodoInicial(){
		
		global $userid,$db;
			
		$SQL_Periodo='SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';
		
			if($Periodo=&$db->Execute($SQL_Periodo)===false){
					echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
					die;
				}
			?>
            <select id="Periodoini" name="Periodoini" style="width:100%; text-align:center">
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
	public function Buscar($id_carrera,$Periodo){
		
		global $userid,$db;
		
		#echo '$id_carrera->'.$id_carrera;
		
		if($id_carrera==0){
				$Condicion = '';
			}else{
				$Condicion = ' AND  c.usuario ="'.$id_carrera.'"';
			}
		
		 $SQL_Datos='SELECT 
					
					c.idcorte,
					c.codigoperiodo,
					m.codigomateria,
					m.nombremateria,
					p.codigocarrera,
					p.nombrecortocarrera,
					c.fechainicialcorte,
					c.fechafinalcorte,
					c.porcentajecorte
					
					
					FROM 
					
					corte c INNER JOIN materia m ON c.codigomateria=m.codigomateria
							INNER JOIN carrera p ON p.codigocarrera=c.usuario
					
					WHERE 
					
					c.codigoperiodo ="'.$Periodo.'"'.$Condicion;
					
				if($C_Datos=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL de los Datos ...<br>'.$SQL_Datos;
						die;
					}
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Codigo Carrera</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Codigo Materia</strong></th>
                    <th class="Titulos"><strong>Materia</strong></th>
                    <th class="Titulos"><strong>Fecha Inicial</strong></th>
                    <th class="Titulos"><strong>Fecha Final</strong></th>
                    <th class="Titulos"><strong>Porcentaje</strong></th>
                    <th class="Titulos"><strong>Periodo</strong></th>
               </tr>     		
			<?PHP
				if(!$C_Datos->EOF){
					$i=1;
					while(!$C_Datos->EOF){
						/***************************************************************************/
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						?>
                        <tr <?PHP echo $Color?>>
                        	<td class="Borde_td" align="center"><?PHP echo $i?></td>
                            <td class="Borde_td" align="center"><?PHP echo $C_Datos->fields['codigocarrera']?></td>
                            <td class="Borde_td"><?PHP echo $C_Datos->fields['nombrecortocarrera']?></td>
                            <td class="Borde_td" align="center"><?PHP echo $C_Datos->fields['codigomateria']?></td>
                            <td class="Borde_td"><?PHP echo $C_Datos->fields['nombremateria']?></td>
                            <td class="Borde_td" align="center"><?PHP $this->FormatFecha($C_Datos->fields['fechainicialcorte'])?></td>
                            <td class="Borde_td" align="center"><?PHP $this->FormatFecha($C_Datos->fields['fechafinalcorte'])?></td>
                            <td class="Borde_td" align="right"><?PHP echo $C_Datos->fields['porcentajecorte']?>&nbsp;%</td>
                            <td class="Borde_td" align="center"><?PHP echo $C_Datos->fields['codigoperiodo']?></td>
                        </tr>
                        <?PHP
						/***************************************/
						/***************************************************************************/
						$i++;
						$C_Datos->MoveNext();
						}
					
					}else{
						?>
                        <tr>
                        	<td colspan="9" align="center"><span style="color:#999">No Hay Informacion...</span></td>
                        </tr>
                        <?PHP
						}
			?>
            </table>
            <?PHP
		}	
	public function FormatFecha($fecha){
		
		global $userid,$db;
		
		
			$D_Fecha = explode('-',$fecha);
			
			
			$D_Fecha[0];#Año
			$D_Fecha[1];#Mes
			$D_Fecha[2];#Dia
			
			$New_Fecha = $D_Fecha[2].'/'.$D_Fecha[1].'/'.$D_Fecha[0];
			
			echo $New_Fecha;
			
		}	
}#Class
function esPar($numero){ 
   $resto = $numero%2; 
   if (($resto==0) && ($numero!=0)) { 
        return 1 ;#true
   }else{ 
        return 0; #false
   } 
}
	
