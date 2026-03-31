<?PHP 
class Reporte_Documento{//Inicon Class
	
	public function Principal(){#Inico Funcion Principal
	#echo 'Seccion-->';$_SESSION['MM_Username'];
		?>
<html>
    <head>
        <title></title>        
        <div id="container">
        
</head>  
	<body id="dt_example">
        <div id="container">
        	<div style="font-size:24px; font-family: 'Times New Roman', Times, serif"><strong>Reporte Documentos</strong></div>      
               
                <div>
                <fieldset>
                 
                	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                    	<tr>
                        	<td width="1%">&nbsp;</td>
                            <td width="99%">
                            	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                                	<tr bgcolor="#FFFFFF">
                                        <td width="13%" style="font-family:'Times New Roman', Times, serif"><strong style="font-size:12px">Fecha Inicio</strong></td>
                                        <td width="36%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="fechainicio" size="12" id="fechainicio" title="Fecha Inicio" maxlength="12" tabindex="7" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo date('Y-m-d')?>" readonly  style="text-align:center"/></td>
                                         <td width="19%">&nbsp;</td>
                                        <td width="17%" align="right" style="font-family:'Times New Roman', Times, serif"><strong style="font-size:12px">Fecha Fin</strong></td>
                                        <td width="15%" align="right"><input type="text" name="fechafin" size="12" id="fechafin" title="Fecha Fin" maxlength="12" placeholder="Fecha Fin" tabindex="8" autocomplete="off" value="<?php echo date('Y-m-d')?>" readonly style="text-align:center" /></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="5">&nbsp;</td>	
                                    </tr>
                                	<tr bgcolor="#FFFFFF">
                                    	<td colspan="1" style="font-family:'Times New Roman', Times, serif"><strong style="font-size:14px">Tipo Filtro:</strong></td>
                                        <td colspan="2" align="left" style="font-family:'Times New Roman', Times, serif"><strong style="font-size:14px"><div id="Nom_filtro"></div></strong></td>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr bgcolor="#FFFFFF">    
                                        <td>
                                        	<select id="Tipos" name="Tipos"  onChange="Cargar_filtro()" style="width:100%" >
                                            	<option value="-1">Elige...</option>
                                                <option value="0">Factor</option>
                                                <option value="1">Caracteristica</option>
                                                <option value="2">Aspecto</option>
                                                <option value="3">Indicador</option>
                                            </select>
                                        </td>
                                        <td colspan="2" align="center"><div id="Box"><input type="text"  id="Filtro" name="Filtro" autocomplete="off"  style="text-align:center;width:90%;" size="70" onClick="formReset('1');" disabled  /></div></td>
                                        <td align="left"><button id="Buscar" title="buscar" value="Buscar" style="font-size:10px" onClick="Buscar()"  class="full_width big">Buscar<img src="../images/Search.png" title="Buscar..." width="15" ></button></td>
                                        <td align="right"><strong style="font-size:14px">Todos</strong>&nbsp;&nbsp;<input type="checkbox" id="All_data" name="All_data" onClick="Busca_active()"></td>
                                        
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td width="1%">&nbsp;</td>
                            <td width="99%">
                            	<table width="100%">
                                	<tr bgcolor="#FFFFFF">
                                    	<td>&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>    
                        <tr>
                        	<td width="1%">&nbsp;</td>
                            <td width="99%">
                            	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr bgcolor="#FFFFFF">
                                    	<td colspan="9">
                                        	<div id="Divdetalles" align="center" style="overflow:scroll;width:100%; height:380; overflow-x:hidden;" ></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="99%">&nbsp;</td> 
                        </tr>
                    </table>
                    </fieldset>
                </div>    
           </div>     
    </body>
</html>
        
        <?
		}#Fin de la Funcion Principal
   public function Box_new($tipo){
		?>
        <script>
		/********************************************************************/
		 $(document).ready(function() {	
			$('#Filtro').autocomplete({
				source: "Reporte_Documento.html.php?actionID=AutoCompletar&Tipo="+<?PHP echo $tipo?>,
				minLength: 2,
				select: function( event, ui ) {
					$('#Filtro_id').val(ui.item.Filtro_id);
					
				}                
			});
		 });
		</script>
        <input type="text"  id="Filtro" name="Filtro" autocomplete="off"  style="text-align:center;width:90%;" size="70" onClick="formReset();"  /><input type="hidden" id="Filtro_id" name="Filtro_id"/>
        <?PHP
	   }
	  public function Resultado($filtro,$id_filtro='',$fecha_ini,$fecha_fin){
		  global $db,$C_Api_Monitoreo;
		  
		 $List = $C_Api_Monitoreo->getQueryIndicadoresACargo();
		 
		  if($filtro==0){
			  	$Filtro_data =' AND  doc.siqfactor_id="'.$id_filtro.'"';
				$Style_1 = 'style="color:#03F"';
			 }
		  if($filtro==1){
			  	$Filtro_data =' AND  doc.siqcaracteristica_id="'.$id_filtro.'"';
				$Style_2 = 'style="color:#03F"';
			  }
		  if($filtro==2){
			  	$Filtro_data =' AND  doc.siqaspecto_id="'.$id_filtro.'"';
				$Style_3 = 'style="color:#03F"';
			  }
		  if($filtro==3){
			  	$Filtro_data =' AND  doc.siqindicador_id="'.$id_filtro.'"';
				$Style_4 = 'style="color:#03F"';
			  }
		  if($filtro==4){
			  	$Filtro_data = '';
				$Style ='';
			  }	  
			  	  	  	  
	         $SQL_Buscar='SELECT 

								doc.idsiq_documento As id,
								doc.siqfactor_id,
								doc.siqcaracteristica_id,
								doc.siqaspecto_id,
								doc.siqindicador_id,
								doc.estado,
								date(doc.fecha_ingreso) AS Fecha_inicial
						
						
						FROM 
						
								siq_documento AS doc
						
						WHERE
								doc.fecha_ingreso BETWEEN "'.$fecha_ini.' 00:00:00" AND "'.$fecha_fin.' 23:59:59" 
								AND
								doc.codigoestado=100'.$Filtro_data.' GROUP BY doc.siqfactor_id, doc.siqcaracteristica_id, doc.siqaspecto_id, doc.siqindicador_id';
								
						if($Datos_R=&$db->Execute($SQL_Buscar)===false){
								echo 'Error en el SQL ..Busqueda...<br>'.$SQL_Buscar;
								die;
							}		
							
				
				if($Datos_R->EOF){
						?>
                       	<strong style="color:#6671A4; text-align:center">No Hay Informacion</strong>
                        <?
					}else{
						$i=1;
						?>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:10px">
                        	<tr bgcolor="#D7D7D7"><!-- 0000FF  E5E2E2-->
                                <th align="center" style="border:#FFFFFF groove 1px; visibility:collapse"><strong style="font-size:12px">N&deg;</strong></td>
                                <th align="left" style="border:#FFFFFF groove 1px"><strong style="font-size:12px">&nbsp;&nbsp;Nombre Filtro</strong></td>
                                <th align="center" style="border:#FFFFFF groove 1px"><strong style="font-size:12px">Fecha Carga&nbsp;&nbsp;&nbsp;</strong></td>
                                <th align="center" style="border:#FFFFFF groove 1px"><strong style="font-size:12px">Fecha Actualizaci&oacute;n</strong></td>
                                <th align="center" style="border:#FFFFFF groove 1px"><strong style="font-size:12px">Fecha Vencimeinto</strong></td>
                                <th align="center" style="border:#FFFFFF groove 1px"><strong style="font-size:12px">N&deg; Archivos</strong></td>
                                <th align="center" style="border:#FFFFFF groove 1px"><strong style="font-size:12px">Estado</strong></td>
                                <th align="center" style="border:#FFFFFF groove 1px"><strong style="font-size:12px">Opciones</strong></td>
                            </tr>
                        <?PHP
						
						if($Lista=&$db->Execute($List)===false){
								echo 'Error en el SQL ....<br>'.$List;
								die;
							}
						
						$R_lista = $Lista->GetArray();
						
						while(!$Datos_R->EOF){
								$val = esPar($i);
								if($val==0){
										$Color = 'bgcolor="#EFEFF1"';	
									}else{
											$Color = 'bgcolor="#DEDDF6"';
										}
							for($t=0;$t<count($R_lista);$t++){
								
									if($Datos_R->fields['siqindicador_id']==$R_lista[$t]['idsiq_indicador']){
										
										
							
							
								?>
                                <tr <?PHP echo $Color?>>
                                	<td align="center" style="visibility:collapse"><strong><?PHP echo $i?></strong></td>
                                    <?PHP 
										$SQL_Factor='SELECT  
															idsiq_factor As id,
															nombre
													FROM 
													
															siq_factor
													
													WHERE
													
															idsiq_factor="'.$Datos_R->fields['siqfactor_id'].'"
															AND
															codigoestado=100';
															
													if($Factor_name=&$db->Execute($SQL_Factor)===false){
															echo 'Error en el SQL Factor...<br>'.$SQL_Factor;
															die;
														}
																
										   $SQL_Carect='SELECT  

																	idsiq_caracteristica As id,
																	nombre
														
														FROM 
																	siq_caracteristica
														
														WHERE
														
																	idsiq_caracteristica="'.$Datos_R->fields['siqcaracteristica_id'].'"
																	AND
																	codigoestado=100';
																	
														if($Caract_name=&$db->Execute($SQL_Carect)===false){
																echo 'Error en el SQl ..Caracteristica...<br>'.$SQL_Carect;
																die;
															}	
																	
										$SQL_Aspecto='SELECT 
			
																idsiq_aspecto as id,
																nombre
														
														FROM 
																siq_aspecto
														
														WHERE
														
																idsiq_aspecto="'.$Datos_R->fields['siqaspecto_id'].'"
																AND
																codigoestado=100';
																
														if($Aspecto_name=&$db->Execute($SQL_Aspecto)===false){
																echo 'Error en el SQl Aspecto...<br>'.$SQL_Aspecto;
																die;
															}		
															
										$SQL_Indicador='SELECT 
														siq_indicador.idsiq_indicador as id, 
														siq_indicadorGenerico.nombre, 
														siq_indicador.fecha_proximo_vencimiento, 
														siq_indicador.idEstado, 
														siq_estadoIndicador.nombre AS estado, 
														date(siq_indicador.fecha_modificacion) As fecha_modificacion,
														siq_indicador.discriminacion,
														siq_indicador.idCarrera,
														siq_indicadorGenerico.idAspecto
														 
														
														FROM 
														siq_indicador, 
														siq_estadoIndicador,
														siq_indicadorGenerico 
														
														WHERE 
														siq_indicador.idsiq_indicador="'.$Datos_R->fields['siqindicador_id'].'" 
														AND 
														siq_indicador.codigoestado=100 
														AND 
														siq_estadoIndicador.codigoestado=100 
														AND 
														siq_estadoIndicador.idsiq_estadoIndicador=siq_indicador.idEstado
														AND
														siq_indicadorGenerico.idsiq_indicadorGenerico=siq_indicador.idIndicadorGenerico';
																	
														if($Inidcador_name=&$db->Execute($SQL_Indicador)===false){
																echo 'Error en el SQl Indicador...<br>'.$SQL_Indicador;
																die;
															}
															
						switch($Inidcador_name->fields['discriminacion']){
							case '1':{$Mas_data='';}break;
							case '2':{
								
								 $SQL_falcutad='SELECT 

														codigofacultad,
														nombrefacultad
											
											FROM 
											
														facultad
											
											WHERE
											
														codigofacultad="'.$Inidcador_name->fields['idFacultad'].'"';
														
														
										if($Facultad=&$db->Execute($SQL_falcutad)===false){
												echo 'Error en el SQL Facultad...<br>'.$SQL_falcutad;
												die;
											}
											
							$Mas_data = '  ::  '.$Facultad->fields['nombrefacultad'];	
								
								}break;
							case '3':{
								
								 $SQL_Carrera='SELECT 

													codigocarrera,
													nombrecarrera
											
											FROM 
											
													carrera
											
											WHERE
											
													codigocarrera="'.$Inidcador_name->fields['idCarrera'].'"';
													
											if($Carrera=&$db->Execute($SQL_Carrera)===false){
													echo 'Error alBuscar la Carrera...<br>'.$SQL_Carrera;
													die;
												}
												
							$Mas_data = '  ::  '.$Carrera->fields['nombrecarrera'];	
								
								}break;
						}	
				
				
				
				
							
							$SQL_Discriminacion='SELECT  

															idsiq_discriminacionIndicador,
															nombre
												
												FROM 
												
															siq_discriminacionIndicador
												
												WHERE
															codigoestado=100
															AND
															idsiq_discriminacionIndicador="'.$Inidcador_name->fields['discriminacion'].'"';
															
												if($Discriminacion=&$db->Execute($SQL_Discriminacion)===false){
														echo 'Error en el SQL Discriminacion....<br>'.$SQL_Discriminacion;
														die;
													}					
									?>
                                    <td align="left" style="font-family:'Times New Roman', Times, serif; "><strong <?PHP echo $Style_1?>><?PHP echo $Factor_name->fields['nombre']?></strong><strong> /</strong> <strong <?PHP echo $Style_2?>><?PHP echo $Caract_name->fields['nombre']?></strong><strong> / </strong><strong <?PHP echo $Style_3?>><?PHP echo $Aspecto_name->fields['nombre']?></strong><strong> / </strong><strong <?PHP echo $Style_4?>><?PHP echo $Inidcador_name->fields['nombre'].'  ::  '.$Discriminacion->fields['nombre'].$Mas_data?></strong></td>
                                    <td align="center"><?PHP echo $Datos_R->fields['Fecha_inicial']?></td>
                                    <td align="center"><?PHP echo $Inidcador_name->fields['fecha_modificacion']?></td>
                                    <td align="center"><?PHP echo $Inidcador_name->fields['fecha_proximo_vencimiento']?></td>
                                    <?PHP 
										 $SQL_Num_Archivo='SELECT     

															COUNT(idsiq_archivodocumento) 
															
															FROM 
															
															siq_archivo_documento
															
															WHERE
															
															siq_documento_id="'.$Datos_R->fields['id'].'"
															AND
															codigoestado=100';
															
												if($Num_Archivos=&$db->Execute($SQL_Num_Archivo)===false){
														echo 'Error en el SQL Numero de Archivos...<br>'.$SQL_Num_Archivo;
														die;
													}			
									?>
                                    <td align="center"><?PHP echo $Num_Archivos->fields[0]?></td>
                                    <?PHP 
									if($Inidcador_name->fields['idEstado']==1){
											$Color = 'color:#FF0000';
										}
									if($Inidcador_name->fields['idEstado']==2){
											$Color = 'color:#0000FF';
										}
									if($Inidcador_name->fields['idEstado']==3){
											$Color = 'color:#990099';
										}
									if($Inidcador_name->fields['idEstado']==4){
											$Color = 'color:#009900';
										}		
									?>
                                    <td align="center"><blink><strong style="font-size:10px;<?PHP echo $Color?>"><?PHP echo $Inidcador_name->fields['estado']?></strong></blink></td>
                                    <td align="center"><input type="button" id="Edit" name="Edit" value="Editar" onClick="Modificar(<?PHP echo $Datos_R->fields['id']?>);"></td>
                                </tr>
                                <?PHP
								
										}#if
								
								}#for	
							
								$i++;
								$Datos_R->MoveNext();
							}
						?>
                        </table>
                        <?PHP
						}		
		  
		  } 	
	}#Fin Class
function esPar($numero){ 
   $resto = $numero%2; 
   if (($resto==0) && ($numero!=0)) { 
        return 1 ;#true
   }else{ 
        return 0; #false
   } 
}
?>