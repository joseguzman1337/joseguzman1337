<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>


<div id="tabs-4">
<form action="save.php" method="post" id="form_desvinculados">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoAcademicosDesvinculados" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="verificar" value="1" id="verificar" />
            <input type="hidden" name="idsiq_formTalentoHumanoAcademicosDesvinculados" value="" id="idsiq_formTalentoHumanoAcademicosDesvinculados" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Académicos desvinculados</legend>
                
                <label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db);  ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Académicos desvinculados</span></th>                                    
                        </tr>         
                        <tr class="dataColumns category">
                            <th class="column borderR"><span>Motivo del retiro</span></th>   
                            <th class="column borderR"><span>Número de Académicos</span></th>    
                            <th class="column" ><span>Dato verificado</span></th>                                 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column borderR">Terminación de Contrato <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number disable" minlength="1" name="numTerminacionContrato" id="numTerminacionContrato" maxlength="20" tabindex="1" autocomplete="off" value="" readonly />
                            </td> 
                            <td class="column center"> 
                                <input type="checkbox" name="vnumTerminacionContrato" value="1" id="vnumTerminacionContrato" >
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Renuncia por nueva oportunidad laboral <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number disable" minlength="1" name="numRenunciaOportunidad" id="numRenunciaOportunidad" maxlength="20" tabindex="1" autocomplete="off" value="" readonly />
                            </td> 
                            <td class="column center"> 
                                <input type="checkbox" name="vnumRenunciaOportunidad" value="1" id="vnumRenunciaOportunidad" >
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Renuncia por motivos personales <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number disable" minlength="1" name="numRenunciaMotivosPersonales" id="numRenunciaMotivosPersonales" maxlength="20" tabindex="1" autocomplete="off" value="" readonly />
                            </td> 
                            <td class="column center"> 
                                <input type="checkbox" name="vnumRenunciaMotivosPersonales" value="1" id="vnumRenunciaMotivosPersonales" >
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Renuncia  por mejores condiciones laborales <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number disable" minlength="1" name="numRenunciaCondicionesLaborales" id="numRenunciaCondicionesLaborales" maxlength="20" tabindex="1" autocomplete="off" value="" readonly />
                            </td> 
                            <td class="column center"> 
                                <input type="checkbox" name="vnumRenunciaCondicionesLaborales" value="1" id="vnumRenunciaCondicionesLaborales" >
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Renuncia por viaje <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number disable" minlength="1" name="numRenunciaViaje" id="numRenunciaViaje" maxlength="20" tabindex="1" autocomplete="off" value="" readonly />
                            </td> 
                            <td class="column center"> 
                                <input type="checkbox" name="vnumRenunciaViaje" value="1" id="vnumRenunciaViaje" >
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Despido <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number disable" minlength="1" name="numDespido" id="numDespido" maxlength="20" tabindex="1" autocomplete="off" value="" readonly />
                            </td> 
                            <td class="column center"> 
                                <input type="checkbox" name="vnumDespido" value="1" id="vnumDespido" >
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Otro <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number disable" minlength="1" name="numOtro" id="numOtro" maxlength="20" tabindex="1" autocomplete="off" value="" readonly />
                            </td> 
                            <td class="column center"> 
                                <input type="checkbox" name="vnumOtro" value="1" id="vnumOtro" >
                            </td>
                        </tr>
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
           <input type="submit" id="submitDesvinculados" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataDesvinculados();
    
                $('#submitDesvinculados').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_desvinculados");
                    if(valido){
                        sendFormDesvinculados();
                    }
                });
                
                $('#form_desvinculados #codigoperiodo').change(function(event) {
                    getDataDesvinculados();
                });
                
                function getDataDesvinculados(){
                    var periodo = $('#form_desvinculados #codigoperiodo').val();
                    var entity = $("#form_desvinculados #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo", verificar: true },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formTalentoHumanoAcademicosDesvinculados").val(data.data.idsiq_formTalentoHumanoAcademicosDesvinculados);
                                 $("#numTerminacionContrato").val(data.data.numTerminacionContrato);
                                 $("#numRenunciaOportunidad").val(data.data.numRenunciaOportunidad);
                                 $("#numRenunciaMotivosPersonales").val(data.data.numRenunciaMotivosPersonales);
                                 $("#numRenunciaCondicionesLaborales").val(data.data.numRenunciaCondicionesLaborales);
                                 $("#numRenunciaViaje").val(data.data.numRenunciaViaje);
                                 $("#numDespido").val(data.data.numDespido);
                                 $("#numOtro").val(data.data.numOtro);
                                 
                                 if(data.datav.vnumTerminacionContrato==1){
                                     $('input[name=vnumTerminacionContrato]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumTerminacionContrato]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumRenunciaOportunidad==1){
                                     $('input[name=vnumRenunciaOportunidad]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumRenunciaOportunidad]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumRenunciaMotivosPersonales==1){
                                     $('input[name=vnumRenunciaMotivosPersonales]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumRenunciaMotivosPersonales]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumRenunciaCondicionesLaborales==1){
                                     $('input[name=vnumRenunciaCondicionesLaborales]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumRenunciaCondicionesLaborales]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumRenunciaViaje==1){
                                     $('input[name=vnumRenunciaViaje]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumRenunciaViaje]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumDespido==1){
                                     $('input[name=vnumDespido]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumDespido]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumOtro==1){
                                     $('input[name=vnumOtro]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumOtro]').attr('checked', false);
                                 }
                                 
                                 $("#form_desvinculados #action").val("update");
                                 //$("#form_desvinculados #verificada_"+data.data.verificada).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formTalentoHumanoAcademicosDesvinculados").val()!=""){
                                    var periodo = $('#form_desvinculados #codigoperiodo').val();
                                    document.forms["form_desvinculados"].reset();
                                    $('#form_desvinculados #codigoperiodo').val(periodo);
                                    $("#form_desvinculados #action").val("save");
                                    $("#idsiq_formTalentoHumanoAcademicosDesvinculados").val("");
                                    $('input:checkbox').removeAttr('checked');
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormDesvinculados(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_desvinculados').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#idsiq_formTalentoHumanoAcademicosDesvinculados").val(data.message);
                                 $("#form_desvinculados #action").val("update");
                                 $('#form_desvinculados #msg-success').css('display','block');
                                 $("#form_desvinculados #msg-success").delay(5500).fadeOut(800);
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
