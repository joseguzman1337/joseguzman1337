<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_consultoria">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasProyectosConsultoria" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasProyectosConsultoria" value="" id="idsiq_formUnidadesAcademicasProyectosConsultoria" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Proyectos de consultoría </legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                
            <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,15,$('#form_consultoria #mes').val()+'-'+$('#form_consultoria #anio').val(),$('#form_consultoria #unidadAcademica').val())","popup_verDocumentos(9,15,$('#form_consultoria #mes').val()+'-'+$('#form_consultoria #anio').val(),$('#form_consultoria #unidadAcademica').val())"); ?>
                         
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Proyectos de consultoría</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Proyectos de Consultoría</span></th> 
                            <th class="column" ><span>Números de proyectos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Consultorías aprobados <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAprobadas" id="numAprobadas" title="Total de Proyectos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Consultorías en ejecución <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numEjecucion" id="numEjecucion" title="Total de Proyectos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitConsultoria" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">
    getDataConsultoria("#form_consultoria");
    
                $('#submitConsultoria').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_consultoria");
                    if(valido){
                        sendFormConsultoria("#form_consultoria");
                    }
                });
                
                $('#form_consultoria #mes').add($('#form_consultoria #anio')).bind('change', function(event) {
                    getDataConsultoria("#form_consultoria");
                });
                
                $(document).on('change', "#form_consultoria #modalidad", function(){
                    getCarreras("#form_consultoria");
                    changeFormModalidad("#form_consultoria");
                });
                
                $(document).on('change', "#form_consultoria #unidadAcademica", function(){
                    getDataConsultoria("#form_consultoria");
                    changeFormModalidad("#form_consultoria");
                });
                
                function getDataConsultoria(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasProyectosConsultoria").val()!=""){
                             var modalidad = $(formName + ' #modalidad').val();
                             var unidadAcademica = $(formName + ' #unidadAcademica').val();
                             var mes = $(formName + ' #mes').val();
                             var anio = $(formName + ' #anio').val();
                             document.forms[formName.replace("#","")].reset();
                             $(formName + ' #modalidad').val(modalidad);
                             $(formName + ' #unidadAcademica').val(unidadAcademica);
                             $(formName + ' #mes').val(mes);
                             $(formName + ' #anio').val(anio);
                             $(formName + " #action").val("save");
                             $("#idsiq_formUnidadesAcademicasProyectosConsultoria").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasProyectosConsultoria").val(data.data.idsiq_formUnidadesAcademicasProyectosConsultoria);
                                    $(formName + " #numAprobadas").val(data.data.numAprobadas);
                                    $(formName + " #numEjecucion").val(data.data.numEjecucion);
                                    $(formName + " #action").val("update");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasProyectosConsultoria").val()!=""){
                                        var modalidad = $(formName + ' #modalidad').val();
                                        var unidadAcademica = $(formName + ' #unidadAcademica').val();
                                        var mes = $(formName + ' #mes').val();
                                        var anio = $(formName + ' #anio').val();
                                        document.forms[formName.replace("#","")].reset();
                                        $(formName + ' #modalidad').val(modalidad);
                                        $(formName + ' #unidadAcademica').val(unidadAcademica);
                                        $(formName + ' #mes').val(mes);
                                        $(formName + ' #anio').val(anio);
                                        $(formName + " #action").val("save");
                                        $("#idsiq_formUnidadesAcademicasProyectosConsultoria").val("");
                                    }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

                function sendFormConsultoria(formName){
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
                                 $("#idsiq_formUnidadesAcademicasProyectosConsultoria").val(data.message);
                                 $(formName + " #action").val("update");
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
