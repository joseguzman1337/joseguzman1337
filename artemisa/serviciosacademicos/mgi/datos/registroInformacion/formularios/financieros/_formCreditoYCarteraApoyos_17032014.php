<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $actividades = $utils->getActives($db,"siq_tipoApoyo","nombre");
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_apoyos">
            <input type="hidden" name="entity" id="entity" value="formCreditoYCarteraApoyos" />
            <input type="hidden" name="action" value="saveDynamic" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="valor">   
                <legend>Estudiantes que se han beneficiado por apoyos o estímulos</legend>                                    
                <label class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />     
                
                                <?php $utils->pintarBotonCargar("popup_cargarDocumento(12,2,$('#form_apoyos #semestre').val())","popup_verDocumentos(12,2,$('#form_apoyos #semestre').val())"); ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Estudiantes que se han Beneficiado por Apoyos o Estímulos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">                            
                            <th class="column" ><span>Apoyos o Estímulos</span></th>
                            <th class="column" ><span>Número de Estudiantes Beneficiados</span></th>                                                        
                        </tr>                        
                     </thead>
                     <tbody>
                         <?php while ($row = $actividades->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_tipoApoyo"]; ?>" value="<?php echo $row["idsiq_tipoApoyo"]; ?>" />
                                    <input type="hidden" name="idsiq_formCreditoYCarteraApoyos[]" value="" id="idsiq_formCreditoYCarteraApoyos_<?php echo $row["idsiq_tipoApoyo"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoApoyo"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoApoyo"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoApoyo"]; ?>" >
                                </td>-->
                            </tr>
   
                        <?php } ?>                        
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitapoyos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataapoyos();
    
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
    
                $('#submitapoyos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_apoyos");
                    if(valido){
                        sendFormapoyos();
                    }
                });
                
                $('#form_apoyos #semestre').bind('change', function(event) {
                    getDataapoyos();
                });
                
                function getDataapoyos(){
                    var periodo = $('#form_apoyos #semestre').val();
                    var entity = $("#form_apoyos #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic", entity: entity, 
                            campoPeriodo: "codigoperiodo", entityJoin: "siq_tipoApoyo",
                            campoJoin: "idCategory",order:"ORDER BY nombre ASC"},     
                        success:function(data){
                            if (data.success == true){
                                var i=0
                                 $('#form_apoyos input[name="idCategory[]"]').each(function() {                                     
                                        $(this).val(data.data[i]["idCategory"]);
                                        $("#idsiq_formCreditoYCarteraApoyos_"+data.data[i]["idCategory"]).val(data.data[i]["idsiq_formCreditoYCarteraApoyos"]);
                                        $("#form_apoyos #valor_"+data.data[i]["idCategory"]).val(data.data[i]["valor"]);                                        
                                        
                                        /*if(data.data[i]["verificada"]==1){
                                             $("#veri_"+data.data[i]["idCategory"]).attr('checked', true);
                                        } else {
                                             $("#veri_"+data.data[i]["idCategory"]).attr('checked', false);
                                        }
                                        $("#verificada_"+data.data[i]["idCategory"]).val(data.data[i]["verificada"]);*/
                                        i = i + 1;
                                    });
                                 $("#form_apoyos #action").val("updateDynamic");
                                 //$("#form_apoyos #verificada_"+data.data[0]["verificada"]).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                var i = 0;
                                $('#form_apoyos input[name="idsiq_formCreditoYCarteraApoyos[]"]').each(function() {
                                       if( ($(this).val()!="") && (i==0)){
                                           var semestre = $('#form_apoyos #semestre').val();                                        
                                             document.forms["form_apoyos"].reset();
                                                    $('#form_apoyos #semestre').val(semestre);                                            
                                   $("#form_apoyos #action").val("saveDynamic"); 
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

                function sendFormapoyos(){
                var periodo = $('#form_apoyos #semestre').val();
                $('#form_apoyos #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_apoyos').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#form_apoyos #action").val("updateDynamic");
                                 $('#form_apoyos #msg-success').css('display','block');
                                 $("#form_apoyos #msg-success").delay(5500).fadeOut(800);
                                 var i=0
                                 $('#form_apoyos input[name="idsiq_formCreditoYCarteraApoyos[]"]').each(function() {
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
