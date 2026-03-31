<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>


<div id="tabs-4">
<form action="save.php" method="post" id="form_prestamos">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoPrestamosCondonables" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formTalentoHumanoPrestamosCondonables" value="" id="idsiq_formTalentoHumanoPrestamosCondonables" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Préstamos Condonables (Aprobados - Efectivos)</legend>
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />     
                
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,5,$('#form_prestamos #mes').val()+'-'+$('#form_prestamos #anio').val())","popup_verDocumentos(5,5,$('#form_prestamos #mes').val()+'-'+$('#form_prestamos #anio').val())"); ?>
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Préstamos Condonables (Aprobados por Consejo Directivo)</span></th>                                    
                        </tr>         
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Ámbito</span></th>   
                            <th class="column borderR" colspan="3"><span>Nivel de Formación</span></th>   
                            <th class="column" rowspan="2"><span>Valor</span></th>                                  
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Especialización</span></th> 
                            <th class="column" ><span>Maestría</span></th> 
                            <th class="column borderR" ><span>Doctorado</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column borderR">Nacional <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-8-12 required number" minlength="1" name="valorNacionalEspecializacion" id="valorNacionalEspecializacion" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column"> 
                                <input type="text"  class="grid-8-12 required number" minlength="1" name="valorNacionalMaestria" id="valorNacionalMaestria" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column borderR"> 
                                <input type="text"  class="grid-8-12 required number" minlength="1" name="valorNacionalDoctorado" id="valorNacionalDoctorado" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column"> 
                                <input type="text"  class="grid-12-12 required number" minlength="1" name="valorTotalNacional" id="valorTotalNacional" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column borderR">Internacional <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-8-12 required number" minlength="1" name="valorInternacionalEspecializacion" id="valorInternacionalEspecializacion" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column">     
                                <input type="text"  class="grid-8-12 required number" minlength="1" name="valorInternacionalMaestria" id="valorInternacionalMaestria" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column borderR">     
                                <input type="text"  class="grid-8-12 required number" minlength="1" name="valorInternacionalDoctorado" id="valorInternacionalDoctorado" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td> <td class="column">     
                                <input type="text"  class="grid-12-12 required number" minlength="1" name="valorTotalInternacional" id="valorTotalInternacional" maxlength="20" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitPrestamos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataPrestamos();
	$(function(){
	  $("#form_prestamos input").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:0,allowNegative:false, defaultZero:false});
	});
    
                $('#submitPrestamos').click(function(event) {
                    event.preventDefault();
				replaceCommas("#form_prestamos");
                    var valido= validateForm("#form_prestamos");
                    if(valido){
                        sendFormPrestamos();
                    }
                });
                
                $('#form_prestamos #mes').add($('#form_prestamos #anio')).bind('change', function(event) {
                    getDataPrestamos();
                });
                
                function getDataPrestamos(){
                    var periodo = $('#form_prestamos #mes').val()+"-"+$('#form_prestamos #anio').val();
                    var entity = $("#form_prestamos #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo" },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formTalentoHumanoPrestamosCondonables").val(data.data.idsiq_formTalentoHumanoPrestamosCondonables);
                                 $("#valorNacionalEspecializacion").val(data.data.valorNacionalEspecializacion);
                                 $("#valorNacionalMaestria").val(data.data.valorNacionalMaestria);
                                 $("#valorNacionalDoctorado").val(data.data.valorNacionalDoctorado);
                                 $("#valorInternacionalEspecializacion").val(data.data.valorInternacionalEspecializacion);
                                 $("#valorInternacionalMaestria").val(data.data.valorInternacionalMaestria);
                                 $("#valorInternacionalDoctorado").val(data.data.valorInternacionalDoctorado);
                                 $("#valorTotalInternacional").val(data.data.valorTotalInternacional);
                                 $("#valorTotalNacional").val(data.data.valorTotalNacional);
								 addCommas("#form_prestamos");
                                 $("#form_prestamos #action").val("update");
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formTalentoHumanoPrestamosCondonables").val()!=""){
                                    var mes = $('#form_prestamos #mes').val();
                                        var anio = $('#form_prestamos #anio').val();
                                        document.forms["form_prestamos"].reset();
                                   $('#form_prestamos #mes').val(mes);
                                            $('#form_prestamos #anio').val(anio);
                                    $("#form_prestamos #action").val("save");
                                    $("#idsiq_formTalentoHumanoPrestamosCondonables").val("");
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormPrestamos(){
                var periodo = $('#form_prestamos #mes').val()+"-"+$('#form_prestamos #anio').val();
                $('#form_prestamos #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_prestamos').serialize(),                
                        success:function(data){
								 addCommas("#form_prestamos");
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#idsiq_formTalentoHumanoPrestamosCondonables").val(data.message);
                                 $("#form_prestamos #action").val("update");
                                 $('#form_prestamos #msg-success').css('display','block');
                                 $("#form_prestamos #msg-success").delay(5500).fadeOut(800);
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
