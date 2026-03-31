<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_equipos">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasEquiposComputo" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasEquiposComputo" value="" id="idsiq_formUnidadesAcademicasEquiposComputo" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Equipos de cómputo disponibles para los académicos</legend>
                
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
            
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,19,$('#form_equipos #mes').val()+'-'+$('#form_equipos #anio').val(),$('#form_equipos #unidadAcademica').val())","popup_verDocumentos(9,19,$('#form_equipos #mes').val()+'-'+$('#form_equipos #anio').val(),$('#form_equipos #unidadAcademica').val())"); ?>
                          
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Equipos de cómputo disponibles para los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Dedicación (según CNA)</span></th> 
                            <th class="column" ><span>Equipos de computo</span></th> 
                            <th class="column" ><span>Total académicos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Tiempo completo (29 - 40h) <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numEquiposTC" id="numEquiposTC" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAcademicosTC" id="numAcademicosTC" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Medio tiempo (15 - 28h) <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numEquiposMT" id="numEquiposMT" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAcademicosMT" id="numAcademicosMT" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitEquiposComputo" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">
    getDataEquipos("#form_equipos");
    
                $('#submitEquiposComputo').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_equipos");
                    if(valido){
                        sendFormEquipos("#form_equipos");
                    }
                });
                
                $('#form_equipos #mes').add($('#form_equipos #anio')).bind('change', function(event) {
                    getDataEquipos("#form_equipos");
                });
                
                $(document).on('change', "#form_equipos #modalidad", function(){
                    getCarreras("#form_equipos");
                    changeFormModalidad("#form_equipos");
                });
                
                $(document).on('change', "#form_equipos #unidadAcademica", function(){
                    getDataEquipos("#form_equipos");
                    changeFormModalidad("#form_equipos");
                });
                
                function getDataEquipos(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasEquiposComputo").val()!=""){
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
                             $("#idsiq_formUnidadesAcademicasEquiposComputo").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasEquiposComputo").val(data.data.idsiq_formUnidadesAcademicasEquiposComputo);
                                    $(formName + " #numEquiposTC").val(data.data.numEquiposTC);
                                    $(formName + " #numAcademicosTC").val(data.data.numAcademicosTC);
                                    $(formName + " #numEquiposMT").val(data.data.numEquiposMT);
                                    $(formName + " #numAcademicosMT").val(data.data.numAcademicosMT);
                                    $(formName + " #action").val("update");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasEquiposComputo").val()!=""){
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
                                        $("#idsiq_formUnidadesAcademicasEquiposComputo").val("");
                                    }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

                function sendFormEquipos(formName){
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                activarModalidades(formName);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/academicos/saveUnidadesAcademicas.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            desactivarModalidades(formName);
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formUnidadesAcademicasEquiposComputo").val(data.message);
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
