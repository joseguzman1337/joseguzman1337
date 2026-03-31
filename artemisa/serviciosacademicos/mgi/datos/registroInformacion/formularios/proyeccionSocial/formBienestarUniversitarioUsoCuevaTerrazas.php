<?PHP  
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>

<script>
  
  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: 'formularios/proyeccionSocial/functionsBienestar.php',
                            data: { mes: mes, action: "getCuevaTerrazas",anio: anio, alias: alias },     
                            success:function(data){								 
                                if (data.success == true){                                    
								 //borro todas las filas
                                    $(formName + ' table').children('tbody').children('tr').remove(); 
                                     $(formName + ' table').children('tbody').html(data.data);
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
</script>

 <form action="" method="post" id="forma<?=$_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Estadísticas uso de la cueva y las terrazas</legend>
		<label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio"); ?>
            <input type="hidden" name="semestre" value="" id="semestre" />             
                
		<!--<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>-->
		<?php //$utils->getSemestresSelect($db,"semestre");
                 $idForm = "forma".$_REQUEST['alias'];
                 $utils->pintarBotonCargar("popup_cargarDocumento(3,5,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())","popup_verDocumentos(3,5,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())");  
		 
		?>
		
		<table align="center" class="formData last" id="table" width="92%">
<?PHP 			 
			 $query2="select	 sch.clasificacionesinfhuerfana
					,sch.aliasclasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana sch
				join (	select idclasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana 
					where aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'
				) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
				where sch.estado";
			$exec2= $db->Execute($query2);
			while($row2 = $exec2->FetchRow()) {

			echo '	<tr class="dataColumns category">
					<th colspan="7" class="borderR">'.$row2['clasificacionesinfhuerfana'].'</th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Día</th>               
					<th class="borderR">Lunes</th>               
					<th class="borderR">Martes</th>               
					<th class="borderR">Miercoles</th>               
					<th class="borderR">Jueves</th>
					<th class="borderR">Viernes</th>
					<th class="borderR">Sabado</th>
				</tr>';
	
				$query="select	 sch.idclasificacionesinfhuerfana
						,sch.clasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana sch
					join (	select idclasificacionesinfhuerfana
						from siq_clasificacionesinfhuerfana 
						where aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'
					) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
					where sch.estado";					
				$exec= $db->Execute($query);
				
				while($row = $exec->FetchRow()) {					
					if(empty($_REQUEST["mes"])){
						$mes=$_COOKIE["mes"];
					}else{
						$mes=$_REQUEST["mes"];
					}
					if(empty($_REQUEST["anio"])){
						$anio=$_COOKIE["anio"];
					}else{
						$anio=$_REQUEST["anio"];
					}
					 $semestre=$mes.$anio;
					
					/* Reiniciar la consulta para pintar los valores */
						$queryValores="SELECT *
										FROM siq_bienestaruniversitario sbu
										JOIN siq_clasificacionesinfhuerfana sch1 USING(idclasificacionesinfhuerfana)
										JOIN siq_clasificacionesinfhuerfana sch2 ON sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
										JOIN siq_clasificacionesinfhuerfana sch3 ON sch2.idpadreclasificacionesinfhuerfana=sch3.idclasificacionesinfhuerfana
										WHERE sbu.semestre='".$semestre."' AND sch3.aliasclasificacionesinfhuerfana='".$_REQUEST["alias"]."' 
											AND sbu.idclasificacionesinfhuerfana='".$row['idclasificacionesinfhuerfana']."'";
						
						$execValores= $db->Execute($queryValores);	
						$row3=$execValores->FetchRow();						
						if(!(empty($row3['lunes']))){
							$lunes=$row3['lunes'];
						}else{
							$lunes=0;
						}if(!(empty($row3['martes']))){
							$martes=$row3['martes'];
						}else{
							$martes=0;
						}if(!(empty($row3['miercoles']))){
							$miercoles=$row3['miercoles'];
						}else{
							$miercoles=0;
						}if(!(empty($row3['jueves']))){
							$jueves=$row3['jueves'];
						}else{
							$jueves=0;
						}if(!(empty($row3['viernes']))){
							$viernes=$row3['viernes'];
						}else{
							$viernes=0;
						}if(!(empty($row3['sabado']))){
							$sabado=$row3['sabado'];
						}else{
							$sabado=0;
						}
	?>					
					<tr id="contentColumns" class="row">
						<td class="column borderR">
							<input type="hidden" name="aux[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" value="<?PHP echo $row['idclasificacionesinfhuerfana']?>">
							<?PHP echo $row['clasificacionesinfhuerfana']?>: <span class="mandatory">(*)</span>
						</td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="lunes[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" id="lunes[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" value="<?PHP  echo $lunes;?>" title="Lunes" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="martes[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" id="martes[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" value="<?PHP  echo $martes;?>" title="Martes" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="miercoles[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" id="miercoles[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" value="<?PHP  echo $miercoles;?>" title="Miercoles" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="jueves[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" id="jueves[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" value="<?PHP  echo $jueves;?>" title="Jueves" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="viernes[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" id="viernes[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" value="<?PHP  echo $viernes;?>" title="Viernes" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="sabado[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" id="sabado[<?PHP echo $row['idclasificacionesinfhuerfana']?>]" value="<?PHP  echo $sabado;?>" title="Sábado" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					</tr>
	<?PHP 
				}
				
			}
	?>
		</table>
		

                <div class="vacio"></div>
                <div id="respuesta_forma<?PHP echo $_REQUEST['alias']?>" class="msg-success" style="display:none"></div>
	</fieldset>
	<input type="hidden" name="alias" value="<?PHP echo $_REQUEST['alias']?>" />
	<input type="submit" value="Guardar cambios" class="first" />
</form>

<script type="text/javascript">
	         $('#form_eventos #mes').add('#form_eventos #anio').bind('change', function(event) {
             sendForm("#form_eventos");
     });
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#forma<?PHP echo $_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
		$('#forma<?PHP echo $_REQUEST['alias']?> #mes').add('#forma<?PHP echo $_REQUEST['alias']?> #anio').bind('change', function(event) {
             //pintar nuevas categorias
			 $("#table tr").remove(); 
             var formName = '#forma<?PHP echo $_REQUEST['alias']?>';
             var mes = $(formName+' #mes').val()
                var anio = $(formName+' #anio').val();
                var alias = "<?PHP echo $_REQUEST['alias']?>";
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: 'formularios/proyeccionSocial/functionsBienestar.php',
                            data: { mes: mes, action: "getCuevaTerrazas",anio: anio, alias: alias },     
                            success:function(data){								 
                                if (data.success == true){                                    
								 //borro todas las filas
                                    $(formName + ' table').children('tbody').children('tr').remove(); 
                                     $(formName + ' table').children('tbody').html(data.data);
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
        });
	function sendForm(){
            var periodo = $('#forma<?PHP echo $_REQUEST['alias']?> #mes').val()+$('#forma<?PHP echo $_REQUEST['alias']?> #anio').val();
                $('#forma<?PHP echo $_REQUEST['alias']?> #semestre').val(periodo);
		$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/proyeccionSocial/saveBienestarUniversitario.php',
				data: $('#forma<?PHP echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
				if (data.success == true){
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').removeClass('msg-error');
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').css('display','block');
                                        $("#respuesta_forma<?=$_REQUEST['alias']?>").delay(5500).fadeOut(800);
				} else {
					
                    if(confirm(data.message+'\n Desea Modificar esta Informacion')){
                        /************************************************************************/
                        $.ajax({
            				dataType: 'json',
            				type: 'POST',
            				url: 'formularios/proyeccionSocial/saveBienestarUniversitario.php?Modificar=1',
            				data: $('#forma<?PHP echo $_REQUEST['alias']?>').serialize(),                
            				success:function(data){
            			             if(data.val=='TRUE'){
            			                 $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
                    					 $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').removeClass('msg-error');
                    					 $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').css('display','block');
                                         $("#respuesta_forma<?PHP echo $_REQUEST['alias']?>").delay(5500).fadeOut(800);
            			             }
            			     },//Data
            			error: function(data,error,errorThrown){alert(error + errorThrown);}
            		}); //Ajax    
                        /************************************************************************/
                    }else{
                        $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
                        $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').addClass('msg-error');
                        $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').css('display','block');
                        $("#respuesta_forma<?PHP echo $_REQUEST['alias']?>").delay(5500).fadeOut(800);
                    }
                    
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
