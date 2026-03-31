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
<form action="save.php" method="post" id="form_movilidadProfesoral">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasMovilidadProfesoral" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasMovilidadProfesoral" value="" id="idsiq_formUnidadesAcademicasMovilidadProfesoral" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Movilidad académica Profesoral</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                    $nombreId = "idsiq_categoriaPais";
                    $categories = $utils->getActives($db,"siq_categoriaPais",$nombreId);
                ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                
             <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,8,$('#form_movilidadProfesoral #mes').val()+'-'+$('#form_movilidadProfesoral #anio').val(),$('#form_movilidadProfesoral #unidadAcademica').val())","popup_verDocumentos(9,8,$('#form_movilidadProfesoral #mes').val()+'-'+$('#form_movilidadProfesoral #anio').val(),$('#form_movilidadProfesoral #unidadAcademica').val())"); ?>
                        
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "7"; else echo "6";?>"><span>Movilidad académica Profesoral: Académicos de la Universidad que viajan</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Región a la que viaja</span></th> 
                            <th class="column borderR" colspan="5"><span>Tipo de movilidad</span></th> 
                            <?php if($aprobacion) { ?>
                            <th class="column borderR" rowspan="2"><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Trabajo de cooperación</span></th> 
                            <th class="column " ><span>Presentación en seminario, congreso, etc.</span></th> 
                            <th class="column " ><span>Investigación</span></th> 
                            <th class="column " ><span>Pasantía</span></th> 
                            <th class="column borderR" ><span>Docencia</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php $i = 0; while ($row = $categories->FetchRow()) {
                             $cats[$i] = $row;
                             ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row[$nombreId]; ?>" value="<?php echo $row[$nombreId]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformUnidadesAcademicasMovilidadProfesoral[]" value="" id="idsiq_detalleformUnidadesAcademicasMovilidadProfesoral_<?php echo $row[$nombreId]; ?>" />
                                </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numCooperacionIda[]" id="numCooperacionIda_<?php echo $row[$nombreId]; ?>" title="Total de Academicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column "> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numPresentacionIda[]" id="numPresentacionIda_<?php echo $row[$nombreId]; ?>" title="Total de Academicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numInvestigacionIda[]" id="numInvestigacionIda_<?php echo $row[$nombreId]; ?>" title="Total de Academicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numPasantiaIda[]" id="numPasantiaIda_<?php echo $row[$nombreId]; ?>" title="Total de Academicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numDocenciaIda[]" id="numDocenciaIda_<?php echo $row[$nombreId]; ?>" title="Total de Academicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="Verificado[]" id="VerEscondido_<?php echo $row[$nombreId]; ?>" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado[]" id="Verificado_<?php echo $row[$nombreId]; ?>" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
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
                            <th class="column" colspan="<?php if($aprobacion) echo "7"; else echo "6";?>"><span>Movilidad académica Profesoral: Académicos de Otras Universidades que vienen a la Universidad</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Región de procedencia</span></th> 
                            <th class="column borderR" colspan="5"><span>Tipo de movilidad</span></th>
                            <?php if($aprobacion) { ?>
                            <th class="column borderR" rowspan="2"><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Trabajo de cooperación</span></th> 
                            <th class="column" ><span>Presentación en seminario, congreso, etc.</span></th> 
                            <th class="column" ><span>Investigación</span></th> 
                            <th class="column" ><span>Pasantía</span></th> 
                            <th class="column borderR" ><span>Docencia</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php foreach ($cats as &$row){ ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numCooperacionLlegada[]" id="numCooperacionLlegada_<?php echo $row[$nombreId]; ?>" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numPresentacionLlegada[]" id="numPresentacionLlegada_<?php echo $row[$nombreId]; ?>" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numInvestigacionLlegada[]" id="numInvestigacionLlegada_<?php echo $row[$nombreId]; ?>" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numPasantiaLlegada[]" id="numPasantiaLlegada_<?php echo $row[$nombreId]; ?>" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numDocenciaLlegada[]" id="numDocenciaLlegada_<?php echo $row[$nombreId]; ?>" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="VerificadoDos[]" id="VerEscondidoDos_<?php echo $row[$nombreId]; ?>" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="VerificadoDos[]" id="VerificadoDos_<?php echo $row[$nombreId]; ?>" title="VerificadoDos" maxlength="10" tabindex="1" autocomplete="off" value="1" />
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
            <input type="submit" id="submitMovilidadP" value="Guardar datos" class="first" /> 
        </div>
        </form>
</div>

<script type="text/javascript">
var aprobacion = '<?php echo $aprobacion; ?>';
    getDataMovilidadProfesoral("#form_movilidadProfesoral");
    
                $('#submitMovilidadP').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_movilidadProfesoral");
                    if(valido){
                        sendFormMovilidadProfesoral("#form_movilidadProfesoral");
                    }
                });
                
                $('#form_movilidadProfesoral #mes').add($('#form_movilidadProfesoral #anio')).bind('change', function(event) {
                    getDataMovilidadProfesoral("#form_movilidadProfesoral");
                });
                
                $(document).on('change', "#form_movilidadProfesoral #modalidad", function(){
                    getCarreras("#form_movilidadProfesoral");
                    changeFormModalidad("#form_movilidadProfesoral");
                });
                
                $(document).on('change', "#form_movilidadProfesoral #unidadAcademica", function(){
                    getDataMovilidadProfesoral("#form_movilidadProfesoral");
                    changeFormModalidad("#form_movilidadProfesoral");
                });
                
                function getDataMovilidadProfesoral(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasMovilidadProfesoral").val()!=""){
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
                             $("#idsiq_formUnidadesAcademicasMovilidadProfesoral").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_categoriaPais",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasMovilidadProfesoral").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformUnidadesAcademicasMovilidadProfesoral_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformUnidadesAcademicasMovilidadProfesoral);
                                        $(formName + " #numCooperacionLlegada_"+data.data[i].idCategory).val(data.data[i].numCooperacionLlegada);
                                        $(formName + " #numPresentacionLlegada_"+data.data[i].idCategory).val(data.data[i].numPresentacionLlegada);
                                        $(formName + " #numInvestigacionLlegada_"+data.data[i].idCategory).val(data.data[i].numInvestigacionLlegada);
                                        $(formName + " #numPasantiaLlegada_"+data.data[i].idCategory).val(data.data[i].numPasantiaLlegada);
                                        $(formName + " #numDocenciaLlegada_"+data.data[i].idCategory).val(data.data[i].numDocenciaLlegada);
                                        
                                        $(formName + " #numCooperacionIda_"+data.data[i].idCategory).val(data.data[i].numCooperacionIda);
                                        $(formName + " #numPresentacionIda_"+data.data[i].idCategory).val(data.data[i].numPresentacionIda);
                                        $(formName + " #numInvestigacionIda_"+data.data[i].idCategory).val(data.data[i].numInvestigacionIda);
                                        $(formName + " #numPasantiaIda_"+data.data[i].idCategory).val(data.data[i].numPasantiaIda);
                                        $(formName + " #numDocenciaIda_"+data.data[i].idCategory).val(data.data[i].numDocenciaIda);
                                        
                                        if(data.data[i].Verificado=="1"){
                                           $(formName + " #Verificado_"+data.data[i].idCategory).attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numCooperacionIda_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numPresentacionIda_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numInvestigacionIda_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numPasantiaIda_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numDocenciaIda_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
                                           }
                                        }
                                        else{
					  $(formName + " #Verificado_"+data.data[i].idCategory).attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numCooperacionIda_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numPresentacionIda_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numInvestigacionIda_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numPasantiaIda_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numDocenciaIda_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
                                           }
                                        }
                                        
                                        //console.log(aprobacion);
                                        if(data.data[i].VerificadoDos=="1"){
                                           $(formName + " #VerificadoDos_"+data.data[i].idCategory).attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numCooperacionLlegada_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numPresentacionLlegada_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numInvestigacionLlegada_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numPasantiaLlegada_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");					      
					      $(formName + " #numDocenciaLlegada_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoDos_"+data.data[i].idCategory).attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numCooperacionLlegada_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numPresentacionLlegada_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numInvestigacionLlegada_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numPasantiaLlegada_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numDocenciaLlegada_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
                                           }
                                        }
                                        
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasMovilidadProfesoral").val()!=""){
                            $(formName + ' input[name="idsiq_detalleformUnidadesAcademicasMovilidadProfesoral[]"]').each(function() {                                     
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
                                                $("#idsiq_formUnidadesAcademicasMovilidadProfesoral").val("");
                                                
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

                function sendFormMovilidadProfesoral(formName){
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
		
		
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                activarModalidades(formName);
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
                                 $("#idsiq_formUnidadesAcademicasMovilidadProfesoral").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformUnidadesAcademicasMovilidadProfesoral_"+data.dataCat[i]).val(data.data[i]);
                                 }
								 $('#msg-success').removeClass('msg-error');
                                 $('#msg-success').html('<p>Los datos han sido guardados de forma correcta.</p>');
                                 $(formName + " #action").val("updateDynamic2");
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
                            }
                            else{                        
                                $('#msg-success').addClass('msg-error');
                                $('#msg-success').html('<p>' + data.message + '</p>');
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
</script>
