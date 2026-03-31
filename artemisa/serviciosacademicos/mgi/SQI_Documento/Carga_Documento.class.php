<?PHP 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
class Carga_Documento{#inico de Class
	
	public function Principal(){#Inico funcion Principal
	global $userid;
	include('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		include('../../Connections/salaado.php');
	
	
		?>
                     
		
         <script>
		 function autocomplet(){
			 
			 
			        var faculta_id   = $('#faculta_id').val();
			        var Programa_id  = $('#Programa_id').val();
					var Discriminacion_id = $('#Discriminacion_id').val();
					//alert('faculta_id-->'+faculta_id+'\n Programa_id-->'+Programa_id);
				
				$('#Factor').autocomplete({
					
					source: "Carga_Documento.html.php?actionID=AutoCompletar&faculta_id="+faculta_id+"&Programa_id="+Programa_id+"&Discriminacion_id="+Discriminacion_id,
					minLength: 2,
					select: function( event, ui ) {
						$('#Factor_id').val(ui.item.Factor_id);
						$('#caracteristica_id').val(ui.item.Caracteristica_id);
						$('#Aspecto_id').val(ui.item.Aspecto_id);
						$('#Inicador_id').val(ui.item.Inicador_id);
						
						$('#Cadena_nom').css('visibility','visible');
						
						$('#Td_Factor').html(ui.item.nom_factor);
						$('#Td_Caracteristica').html(ui.item.nom_caracteristica);
						$('#Td_Aspecto').html(ui.item.nom_aspecto);
						$('#Td_indicador').html(ui.item.nom_indicador);
						$('#Td_indicadorCode').html(ui.item.Inicador_id);
						$('#Td_Discriminacion').html(ui.item.Discriminacion);
						$('#Td_TipoIndicador').html(ui.item.NomTipo);	
						$('#Td_TipoArchivo').html(ui.item.NomArchivo);					
						if(ui.item.Discri_value==2 || ui.item.Discri_value==3){
								$('#Discriminacion').html(ui.item.Discriminacion);
								$('#Td_Dato').html(ui.item.tipo_discrimi);
							}
						$('#Analisi').val(ui.item.Analisis);
						$('#Anexo').val(ui.item.Anexo);
						$('#Tipo_indicador').val(ui.item.idTipo_indicador);
						if(ui.item.Estado==1){
							validar_tipo('3',ui.item.idTipo_indicador,ui.item.Analisis,ui.item.Anexo);
							}else{
									if(ui.item.Estado==2){
											var tipo_estado = 'En Proceso';
										}
									if(ui.item.Estado==3){
											var tipo_estado = 'En Revision';
										}	
									if(ui.item.Estado==4){
											var tipo_estado = 'Actualizada';
										}	
									var Confir = confirm('El Indicador se encuentra '+tipo_estado+' \n Desea continuar...?');
									
									if(Confir){
											location.href='Documento_Ver.html.php?actionID=Modificar_UP&Inicador_id='+ui.item.Inicador_id;
										}else{
												location.href='Carga_Documento.html.php';
											}
								}
						//$('#Carecteristicas').attr('readOnly',false);
						//Box_Caracteritica(ui.item.Factor_id);
					}                
				});
			 
			 }	
		
		</script>
       <html>
                <head>
                    <title></title>        
                    <div id="container">
                    
            </head>  
                <body id="dt_example">
                    <div id="container">
                        <div style="font-size:24px; font-family:'Times New Roman', Times, serif"><strong>Gesti&oacute;n Documental</strong></div>
                        <br>
                             
                            <div>  
       <div id="container">
               
                <h2></h2>
         <fieldset><span style="color:#F00; font-size:10px">(*)son campos Obligatorios</span>        
        <table border="0" cellpadding="0" cellspacing="0"  id="uno" width="99%" style="display:block; table-layout:fixed"><!--table 1-->
        <form action="Cargar_archivo.php" method="post" enctype="multipart/form-data" name="Principal">
            <tr>
            	<td colspan="3">
                <fieldset>
                	<table border="0" id="aca" width="99%"><!--table 2-->
                    	<tr>
                        	<td>
                            	<table  border="0" cellpadding="0" cellspacing="0" id="despues"><!--table 3-->
                                    <tr>
                                        <td style="font-family:'Times New Roman', Times, serif"><strong>Clase de Indicador:</strong></td>
                                        <td>&nbsp;</td>
                                        <td id="td_Faculta" style="visibility: collapse;font-family:'Times New Roman', Times, serif"><strong>Facultad</strong></td>
                                        <td>&nbsp;</td>
                                        <td id="td_programa" style="visibility:collapse;font-family:'Times New Roman', Times, serif"><strong>Programa</strong></td>
                                        <td>&nbsp;</td>
                                   </tr>
                                    <?PHP 
                                    $SQL_Discriminacion='SELECT  
            
                                                                        idsiq_discriminacionIndicador as id,
                                                                        nombre
                                                            
                                                            FROM 
                                                            
                                                                        siq_discriminacionIndicador
                                                            
                                                            WHERE
                                                                        codigoestado=100';
                                                                        
                                                            if($Discriminacion=&$db->Execute($SQL_Discriminacion)===false){
                                                                    echo 'Error en el SQL Discriminacion....<br>'.$SQL_Discriminacion;
                                                                    die;
                                                                }		
                                    ?>
                                    <tr>
                                        <td>
                                        <select id="Discriminacion_id" name="Discriminacion_id"  style="width:90%" onChange="Activar()" >
                                            <option value="-1">Elige...</option>
                                            <?PHP 
                                            while(!$Discriminacion->EOF){
                                                ?>
                                                <option value="<?PHP echo $Discriminacion->fields['id']?>"><?PHP echo $Discriminacion->fields['nombre']?></option>
                                                <?PHP
                                                $Discriminacion->MoveNext();
                                                }
                                            ?>
                                        </select>
                                        
                                        </td>
                                        <td>&nbsp;</td>
                                        <td style="font-family:'Times New Roman', Times, serif">
                                        	<div id="Div_Faculta" style="display:none">
                                            <?PHP	
                                                 $SQL='SELECT 
		
                                                                    codigofacultad as id,
                                                                    nombrefacultad
                                                        
                                                        FROM 
                                                        
                                                                    facultad
                                                                    
                                                                    ORDER BY nombrefacultad ASC';
                                                        if($Select_Option=&$db->Execute($SQL)===false){
                                                            echo 'Error en el SQL Secte del Ajax...<br>'.$SQL;
                                                            die;
                                                        }
                                                        
                                                ?>
                                                <select id="faculta_id" name="faculta_id"  style="width:90%">
                                                    <option value="-1">Elige...</option>
                                                        <?PHP 
                                                            while(!$Select_Option->EOF){
                                                                    ?>
                                                                    <option value="<?PHP echo $Select_Option->fields['id']?>" onClick="Program_ver('<?PHP echo $Select_Option->fields['id']?>')"><?PHP echo $Select_Option->fields['nombrefacultad']?></option>
                                                                    <?PHP
                                                                $Select_Option->MoveNext();	
                                                                }
                                                        ?>
                                                    </option>
                                                </select> 
                                            </div>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td style="font-family:'Times New Roman', Times, serif"><div id="Div_Programa"></div></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table><!--table 3-->
                            </td>
                            <td align="center">&nbsp;&nbsp;</td>
               				<td align="center">
                                <table border="0" ><!--table 4-->
                                    <tr>
                                        <td style="font-family:'Times New Roman', Times, serif"><strong>&nbsp;&nbsp;Nombre del Indicador:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text"  id="Factor" name="Factor" autocomplete="off"  style="text-align:center;width:90%;" size="70" onClick="formReset('1');" onKeyPress="autocomplet()"  /><input type="hidden" id="Factor_id" name="Factor_id"/></td>
                                    </tr>
                                </table><!--table 4-->
                            </td>
                        </tr>
                    </table><!--table 2-->
                </fieldset>
                </td>
            </tr>
            <tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="3" align="center" style="visibility:collapse" id="Cadena_nom">
                	<table border="0" width="100%"><!--table 5-->
                    	<tr>
                        	<td style="font-family:'Times New Roman', Times, serif"><strong>Factor:</strong></td>
                        	<td id="Td_Factor" style="font-family:'Times New Roman', Times, serif"></td>
                        </tr>
                        <tr>
                        	<td style="font-family:'Times New Roman', Times, serif"><strong>Caracteristica:</strong></td>    
                            <td id="Td_Caracteristica" style="font-family:'Times New Roman', Times, serif"></td>
                        </tr>
                        <tr>    
                        	<td style="font-family:'Times New Roman', Times, serif"><strong>Aspecto a Evaluar:</strong></td>
                            <td id="Td_Aspecto" style="font-family:'Times New Roman', Times, serif"></td>
                        </tr>
                        <tr>    
                            <td style="font-family:'Times New Roman', Times, serif"><strong>Indicador:</strong></td>
                            <td id="Td_indicador" style="font-family:'Times New Roman', Times, serif"></td>
                        </tr>
                        <tr>    
                            <td style="font-family:'Times New Roman', Times, serif"><strong>Codigo Indicador:</strong></td>
                            <td id="Td_indicadorCode" style="font-family:'Times New Roman', Times, serif"></td>
                        </tr>
                        <tr>    
                            <td style="font-family:'Times New Roman', Times, serif"><strong>Discriminaci&oacute;n:</strong></td>
                            <td id="Td_Discriminacion" style="font-family:'Times New Roman', Times, serif"></td>
                        </tr>
                        <tr>    
                            <td style="font-family:'Times New Roman', Times, serif"><strong>Tipo Indicador:</strong></td>
                            <td id="Td_TipoIndicador" style="font-family:'Times New Roman', Times, serif"></td>
                        </tr>
                        <tr>    
                            <td style="font-family:'Times New Roman', Times, serif"><strong>Tipo Archivo:</strong></td>
                            <td id="Td_TipoArchivo" style="font-family:'Times New Roman', Times, serif"></td>
                        </tr>
                    </table><!--table 5-->
                </td>
            </tr>
            <tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <!--<tr id="Tr_URL" style="visibility:collapse">
            	<td>
                	<table border="0"  cellpadding="0" cellspacing="0">
                    	<tr>
                            <td align="left"><strong>&nbsp;&nbsp;URL:&nbsp;&nbsp;<span style="color:#F00">*</span></strong></td>
                        </tr>
                        <tr>
                        	<td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="tetx" id="url_Ubicacion" name="url_Ubicacion" size="50"  autocomplete="off" /></td>
                        </tr>
                    </table>
                </td>
                <td align="center">
                	<table>
                    	<tr>
                        	<td>
                            	<strong style="font-size:12px">&nbsp;&nbsp;Tipo Archivo:</strong>
                            </td>
                       </tr>
                       <tr>
                       		<td>
                            	<select id="Tipo_URl" name="Tipo_URl"  style="width:90%">
                                	<option value="-1">Elige...</option>
                                    <option value="1" onClick="validar_tipo('0')">Principal</option>
                                    <option value="2" onClick="validar_tipo('1')">An&aacute;lisis</option>
                                    <option value="3" onClick="validar_tipo('2')">Anexo</option>
                                </select>
                            </td>
                       </tr>
                    </table>
                </td>
                <td align="left">
                	<table align="center">
                    	<tr>
                        	<td><strong>Periodo:</strong></td>
                            <td align="left"><strong>Programa:</strong></td>
                        </tr>
                        <tr>
                        	<td align="center">
                            <?PHP 
							/*$year = date('Y');
							$monunt = date('m');
							
							if($monunt<6){
									$Periodo_num = '1';
								}else{
										$Periodo_num = '2';
									}*/
							?>
                            <input type="text" value="<?PHP #echo $year.'-'.$Periodo_num;?>"  id="Periodo" name="Periodo" readonly style="text-align:center">
                            </td>
                            <td>
                            	
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>-->
            <tr id="TR_Cargar">
            	<td>
                	<table border="0"  cellpadding="0" cellspacing="0">
                    	<tr>
                            <td align="left" style="font-family:'Times New Roman', Times, serif"><strong>&nbsp;&nbsp;Cargar Archivo:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
                        </tr>
                        <tr>
                        	<td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><input type="file" id="file" name="file" height="80px"  size="50"/><br><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Max / Word</span></td>
                        </tr>
                    </table>
                </td>
                <td colspan="2"></td>
             </tr> 
             <tr>  
                <td align="center">
                	<table>
                    	<tr>
                        	<td style="font-family:'Times New Roman', Times, serif">
                            	<strong>&nbsp;&nbsp;Tipo Archivo:</strong>
                            </td>
                       </tr>
                       <tr>
                       		<td>
                            	<select id="Tipo_Carga" name="Tipo_Carga"  style="width:100%">
                                	<option value="-1">Elige...</option>
                                    <option value="1" onClick="validar_tipo('0');CambiarDoc('0')">Principal</option>
                                    <option value="2" onClick="validar_tipo('1');CambiarDoc('0')">An&aacute;lisis</option>
                                    <option value="3" onClick="validar_tipo('2');CambiarDoc('1')">Anexo</option>
                                </select>
                            </td>
                       </tr>
                    </table>
                </td>
                <td align="left">
                	<table align="center">
                    	<tr>
                        	<td style="font-family:'Times New Roman', Times, serif"><strong>Periodo:</strong></td>
                            <td align="left" style="font-family:'Times New Roman', Times, serif"><strong id="Discriminacion">Programa:</strong></td>
                        </tr>
                        <tr>
                        	<td align="center">
                            <?PHP 
							$year = date('Y');
							$monunt = date('m');
							
							if($monunt<6){
									$Periodo_num = '1';
								}else{
										$Periodo_num = '2';
									}
							?>
                            <input type="text" value="<?PHP echo $year.'-'.$Periodo_num;?>"  id="Periodo" name="Periodo" size="8" readonly style="text-align:center">
                            </td>
                            <td align="left"><div id="Td_Dato" style="font-size:12px; font-family:'Times New Roman', Times, serif; width:auto"></div></td>
                        </tr>
                    </table>
                </td>
                <td></td>
            </tr>
            <tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <tr>
            	<td align="left" colspan="3" style="font-family:'Times New Roman', Times, serif"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
            </tr>
            <tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <tr>
            	<td align="center" colspan="3"><textarea  id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
            </tr>
            <tr>
            	<td colspan="3">&nbsp;<input type="hidden" id="caracteristica_id" name="caracteristica_id" /><br><input type="hidden" id="Aspecto_id" name="Aspecto_id" /><br><input type="hidden" id="Inicador_id" name="Inicador_id" /><br /><input type="hidden" id="Analisi" name="Analisi" /><br /><input type="hidden" id="Anexo" name="Anexo" /><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" /></td>
            </tr>
            <tr>
            	<td colspan="3" align="center">
                	<div id="File_Sub" style="display:none">
                    	<input type="button" id="Save_OK" name="Save_OK" onClick="Save_Documento()" value="Guardar" />
                    </div>
                    <div id="Save_Ok" >
                    	<input type="submit" id="Save" name="Save" value="Guardar" onClick="return Validar();" />
                    </div>
                </td>
            </tr>
          </form>  
        </table><!--table 1-->
       </fieldset> 
        </div>
       </div>    
   </div>     
</body>
</html>  
        <?PHP
		}#fin Funcion Principal
		
		public function Box_Caracteritica($factor_id){
			?>
            <script>
            /********************************************************************/
			 $(document).ready(function() {	
				$('#Carecteristicas').autocomplete({
					source: "Carga_Documento.html.php?actionID=AutoCompletar_Caracteritica&Factor_id="+<?PHP echo $factor_id?>,
					minLength: 2,
					select: function( event, ui ) {
						$('#caracteristica_id').val(ui.item.Caracteristica_id);
						Box_Aspecto(ui.item.Caracteristica_id);
					}                
				});
			 });
			</script>	
            <input type="text"  id="Carecteristicas" name="Carecteristicas" autocomplete="off"  style="text-align:center;width:90%" size="70" onClick="formReset('2');"   />
            <?
			}
		public function Box_Aspecto($Caracteritica_id){
			?>
            <script>
            /********************************************************************/
			 $(document).ready(function() {
				$('#Aspecto').autocomplete({
					source: "Carga_Documento.html.php?actionID=AutoCompletar_Aspecto&Caract_id="+<?PHP echo $Caracteritica_id?>,
					minLength: 2,
					select: function( event, ui ) {
						$('#Aspecto_id').val(ui.item.Aspecto_id);
						Box_Indicador(ui.item.Aspecto_id);
					}                
				});
			 });
            </script>
            <input type="text"  id="Aspecto" name="Aspecto" autocomplete="off"  style="text-align:center;width:90%" size="70" onClick="formReset('3');" />
            <?PHP
			}	
	    public function Box_Indicador($Aspecto_id){
			?>
            <script>
            /********************************************************************/
			 $(document).ready(function() {
				/********************************************************************/
				$('#Indicador').autocomplete({
					source: "Carga_Documento.html.php?actionID=AutoCompletar_Indicador&Aspecto_id="+<?PHP echo $Aspecto_id?>,
					minLength: 2,
					select: function( event, ui ) {
						$('#Inicador_id').val(ui.item.Inicador_id);
						$('#Analisi').val(ui.item.Analisis);
						$('#Anexo').val(ui.item.Anexo);
						$('#Tipo_indicador').val(ui.item.idTipo_indicador);
						if(ui.item.Estado==1){
							validar_tipo('3',ui.item.idTipo_indicador,ui.item.Analisis,ui.item.Anexo);
							}else{
									if(ui.item.Estado==2){
											var tipo_estado = 'En Proceso';
										}
									if(ui.item.Estado==3){
											var tipo_estado = 'En Revision';
										}	
									if(ui.item.Estado==4){
											var tipo_estado = 'Actualizada';
										}	
									var Confir = confirm('El Indicador se encuentra '+tipo_estado+' \n Desea continuar...?');
									
									if(Confir){
											location.href='Documento_Ver.html.php?actionID=Modificar_UP&Inicador_id='+ui.item.Inicador_id;
										}else{
												location.href='Carga_Documento.html.php';
											}
								}
								
					}                
				   });
			     });  
			 
            </script>
            <input type="text"  id="Indicador" name="Indicador" autocomplete="off"  style="text-align:center;width:90%" size="70" onClick="formReset('4');" />
            <?PHP
			}  
		public function Select_ajax($opction,$id){
			include('../../Connections/sala2.php');
			$rutaado = "../../funciones/adodb/";
			include('../../Connections/salaado.php');
			
				switch($opction){
						case '2':{#Faculta
							
							  $SQL='SELECT 
		
												codigofacultad as id,
												nombrefacultad
									
									FROM 
									
												facultad
												
												ORDER BY nombrefacultad ASC';
									if($Select_Option=&$db->Execute($SQL)===false){
										echo 'Error en el SQL Secte del Ajax...<br>'.$SQL;
										die;
									}
									
							?>
                            <select id="faculta_id" name="faculta_id"  style="width:90%">
                            	<option value="-1">Elige...</option>
                                	<?PHP 
										while(!$Select_Option->EOF){
												?>
                                                <option value="<?PHP echo $Select_Option->fields['id']?>"><?PHP echo $Select_Option->fields['nombrefacultad']?></option>
                                                <?PHP
											$Select_Option->MoveNext();	
											}
									?>
                                </option>
                            </select> 
                            <?PHP						
							
							}break;
						case '3':{#Programa
							
							  $SQL='SELECT 

											codigocarrera as id,
											nombrecarrera
									
									FROM 
									
											carrera
									WHERE
											codigofacultad="'.$id.'"		
											ORDER BY nombrecarrera ASC';
											
									if($Select_Option=&$db->Execute($SQL)===false){
										echo 'Error en el SQL Secte del Ajax...<br>'.$SQL;
										die;
									}		
								?>
                                <select id="Programa_id" name="Programa_id"  style="width:90%">
                                    <option value="-1">Elige...</option>
                                        <?PHP 
                                            while(!$Select_Option->EOF){
                                                    ?>
                                                    <option value="<?PHP echo $Select_Option->fields['id']?>"><?PHP echo $Select_Option->fields['nombrecarrera']?></option>
                                                    <?PHP
                                                $Select_Option->MoveNext();	
                                                }
                                        ?>
                                    </option>
                                </select> 
                                <?PHP	
							}break;
					}
					
					
						
					
			}	
			
		public function Percepcion($indicador_id,$pregunta_id){
				include('../../Connections/sala2.php');
				$rutaado = "../../funciones/adodb/";
				include('../../Connections/salaado.php');
				
				
				
				$SQL_Datos='SELECT

										ind.idsiq_indicador,
										ind.idIndicadorGenerico,
										ind.idCarrera,
										ind.discriminacion,
										gen.idsiq_indicadorGenerico,
										gen.idAspecto,
										gen.nombre as nombre_ind,
										asp.idsiq_aspecto,
										asp.idCaracteristica,
										asp.nombre as Nombre_asp,
										carct.idsiq_caracteristica,
										carct.idFactor,
										carct.nombre as nombre_carct,
										fac.idsiq_factor,
										fac.nombre as nombre_fac,
										gen.idTipo		

							
							FROM
							
										siq_indicador  as ind,
										siq_indicadorGenerico as gen,
										siq_aspecto as asp,
										siq_caracteristica as carct,
										siq_factor as fac
							
							WHERE
							
										ind.idsiq_indicador="'.$indicador_id.'"
										AND
										ind.idIndicadorGenerico=gen.idsiq_indicadorGenerico
										AND
										gen.idAspecto=asp.idsiq_aspecto
										AND
										asp.idCaracteristica=carct.idsiq_caracteristica
										AND
										carct.idFactor=fac.idsiq_factor
										AND
										ind.codigoestado=100
										AND
										gen.codigoestado=100
										AND
										asp.codigoestado=100
										AND
										carct.codigoestado=100
										AND
										fac.codigoestado=100';
										
						if($Datos=&$db->Execute($SQL_Datos)===false){
								echo 'Error en el SQL Datos de percepcion......<br>'.$SQL_Datos;
								die;
							}
							
					$P_Datos = $Datos->GetArray();
					
					#echo '<pre>';print_r($P_Datos);						
						
				?>
                <style>
                fieldset {
				-webkit-border-radius: 8px;
				-moz-border-radius: 8px;
				border-radius: 8px;
				border-color:#316FC0;
				border-style: solid;
				border-width: 1px;
				
				}
				legend {
				color: #316FC0; 
				font-size:14px;
				font-weight: bold;
				letter-spacing:-1px;
				padding-bottom:20px;
				padding-top:8px;
				text-transform:capitalize;
				}
                </style>
                <fieldset>
                <legend>Cargar Documentos Percepci&oacute;n</legend>  
                <form action="Cargar_archivoPercepcion.php" method="post" enctype="multipart/form-data" name="Principal">
                <table width="90%" border="0" cellpadding="0" cellspacing="0" style="font-family:'Times New Roman', Times, serif" align="center">
                	<tr>
                    	<td><strong>Factor:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_fac']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Caracteristica:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_carct']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Aspecto a Evaluar:</strong></td>
                        <td><?PHP echo $P_Datos[0]['Nombre_asp']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Indicador:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_ind']?></td>
                    </tr>
                    <?PHP 
						switch($P_Datos[0]['discriminacion']){
								case '1':{
											$Nombre = 'Institucional';	
											$Relacion = '&nbsp;&nbsp;';
											$ver   = ' style="visibility:collapse"';
									}break;
								case '2':{
											$Nombre = 'Facultad';
											$Relacion = '&nbsp;&nbsp;';
											$ver   = ' style="visibility:collapse"';
									}break;
								case '3':{
											$Nombre = 'Programa';
											
											 $SQL_Carrera='SELECT 

																	codigocarrera,
																	nombrecarrera
															
															FROM 
															
																	carrera
															
															WHERE
															
																	codigocarrera="'.$P_Datos[0]['idCarrera'].'"';
																	
															if($Carrera=&$db->Execute($SQL_Carrera)===false){
																	echo 'Error alBuscar la Carrera...<br>'.$SQL_Carrera;
																	die;
																}
																
													$Relacion = $Carrera->fields['nombrecarrera'];
													$ver   = '';			
											
									}break;
							}
					?>
                    <tr>
                    	<td><strong>Discriminaci&oacute;n</strong></td>
                        <td><?PHP echo $Nombre?></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="2"><input type="file" id="file" name="file" height="80px"  size="50"/><br><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Máx / PDF</span></td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="30%"><strong>Tipo Documento:</strong></td>
                                    <td width="30%"><strong>Periodo:</strong></td>
                                    <td width="40%"><strong <?PHP echo $ver?>><?PHP echo $Nombre?></strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="30%">
                                        <select id="Tipo_Carga" name="Tipo_Carga" style="width: auto">
                                            <option value="3">Anexo</option>	
                                        </select>
                                   </td>
                                   <td width="30%">
                                    <?PHP 
                                        $year = date('Y');
                                        $monunt = date('m');
                                        
                                        if($monunt<6){
                                                $Periodo_num = '1';
                                            }else{
                                                    $Periodo_num = '2';
                                                }
                                        ?>
                                        <input type="text" value="<?PHP echo $year.'-'.$Periodo_num;?>"  id="Periodo" name="Periodo" size="8" readonly style="text-align:center">
                                   </td>
                                   <td width="40%" <?PHP echo $ver?>><?PHP echo $Relacion?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2"><textarea  id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
                    </tr>
                     <tr>
                    	<td colspan="2" align="center"><input type="submit" id="Save" name="Save" value="Guardar" onClick="return Validar();" /></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;<input type="hidden" id="Factor_id" name="Factor_id" value="<?PHP echo $P_Datos[0]['idsiq_factor']?>"/><br><input type="hidden" id="caracteristica_id" name="caracteristica_id" value="<?PHP echo $P_Datos[0]['idsiq_caracteristica']?>" /><br><input type="hidden" id="Aspecto_id" name="Aspecto_id" value="<?PHP echo $P_Datos[0]['idsiq_aspecto']?>" /><br><input type="hidden" id="Inicador_id" name="Inicador_id" value="<?PHP echo $indicador_id?>" /><br /><input type="hidden" id="Analisi" name="Analisi" value="0" /><br /><input type="hidden" id="Anexo" name="Anexo" value="1" /><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" value="<?PHP echo $P_Datos[0]['idTipo']?>" /><br><input type="hidden" id="Pregunta_id" name="Pregunta_id" value="<?PHP echo $pregunta_id?>"></td>
                    </tr>
                   
                </table>
                </form>
                </fieldset>
				<?PHP	
			}
                public function InformacionHuerfana($idFormulario,$pestana,$periodo,$carrera=null){   
                                include('../../Connections/sala2.php');
				$rutaado = "../../funciones/adodb/";
				include('../../Connections/salaado.php');
				
				$SQL_Datos='SELECT nombre FROM 	siq_formulario WHERE idsiq_formulario='.$idFormulario.' AND
						codigoestado=100';
										
						if($Datos=&$db->Execute($SQL_Datos)===false){
								echo 'Error en el SQL Datos de información huérfana......<br>'.$SQL_Datos;
								die;
					}
							
					$P_Datos = $Datos->GetArray();
                                        
                                   if($carrera!==null){     
                                       $currentdate  = date("Y-m-d H:i:s");
                                        $SQL_Datos='SELECT nombrecarrera FROM carrera WHERE codigocarrera='.$carrera.'
                                            AND fechavencimientocarrera>"'.$currentdate.'"';

                                                        if($Datos=&$db->Execute($SQL_Datos)===false){
                                                                        echo 'Error en el SQL Datos de información huérfana......<br>'.$SQL_Datos;
                                                                        die;
                                                }

                                                $P_Carrera = $Datos->GetArray();
                                   } ?>
                
                <style>
                fieldset {
				-webkit-border-radius: 8px;
				-moz-border-radius: 8px;
				border-radius: 8px;
				border-color:#316FC0;
				border-style: solid;
				border-width: 1px;
                                margin: 20px;
				
				}
				legend {
				color: #316FC0; 
				font-size:14px;
				font-weight: bold;
				letter-spacing:-1px;
				padding-bottom:20px;
				padding-top:8px;
				text-transform:capitalize;
				}
                </style>
                <fieldset>
                <legend>Cargar Documento de Soporte</legend>  
                <form action="Cargar_archivoHuerfana.php" method="post" enctype="multipart/form-data" name="Principal">
                <table width="90%" border="0" cellpadding="0" cellspacing="0" style="font-family:'Times New Roman', Times, serif" align="center">
                	<tr>
                            <td><strong>Módulo de Información:</strong></td>
                            <td><?php echo $P_Datos[0]['nombre']?></td>
                        </tr>
                        <?php if($carrera!==null){ ?>
                        <tr>
                            <td><strong>Carrera:</strong></td>
                            <td><?php echo $P_Carrera[0]['nombrecarrera']?><input type="hidden" id="codigocarrera" name="codigocarrera" value="<?php echo $carrera; ?>"/></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="file" id="file" name="file" height="80px"  size="50"/><br><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Máx / Excel, PDF, Word, JPG</span></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:5px">
                                    <tr>
                                        <td width="30%"><strong>Tipo Documento:</strong></td>
                                        <td width="30%"><strong>Periodo:</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                            <td width="30%">
                                            <select id="Tipo_Carga" name="Tipo_Carga" style="width: auto">
                                                <option value="1">Anexo</option>	
                                            </select>
                                    </td>
                                    <td width="30%">
                                            <input type="text" value="<?php echo $periodo; ?>"  id="Periodo" name="Periodo" size="8" readonly style="text-align:center">
                                    </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2"><br/><strong>&nbsp;&nbsp;Descripción del Archivo:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2"><textarea  id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left"><br/><input type="submit" id="Save" name="Save" value="Guardar archivo" onClick="return ValidarHuefana();" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;<input type="hidden" id="numPestana" name="numPestana" value="<?php echo $pestana; ?>"/><br><input type="hidden" id="idFormulario" name="idFormulario" value="<?PHP echo $idFormulario; ?>"></td>
                        </tr>
                        
                    
                </table>
                </form>
                </fieldset>
              <?php  }     
                        
                        
		public function Numerico($indicador_id){
				include('../../Connections/sala2.php');
				$rutaado = "../../funciones/adodb/";
				include('../../Connections/salaado.php');
				include ('../monitoreo/class/Utils_monitoreo.php'); $C_Utils_monitoreo = new Utils_monitoreo();
				
				$Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db,$indicador_id);
												
												#echo '<pre>';print_r($Permisos);  
												
												if($Permisos[1][0]==1){
														$C_Permiso = 1;#Todos
													}else if($Permisos[1][0]==2 || $Permisos[1][0]==3){
														$C_Permiso = 2;#ver
														?>
                                                        <table border="0" align="center" width="80%">
                                                        	<tr>
                                                            	<td align="center"><blink><span style="color:#F00">No Tiene Permisos...</span></blink></td>
                                                            </tr>
                                                        </table>
                                                        <?PHP
														die;
													}
				$SQL_Datos='SELECT

										ind.idsiq_indicador,
										ind.idIndicadorGenerico,
										ind.idCarrera,
										ind.discriminacion,
										gen.idsiq_indicadorGenerico,
										gen.idAspecto,
										gen.nombre as nombre_ind,
										asp.idsiq_aspecto,
										asp.idCaracteristica,
										asp.nombre as Nombre_asp,
										carct.idsiq_caracteristica,
										carct.idFactor,
										carct.nombre as nombre_carct,
										fac.idsiq_factor,
										fac.nombre as nombre_fac,
										gen.idTipo		

							
							FROM
							
										siq_indicador  as ind,
										siq_indicadorGenerico as gen,
										siq_aspecto as asp,
										siq_caracteristica as carct,
										siq_factor as fac
							
							WHERE
							
										ind.idsiq_indicador="'.$indicador_id.'"
										AND
										ind.idIndicadorGenerico=gen.idsiq_indicadorGenerico
										AND
										gen.idAspecto=asp.idsiq_aspecto
										AND
										asp.idCaracteristica=carct.idsiq_caracteristica
										AND
										carct.idFactor=fac.idsiq_factor
										AND
										ind.codigoestado=100
										AND
										gen.codigoestado=100
										AND
										asp.codigoestado=100
										AND
										carct.codigoestado=100
										AND
										fac.codigoestado=100';
										
						if($Datos=&$db->Execute($SQL_Datos)===false){
								echo 'Error en el SQL Datos de percepcion......<br>'.$SQL_Datos;
								die;
							}
							
					$P_Datos = $Datos->GetArray();
					
					#echo '<pre>';print_r($P_Datos);						
						
				?>
                <style>
                fieldset {
				-webkit-border-radius: 8px;
				-moz-border-radius: 8px;
				border-radius: 8px;
				border-color:#316FC0;
				border-style: solid;
				border-width: 1px;
				
				}
				legend {
				color: #316FC0; 
				font-size:14px;
				font-weight: bold;
				letter-spacing:-1px;
				padding-bottom:20px;
				padding-top:8px;
				text-transform:capitalize;
				}
                </style>
                <fieldset>
                <legend>Cargar Documentos Indicadores Numericos</legend>  
                <form action="Cargar_archivoNumerico.php" method="post" enctype="multipart/form-data" name="Principal">
                <table width="90%" border="0" cellpadding="0" cellspacing="0" style="font-family:'Times New Roman', Times, serif" align="center">
                	<tr>
                    	<td><strong>Factor:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_fac']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Caracteristica:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_carct']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Aspecto a Evaluar:</strong></td>
                        <td><?PHP echo $P_Datos[0]['Nombre_asp']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Indicador:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_ind']?></td>
                    </tr>
                    <?PHP 
						switch($P_Datos[0]['discriminacion']){
								case '1':{
											$Nombre = 'Institucional';	
											$Relacion = '&nbsp;&nbsp;';
											$ver   = ' style="visibility:collapse"';
									}break;
								case '2':{
											$Nombre = 'Facultad';
											$Relacion = '&nbsp;&nbsp;';
											$ver   = ' style="visibility:collapse"';
									}break;
								case '3':{
											$Nombre = 'Programa';
											
											 $SQL_Carrera='SELECT 

																	codigocarrera,
																	nombrecarrera
															
															FROM 
															
																	carrera
															
															WHERE
															
																	codigocarrera="'.$P_Datos[0]['idCarrera'].'"';
																	
															if($Carrera=&$db->Execute($SQL_Carrera)===false){
																	echo 'Error alBuscar la Carrera...<br>'.$SQL_Carrera;
																	die;
																}
																
													$Relacion = $Carrera->fields['nombrecarrera'];
													$ver   = '';			
											
									}break;
							}
					?>
                    <tr>
                    	<td><strong>Discriminaci&oacute;n</strong></td>
                        <td><?PHP echo $Nombre?></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="2"><input type="file" id="file" name="file" height="80px"  size="50"/><br><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Max / Word</span></td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="30%"><strong>Tipo Documento:</strong></td>
                                    <td width="30%"><strong>Periodo:</strong></td>
                                    <td width="40%"><strong <?PHP echo $ver?>><?PHP echo $Nombre?></strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="30%">
                                        <select id="Tipo_Carga" name="Tipo_Carga" style="width: auto">
                                            <option value="-1">Elige...</option>
                                            <option value="1" onClick="validar_tipo('0');CambiarDoc('0')">Principal</option>
                                            <option value="2" onClick="validar_tipo('1');CambiarDoc('0')">An&aacute;lisis</option>
                                            <option value="3" onClick="validar_tipo('2'),CambiarDoc('1')">Anexo</option>
                                        </select>
                                   </td>
                                   <td width="30%">
                                    <?PHP 
                                        $year = date('Y');
                                        $monunt = date('m');
                                        
                                        if($monunt<6){
                                                $Periodo_num = '1';
                                            }else{
                                                    $Periodo_num = '2';
                                                }
                                        ?>
                                        <input type="text" value="<?PHP echo $year.'-'.$Periodo_num;?>"  id="Periodo" name="Periodo" size="8" readonly style="text-align:center">
                                   </td>
                                   <td width="40%" <?PHP echo $ver?>><?PHP echo $Relacion?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2"><textarea  id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;<input type="hidden" id="Factor_id" name="Factor_id" value="<?PHP echo $P_Datos[0]['idsiq_factor']?>"/><br><input type="hidden" id="caracteristica_id" name="caracteristica_id" value="<?PHP echo $P_Datos[0]['idsiq_caracteristica']?>" /><br><input type="hidden" id="Aspecto_id" name="Aspecto_id" value="<?PHP echo $P_Datos[0]['idsiq_aspecto']?>" /><br><input type="hidden" id="Inicador_id" name="Inicador_id" value="<?PHP echo $indicador_id?>" /><br /><input type="hidden" id="Analisi" name="Analisi" value="0" /><br /><input type="hidden" id="Anexo" name="Anexo" value="1" /><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" value="<?PHP echo $P_Datos[0]['idTipo']?>" /><br><input type="hidden" id="Pregunta_id" name="Pregunta_id" value="<?PHP echo $pregunta_id?>"></td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center"><input type="submit" id="Save" name="Save" value="Guardar" onClick="return Validar();" /></td>
                    </tr>
                </table>
                </form>
                </fieldset>
				<?PHP	
			}	
	public function CargarDocumeto($indicador_id){
		
				include('../../Connections/sala2.php');
				$rutaado = "../../funciones/adodb/";
				include('../../Connections/salaado.php');
				
				
				
				$SQL_Datos='SELECT

										ind.idsiq_indicador,
										ind.idIndicadorGenerico,
										ind.idCarrera,
										ind.discriminacion,
										gen.idsiq_indicadorGenerico,
										gen.idAspecto,
										gen.nombre as nombre_ind,
										asp.idsiq_aspecto,
										asp.idCaracteristica,
										asp.nombre as Nombre_asp,
										carct.idsiq_caracteristica,
										carct.idFactor,
										carct.nombre as nombre_carct,
										fac.idsiq_factor,
										fac.nombre as nombre_fac,
										gen.idTipo,
										tipo.nombre,
										ind.es_objeto_analisis,
										ind.tiene_anexo		

							
							FROM
							
										siq_indicador as ind 
										INNER JOIN siq_indicadorGenerico as gen ON  ind.idIndicadorGenerico=gen.idsiq_indicadorGenerico 
										INNER JOIN siq_tipoIndicador AS tipo ON gen.idTipo=tipo.idsiq_tipoIndicador
										INNER JOIN siq_aspecto as asp ON gen.idAspecto=asp.idsiq_aspecto  
										INNER JOIN siq_caracteristica as carct  ON asp.idCaracteristica=carct.idsiq_caracteristica 
										INNER JOIN  siq_factor as fac  on carct.idFactor=fac.idsiq_factor
							
							WHERE
							
										ind.idsiq_indicador="'.$indicador_id.'"
										AND
										ind.codigoestado=100 
										AND 
										gen.codigoestado=100 
										AND 
										asp.codigoestado=100 
										AND 
										carct.codigoestado=100 
										AND 
										fac.codigoestado=100 
										AND
										tipo.codigoestado=100';
										
						if($Datos=&$db->Execute($SQL_Datos)===false){
								echo 'Error en el SQL Datos de percepcion......<br>'.$SQL_Datos;
								die;
							}
							
					$P_Datos = $Datos->GetArray();
					
					#echo '<pre>';print_r($P_Datos);						
						
				?>
                <style>
                fieldset {
				-webkit-border-radius: 8px;
				-moz-border-radius: 8px;
				border-radius: 8px;
				border-color:#316FC0;
				border-style: solid;
				border-width: 1px;
				
				}
				legend {
				color: #316FC0; 
				font-size:14px;
				font-weight: bold;
				letter-spacing:-1px;
				padding-bottom:20px;
				padding-top:8px;
				text-transform:capitalize;
				}
                </style>
                <fieldset>
                <legend>Cargar Documentos...</legend>  
                <form action="Cargar_archivo.php" method="post" enctype="multipart/form-data" name="Principal">
                <table width="90%" border="0" cellpadding="0" cellspacing="0" style="font-family:'Times New Roman', Times, serif" align="center">
                	<tr>
                    	<td><strong>Factor:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_fac']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Caracteristica:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_carct']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Aspecto a Evaluar:</strong></td>
                        <td><?PHP echo $P_Datos[0]['Nombre_asp']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Indicador:</strong></td>
                        <td><?PHP echo $P_Datos[0]['idsiq_indicador'].'&nbsp;--&nbsp;'.$P_Datos[0]['nombre_ind']?></td>
                    </tr>
                    <tr>
                        <td><strong>Tipo Indicador:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre']?></td>
                    </tr>
                     <?PHP 
							if($P_Datos[0]['idTipo']==1 && $P_Datos[0]['es_objeto_analisis']==0   && $P_Datos[0]['tiene_anexo']==0){
									$Archivo = 'Principal';
								}
							if($P_Datos[0]['idTipo']==1 && $P_Datos[0]['es_objeto_analisis']==1   && $P_Datos[0]['tiene_anexo']==0){
									$Archivo = 'Principal &oacute; Analisis';
								}
							if($P_Datos[0]['idTipo']==1 && $P_Datos[0]['es_objeto_analisis']==1   && $P_Datos[0]['tiene_anexo']==1){
									$Archivo = 'Principal &oacute; Analisis &oacute; Anexo';
								}
							if($P_Datos[0]['idTipo']!=1 && $P_Datos[0]['es_objeto_analisis']==1   && $P_Datos[0]['tiene_anexo']==0){
									$Archivo = 'Analisis';
								}
							if($P_Datos[0]['idTipo']!=1 && $P_Datos[0]['es_objeto_analisis']==0   && $P_Datos[0]['tiene_anexo']==1){
									$Archivo = 'Anexo';
								}
							if($P_Datos[0]['idTipo']!=1 && $P_Datos[0]['es_objeto_analisis']==1   && $P_Datos[0]['tiene_anexo']==1){
									$Archivo = 'Analisis &oacute; Anexo';
								}
							if($P_Datos[0]['idTipo']==1 && $P_Datos[0]['es_objeto_analisis']==0   && $P_Datos[0]['tiene_anexo']==1){
									$Archivo = 'Principal &oacute; Anexo';
								}						
						?>
                        <tr>
                            <td><strong>Tipo Archivo:</strong></td>
                            <td><?PHP echo $Archivo?></td>
                        </tr>
                    <?PHP 
						switch($P_Datos[0]['discriminacion']){
								case '1':{
											$Nombre = 'Institucional';	
											$Relacion = '&nbsp;&nbsp;';
											$ver   = ' style="visibility:collapse"';
									}break;
								case '2':{
											$Nombre = 'Facultad';
											$Relacion = '&nbsp;&nbsp;';
											$ver   = ' style="visibility:collapse"';
									}break;
								case '3':{
											$Nombre = 'Programa';
											
											 $SQL_Carrera='SELECT 

																	codigocarrera,
																	nombrecarrera
															
															FROM 
															
																	carrera
															
															WHERE
															
																	codigocarrera="'.$P_Datos[0]['idCarrera'].'"';
																	
															if($Carrera=&$db->Execute($SQL_Carrera)===false){
																	echo 'Error alBuscar la Carrera...<br>'.$SQL_Carrera;
																	die;
																}
																
													$Relacion = $Carrera->fields['nombrecarrera'];
													$ver   = '';			
											
									}break;
							}
					?>
                    <tr>
                    	<td><strong>Discriminaci&oacute;n</strong></td>
                        <td><?PHP echo $Nombre?></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="2"><input type="file" id="file" name="file" height="80px"  size="50"/><br><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Max / Word</span></td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="30%"><strong>Tipo Documento:</strong></td>
                                    <td width="30%"><strong>Periodo:</strong></td>
                                    <td width="40%"><strong <?PHP echo $ver?>><?PHP echo $Nombre?></strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="30%">
                                        <select id="Tipo_Carga" name="Tipo_Carga" style="width: auto">
                                            <option value="-1">Elige...</option>
                                            <option value="1" onClick="validar_tipo('0');CambiarDoc('0')">Principal</option>
                                            <option value="2" onClick="validar_tipo('1');CambiarDoc('0')">An&aacute;lisis</option>
                                            <option value="3" onClick="validar_tipo('2');CambiarDoc('1')">Anexo</option>
                                        </select>
                                   </td>
                                   <td width="30%">
                                    <?PHP 
                                        $year = date('Y');
                                        $monunt = date('m');
                                        
                                        if($monunt<6){
                                                $Periodo_num = '1';
                                            }else{
                                                    $Periodo_num = '2';
                                                }
                                        ?>
                                        <input type="text" value="<?PHP echo $year.'-'.$Periodo_num;?>"  id="Periodo" name="Periodo" size="8" readonly style="text-align:center">
                                   </td>
                                   <td width="40%" <?PHP echo $ver?>><?PHP echo $Relacion?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2"><textarea  id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;<input type="hidden" id="Factor_id" name="Factor_id" value="<?PHP echo $P_Datos[0]['idsiq_factor']?>"/><br><input type="hidden" id="caracteristica_id" name="caracteristica_id" value="<?PHP echo $P_Datos[0]['idsiq_caracteristica']?>" /><br><input type="hidden" id="Aspecto_id" name="Aspecto_id" value="<?PHP echo $P_Datos[0]['idsiq_aspecto']?>" /><br><input type="hidden" id="Inicador_id" name="Inicador_id" value="<?PHP echo $indicador_id?>" /><br /><input type="hidden" id="Analisi" name="Analisi" value="0" /><br /><input type="hidden" id="Anexo" name="Anexo" value="1" /><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" value="<?PHP echo $P_Datos[0]['idTipo']?>" /><br><input type="hidden" id="Pregunta_id" name="Pregunta_id" value="<?PHP echo $pregunta_id?>"></td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center"><input type="submit" id="Save" name="Save" value="Guardar" onClick="return Validar();" /></td>
                    </tr>
                </table>
                </form>
                </fieldset>
				<?PHP	
			}	
		public function Documentos($indicador_id){
				include('../../Connections/sala2.php');
				$rutaado = "../../funciones/adodb/";
				include('../../Connections/salaado.php');
				include ('../monitoreo/class/Utils_monitoreo.php'); $C_Utils_monitoreo = new Utils_monitoreo();
				
				$Permisos = $C_Utils_monitoreo->getResponsabilidadesIndicador($db,$indicador_id);
												
												#echo '<pre>';print_r($Permisos);  
												
												if($Permisos[1][0]==1){
														$C_Permiso = 1;#Todos
													}else if($Permisos[1][0]==2 || $Permisos[1][0]==3){
														$C_Permiso = 2;#ver
														?>
                                                        <table border="0" align="center" width="80%">
                                                        	<tr>
                                                            	<td align="center"><blink><span style="color:#F00">No Tiene Permisos...</span></blink></td>
                                                            </tr>
                                                        </table>
                                                        <?PHP
														die;
													}
				$SQL_Datos='SELECT

										ind.idsiq_indicador,
										ind.idIndicadorGenerico,
										ind.idCarrera,
										ind.discriminacion,
										gen.idsiq_indicadorGenerico,
										gen.idAspecto,
										gen.nombre as nombre_ind,
										asp.idsiq_aspecto,
										asp.idCaracteristica,
										asp.nombre as Nombre_asp,
										carct.idsiq_caracteristica,
										carct.idFactor,
										carct.nombre as nombre_carct,
										fac.idsiq_factor,
										fac.nombre as nombre_fac,
										gen.idTipo		

							
							FROM
							
										siq_indicador  as ind,
										siq_indicadorGenerico as gen,
										siq_aspecto as asp,
										siq_caracteristica as carct,
										siq_factor as fac
							
							WHERE
							
										ind.idsiq_indicador="'.$indicador_id.'"
										AND
										ind.idIndicadorGenerico=gen.idsiq_indicadorGenerico
										AND
										gen.idAspecto=asp.idsiq_aspecto
										AND
										asp.idCaracteristica=carct.idsiq_caracteristica
										AND
										carct.idFactor=fac.idsiq_factor
										AND
										ind.codigoestado=100
										AND
										gen.codigoestado=100
										AND
										asp.codigoestado=100
										AND
										carct.codigoestado=100
										AND
										fac.codigoestado=100';
										
						if($Datos=&$db->Execute($SQL_Datos)===false){
								echo 'Error en el SQL Datos de percepcion......<br>'.$SQL_Datos;
								die;
							}
							
					$P_Datos = $Datos->GetArray();
					
					#echo '<pre>';print_r($P_Datos);						
						
				?>
                <style>
                fieldset {
				-webkit-border-radius: 8px;
				-moz-border-radius: 8px;
				border-radius: 8px;
				border-color:#316FC0;
				border-style: solid;
				border-width: 1px;
				
				}
				legend {
				color: #316FC0; 
				font-size:14px;
				font-weight: bold;
				letter-spacing:-1px;
				padding-bottom:20px;
				padding-top:8px;
				text-transform:capitalize;
				}
                </style>
                <fieldset>
                <legend>Cargar Documentos Indicadores Documental</legend>  
                <form action="../../SQI_Documento/Cargar_archivo.php" method="post" enctype="multipart/form-data" name="Principal">
                <table width="90%" border="0" cellpadding="0" cellspacing="0" style="font-family:'Times New Roman', Times, serif" align="center">
                	<tr>
                    	<td><strong>Factor:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_fac']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Caracteristica:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_carct']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Aspecto a Evaluar:</strong></td>
                        <td><?PHP echo $P_Datos[0]['Nombre_asp']?></td>
                    </tr>
                    <tr>
                    	<td><strong>Indicador:</strong></td>
                        <td><?PHP echo $P_Datos[0]['nombre_ind']?></td>
                    </tr>
                    <?PHP 
						switch($P_Datos[0]['discriminacion']){
								case '1':{
											$Nombre = 'Institucional';	
											$Relacion = '&nbsp;&nbsp;';
											$ver   = ' style="visibility:collapse"';
									}break;
								case '2':{
											$Nombre = 'Facultad';
											$Relacion = '&nbsp;&nbsp;';
											$ver   = ' style="visibility:collapse"';
									}break;
								case '3':{
											$Nombre = 'Programa';
											
											 $SQL_Carrera='SELECT 

																	codigocarrera,
																	nombrecarrera
															
															FROM 
															
																	carrera
															
															WHERE
															
																	codigocarrera="'.$P_Datos[0]['idCarrera'].'"';
																	
															if($Carrera=&$db->Execute($SQL_Carrera)===false){
																	echo 'Error alBuscar la Carrera...<br>'.$SQL_Carrera;
																	die;
																}
																
													$Relacion = $Carrera->fields['nombrecarrera'];
													$ver   = '';			
											
									}break;
							}
					?>
                    <tr>
                    	<td><strong>Discriminaci&oacute;n</strong></td>
                        <td><?PHP echo $Nombre?></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="2"><input type="file" id="file" name="file" height="80px"  size="50"/><br><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Max / Word</span></td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="30%"><strong>Tipo Documento:</strong></td>
                                    <td width="30%"><strong>Periodo:</strong></td>
                                    <td width="40%"><strong <?PHP echo $ver?>><?PHP echo $Nombre?></strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2">
                        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="30%">
                                        <select id="Tipo_Carga" name="Tipo_Carga" style="width: auto">
                                            <option value="-1">Elige...</option>
                                            <option value="1" onClick="validar_tipo('0');CambiarDoc('0')">Principal</option>
                                            <option value="2" onClick="validar_tipo('1');CambiarDoc('0')">An&aacute;lisis</option>
                                            <option value="3" onClick="validar_tipo('2');CambiarDoc('1')">Anexo</option>
                                        </select>
                                   </td>
                                   <td width="30%">
                                    <?PHP 
                                        $year = date('Y');
                                        $monunt = date('m');
                                        
                                        if($monunt<6){
                                                $Periodo_num = '1';
                                            }else{
                                                    $Periodo_num = '2';
                                                }
                                        ?>
                                        <input type="text" value="<?PHP echo $year.'-'.$Periodo_num;?>"  id="Periodo" name="Periodo" size="8" readonly style="text-align:center">
                                   </td>
                                   <td width="40%" <?PHP echo $ver?>><?PHP echo $Relacion?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><strong>&nbsp;&nbsp;Descripcion del Archivo:&nbsp;&nbsp;<span style="color:#F00; font-size:10px">(*)</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2"><textarea  id="Descripcion" name="Descripcion" style="width:90%" cols="20" rows="10"></textarea></td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;<input type="hidden" id="Factor_id" name="Factor_id" value="<?PHP echo $P_Datos[0]['idsiq_factor']?>"/><br><input type="hidden" id="caracteristica_id" name="caracteristica_id" value="<?PHP echo $P_Datos[0]['idsiq_caracteristica']?>" /><br><input type="hidden" id="Aspecto_id" name="Aspecto_id" value="<?PHP echo $P_Datos[0]['idsiq_aspecto']?>" /><br><input type="hidden" id="Inicador_id" name="Inicador_id" value="<?PHP echo $indicador_id?>" /><br /><input type="hidden" id="Analisi" name="Analisi" value="0" /><br /><input type="hidden" id="Anexo" name="Anexo" value="1" /><br /><input type="hidden" id="Tipo_indicador" name="Tipo_indicador" value="<?PHP echo $P_Datos[0]['idTipo']?>" /><br><input type="hidden" id="Pregunta_id" name="Pregunta_id" value="<?PHP echo $pregunta_id?>"></td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center"><input type="submit" id="Save" name="Save" value="Guardar" onClick="return Validar();" /></td>
                    </tr>
                </table>
                </form>
                </fieldset>
				<?PHP	
			}	
	}#Fin de Class
	
?>