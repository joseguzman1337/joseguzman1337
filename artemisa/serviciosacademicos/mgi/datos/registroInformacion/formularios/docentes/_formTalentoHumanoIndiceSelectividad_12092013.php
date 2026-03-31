<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $actividades = $utils->getActives($db,"siq_dedicacionPersonal","nombre");
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_indices">
            <input type="hidden" name="entity" id="entity" value="formTalentoIndiceSelectividad" />
            <input type="hidden" name="action" value="saveDynamic" id="action" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Índice de selectividad de los académicos</legend>                  
                <!--<label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php //$utils->getSemestresSelect($db);  ?>-->
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />             
                
                <div class="vacio"></div>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,6,$('#form_indices #codigoperiodo').val())","popup_verDocumentos(5,6,$('#form_indices #codigoperiodo').val())"); ?>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Índice de selectividad de los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Dedicación</span></th> 
                            <th class="column" ><span>Número procesos de selección</span></th> 
                            <th class="column" ><span>Número de Aspirantes</span></th> 
                            <th class="column" ><span>Número de seleccionados</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $actividades->FetchRow()) { 
                             $idCat = $row["idsiq_dedicacionPersonal"];
                             ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idDedicacion[]" id="idDedicacion_<?php echo $idCat; ?>" value="<?php echo $idCat; ?>" />
                                    <input type="hidden" name="idsiq_formTalentoIndiceSelectividad[]" value="" id="idsiq_formTalentoIndiceSelectividad_<?php echo $idCat; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-5-12 required number" minlength="1" name="numProcesosSeleccion[]" id="numProcesosSeleccion_<?php echo $idCat; ?>" maxlength="10" tabindex="1" autocomplete="off" value="" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-8-12 required number" minlength="1" name="numAspirantes[]" id="numAspirantes_<?php echo $idCat; ?>" maxlength="30" tabindex="1" autocomplete="off" value="" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-8-12 required number" minlength="1" name="numSeleccionados[]" id="numSeleccionados_<?php echo $idCat; ?>" maxlength="30" tabindex="1" autocomplete="off" value="" />
                                </td>
                            </tr>
   
                        <?php } ?>                        
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitIndices" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
        getDataIndices();
    
                $('#submitIndices').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_indices");
                    if(valido){
                        sendFormIndices();
                    }
                });
                
                /*$('#form_indices #codigoperiodo').change(function(event) {
                    getDataIndices();
                });*/
    $('#form_indices #mes').add($('#form_indices #anio')).bind('change', function(event) {
          getDataIndices();
    });
                
                function getDataIndices(){
                    //var periodo = $('#form_indices #codigoperiodo').val();
                    var periodo = $('#form_indices #mes').val()+"-"+$('#form_indices #anio').val();
                    var entity = $("#form_indices #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic", entity: entity, 
                            campoPeriodo: "codigoperiodo", entityJoin: "siq_dedicacionPersonal",
                            campoJoin: "idDedicacion"},     
                        success:function(data){
                            if (data.success == true){
                                var i=0
                                 $('input[name="idDedicacion[]"]').each(function() {                                     
                                        $(this).val(data.data[i]["idDedicacion"]);
                                        $("#idsiq_formTalentoIndiceSelectividad_"+data.data[i]["idDedicacion"]).val(data.data[i]["idsiq_formTalentoIndiceSelectividad"]);
                                        $("#numProcesosSeleccion_"+data.data[i]["idDedicacion"]).val(data.data[i]["numProcesosSeleccion"]);
                                        $("#numAspirantes_"+data.data[i]["idDedicacion"]).val(data.data[i]["numAspirantes"]);
                                        $("#numSeleccionados_"+data.data[i]["idDedicacion"]).val(data.data[i]["numSeleccionados"]);
                                        
                                        i = i + 1;
                                    });
                                 $("#form_indices #action").val("updateDynamic");
                            }
                            else{                        
                                //no se encontraron datos
                                var i = 0;
                                $('input[name="idsiq_formTalentoIndiceSelectividad[]"]').each(function() {
                                       if( ($(this).val()!="") && (i==0)){
                                          // var periodo = $('#form_indices #codigoperiodo').val();                                          
                                        var mes = $('#form_indices #mes').val();
                                        var anio = $('#form_indices #anio').val();
                                            document.forms["form_indices"].reset();
                                           // $('#form_indices #codigoperiodo').val(periodo);                                           
                                            $('#form_indices #mes').val(mes);
                                            $('#form_indices #anio').val(anio);
                                            $("#form_indices #action").val("saveDynamic"); 
                                       } 
                                       $(this).val("");
                                       i = 1;
                                });
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormIndices(){
                var periodo = $('#form_indices #mes').val()+"-"+$('#form_indices #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_indices').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#form_indices #action").val("updateDynamic");
                                 $('#form_indices #msg-success').css('display','block');
                                 $("#form_indices #msg-success").delay(5500).fadeOut(800);
                                 var i=0
                                 $('input[name="idsiq_formTalentoIndiceSelectividad[]"]').each(function() {
                                        $(this).val(data.data[i]);
                                        i = i + 1;
                                    });                                
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
