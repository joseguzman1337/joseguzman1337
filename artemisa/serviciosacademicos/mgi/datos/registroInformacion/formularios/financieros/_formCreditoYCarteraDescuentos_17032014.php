<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $actividades = $utils->getActives($db,"siq_tipoDescuento","nombre");
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_descuentos">
            <input type="hidden" name="entity" id="entity" value="detalleformCreditoYCarteraDescuentos" />
            <input type="hidden" name="action" value="saveDynamic" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="valor">   
                <legend>Estudiantes que se han beneficiado por descuentos</legend>                                    
                <label class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />     
                
                                <?php $utils->pintarBotonCargar("popup_cargarDocumento(12,1,$('#form_descuentos #semestre').val())","popup_verDocumentos(12,1,$('#form_descuentos #semestre').val())"); ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Estudiantes que se han Beneficiado por Descuentos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">                            
                            <th class="column" ><span>Descuentos</span></th>
                            <th class="column" ><span>Número de Estudiantes Beneficiados</span></th>                                                        
                        </tr>                        
                     </thead>
                     <tbody>
                         <?php while ($row = $actividades->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_tipoDescuento"]; ?>" value="<?php echo $row["idsiq_tipoDescuento"]; ?>" />
                                    <input type="hidden" name="idsiq_detalleformCreditoYCarteraDescuentos[]" value="" id="idsiq_detalleformCreditoYCarteraDescuentos_<?php echo $row["idsiq_tipoDescuento"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoDescuento"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoDescuento"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoDescuento"]; ?>" >
                                </td>-->
                            </tr>
   
                        <?php } ?>                        
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitcreditoycarteradescuentos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDatadescuentos();
    
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
    
                $('#submitcreditoycarteradescuentos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_descuentos");
                    if(valido){
                        sendFormdescuentos();
                    }
                });
                
                $('#form_descuentos #semestre').bind('change', function(event) {
                    getDatadescuentos();
                });
                
                function getDatadescuentos(){
                    var periodo = $('#form_descuentos #semestre').val();
                    var entity = $("#form_descuentos #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic", entity: entity, 
                            campoPeriodo: "codigoperiodo", entityJoin: "siq_tipoDescuento",
                            campoJoin: "idCategory",order:"ORDER BY nombre ASC"},     
                        success:function(data){
                            if (data.success == true){
                                var i=0
                                 $('#form_descuentos input[name="idCategory[]"]').each(function() {                                     
                                        $(this).val(data.data[i]["idCategory"]);
                                        $("#idsiq_detalleformCreditoYCarteraDescuentos_"+data.data[i]["idCategory"]).val(data.data[i]["idsiq_detalleformCreditoYCarteraDescuentos"]);
                                        $("#form_descuentos #valor_"+data.data[i]["idCategory"]).val(data.data[i]["valor"]);                                        
                                        
                                        /*if(data.data[i]["verificada"]==1){
                                             $("#veri_"+data.data[i]["idCategory"]).attr('checked', true);
                                        } else {
                                             $("#veri_"+data.data[i]["idCategory"]).attr('checked', false);
                                        }
                                        $("#verificada_"+data.data[i]["idCategory"]).val(data.data[i]["verificada"]);*/
                                        i = i + 1;
                                    });
                                 $("#form_descuentos #action").val("updateDynamic");
                                 //$("#form_descuentos #verificada_"+data.data[0]["verificada"]).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                var i = 0;
                                $('#form_descuentos input[name="idsiq_detalleformCreditoYCarteraDescuentos[]"]').each(function() {
                                       if( ($(this).val()!="") && (i==0)){
                                           var semestre = $('#form_descuentos #semestre').val();                                        
                                             document.forms["form_descuentos"].reset();
                                                    $('#form_descuentos #semestre').val(semestre);                                            
                                   $("#form_descuentos #action").val("saveDynamic"); 
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

                function sendFormdescuentos(){
                var periodo = $('#form_descuentos #semestre').val();
                $('#form_descuentos #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_descuentos').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#form_descuentos #action").val("updateDynamic");
                                 $('#form_descuentos #msg-success').css('display','block');
                                 $("#form_descuentos #msg-success").delay(5500).fadeOut(800);
                                 var i=0
                                 $('#form_descuentos input[name="idsiq_detalleformCreditoYCarteraDescuentos[]"]').each(function() {
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
