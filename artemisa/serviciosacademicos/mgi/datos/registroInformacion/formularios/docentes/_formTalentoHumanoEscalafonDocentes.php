<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>

<div id="tabs-2">
<form action="save.php" method="post" id="form_escalafon">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoDocentesEscalafon" />
            <input type="hidden" name="action" value="save" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            <input type="hidden" name="idsiq_formTalentoHumanoDocentesEscalafon" value="" id="idsiq_formTalentoHumanoDocentesEscalafon" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Docentes por escalafón docente</legend>
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,2,$('#form_escalafon #mes').val()+'-'+$('#form_escalafon #anio').val())","popup_verDocumentos(5,2,$('#form_escalafon #mes').val()+'-'+$('#form_escalafon #anio').val())"); ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />                   
            
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Docentes por escalafón docente</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Escalafón Docente</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th> 
                            <!--<th class="column" ><span>Dato verificado</span></th> -->
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column">Profesor Titular <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAcademicosPTitular" id="numAcademicosPTitular" title="Académicos Titulates" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosPTitular" value="1" id="vnumAcademicosPTitular" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Profesor Asociado <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAcademicosPAsociado" id="numAcademicosPAsociado" title="Académicos Asociados" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosPAsociado" value="1" id="vnumAcademicosPAsociado" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Profesor Asistente <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAcademicosPAsistente" id="numAcademicosPAsistente" title="Académicos Asistentes" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosPAsistente" value="1" id="vnumAcademicosPAsistente" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Instructor Asociado <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAcademicosIAsociado" id="numAcademicosIAsociado" title="Académicos como Instructor Asociado" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosIAsociado" value="1" id="vnumAcademicosIAsociado" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Instructor Asistente <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAcademicosIAsistente" id="numAcademicosIAsistente" title="Académicos como Instructor Asistente" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosIAsistente" value="1" id="vnumAcademicosIAsistente" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Sin Escalafón <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAcademicosOtros" id="numAcademicosOtros" title="Otros Académicos" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosOtros" value="1" id="vnumAcademicosOtros" >
                            </td>-->
                        </tr>
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitEscalafon" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataEscalafon();
    
                $('#submitEscalafon').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_escalafon");
                    if(valido){
                        sendFormEscalafon();
                    }
                });
                
       //         $('#form_escalafon #codigoperiodo').change(function(event) {
      $('#form_escalafon #mes').add($('#form_escalafon #anio')).bind('change', function(event) {
                 getDataEscalafon();
                });
                
                function getDataEscalafon(){
                    var periodo = $('#form_escalafon #mes').val()+"-"+$('#form_escalafon #anio').val();
                    var entity = $("#form_escalafon #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo", verificar: true },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formTalentoHumanoDocentesEscalafon").val(data.data.idsiq_formTalentoHumanoDocentesEscalafon);
                                 $("#numAcademicosPTitular").val(data.data.numAcademicosPTitular);
                                 $("#numAcademicosPAsociado").val(data.data.numAcademicosPAsociado);
                                 $("#numAcademicosPAsistente").val(data.data.numAcademicosPAsistente);
                                 $("#numAcademicosIAsociado").val(data.data.numAcademicosIAsociado);
                                 $("#numAcademicosIAsistente").val(data.data.numAcademicosIAsistente);
                                 $("#numAcademicosOtros").val(data.data.numAcademicosOtros);
                                 
                                 /*if(data.datav.vnumAcademicosPTitular==1){
                                     $('input[name=vnumAcademicosPTitular]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosPTitular]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosPAsociado==1){
                                     $('input[name=vnumAcademicosPAsociado]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosPAsociado]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosPAsistente==1){
                                     $('input[name=vnumAcademicosPAsistente]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosPAsistente]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosIAsociado==1){
                                     $('input[name=vnumAcademicosIAsociado]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosIAsociado]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosIAsistente==1){
                                     $('input[name=vnumAcademicosIAsistente]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosIAsistente]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosOtros==1){
                                     $('input[name=vnumAcademicosOtros]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosOtros]').attr('checked', false);
                                 }*/
                                 
                                 $("#form_escalafon #action").val("update");
                                 //$("#form_escalafon #verificada_"+data.data.verificada).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formTalentoHumanoDocentesEscalafon").val()!=""){
                                        var mes = $('#form_escalafon #mes').val();
                                        var anio = $('#form_escalafon #anio').val();
                                    document.forms["form_escalafon"].reset();                                  
                                            $('#form_escalafon #mes').val(mes);
                                            $('#form_escalafon #anio').val(anio);
                                    $("#form_escalafon #action").val("save");
                                    $("#idsiq_formTalentoHumanoDocentesEscalafon").val("");
                                    $('input:checkbox').removeAttr('checked');
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormEscalafon(){
                var periodo = $('#form_escalafon #mes').val()+"-"+$('#form_escalafon #anio').val();
                $('#form_escalafon #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_escalafon').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#idsiq_formTalentoHumanoDocentesEscalafon").val(data.message);
                                 $("#form_escalafon #action").val("update");
                                 $('#form_escalafon #msg-success').css('display','block');
                                 $("#form_escalafon #msg-success").delay(5500).fadeOut(800);
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
