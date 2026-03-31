<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $query1="categoria='Ingresos_Operacionales'";
    $actividades1 = $utils->getAll($db,"siq_tipoEstadoResultados",$query1,"nombre");
    $query2="categoria='Gastos_Operacionales'";
    $actividades2 = $utils->getAll($db,"siq_tipoEstadoResultados",$query2,"nombre");
    $query3="categoria='Ingresos_No_Operacionales'";
    $actividades3 = $utils->getAll($db,"siq_tipoEstadoResultados",$query3,"nombre");
    $query4="categoria='Gastos_No_Operacionales'";
    $actividades4 = $utils->getAll($db,"siq_tipoEstadoResultados",$query4,"nombre");
    
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_estadoresultados">
            <input type="hidden" name="entity" id="entity" value="formEstadoResultadosComparativo" />
            <input type="hidden" name="action" value="saveDynamic" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="valor">   
                <legend>Estado De Resultados Comparativo</legend>                                   
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />     
                
                                <?php $utils->pintarBotonCargar("popup_cargarDocumento(13,12,$('#form_estadoresultados #anio').val())","popup_verDocumentos(13,12,$('#form_estadoresultados #anio').val())"); ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Estado De Resultados Comparativo</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">                            
                            <th class="column" ><span>Categoria</span></th>
                            <th class="column" ><span>Valor</span></th>                                                                                    
                        </tr>                        
                     </thead>
                     <tbody>
			<tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>INGRESOS OPERACIONALES</span></th>                              
			</tr>
                         <?php while ($row = $actividades1->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoEstado[]" id="idtipoEstado_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" value="<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" />
                                    <input type="hidden" name="idsiq_formEstadoResultadosComparativo[]" value="" id="idsiq_formEstadoResultadosComparativo_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>GASTOS OPERACIONALES</span></th>                              
			</tr>
                         <?php while ($row = $actividades2->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoEstado[]" id="idtipoEstado_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" value="<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" />
                                    <input type="hidden" name="idsiq_formEstadoResultadosComparativo[]" value="" id="idsiq_formEstadoResultadosComparativo_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>INGRESOS NO PERACIONALES</span></th>                              
			</tr>
                         <?php while ($row = $actividades3->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoEstado[]" id="idtipoEstado_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" value="<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" />
                                    <input type="hidden" name="idsiq_formEstadoResultadosComparativo[]" value="" id="idsiq_formEstadoResultadosComparativo_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>                        
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>GASTOS NO OPERACIONALES</span></th>                              
			</tr>
                         <?php while ($row = $actividades4->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoEstado[]" id="idtipoEstado_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" value="<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" />
                                    <input type="hidden" name="idsiq_formEstadoResultadosComparativo[]" value="" id="idsiq_formEstadoResultadosComparativo_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoEstadoResultados"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>                        
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitestadoresultados" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataestadoresultados();
    
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
    
                $('#submitestadoresultados').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_estadoresultados");
                    if(valido){
                        sendFormestadoresultados();
                    }
                });
                
                $('#form_estadoresultados #anio').bind('change', function(event) {
                    getDataestadoresultados();
                });
                
                function getDataestadoresultados(){
                    var periodo = $('#form_estadoresultados #anio').val();
                    var entity = $("#form_estadoresultados #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic", entity: entity, 
                            campoPeriodo: "codigoperiodo", entityJoin: "siq_tipoEstadoResultados",
                            campoJoin: "idtipoEstado",order:"ORDER BY nombre ASC"},     
                        success:function(data){
                            if (data.success == true){
                                var i=0
                                 $('#form_estadoresultados input[name="idtipoEstado[]"]').each(function() {                                     
                                        //$(this).val(data.data[i]["idtipoEstado"]);
                                        $("#form_estadoresultados #idsiq_formEstadoResultadosComparativo_"+data.data[i]["idtipoEstado"]).val(data.data[i]["idsiq_formEstadoResultadosComparativo"]);
                                        $("#form_estadoresultados #valor_"+data.data[i]["idtipoEstado"]).val(data.data[i]["valor"]);                                        
                                        
                                        /*if(data.data[i]["verificada"]==1){
                                             $("#veri_"+data.data[i]["idtipoEstado"]).attr('checked', true);
                                        } else {
                                             $("#veri_"+data.data[i]["idtipoEstado"]).attr('checked', false);
                                        }
                                        $("#verificada_"+data.data[i]["idtipoEstado"]).val(data.data[i]["verificada"]);*/
                                        i = i + 1;
                                    });
                                 $("#form_estadoresultados #action").val("updateDynamic");
                                 //$("#form_estadoresultados #verificada_"+data.data[0]["verificada"]).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                var i = 0;
                                $('input[name="idsiq_formEstadoResultadosComparativo[]"]').each(function() {
                                       if( ($(this).val()!="") && (i==0)){                                           
                                        var anio = $('#form_estadoresultados #anio').val();
                                             document.forms["form_estadoresultados"].reset();                                                    
                                            $('#form_estadoresultados #anio').val(anio);
                                   $("#form_estadoresultados #action").val("saveDynamic"); 
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

                function sendFormestadoresultados(){
                var periodo = $('#form_estadoresultados #anio').val();
                $('#form_estadoresultados #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_estadoresultados').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#form_estadoresultados #action").val("updateDynamic");
                                 $('#form_estadoresultados #msg-success').css('display','block');
                                 $("#form_estadoresultados #msg-success").delay(5500).fadeOut(800);
                                 var i=0
                                 $('input[name="idsiq_formEstadoResultadosComparativo[]"]').each(function() {
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
