<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
    $aprobacion=true;
    }
?>

<div id="tabs-12">
<form action="save.php" method="post" id="form_formacionProfesional">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasFormacionProfesional" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasFormacionProfesional" value="" id="idsiq_formUnidadesAcademicasFormacionProfesional" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Número de académicos que participan en formación profesoral</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                      $sectores = $utils->getActives($db,"areaconocimiento","nombreareaconocimiento");
                ?>
                
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,9,$('#form_formacionProfesional #codigoperiodo').val(),$('#form_formacionProfesional #unidadAcademica').val())","popup_verDocumentos(9,9,$('#form_formacionProfesional #codigoperiodo').val(),$('#form_formacionProfesional #unidadAcademica').val())"); ?>
                         
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "10"; else echo "9";?>"><span>Número de académicos que participan en formación profesoral</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Área de formación</span></th> 
                            <th class="column borderR" colspan="3"><span>Especialización</span></th> 
                            <th class="column borderR" colspan="2"><span>Maestría </span></th> 
                            <th class="column borderR" colspan="3"><span>Doctorado</span></th>
                            <?php if($aprobacion) { ?>
                            <th class="column borderR" rowspan="2"><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>1 año</span></th> 
                            <th class="column" ><span>2 - 3 años</span></th> 
                            <th class="column borderR" ><span>4 - 5 años</span></th> 
                            <th class="column" ><span>2 años</span></th> 
                            <th class="column borderR" ><span>3 años</span></th> 
                            <th class="column" ><span>2 años</span></th> 
                            <th class="column" ><span>3 años</span></th> 
                            <th class="column borderR" ><span>4 años</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $sectores->FetchRow()) { ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombreareaconocimiento"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idareaconocimiento"]; ?>" value="<?php echo $row["idareaconocimiento"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformUnidadesAcademicasFormacionProfesional[]" value="" id="idsiq_detalleformUnidadesAcademicasFormacionProfesional_<?php echo $row["idareaconocimiento"]; ?>" />
                               
                            </td>
                            <td class="column"> 
                                <input type="text"  class="grid-11-12 required number" minlength="1" name="numEspecializacion1[]" id="numEspecializacion1_<?php echo $row["idareaconocimiento"]; ?>" title="Proyectos de Salud" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text"  class="grid-11-12 required number" minlength="1" name="numEspecializacion2[]" id="numEspecializacion2_<?php echo $row["idareaconocimiento"]; ?>" title="Proyectos de Calidad de Vida" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-11-12 required number" minlength="1" name="numEspecializacion4[]" id="numEspecializacion4_<?php echo $row["idareaconocimiento"]; ?>" title="Otros" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text"  class="grid-11-12 required number" minlength="1" name="numMaestria2[]" id="numMaestria2_<?php echo $row["idareaconocimiento"]; ?>" title="Proyectos de Calidad de Vida" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-11-12 required number" minlength="1" name="numMaestria3[]" id="numMaestria3_<?php echo $row["idareaconocimiento"]; ?>" title="Proyectos de Calidad de Vida" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text"  class="grid-11-12 required number" minlength="1" name="numDoctorado2[]" id="numDoctorado2_<?php echo $row["idareaconocimiento"]; ?>" title="Proyectos de Calidad de Vida" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text"  class="grid-11-12 required number" minlength="1" name="numDoctorado3[]" id="numDoctorado3_<?php echo $row["idareaconocimiento"]; ?>" title="Proyectos de Calidad de Vida" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-11-12 required number" minlength="1" name="numDoctorado4[]" id="numDoctorado4_<?php echo $row["idareaconocimiento"]; ?>" title="Proyectos de Calidad de Vida" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="Verificado[]" id="VerEscondido_<?php echo $row["idareaconocimiento"]; ?>" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado[]" id="Verificado_<?php echo $row["idareaconocimiento"]; ?>" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
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
                <input type="submit" id="submitFormacionProfesional" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">
var aprobacion = '<?php echo $aprobacion; ?>';
    getDataFormacionProfesional("#form_formacionProfesional");
    
                $('#submitFormacionProfesional').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_formacionProfesional");
                    if(valido){
                        sendFormFormacionProfesional("#form_formacionProfesional");
                    }
                });
                
                $('#form_formacionProfesional #codigoperiodo').bind('change', function(event) {
                    getDataFormacionProfesional("#form_formacionProfesional");
                });
                
                $(document).on('change', "#form_formacionProfesional #modalidad", function(){
                    getCarreras("#form_formacionProfesional");
                    changeFormModalidad("#form_formacionProfesional");
                });
                
                $(document).on('change', "#form_formacionProfesional #unidadAcademica", function(){
                    getDataFormacionProfesional("#form_formacionProfesional");
                    changeFormModalidad("#form_formacionProfesional");
                });
                
                function getDataFormacionProfesional(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasFormacionProfesional").val()!=""){
                             var modalidad = $(formName + ' #modalidad').val();
                             var unidadAcademica = $(formName + ' #unidadAcademica').val();
                             var mes = $(formName + ' #codigoperiodo').val();
                             document.forms[formName.replace("#","")].reset();
                             $(formName + ' #modalidad').val(modalidad);
                             $(formName + ' #unidadAcademica').val(unidadAcademica);
                             $(formName + ' #codigoperiodo').val(mes);
                             $(formName + " #action").val("saveDynamic2");
                             $("#idsiq_formUnidadesAcademicasFormacionProfesional").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "areaconocimiento",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasFormacionProfesional").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformUnidadesAcademicasFormacionProfesional_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformUnidadesAcademicasFormacionProfesional);
                                        $(formName + " #numEspecializacion1_"+data.data[i].idCategory).val(data.data[i].numEspecializacion1);
                                        $(formName + " #numEspecializacion2_"+data.data[i].idCategory).val(data.data[i].numEspecializacion2);
                                        $(formName + " #numEspecializacion4_"+data.data[i].idCategory).val(data.data[i].numEspecializacion4);
                                        $(formName + " #numMaestria2_"+data.data[i].idCategory).val(data.data[i].numMaestria2);
                                        $(formName + " #numMaestria3_"+data.data[i].idCategory).val(data.data[i].numMaestria3);
                                        $(formName + " #numDoctorado2_"+data.data[i].idCategory).val(data.data[i].numDoctorado2);
                                        $(formName + " #numDoctorado3_"+data.data[i].idCategory).val(data.data[i].numDoctorado3);
                                        $(formName + " #numDoctorado4_"+data.data[i].idCategory).val(data.data[i].numDoctorado4);
                                        
                                         //console.log(aprobacion);
                                        if(data.data[i].Verificado=="1"){
                                           $("#Verificado_"+data.data[i].idCategory).attr("checked", true);
                                           if(aprobacion==""){
					      $("#numEspecializacion1_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numEspecializacion2_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numEspecializacion4_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numMaestria2_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numMaestria3_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numDoctorado2_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numDoctorado3_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numDoctorado4_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
                                           }
                                        }
                                        else{
					  $("#Verificado_"+data.data[i].idCategory).attr("checked", false); 
					  if(aprobacion==""){
					      $("#numEspecializacion1_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numEspecializacion2_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numEspecializacion4_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numMaestria2_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numMaestria3_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numDoctorado2_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numDoctorado3_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numDoctorado4_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
                                           }
                                        }
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasFormacionProfesional").val()!=""){
                            $(formName + ' input[name="idsiq_detalleformUnidadesAcademicasFormacionProfesional[]"]').each(function() {                                     
                                  $(this).val("");                                       
                             });
                                                var modalidad = $(formName + ' #modalidad').val();
                                                var unidadAcademica = $(formName + ' #unidadAcademica').val();
                                                var mes = $(formName + ' #codigoperiodo').val();
                                                document.forms[formName.replace("#","")].reset();
                                                $(formName + ' #modalidad').val(modalidad);
                                                $(formName + ' #unidadAcademica').val(unidadAcademica);
                                                $(formName + ' #codigoperiodo').val(mes);
                                                $(formName + " #action").val("saveDynamic2");
                                                $("#idsiq_formUnidadesAcademicasFormacionProfesional").val("");
                                                $( formName + " input[type=checkbox]" ).each(function() {					      
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

                function sendFormFormacionProfesional(formName){
                 $(formName + " input[type=checkbox]:checked" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $( "#VerEscondido_"+n[1]).attr("disabled","disabled");
		});
		
		$(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $( "#VerEscondido_"+n[1]).removeAttr("disabled");
		});
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
                                 $("#idsiq_formUnidadesAcademicasFormacionProfesional").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformUnidadesAcademicasFormacionProfesional_"+data.dataCat[i]).val(data.data[i]);
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
