<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="form_cuatro">
	
	<form  method="post" id="program_edu_cuatro" name="program_edu_cuatro">
        <input type="hidden" name="action" value="SelectDynamic" id="action" />
        <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
        <input type="hidden" name="actividad" value="numero_programas" id="actividad" />
        <input type="hidden" name="procesID" value="insert_academica" id="procesID" />
		
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Programas de Educación Continuada por Unidad Académica</legend>
                
                              
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect("mes");  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                $utils->pintarBotonCargar("popup_cargarDocumento(14,4,$('#program_edu_cuatro #mes').val()+'-'+$('#program_edu_cuatro #anio').val())","popup_verDocumentos(14,4,$('#program_edu_cuatro #mes').val()+'-'+$('#program_edu_cuatro #anio').val())");
                    $sectores = $utils->getActives($db,"siq_sectores","idsiq_sectores");
                ?>
			<table align="center" class="formData last" width="95%" >
	                    <thead>            
		                      <tr class="dataColumns">
	                            <th class="column" colspan="9"><span>Programas de Educación Continuada por Unidad Académica</span></th>                                    
	                        </tr>
	                        <tr class="dataColumns category">
	                            <th class="column borderR center" rowspan="2" width="1%" ><span>Programa</span></th>
	                            <th class="column borderR center" colspan="3" width="1%" ><span>Número de Cursos</span>
	                    		<th class="column borderR center" colspan="5" width="1%"><span>Modalidad</span></th>
	                    	</tr>
	                    	<tr >
	                   	       <th class="column borderR center" width="1%" >Cursos</th>
	                    		<th class="column borderR center " width="1%" >Diplomados</th>
	                    		<th class="column borderR center" width="1%" >Eventos de <br/> Actualización</th>
	                    		<th class="column borderR center"  width="1%">ABI</th>
	                    		<th class="column borderR center" width="1%">CER</th>	
	                    		<th class="column borderR center"width="1%" >PRE</th>
	                    		<th class="column borderR center"width="1%">VIR</th>
	                    		<th class="column borderR center"width="1%">SEMI</th>
	                    	</tr>
	                    	 
                    </thead> 
	                   <tbody>
			                   <?php 
			                     	$query_sectores = "SELECT codigocarrera,nombrecarrera,codigomodalidadacademicasic 
    													FROM carrera 
    													WHERE codigomodalidadacademicasic = '200' and fechavencimientocarrera > '2013-05-29'";
								      $sectores= $db->Execute($query_sectores);
								      $totalRows_sectores = $sectores->RecordCount();
						
							while($row_sectores = $sectores->FetchRow()){ 
									
								?> 
								<tr id="contentColumns" class="row">
                                                                <td class="column borderR" ><?php echo $row_sectores['nombrecarrera']; ?>:<span class="mandatory">(*)</span>
                                                                <input type="hidden" name="tipo_programa[] " id="tipo_programa_<?php echo $row_sectores['codigocarrera']; ?>" value="<?php echo $row_sectores['codigocarrera']; ?>"/></td>
                                                                <input type="hidden" name="id_academicoscontinuada[] "  id="id_academicoscontinuada_<?php echo $row_sectores['codigocarrera']; ?>" />
                                                                <td class="column borderR center" ><input type="text" class="required number" minlength="" name="cant_curso[]" id="cant_curso_<?php echo $row_sectores['codigocarrera']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                                <td class="column borderR center" ><input type="text" class="required number" minlength="" name="cant_diplomado[]" id="cant_diplomado_<?php echo $row_sectores['codigocarrera']; ?>"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                                <td class="column borderR center" ><input type="text" class="required number" minlength="" name="cant_evento[]" id="cant_evento_<?php echo $row_sectores['codigocarrera']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                                <td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_abierto[]" id="num_abierto_<?php echo $row_sectores['codigocarrera']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                                <td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_cerrado[]" id="num_cerrado_<?php echo $row_sectores['codigocarrera']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                                <td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_pres[]" id="num_pres_<?php echo $row_sectores['codigocarrera']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                                <td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_vir[]" id="num_vir_<?php echo $row_sectores['codigocarrera']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                                <td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_sem[]" id="num_sem_<?php echo $row_sectores['codigocarrera']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                        <?php }//while($row_sectores=$sectores->FetchRow())?>
							</tr>
						</tbody>               	 
	   </table>
		</fieldset>
			<div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
			<input type="submit" width="30px" alin id="submit_fom_continuada_carreras" value="Guardar datos" class="first" /> 
	</form>
</div>
<script type="text/javascript">
    var tipo=$("#actividad").val()
    getformulario_cuatro("#program_edu_cuatro");
    
         
                $('#submit_fom_continuada_carreras').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#program_edu_cuatro");
                    if(valido){
                       //sendDetalleFormacionActividadesAcademicos("#form_DedicacionSemanal3");
                    
                       sendformulario_cuatro("#program_edu_cuatro");
                    }
                });
                
                $('#program_edu_cuatro'+' #mes').bind('change', function(event) {
                    getformulario_cuatro("#program_edu_cuatro");
                });
                
                $('#program_edu_cuatro'+' #anio').bind('change', function(event) {
                    getformulario_cuatro("#program_edu_cuatro");
                });
                
             
                function getformulario_cuatro(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var actividad = $(formName + " #actividad").val();
                    var entity = $(formName + " #entity").val();
                    $(formName + " #action").val('SelectDynamic');
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: "./formularios/academicos/procesarEducacionCon.php",
                            data: $(formName).serialize(),      
                            success:function(data){
                                if (data.success == true){
                                    for (var i=0;i<data.total;i++){   
                                     //  alert(data[i].id_academicoscontinuada+'-->'+data[i].tipo_programa+'-->'+data[i].id_academicoscontinuada+'-->'+data[i].cantidad_salud+'-->'+data[i].cantidad_nucleo+'-->'+data[i].cantidad_academica);                                
                                        $(formName + " #tipo_programa_"+data[i].tipo_programa).val(data[i].tipo_programa);
                                        $(formName + " #id_academicoscontinuada_"+data[i].tipo_programa).val(data[i].id_academicoscontinuada);
                                        $(formName + " #cant_curso_"+data[i].tipo_programa).val(data[i].cant_curso);
                                        $(formName + " #cant_diplomado_"+data[i].tipo_programa).val(data[i].cant_diplomado);
                                        $(formName + " #cant_evento_"+data[i].tipo_programa).val(data[i].cant_evento);
                                        $(formName + " #num_abierto_"+data[i].tipo_programa).val(data[i].num_abierto);
                                        $(formName + " #num_cerrado_"+data[i].tipo_programa).val(data[i].num_cerrado);
                                        $(formName + " #num_pres_"+data[i].tipo_programa).val(data[i].num_pres);
                                        $(formName + " #num_vir_"+data[i].tipo_programa).val(data[i].num_vir);
                                        $(formName + " #num_sem_"+data[i].tipo_programa).val(data[i].num_sem);
                                      }
                                    $(formName + " #action").val("UpdateDynamic");
                                    
                                }else{                        
                                    var mes = $(formName + ' #mes').val();
                                    var anio = $(formName + ' #anio').val();
                                    document.forms[formName.replace("#","")].reset();
                                    $(formName + ' #mes').val(mes);
                                    $(formName + ' #anio').val(anio);
                                    $(formName + " #action").val("SaveDynamic");
                                            
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                 }
                
                function sendformulario_cuatro(formName){
                    //alert('aca..')
                
//                    var periodo = $(formName +' #mes').val()+"-"+$(formName + ' #anio').val();
//                    
//                    $(formName + " #codigoperiodo").val(periodo)
//                    var entity = $(formName + " #entity1").val();
//                    var anio = $(formName + " #anio").val();
//                    var mes = $(formName + " #mes").val();
                  //  $(formName + " #action").val("SaveDynamic");
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                         url: "./formularios/academicos/procesarEducacionCon.php",
                         data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 $(formName + " #msg-success").css('display','');
                                 $(formName + " #msg-success").html('<p>' + data.descrip + '</p>');
                                 $(formName + " #msg-success").delay(900).fadeOut(800);
                                // getformulario_cuatro("#program_edu_cuatro");
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
//                           
</script>

	