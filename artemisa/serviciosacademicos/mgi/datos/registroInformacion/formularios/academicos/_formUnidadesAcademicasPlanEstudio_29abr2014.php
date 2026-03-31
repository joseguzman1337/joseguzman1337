<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_planEstudio">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasPlanEstudio" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="verificar" value="1" id="verificar" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasPlanEstudio" value="" id="idsiq_formUnidadesAcademicasPlanEstudio" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Distribución del Plan de Estudios</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>               
                
                <div class="vacio"></div>
                
                <label for="planEstudio" class="fixedLabel">Plan de Estudios: <span class="mandatory">(*)</span></label>
                <select name="planEstudio" id="planEstudio" class="required" style='font-size:0.8em;width:auto'>
                    <option value="" selected></option>
                </select>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                ?>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Distribución del Plan de Estudios</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Tipo de Asignaturas</span></th> 
                            <th class="column" ><span>Número de Asignaturas</span></th> 
                            <th class="column" ><span>Número de Créditos</span></th> 
                            <th class="column" ><span>Dato verificado</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Formación Fundamental <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number disable" minlength="1" name="numAsignaturasFundamental" id="numAsignaturasFundamental" title="Total de Asignaturas Fundamental" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number disable" minlength="1" name="numCreditosFundamental" id="numCreditosFundamental" title="Total de Créditos Fundamental" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>                            
                            <td class="column center"> 
                                <input type="checkbox" name="vnumAsignaturasFundamental" value="1" id="vnumAsignaturasFundamental" onclick="CambiarClass();" >
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Formación Diversificada <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number disable" minlength="1" name="numAsignaturasDiversificada" id="numAsignaturasDiversificada" title="Total de Asignaturas Diversificadas" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number disable" minlength="1" name="numCreditosDiversificada" id="numCreditosDiversificada" title="Total de Creditos Diversificadas" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>                            
                            <td class="column center"> 
                                <input type="checkbox" name="vnumAsignaturasDiversificada" value="1" id="vnumAsignaturasDiversificada" onclick="CambiarClass();" >
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Electivas complementarias <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number disable" minlength="1" name="numAsignaturasElectivas" id="numAsignaturasElectivas" title="Total de Asignaturas Electivas" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number disable" minlength="1" name="numCreditosElectivas" id="numCreditosElectivas" title="Total de Creditos Electivas" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>
                            <td class="column center"> 
                                <input type="checkbox" name="vnumAsignaturasElectivas" value="1" id="vnumAsignaturasElectivas" onclick="CambiarClass();" >
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitPlanEstudio" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        getPlanesEstudio("#form_planEstudio");
        getDataPlanEstudio("#form_planEstudio");
    });
    
    
                $('#submitPlanEstudio').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_planEstudio");
                    if(valido){
                        sendFormPlanEstudio("#form_planEstudio");
                    }
                });
                
                $('#form_planEstudio #codigoperiodo').add($('#form_planEstudio #planEstudio')).bind('change', function(event) {
                    getDataPlanEstudio("#form_planEstudio");
                });
                
                $(document).on('change', "#form_planEstudio #modalidad", function(){
                    getCarreras("#form_planEstudio");
                    changeFormModalidad("#form_planEstudio");
                });
                
                $(document).on('change', "#form_planEstudio #unidadAcademica", function(){
                    getPlanesEstudio("#form_planEstudio");
                    changeFormModalidad("#form_planEstudio");
                });
                
                function getPlanesEstudio(formName){
                    $(formName + " #planEstudio").html("");
                    $(formName + " #planEstudio").css("width","auto");   
                    if($(formName + ' #unidadAcademica').val()!=""){
                        var mod = $(formName + ' #unidadAcademica').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForPlanesEstudios.php',
                                data: { carrera: mod },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $(formName + " #planEstudio").html(html);
                                        $(formName + " #planEstudio").css("width","500px");                                        
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
                }
                
                function getDataPlanEstudio(formName){
                    
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    var planEstudio = $(formName + " #planEstudio").val();
                    if(codigocarrera=="" || planEstudio==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasPlanEstudio").val()!=""){
                             var modalidad = $(formName + ' #modalidad').val();
                             var unidadAcademica = $(formName + ' #unidadAcademica').val();
                             var planEstudio = $(formName + ' #planEstudio').val();
                             var mes = $(formName + ' #codigoperiodo').val();
                             document.forms[formName.replace("#","")].reset();
                             $(formName + ' #modalidad').val(modalidad);
                             $(formName + ' #unidadAcademica').val(unidadAcademica);
                             $(formName + ' #planEstudio').val(planEstudio);
                             $(formName + ' #codigoperiodo').val(mes);
                             $(formName + " #action").val("save");
                             $("#idsiq_formUnidadesAcademicasPlanEstudio").val("");
                             $('input:checkbox').removeAttr('checked');
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera, planEstudio: planEstudio, verificar: true },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasPlanEstudio").val(data.data.idsiq_formUnidadesAcademicasPlanEstudio);
                                    $(formName + " #numAsignaturasFundamental").val(data.data.numAsignaturasFundamental);
                                    $(formName + " #numCreditosFundamental").val(data.data.numCreditosFundamental);
                                    $(formName + " #numAsignaturasDiversificada").val(data.data.numAsignaturasDiversificada);
                                    $(formName + " #numCreditosDiversificada").val(data.data.numCreditosDiversificada);
                                    $(formName + " #numAsignaturasElectivas").val(data.data.numAsignaturasElectivas);
                                    $(formName + " #numCreditosElectivas").val(data.data.numCreditosElectivas);
                                    
                                    if(data.datav.vnumAsignaturasFundamental==1){
                                        $('input[name=vnumAsignaturasFundamental]').attr('checked', true);
                                    } else {
                                        $('input[name=vnumAsignaturasFundamental]').attr('checked', false);
                                        $(formName + " #numAsignaturasFundamental").removeClass('disable');
                                        $(formName + " #numCreditosFundamental").removeClass('disable');
                                        
                                    }

                                    if(data.datav.vnumAsignaturasDiversificada==1){
                                        $('input[name=vnumAsignaturasDiversificada]').attr('checked', true);
                                    } else {
                                        $('input[name=vnumAsignaturasDiversificada]').attr('checked', false);
                                        $(formName + " #numAsignaturasDiversificada").removeClass('disable');
                                        $(formName + " #numCreditosDiversificada").removeClass('disable');
                                        
                                    }

                                    if(data.datav.vnumAsignaturasElectivas==1){
                                        $('input[name=vnumAsignaturasElectivas]').attr('checked', true);
                                    } else {
                                        $('input[name=vnumAsignaturasElectivas]').attr('checked', false);
                                        $(formName + " #numAsignaturasElectivas").removeClass('disable');
                                        $(formName + " #numCreditosElectivas").removeClass('disable');
                                    }     
                                    $(formName + " #action").val("update");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasPlanEstudio").val()!=""){
                                        var modalidad = $(formName + ' #modalidad').val();
                                        var unidadAcademica = $(formName + ' #unidadAcademica').val();
                                        var planEstudio = $(formName + ' #planEstudio').val();
                                        var mes = $(formName + ' #codigoperiodo').val();
                                        document.forms[formName.replace("#","")].reset();
                                        $(formName + ' #modalidad').val(modalidad);
                                        $(formName + ' #unidadAcademica').val(unidadAcademica);
                                        $(formName + ' #planEstudio').val(planEstudio);
                                        $(formName + ' #codigoperiodo').val(mes);
                                        $(formName + " #action").val("save");
                                        $("#idsiq_formUnidadesAcademicasPlanEstudio").val("");                                        
                                        $('input:checkbox').removeAttr('checked');
                                    }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

         function sendFormPlanEstudio(formName){
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
                                if($('input[name=vnumAsignaturasFundamental]').is(':checked')){
                                    
                                    $(formName + " #numAsignaturasFundamental").addClass('disable');
                                    $(formName + " #numCreditosFundamental").addClass('disable');
                                }else{
                                    $(formName + " #numAsignaturasFundamental").removeClass('disable');
                                    $(formName + " #numCreditosFundamental").removeClass('disable');
                                }
                                if($('input[name=vnumAsignaturasDiversificada]').is(':checked')){
                                    
                                  $(formName + " #numAsignaturasDiversificada").addClass('disable');
                                  $(formName + " #numCreditosDiversificada").addClass('disable'); 
                                }else{
                                    $(formName + " #numAsignaturasDiversificada").removeClass('disable');
                                    $(formName + " #numCreditosDiversificada").removeClass('disable'); 
                                }
                                
                                if($('input[name=vnumAsignaturasElectivas]').is(':checked')){
                                   
                                   $(formName + " #numAsignaturasElectivas").addClass('disable');
                                   $(formName + " #numCreditosElectivas").addClass('disable'); 
                                }else{
                                   $(formName + " #numAsignaturasElectivas").removeClass('disable');
                                   $(formName + " #numCreditosElectivas").removeClass('disable');
                                }
                                
                                
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formUnidadesAcademicasPlanEstudio").val(data.message);
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
                
          function CambiarClass(){
            /****************************************/
            var formName = '#form_planEstudio';
            
            if($('input[name=vnumAsignaturasFundamental]').is(':checked')){
                
                $(formName + " #numAsignaturasFundamental").addClass('disable');
                $(formName + " #numCreditosFundamental").addClass('disable');
            }else{
                $(formName + " #numAsignaturasFundamental").removeClass('disable');
                $(formName + " #numCreditosFundamental").removeClass('disable');
            }
            if($('input[name=vnumAsignaturasDiversificada]').is(':checked')){
                
              $(formName + " #numAsignaturasDiversificada").addClass('disable');
              $(formName + " #numCreditosDiversificada").addClass('disable'); 
            }else{
                $(formName + " #numAsignaturasDiversificada").removeClass('disable');
                $(formName + " #numCreditosDiversificada").removeClass('disable'); 
            }
            
            if($('input[name=vnumAsignaturasElectivas]').is(':checked')){
               
               $(formName + " #numAsignaturasElectivas").addClass('disable');
               $(formName + " #numCreditosElectivas").addClass('disable'); 
            }else{
               $(formName + " #numAsignaturasElectivas").removeClass('disable');
               $(formName + " #numCreditosElectivas").removeClass('disable');
            }
            /****************************************/
          }/*function CambiarClass*/      
                
</script>
