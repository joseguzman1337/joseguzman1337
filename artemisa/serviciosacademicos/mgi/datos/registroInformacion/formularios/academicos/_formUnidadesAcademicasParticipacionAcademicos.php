<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    
    
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
    $aprobacion=true;
    }

?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_participacion">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasParticipacionAcademicos" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasParticipacionAcademicos" value="" id="idsiq_formUnidadesAcademicasParticipacionAcademicos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Participación de los académicos</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                    $categories = $utils->getActives($db,"siq_tipoEventoAcademico","idsiq_tipoEventoAcademico");
                ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                
            <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,2,$('#form_participacion #mes').val()+'-'+$('#form_participacion #anio').val(),$('#form_participacion #unidadAcademica').val())","popup_verDocumentos(9,2,$('#form_participacion #mes').val()+'-'+$('#form_participacion #anio').val(),$('#form_participacion #unidadAcademica').val())"); ?>
            
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "5"; else echo "4";?>"><span>Participación de los académicos como expositor en congresos, seminarios, simposios, talleres por núcleo estratégico</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Programa</span></th> 
                            <th class="column borderR" colspan="2"><span>Núcleo estratégico</span></th> 
                            <th class="column " rowspan="2"><span>Otras Disciplinas</span></th>
                            <?php if($aprobacion) { ?>
                            <th class="column borderR" rowspan="2"><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Salud</span></th> 
                            <th class="column borderR" ><span>Calidad de Vida</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php $i = 0; while ($row = $categories->FetchRow()) {
                             $cats[$i] = $row;
                             ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" value="<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformUnidadesAcademicasParticipacionAcademicos[]" value="" id="idsiq_detalleformUnidadesAcademicasParticipacionAcademicos_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" />
                                </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numSalud[]" id="numSalud_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" title="Total de Academicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numCalidad[]" id="numCalidad_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" title="Total de Academicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numOtros[]" id="numOtros_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" title="Total de Academicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="Verificado[]" id="VerEscondido_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado[]" id="Verificado_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
                            </td>
                            <?php 
                            }
                            ?> 
                        </tr>
                        <?php $i = $i + 1; } ?> 
                    </tbody>
                </table>   
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "4"; else echo "3";?>"><span>Participación de los académicos como expositor en congresos, seminarios, simposios, talleres nacionales e internacionales</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Programa</span></th> 
                            <th class="column borderR" colspan="2"><span>Ámbito</span></th> 
                            <?php if($aprobacion) { ?>
                            <th class="column borderR" rowspan="2"><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nacional</span></th> 
                            <th class="column borderR" ><span>Internacional</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php foreach ($cats as &$row){ ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numNacional[]" id="numNacional_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numInternacional[]" id="numInternacional_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="VerificadoDos[]" id="VerEscondidoDos_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="VerificadoDos[]" id="VerificadoDos_<?php echo $row["idsiq_tipoEventoAcademico"]; ?>" title="VerificadoDos" maxlength="10" tabindex="1" autocomplete="off" value="1" />
                            </td>
                            <?php 
                            }
                            ?> 
                        </tr>
                        <?php } ?> 
                    </tbody>
                </table> 
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>

            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitDescuentos" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">
var aprobacion = '<?php echo $aprobacion; ?>';
    getDataParticipacion("#form_participacion");
    
                $('#submitDescuentos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_participacion");
                    if(valido){
                        sendFormParticipacion("#form_participacion");
                    }
                });
                
                $('#form_participacion #mes').add($('#form_participacion #anio')).bind('change', function(event) {
                    getDataParticipacion("#form_participacion");
                });
                
                $(document).on('change', "#form_participacion #modalidad", function(){
                    getCarreras("#form_participacion");
                    changeFormModalidad("#form_participacion");
                });
                
                $(document).on('change', "#form_participacion #unidadAcademica", function(){
                    getDataParticipacion("#form_participacion");
                    changeFormModalidad("#form_participacion");
                });
                
                function getDataParticipacion(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasParticipacionAcademicos").val()!=""){
                            $(formName + ' input[name="idsiq_detalleformUnidadesAcademicasParticipacionAcademicos[]"]').each(function() {                                     
                                  $(this).val("");                                       
                             });
                             var modalidad = $(formName + ' #modalidad').val();
                             var unidadAcademica = $(formName + ' #unidadAcademica').val();
                             var mes = $(formName + ' #mes').val();
                             var anio = $(formName + ' #anio').val();
                             document.forms[formName.replace("#","")].reset();
                             $(formName + ' #modalidad').val(modalidad);
                             $(formName + ' #unidadAcademica').val(unidadAcademica);
                             $(formName + ' #mes').val(mes);
                             $(formName + ' #anio').val(anio);
                             $(formName + " #action").val("saveDynamic2");
                             $("#idsiq_formUnidadesAcademicasParticipacionAcademicos").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_tipoEventoAcademico",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasParticipacionAcademicos").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformUnidadesAcademicasParticipacionAcademicos_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformUnidadesAcademicasParticipacionAcademicos);
                                        $(formName + " #numSalud_"+data.data[i].idCategory).val(data.data[i].numSalud);
                                        $(formName + " #numCalidad_"+data.data[i].idCategory).val(data.data[i].numCalidad);
                                        $(formName + " #numOtros_"+data.data[i].idCategory).val(data.data[i].numOtros);
                                        $(formName + " #numNacional_"+data.data[i].idCategory).val(data.data[i].numNacional);
                                        $(formName + " #numInternacional_"+data.data[i].idCategory).val(data.data[i].numInternacional);
                                        
                                         //console.log(aprobacion);
                                        if(data.data[i].Verificado=="1"){
                                           $(formName + " #Verificado_"+data.data[i].idCategory).attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numSalud_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numCalidad_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numOtros_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #Verificado_"+data.data[i].idCategory).attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numSalud_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numCalidad_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numOtros_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                        
                                        //console.log(aprobacion);
                                        if(data.data[i].VerificadoDos=="1"){
                                           $(formName + " #VerificadoDos_"+data.data[i].idCategory).attr("checked", true);
                                           if(aprobacion==""){					      
					      $(formName + " #numNacional_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numInternacional_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoDos_"+data.data[i].idCategory).attr("checked", false); 
					  if(aprobacion==""){					      
					      $(formName + " #numNacional_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numInternacional_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
                                           }
                                        }
                                        
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasParticipacionAcademicos").val()!=""){
                                    
						$(formName + ' input[name="idsiq_detalleformUnidadesAcademicasParticipacionAcademicos[]"]').each(function() {                                     
						$(this).val("");                                       
						});
                                                var modalidad = $(formName + ' #modalidad').val();
                                                var unidadAcademica = $(formName + ' #unidadAcademica').val();
                                                var mes = $(formName + ' #mes').val();
                                                var anio = $(formName + ' #anio').val();
                                                document.forms[formName.replace("#","")].reset();
                                                $(formName + ' #modalidad').val(modalidad);
                                                $(formName + ' #unidadAcademica').val(unidadAcademica);
                                                $(formName + ' #mes').val(mes);
                                                $(formName + ' #anio').val(anio);
                                                $(formName + " #action").val("saveDynamic2");
                                                $("#idsiq_formUnidadesAcademicasParticipacionAcademicos").val("");
						
						$( formName + " input[name='Verificado[]'][type=checkbox]" ).each(function() {
						  $( this).attr("checked", false);
						});
						$( formName + " input[name='VerificadoDos[]'][type=checkbox]" ).each(function() {
						  $( this).attr("checked", false);
						});
						$( formName + " input[type=text]" ).each(function() {					      
						  $( this).attr("readonly", false).removeClass("disable");
						});
                                            }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                    }
                }

   function sendFormParticipacion(formName){
    
                $(formName + " input[name='Verificado[]'][type=checkbox]:checked" ).each(function() {
        		  var id= $( this ).attr( "id" );
        		  var n = id.split("_");
        		  $(formName + " #VerEscondido_"+n[1]).attr("disabled","disabled");
        		});
		
		$(formName + " input[name='Verificado[]'][type=checkbox]:not(:checked)" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $(formName + " #VerEscondido_"+n[1]).removeAttr("disabled");
		});
		
		$(formName + " input[name='VerificadoDos[]'][type=checkbox]:checked" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $(formName + " #VerEscondidoDos_"+n[1]).attr("disabled","disabled");
		});
		
		$(formName + " input[name='VerificadoDos[]'][type=checkbox]:not(:checked)" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $(formName + " #VerEscondidoDos_"+n[1]).removeAttr("disabled");
		});
		
                activarModalidades(formName);
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/academicos/saveUnidadesAcademicas.php',
                        data: $(formName).serialize(),                
                        success:function(data){
							<?php if($permisos["rol"][0]!=1) { ?>
								desactivarModalidades(formName);
							<?php } ?>
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formUnidadesAcademicasParticipacionAcademicos").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformUnidadesAcademicasParticipacionAcademicos_"+data.dataCat[i]).val(data.data[i]);
                                 }
                                 $(formName + " #action").val("updateDynamic2");
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
</script>
