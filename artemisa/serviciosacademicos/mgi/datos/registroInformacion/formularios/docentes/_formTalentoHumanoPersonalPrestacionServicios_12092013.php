<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $actividades = $utils->getActives($db,"siq_actividadPrestacionServicios","nombre");
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_prestacion">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoPersonalPrestacionServicios" />
            <input type="hidden" name="action" value="saveDynamic" id="action" />
            <input type="hidden" name="verificar" value="1" id="verificar" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Personal por prestación de servicios</legend>                  
                <label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db); ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Personal por prestación de servicios</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Actividad</span></th> 
                            <th class="column" ><span>Número de Personas</span></th> 
                            <th class="column" ><span>Valor Total de los Servicios</span></th> 
                            <th class="column" ><span>Dato verificado</span></th>       
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $actividades->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idActividad[]" id="idActividad_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" value="<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" />
                                    <input type="hidden" name="idsiq_formTalentoHumanoPersonalPrestacionServicios[]" value="" id="idsiq_formTalentoHumanoPersonalPrestacionServicios_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-6-12 required number disable" minlength="1" name="numPersonas[]" id="numPersonas_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-9-12 required number disable" minlength="1" name="valorServicios[]" id="valorServicios_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value="" readonly />
                                </td>
                                <td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" >
                                </td>
                            </tr>
   
                        <?php } ?>                        
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitPrestacion" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataPrestacion();
    
        $(document).ready(function(){  
      
            $(".verificarDato").change(function() {  
                if(this.checked) {  
                    var id = $(this).attr('id').replace("veri_","");
                    $("#verificada_"+id).val(1);
                } else {  
                    var id = $(this).attr('id').replace("veri_","");
                    $("#verificada_"+id).val(0);
                }  
            });  

        });  
    
                $('#submitPrestacion').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_prestacion");
                    if(valido){
                        sendFormPrestacion();
                    }
                });
                
                $('#form_prestacion #codigoperiodo').change(function(event) {
                    getDataPrestacion();
                });
                
                function getDataPrestacion(){
                    var periodo = $('#form_prestacion #codigoperiodo').val();
                    var entity = $("#form_prestacion #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic", entity: entity, 
                            campoPeriodo: "codigoperiodo", entityJoin: "siq_actividadPrestacionServicios",
                            campoJoin: "idActividad",order:"ORDER BY nombre ASC"},     
                        success:function(data){
                            if (data.success == true){
                                var i=0
                                 $('input[name="idActividad[]"]').each(function() {                                     
                                        $(this).val(data.data[i]["idActividad"]);
                                        $("#idsiq_formTalentoHumanoPersonalPrestacionServicios_"+data.data[i]["idActividad"]).val(data.data[i]["idsiq_formTalentoHumanoPersonalPrestacionServicios"]);
                                        $("#numPersonas_"+data.data[i]["idActividad"]).val(data.data[i]["numPersonas"]);
                                        $("#valorServicios_"+data.data[i]["idActividad"]).val(data.data[i]["valorServicios"]);
                                        
                                        if(data.data[i]["verificada"]==1){
                                             $("#veri_"+data.data[i]["idActividad"]).attr('checked', true);
                                        } else {
                                             $("#veri_"+data.data[i]["idActividad"]).attr('checked', false);
                                        }
                                        $("#verificada_"+data.data[i]["idActividad"]).val(data.data[i]["verificada"]);
                                        i = i + 1;
                                    });
                                 $("#form_prestacion #action").val("updateDynamic");
                                 //$("#form_prestacion #verificada_"+data.data[0]["verificada"]).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                var i = 0;
                                $('input[name="idsiq_formTalentoHumanoPersonalPrestacionServicios[]"]').each(function() {
                                       if( ($(this).val()!="") && (i==0)){
                                           var periodo = $('#form_prestacion #codigoperiodo').val();
                                            document.forms["form_prestacion"].reset();
                                            $('#form_prestacion #codigoperiodo').val(periodo);
                                            $("#form_prestacion #action").val("saveDynamic"); 
                                       } 
                                       $(this).val("");
                                       i = 1;
                                });
                                $('input:checkbox').removeAttr('checked');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormPrestacion(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_prestacion').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#form_prestacion #action").val("updateDynamic");
                                 $('#form_prestacion #msg-success').css('display','block');
                                 $("#form_prestacion #msg-success").delay(5500).fadeOut(800);
                                 var i=0
                                 $('input[name="idsiq_formTalentoHumanoPersonalPrestacionServicios[]"]').each(function() {
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
