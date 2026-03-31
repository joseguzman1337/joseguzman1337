<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>


<div id="tabs-4">
<form action="save.php" method="post" id="form_desvinculados">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoAcademicosDesvinculados" />
            <input type="hidden" name="action" value="save" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            <input type="hidden" name="idsiq_formTalentoHumanoAcademicosDesvinculados" value="" id="idsiq_formTalentoHumanoAcademicosDesvinculados" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Académicos desvinculados</legend>
                
               <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />             
                
                <div class="vacio"></div>
                
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,7,$('#form_desvinculados #mes').val()+'-'+$('#form_desvinculados #anio').val())","popup_verDocumentos(5,7,$('#form_desvinculados #mes').val()+'-'+$('#form_desvinculados #anio').val())"); ?>
                
                
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
                            <!--<th class="column" ><span>Dato verificado</span></th>  -->                               
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column borderR">Abandono de cargo <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numAbandono" id="numAbandono" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> 
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Despido <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numDespido" id="numDespido" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> 
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Realización de Estudios <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numEstudios" id="numEstudios" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> 
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Reconocimiento de pensión <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numPension" id="numPension" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> 
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Renuncia por motivos personales <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numRenunciaMotivosPersonales" id="numRenunciaMotivosPersonales" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> 
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Renuncia por nueva oportunidad laboral <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numRenunciaOportunidad" id="numRenunciaOportunidad" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> 
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Renuncia por viaje <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numRenunciaViaje" id="numRenunciaViaje" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> 
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Terminación de Contrato a término fijo <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numTerminacionContrato" id="numTerminacionContrato" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> 
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Otros <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-5-12 required number" minlength="1" name="numOtro" id="numOtro" maxlength="20" tabindex="1" autocomplete="off" value="" />
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
                
    $('#form_desvinculados #mes').add($('#form_desvinculados #anio')).bind('change', function(event) {
                    getDataDesvinculados();
                });
                
                function getDataDesvinculados(){
                    var periodo = $('#form_desvinculados #mes').val()+"-"+$('#form_desvinculados #anio').val();
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
                                 $("#numAbandono").val(data.data.numAbandono);
                                 $("#numRenunciaViaje").val(data.data.numRenunciaViaje);
                                 $("#numEstudios").val(data.data.numEstudios);
                                 $("#numDespido").val(data.data.numDespido);
                                 $("#numPension").val(data.data.numPension);
                                 $("#numOtro").val(data.data.numOtro);
                                 
                                 /*if(data.datav.vnumTerminacionContrato==1){
                                     $('input[name=vnumTerminacionContrato]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumTerminacionContrato]').attr('checked', false);
                                 }*/
                                 
                                 $("#form_desvinculados #action").val("update");
                                 //$("#form_desvinculados #verificada_"+data.data.verificada).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formTalentoHumanoAcademicosDesvinculados").val()!=""){
                                    var mes = $('#form_desvinculados #mes').val();
                                        var anio = $('#form_desvinculados #anio').val();
                                        document.forms["form_desvinculados"].reset();
                                    $('#form_desvinculados #mes').val(mes);
                                            $('#form_desvinculados #anio').val(anio);
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
                var periodo = $('#form_desvinculados #mes').val()+"-"+$('#form_desvinculados #anio').val();
                $('#form_desvinculados #codigoperiodo').val(periodo);
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
