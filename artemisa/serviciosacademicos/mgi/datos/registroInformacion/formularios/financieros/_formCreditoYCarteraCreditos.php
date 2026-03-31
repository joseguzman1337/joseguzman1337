<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_creditos">
            <input type="hidden" name="entity" id="entity" value="formCreditoYCarteraCreditos" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formCreditoYCarteraCreditos" value="" id="idsiq_formCreditoYCarteraCreditos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Estudiantes que se han beneficiado por créditos </legend>
                
                <label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db);  ?>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Estudiantes que se han beneficiado por créditos </span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Entidad de financiamiento</span></th> 
                            <th class="column" ><span>Número de estudiantes beneficiados</span></th> 
                            <th class="column" ><span>Valor Financiado</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Entidad Financiera <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numEntidadFinanciera" id="numEntidadFinanciera" title="Total de Estudiantes por Entidad Financiera" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text" class="grid-12-12 required number" minlength="1" name="valorEntidadFinanciera" id="valorEntidadFinanciera" title="Valor Estudiantes por Entidad Financiera" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">ICETEX <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numICETEX" id="numICETEX" title="Total de Estudiantes por ICETEX" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text" class="grid-12-12 required number" minlength="1" name="valorICETEX" id="valorICETEX" title="Valor Estudiantes por ICETEXT" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Crédito de la Universidad <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numCreditoUniversidad" id="numCreditoUniversidad" title="Total de Estudiantes por Crédito Universidad" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column">
                                <input type="text" class="grid-12-12 required number" minlength="1" name="valorCreditoUniversidad" id="valorCreditoUniversidad" title="Valor Estudiantes por Crédito Universidad" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitCreditos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    var formName3 = "#form_creditos";
    getDataCreditos(formName3);
    
                $('#submitCreditos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm(formName3);
                    if(valido){
                        sendFormCreditos(formName3);
                    }
                });
                
                $(formName3 + ' #codigoperiodo').change(function(event) {
                    getDataCreditos(formName3);
                });
                
                function getDataCreditos(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/financieros/saveCreditoYCartera.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo" },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formCreditoYCarteraCreditos").val(data.data.idsiq_formCreditoYCarteraCreditos);
                                 $("#numEntidadFinanciera").val(data.data.numEntidadFinanciera);
                                 $("#valorEntidadFinanciera").val(data.data.valorEntidadFinanciera);
                                 $("#numICETEX").val(data.data.numICETEX);
                                 $("#valorICETEX").val(data.data.valorICETEX);
                                 $("#numCreditoUniversidad").val(data.data.numICETEX);
                                 $("#valorCreditoUniversidad").val(data.data.valorICETEX);
                                 $(formName + " #action").val("update");
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formCreditoYCarteraCreditos").val()!=""){
                                    var periodo = $(formName + ' #codigoperiodo').val();
                                    document.forms[formName.replace("#","")].reset();
                                    $(formName + ' #codigoperiodo').val(periodo);
                                    $(formName + " #action").val("save");
                                    $("#idsiq_formCreditoYCarteraCreditos").val("");
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormCreditos(formName){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/financieros/saveCreditoYCartera.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formCreditoYCarteraCreditos").val(data.message);
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
