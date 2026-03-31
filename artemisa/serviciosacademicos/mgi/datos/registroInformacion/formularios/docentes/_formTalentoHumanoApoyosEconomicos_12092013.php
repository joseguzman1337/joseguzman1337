<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>


<div id="tabs-4">
<form action="save.php" method="post" id="form_apoyos">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoApoyosEconomicos" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formTalentoHumanoApoyosEconomicos" value="" id="idsiq_formTalentoHumanoApoyosEconomicos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Apoyos económicos (Aprobados por Consejo Directivo)</legend>
                
                <label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db);  ?>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Apoyos económicos (Aprobados por Consejo Directivo)</span></th>                                    
                        </tr>         
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Ámbito</span></th>   
                            <th class="column" colspan="3"><span>Tipo de evento</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Congreso</span></th> 
                            <th class="column" ><span>Diplomado</span></th> 
                            <th class="column" ><span>Taller</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column borderR">Nacional <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-12-12 required number" minlength="1" name="valorNacionalCongreso" id="valorNacionalCongreso" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column"> 
                                <input type="text"  class="grid-12-12 required number" minlength="1" name="valorNacionalDiplomado" id="valorNacionalDiplomado" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column"> 
                                <input type="text"  class="grid-12-12 required number" minlength="1" name="valorNacionalTaller" id="valorNacionalTaller" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Internacional <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-12-12 required number" minlength="1" name="valorInternacionalCongreso" id="valorInternacionalCongreso" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column">     
                                <input type="text"  class="grid-12-12 required number" minlength="1" name="valorInternacionalDiplomado" id="valorInternacionalDiplomado" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column">     
                                <input type="text"  class="grid-12-12 required number" minlength="1" name="valorInternacionalTaller" id="valorInternacionalTaller" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitApoyos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataApoyos();
    
                $('#submitApoyos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_apoyos");
                    if(valido){
                        sendFormApoyos();
                    }
                });
                
                $('#form_apoyos #codigoperiodo').change(function(event) {
                    getDataApoyos();
                });
                
                function getDataApoyos(){
                    var periodo = $('#form_apoyos #codigoperiodo').val();
                    var entity = $("#form_apoyos #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo" },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formTalentoHumanoApoyosEconomicos").val(data.data.idsiq_formTalentoHumanoApoyosEconomicos);
                                 $("#valorNacionalCongreso").val(data.data.valorNacionalCongreso);
                                 $("#valorNacionalDiplomado").val(data.data.valorNacionalDiplomado);
                                 $("#valorNacionalTaller").val(data.data.valorNacionalTaller);
                                 $("#valorInternacionalCongreso").val(data.data.valorInternacionalCongreso);
                                 $("#valorInternacionalDiplomado").val(data.data.valorInternacionalDiplomado);
                                 $("#valorInternacionalTaller").val(data.data.valorInternacionalTaller);
                                 $("#form_apoyos #action").val("update");
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formTalentoHumanoApoyosEconomicos").val()!=""){
                                    var periodo = $('#form_apoyos #codigoperiodo').val();
                                    document.forms["form_apoyos"].reset();
                                    $('#form_apoyos #codigoperiodo').val(periodo);
                                    $("#form_apoyos #action").val("save");
                                    $("#idsiq_formTalentoHumanoApoyosEconomicos").val("");
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormApoyos(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_apoyos').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#idsiq_formTalentoHumanoApoyosEconomicos").val(data.message);
                                 $("#form_apoyos #action").val("update");
                                 $('#form_apoyos #msg-success').css('display','block');
                                 $("#form_apoyos #msg-success").delay(5500).fadeOut(800);
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
