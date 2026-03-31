<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_invEstudiantes">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasEstudiantesInvestigacion" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasEstudiantesInvestigacion" value="" id="idsiq_formUnidadesAcademicasEstudiantesInvestigacion" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Participación de estudiantes en la evaluación de la Investigación formativa</legend>
                
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
                
            <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,14,$('#form_invEstudiantes #mes').val()+'-'+$('#form_invEstudiantes #anio').val(),$('#form_invEstudiantes #unidadAcademica').val())","popup_verDocumentos(9,14,$('#form_invEstudiantes #mes').val()+'-'+$('#form_invEstudiantes #anio').val(),$('#form_invEstudiantes #unidadAcademica').val())"); ?>
                        
                <table align="center" class="formData last" width="92%" >
                     <tbody>
                        <tr class="dataColumns">
                            <th class="column" style="text-align: left"><span>Estudiantes que realizaron evaluación de la Investigación formativa</span></th> 
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numEstudiantes" id="numEstudiantes" title="Total de Asignaturas" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                        </tr>                  
                    </tbody>
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitInvEstudiantes" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">
    getDataInvEstudiantes("#form_invEstudiantes");
    
                $('#submitInvEstudiantes').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_invEstudiantes");
                    if(valido){
                        sendFormInvEstudiantes("#form_invEstudiantes");
                    }
                });
                
                $('#form_invEstudiantes #mes').add($('#form_invEstudiantes #anio')).bind('change', function(event) {
                    getDataInvEstudiantes("#form_invEstudiantes");
                });
                
                $(document).on('change', "#form_invEstudiantes #modalidad", function(){
                    getCarreras("#form_invEstudiantes");
                    changeFormModalidad("#form_invEstudiantes");
                });
                
                $(document).on('change', "#form_invEstudiantes #unidadAcademica", function(){
                    getDataInvEstudiantes("#form_invEstudiantes");
                    changeFormModalidad("#form_invEstudiantes");
                });
                
                function getDataInvEstudiantes(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasEstudiantesInvestigacion").val()!=""){
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
                             $("#idsiq_formUnidadesAcademicasEstudiantesInvestigacion").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasEstudiantesInvestigacion").val(data.data.idsiq_formUnidadesAcademicasEstudiantesInvestigacion);
                                    $(formName + " #numEstudiantes").val(data.data.numEstudiantes);
                                    $(formName + " #action").val("update");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasEstudiantesInvestigacion").val()!=""){
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
                                        $("#idsiq_formUnidadesAcademicasEstudiantesInvestigacion").val("");
                                    }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

                function sendFormInvEstudiantes(formName){
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
                                 $("#idsiq_formUnidadesAcademicasEstudiantesInvestigacion").val(data.message);
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
