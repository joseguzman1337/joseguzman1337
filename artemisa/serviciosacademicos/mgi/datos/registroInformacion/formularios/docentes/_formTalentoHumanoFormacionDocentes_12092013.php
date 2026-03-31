<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>

<div id="tabs-3">
<form action="save.php" method="post" id="form_formacion">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoDocentesFormacion" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formTalentoHumanoDocentesFormacion" value="" id="idsiq_formTalentoHumanoDocentesFormacion" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Docentes por nivel de Formación</legend>
                
                <!--<label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php //$utils->getSemestresSelect($db);  ?>-->
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />     
                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Docentes por nivel de Formación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Titulo</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th> 
                            <th class="column" ><span>Número de Académicos<br/>(Especializaciones<br/>médico – quirúrgicas)</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column">T. Doctorado <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosDoctorado" id="numAcademicosDoctorado" title="Total de Académicos con Doctorado" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosDoctoradoMedico" id="numAcademicosDoctoradoMedico" title="Total de Académicos con Doctarado (Médico-quirúrgico)" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">T. Maestría <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosMaestria" id="numAcademicosMaestria" title="Total de Académicos con Maestría" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosMaestriaMedico" id="numAcademicosMaestriaMedico" title="Total de Académicos con Maestría (Médico-quirúrgico)" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">T. Especialización <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosEspecializacion" id="numAcademicosEspecializacion" title="Total de Académicos con Especialización" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosEspecializacionMedico" id="numAcademicosEspecializacionMedico" title="Total de Académicos con Especialización (Médico-quirúrgico)" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">T. Profesional <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosProfesional" id="numAcademicosProfesional" title="Total de Académicos con Titulo Profesional" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosProfesionalMedico" id="numAcademicosProfesionalMedico" title="Total de Académicos con Titulo Profesional (Médico-quirúrgico)" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">T. Técnico/Tecnólogo <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosTecnico" id="numAcademicosTecnico" title="Total de Académicos con Titulo de Técnico" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosTecnicoMedico" id="numAcademicosTecnicoMedico" title="Total de Académicos con Titulo de Técnico (Médico-quirúrgico)" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">T. Licenciado <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosLicenciado" id="numAcademicosLicenciado" title="Total de Académicos con Licenciatura" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosLicenciadoMedico" id="numAcademicosLicenciadoMedico" title="Total de Académicos con Licenciatura (Médico-quirúrgico)" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Sin Titulo <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosNoTitulo" id="numAcademicosNoTitulo" title="Total de Académicos sin Titulo" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosNoTituloMedico" id="numAcademicosNoTituloMedico" title="Total de Académicos sin Titulo (Médico-quirúrgico)" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>   
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Docentes en formación </span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Titulo</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column">Doctorado <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosEnDoctorado" id="numAcademicosEnDoctorado" title="Académicos Cursando un Doctorado" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Maestría <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosEnMaestria" id="numAcademicosEnMaestria" title="Académicos Cursando una Maestría" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Especialización <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-3-12 required number" minlength="1" name="numAcademicosEnEspecializacion" id="numAcademicosEnEspecializacion" title="Académicos Cursando una Especialización" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitFormacion" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataFormacion();
    
                $('#submitFormacion').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_formacion");
                    if(valido){
                        sendFormFormacion();
                    }
                });
                
                $('#form_formacion #mes').add($('#form_formacion #anio')).bind('change', function(event) {
                    getDataFormacion();
                });
                
                function getDataFormacion(){
                    //var periodo = $('#form_formacion #codigoperiodo').val();                    
                    var periodo = $('#form_formacion  #mes').val()+"-"+$('#form_formacion  #anio').val();
                    var entity = $("#form_formacion #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo" },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formTalentoHumanoDocentesFormacion").val(data.data.idsiq_formTalentoHumanoDocentesFormacion);
                                 $("#numAcademicosDoctorado").val(data.data.numAcademicosDoctorado);
                                 $("#numAcademicosDoctoradoMedico").val(data.data.numAcademicosDoctoradoMedico);
                                 $("#numAcademicosMaestria").val(data.data.numAcademicosMaestria);
                                 $("#numAcademicosMaestriaMedico").val(data.data.numAcademicosMaestriaMedico);
                                 $("#numAcademicosEspecializacion").val(data.data.numAcademicosEspecializacion);
                                 $("#numAcademicosEspecializacionMedico").val(data.data.numAcademicosEspecializacionMedico);
                                 $("#numAcademicosProfesional").val(data.data.numAcademicosProfesional);
                                 $("#numAcademicosProfesionalMedico").val(data.data.numAcademicosProfesionalMedico);
                                 $("#numAcademicosTecnico").val(data.data.numAcademicosTecnico);
                                 $("#numAcademicosTecnicoMedico").val(data.data.numAcademicosTecnicoMedico);
                                 $("#numAcademicosLicenciado").val(data.data.numAcademicosLicenciado);
                                 $("#numAcademicosLicenciadoMedico").val(data.data.numAcademicosLicenciadoMedico);
                                 $("#numAcademicosNoTitulo").val(data.data.numAcademicosNoTitulo);
                                 $("#numAcademicosNoTituloMedico").val(data.data.numAcademicosNoTituloMedico);
                                 $("#numAcademicosEnDoctorado").val(data.data.numAcademicosEnDoctorado);
                                 $("#numAcademicosEnMaestria").val(data.data.numAcademicosEnMaestria);
                                 $("#numAcademicosEnEspecializacion").val(data.data.numAcademicosEnEspecializacion);
                                 $("#form_formacion #action").val("update");
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formTalentoHumanoDocentesFormacion").val()!=""){
                                    // var periodo = $('#form_indices #codigoperiodo').val();                                          
                                        var mes = $('#form_formacion #mes').val();
                                        var anio = $('#form_formacion #anio').val();
                                    document.forms["form_formacion"].reset();
                                    //$('#form_formacion #codigoperiodo').val(periodo);                                       
                                            $('#form_formacion #mes').val(mes);
                                            $('#form_formacion #anio').val(anio);
                                    $("#form_formacion #action").val("save");
                                    $("#idsiq_formTalentoHumanoDocentesFormacion").val("");
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormFormacion(){
                var periodo = $('#form_formacion #mes').val()+"-"+$('#form_formacion #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_formacion').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#idsiq_formTalentoHumanoDocentesFormacion").val(data.message);
                                 $("#form_formacion #action").val("update");
                                 $('#form_test #msg-success').css('display','block');
                                 $("#form_test #msg-success").delay(5500).fadeOut(800);
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
