<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $actividades = $utils->getActives($db,"siq_talentohumano_docente_escalafon","orden");
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_dedicacionescalafon">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoDedicacionEscalafon" />
            <input type="hidden" name="action" value="saveDynamic" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="cuartoTiempo">   
                <legend>Dedicación Semanal de Acuerdo a la Categorización de la Universidad El Bosque / Escalafón docente</legend>                  
                  <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />     
                
                                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,4,$('#form_dedicacionescalafon #mes').val()+'-'+$('#form_dedicacionescalafon #anio').val())","popup_verDocumentos(5,4,$('#form_dedicacionescalafon #mes').val()+'-'+$('#form_dedicacionescalafon #anio').val())"); ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Dedicación Semanal de Acuerdo a la Categorización de la Universidad El Bosque / Escalafón docente</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Escalafón Docente</span></th> 
                            <th class="column borderR" rowspan="2"><span>1/4 Tiempo</span></th> 
                            <th class="column borderR" ><span>1/2 Tiempo</span></th>
                            <th class="column borderR" ><span>3/4 Tiempo</span></th>
                            <th class="column borderR" ><span>Tiempo Completo</span></th> 
                            <!--<th class="column" ><span>Dato verificado</span></th>    -->   
                        </tr>
                        <tr class="dataColumns category">
			    <th class="column borderR" ><span>11-20 Horas</span></th>
                            <th class="column borderR" ><span>21-30 Horas</span></th>
                            <th class="column borderR" ><span>31-40 Horas</span></th>
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $actividades->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idTalentoEscalafon[]" id="idTalentoEscalafon_<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" value="<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" />
                                    <input type="hidden" name="idsiq_formTalentoHumanoDedicacionEscalafon[]" value="" id="idsiq_formTalentoHumanoDedicacionEscalafon_<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" />
                                </td>
                                <td class="column borderR"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="cuartoTiempo[]" id="cuartoTiempo_<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value=""  />
                                </td>
                                <td class="column borderR"> 
                                    <input type="text"  class="grid-10-12 required number" minlength="1" name="medioTiempo[]" id="medioTiempo_<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>
                                <td class="column borderR"> 
                                    <input type="text"  class="grid-10-12 required number" minlength="1" name="tresCuartosTiempo[]" id="tresCuartosTiempo_<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-10-12 required number" minlength="1" name="completoTiempo[]" id="completoTiempo_<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_talentohumano_docente_escalafon"]; ?>" >
                                </td>-->
                            </tr>
   
                        <?php } ?>                        
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitdedicacionescalafon" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDatadedicacionescalafon();
    
       /* $(document).ready(function(){  
      
            $(".verificarDato").change(function() {  
                if(this.checked) {  
                    var id = $(this).attr('id').replace("veri_","");
                    $("#verificada_"+id).val(1);
                } else {  
                    var id = $(this).attr('id').replace("veri_","");
                    $("#verificada_"+id).val(0);
                }  
            });  

        });  */
    
                $('#submitdedicacionescalafon').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_dedicacionescalafon");
                    if(valido){
                        sendFormdedicacionescalafon();
                    }
                });
                
                $('#form_dedicacionescalafon #mes').add($('#form_dedicacionescalafon #anio')).bind('change', function(event) {
                    getDatadedicacionescalafon();
                });
                
                function getDatadedicacionescalafon(){
                    var periodo = $('#form_dedicacionescalafon #mes').val()+"-"+$('#form_dedicacionescalafon #anio').val();
                    var entity = $("#form_dedicacionescalafon #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic", entity: entity, 
                            campoPeriodo: "codigoperiodo", entityJoin: "siq_talentohumano_docente_escalafon",
                            campoJoin: "idTalentoEscalafon",order:"ORDER BY nombre ASC"},     
                        success:function(data){
                            if (data.success == true){
                                var i=0
								for (var i=0;i<data.total;i++){
                                 //$('input[name="idTalentoEscalafon[]"]').each(function() {                                     
                                        $("#idTalentoEscalafon_"+data.data[i]["idTalentoEscalafon"]).val(data.data[i]["idTalentoEscalafon"]);
                                        $("#idsiq_formTalentoHumanoDedicacionEscalafon_"+data.data[i]["idTalentoEscalafon"]).val(data.data[i]["idsiq_formTalentoHumanoDedicacionEscalafon"]);
                                        $("#cuartoTiempo_"+data.data[i]["idTalentoEscalafon"]).val(data.data[i]["cuartoTiempo"]);
                                        $("#medioTiempo_"+data.data[i]["idTalentoEscalafon"]).val(data.data[i]["medioTiempo"]);
                                        $("#tresCuartosTiempo_"+data.data[i]["idTalentoEscalafon"]).val(data.data[i]["tresCuartosTiempo"]);
                                        $("#completoTiempo_"+data.data[i]["idTalentoEscalafon"]).val(data.data[i]["completoTiempo"]);
                                        
                                        /*if(data.data[i]["verificada"]==1){
                                             $("#veri_"+data.data[i]["idTalentoEscalafon"]).attr('checked', true);
                                        } else {
                                             $("#veri_"+data.data[i]["idTalentoEscalafon"]).attr('checked', false);
                                        }
                                        $("#verificada_"+data.data[i]["idTalentoEscalafon"]).val(data.data[i]["verificada"]);*/
                                        //i = i + 1;
                                    //});
									}
                                 $("#form_dedicacionescalafon #action").val("updateDynamic");
                                 //$("#form_dedicacionescalafon #verificada_"+data.data[0]["verificada"]).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                var i = 0;
                                $('input[name="idsiq_formTalentoHumanoDedicacionEscalafon[]"]').each(function() {
                                       if( ($(this).val()!="") && (i==0)){
                                           var mes = $('#form_dedicacionescalafon #mes').val();
                                        var anio = $('#form_dedicacionescalafon #anio').val();
                                             document.forms["form_dedicacionescalafon"].reset();
                                                    $('#form_dedicacionescalafon #mes').val(mes);
                                            $('#form_dedicacionescalafon #anio').val(anio);
                                   $("#form_dedicacionescalafon #action").val("saveDynamic"); 
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

                function sendFormdedicacionescalafon(){
                var periodo = $('#form_dedicacionescalafon #mes').val()+"-"+$('#form_dedicacionescalafon #anio').val();
                $('#form_dedicacionescalafon #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_dedicacionescalafon').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#form_dedicacionescalafon #action").val("updateDynamic");
                                 $('#form_dedicacionescalafon #msg-success').css('display','block');
                                 $("#form_dedicacionescalafon #msg-success").delay(5500).fadeOut(800);
                                 var i=0
                                 $('input[name="idsiq_formTalentoHumanoDedicacionEscalafon[]"]').each(function() {
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
