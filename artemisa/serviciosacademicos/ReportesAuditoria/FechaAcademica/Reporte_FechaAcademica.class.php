<?PHP 
class Reporte_FechasAcademicas{
	
	public function Principal(){#public function Principal()
		global $userid,$db;
		?>
        <fieldset style="width:98%;">
            	<legend>Reporte de Fechas Academicas.</legend>
            	<table border="0" align="center" cellpadding="0" cellspacing="0" width="98%">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>Modalidad Académica</strong></td>
                        <td>
                            <?php 
                            /**
                             * @modified Andres Ariza <emailautor@unbosque.edu.do>
                             * La modalidad deja de ser un caja de texto abierta y pasa a ser un select list
                             * @since Junio 18, 2018
                            */
                            $this->ModalidadAcademica();
                            ?>
                        </td>
                        <td>&nbsp;</td>
                        <td><strong>Periodo</strong></td>
                        <td><?php $this->Periodo()?></td>
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
           
        /**
         * @modified Andres Ariza <emailautor@unbosque.edu.do>
         * La modalidad deja de ser un caja de texto abierta y pasa a ser un select list
         * @since Junio 18, 2018
        */     
        public function ModalidadAcademica(){
            global $userid,$db;
            
            $query = "SELECT codigomodalidadacademica, nombremodalidadacademica "
                    . " FROM modalidadacademica "
                    . " WHERE codigomodalidadacademica IN(200,300,400,800,810) "
                    . " AND codigoestado = 100";
            
            if($Modalidad = &$db->Execute($query)===false){
                echo 'Error en el Modalidades...<br>';
                die;
            }
            ?>
            <select id="Modalidad" name="Modalidad" style="width:100%; text-align:center"  onChange="UpdatePeriodo(this);">
            	<option value="0">Selecionar</option>
                <?php
                while(!$Modalidad->EOF){
                    ?>
                    <option value="<?php echo $Modalidad->fields['codigomodalidadacademica']; ?>"><?php echo $Modalidad->fields['nombremodalidadacademica']; ?></option>
                    <?php
                    $Modalidad->MoveNext();
                }
                ?>
            </select>
            <?php
        }

        /**
         * @modified Andres Ariza <emailautor@unbosque.edu.do>
         * Cuando cuando se cambia la modalidad academica se envia una peticion ajax con el actionID updatePeriodo
         * para traer los periodos correspondientes a dicha modalidad seleccionada, por esta razon se agrega el parametro
         * $idModalidad a la funcion periodo, cuando no viene nada en ese parametro la funcion hace la misma consulta que solia hacer
         * @since Junio 18, 2018
        */
	public function Periodo($idModalidad=null){
		
		global $userid,$db;
		if(!empty($idModalidad) && ($idModalidad==800 || $idModalidad==810 )){
                    $SQL_Periodo="SELECT PV.CodigoPeriodo as codigoperiodo "
                            . " FROM PeriodosVirtuales PV "
                            . " INNER JOIN PeriodoVirtualCarrera PVC ON (PVC.idPeriodoVirtual = PV.IdPeriodoVirtual) "
                            . " WHERE PVC.codigoModalidadAcademica=".$idModalidad." ";
		}else{
                    $SQL_Periodo='SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';
                }
                
			if($Periodo=&$db->Execute($SQL_Periodo)===false){
					echo 'Error en el SQL del Periodo...<br>'.$SQL_Periodo;
					die;
				}
			?>
            <select id="Periodo" name="Periodo" style="width:100%; text-align:center">
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
	public function Buscar($id_Movilidad,$Periodo,$id_carrera){
		
		global $userid,$db;
		
		
		if($id_carrera==0){
				##Buscar solo Por Todas las Carreras
				$this->TodasCarreras($id_Movilidad,$Periodo);
			}
		if($id_carrera!=0){
				##Busqueda Detallada
				$this->BuscarDetallada($id_Movilidad,$Periodo,$id_carrera);
			}	
		
		}	
	public function BuscarDetallada($id_Movilidad,$Periodo,$id_carrera){
		
		global $userid,$db;
		
		$SQL_Datos='SELECT 

					fechacortenotas  AS CorteNotas,
					fechacargaacademica  AS CargaAcademica,
					fechainicialprematricula  AS IniPrematricula,
					fechafinalprematricula  AS FinPrematricula,
					fechainicialpostmatriculafechaacademica  AS iniPos,
					fechafinalpostmatriculafechaacademica  AS finPos,
					fechainicialprematriculacarrera AS iniPre,
					fechafinalprematriculacarrera AS finPre,
					fechainicialretiroasignaturafechaacademica AS iniRetiros,
					fechafinallretiroasignaturafechaacademica AS finRetiros,
					fechainicialentregaordenpago AS iniEntrega,
					fechafinalentregaordenpago AS finEntrega,
					fechafinalordenpagomatriculacarrera As finOrden,
					codigocarrera
					
					FROM 
					
					fechaacademica 
					
					WHERE 
					
					codigoperiodo ="'.$Periodo.'" 
					AND 
					codigocarrera ="'.$id_carrera.'"';
					
				if($Detalle=&$db->Execute($SQL_Datos)===false){
						echo 'Error en el SQL De los Datos del Detalle...<br>'.$SQL_Datos;
						die;
					}		
					
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Fecha Corte Notas</strong></th>	
                    <th class="Titulos"><strong>Fecha Carga Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Prematricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Prematricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Posmatricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Posmatricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Prematricula Carrera</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Prematricula Carrera</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Retiro Asignatura Fecha Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Finall Retiro Asignatura Fecha Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Entrega Orden de Pago</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Entrega Orden de Pago</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Orden de Pago Matricula Carrera</strong></th>	
                </tr>
             <?PHP 
			 	if(!$Detalle->EOF){
					
					$i=1;
					
					while(!$Detalle->EOF){
						
						 $SQL_Carrera='SELECT 

										codigocarrera,
										nombrecarrera
										
										FROM 
										
										carrera
										
										WHERE
										
										codigocarrera="'.$Detalle->fields['codigocarrera'].'"';			
										
										
								if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
										echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Carrera;
										die;
									}	
						
						?>
                        <tr>
                           <td align="center" class="Borde_td"><?PHP echo $i?></td>
                           <td align="center" class="Borde_td"><?PHP echo $D_Carrera->fields['nombrecarrera']?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['CorteNotas'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['CargaAcademica'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['IniPrematricula'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['FinPrematricula'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['iniPos'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['finPos'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['iniPre'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['finPre'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['iniRetiros'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['finRetiros'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['iniEntrega'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['finEntrega'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Detalle->fields['finOrden'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Detalle->MoveNext();
						}
					
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
	function TodasCarreras($id_Movilidad,$Periodo){
		
			global $userid,$db;
			
			 $SQL_Datos='SELECT 

						f.fechacortenotas  AS CorteNotas,
						f.fechacargaacademica  AS CargaAcademica,
						f.fechainicialprematricula  AS IniPrematricula,
						f.fechafinalprematricula  AS FinPrematricula,
						f.fechainicialpostmatriculafechaacademica  AS iniPos,
						f.fechafinalpostmatriculafechaacademica  AS finPos,
						f.fechainicialprematriculacarrera AS iniPre,
						f.fechafinalprematriculacarrera AS finPre,
						f.fechainicialretiroasignaturafechaacademica AS iniRetiros,
						f.fechafinallretiroasignaturafechaacademica AS finRetiros,
						f.fechainicialentregaordenpago AS iniEntrega,
						f.fechafinalentregaordenpago AS finEntrega,
						f.fechafinalordenpagomatriculacarrera As finOrden,
						f.codigocarrera
						
						FROM    
						
						fechaacademica f INNER JOIN carrera c ON f.codigocarrera=c.codigocarrera 
						
						WHERE 
						
						f.codigoperiodo ="'.$Periodo.'" 
						AND
						c.codigomodalidadacademica="'.$id_Movilidad.'"';
						
					if($Todas=&$db->Execute($SQL_Datos)===false){
							echo 'Error en el SQl de Todas LAs Fecha Pra Todas LAs Carreras...<br>'.$SQL_Datos;
							die;
						}	
			?>	
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <th class="Titulos"><strong>N&deg;</strong></th>
                    <th class="Titulos"><strong>Carrera</strong></th>
                    <th class="Titulos"><strong>Fecha Corte Notas</strong></th>	
                    <th class="Titulos"><strong>Fecha Carga Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Prematricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Prematricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Posmatricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Posmatricula</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Prematricula Carrera</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Prematricula Carrera</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Retiro Asignatura Fecha Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Finall Retiro Asignatura Fecha Academica</strong></th>	
                    <th class="Titulos"><strong>Fecha Inicial Entrega Orden de Pago</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Entrega Orden de Pago</strong></th>	
                    <th class="Titulos"><strong>Fecha Final Orden de Pago Matricula Carrera</strong></th>	
                </tr>
             <?PHP 
			 	if(!$Todas->EOF){
					
					$i=1;
					
					while(!$Todas->EOF){
						
						 $SQL_Carrera='SELECT 

										codigocarrera,
										nombrecarrera
										
										FROM 
										
										carrera
										   
										WHERE
										
										codigocarrera="'.$Todas->fields['codigocarrera'].'"';			
										
										
								if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
										echo 'Error en la Busqyeda de Datos...<br>'.$SQL_Carrera;
										die;
									}	
						/**************************************/								
						
						$val = esPar($i);
						
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
						
						/***************************************/			
						
						?>
                        <tr <?PHP echo $Color?>>
                           <td align="center" class="Borde_td"><?PHP echo $i?></td>
                           <td align="center" class="Borde_td"><?PHP echo $D_Carrera->fields['nombrecarrera']?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['CorteNotas'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['CargaAcademica'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['IniPrematricula'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['FinPrematricula'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['iniPos'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['finPos'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['iniPre'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['finPre'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['iniRetiros'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['finRetiros'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['iniEntrega'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['finEntrega'])?></td>
                           <td align="center" class="Borde_td"><?PHP $this->FormatFecha($Todas->fields['finOrden'])?></td>
                        </tr>
                        <?PHP
						$i++;
						$Todas->MoveNext();
						}
					
					}			 
			 ?>   
            </table>    	
			<?PHP
		}				
	
	}#Fina CLass
function esPar($numero){ 
   $resto = $numero%2; 
   if (($resto==0) && ($numero!=0)) { 
        return 1 ;#true
   }else{ 
        return 0; #false
   } 
}
	
?>