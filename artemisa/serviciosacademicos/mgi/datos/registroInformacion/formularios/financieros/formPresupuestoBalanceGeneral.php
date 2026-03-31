<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $query1="categoria='Activo_Corriente'";
    $actividades1 = $utils->getAll($db,"siq_tipoDatoBalance",$query1,"orden");
    $query2="categoria='Activo_No_Corriente'";
    $actividades2 = $utils->getAll($db,"siq_tipoDatoBalance",$query2,"orden");
    $query3="categoria='Pasivo_Corriente'";
    $actividades3 = $utils->getAll($db,"siq_tipoDatoBalance",$query3,"orden");
    $query4="categoria='Pasivo_Diferido'";
    $actividades4 = $utils->getAll($db,"siq_tipoDatoBalance",$query4,"orden");
    $query5="categoria='Pasivo_No_Corriente'";
    $actividades5 = $utils->getAll($db,"siq_tipoDatoBalance",$query5,"orden");
    $query6="categoria='Patrimonio'";
    $actividades6 = $utils->getAll($db,"siq_tipoDatoBalance",$query6,"orden");
    $query7="categoria='Cuentas_Orden'";
    $actividades7 = $utils->getAll($db,"siq_tipoDatoBalance",$query7,"orden");
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_presupuestobalance">
            <input type="hidden" name="entity" id="entity" value="formPresupuestoBalanceGeneral" />
            <input type="hidden" name="action" value="saveDynamic" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="valor">   
                <legend>Balance General Comparativo</legend>                                   
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />     
                
                                <?php $utils->pintarBotonCargar("popup_cargarDocumento(13,11,$('#form_presupuestobalance #anio').val())","popup_verDocumentos(13,11,$('#form_presupuestobalance #anio').val())"); ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Balance General Comparativo</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">                            
                            <th class="column" ><span>Categoría</span></th>
                            <th class="column" ><span>Año actual</span></th>                                                                                     
                        </tr>                        
                     </thead>
                     <tbody>
			<tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>ACTIVO CORRIENTE</span></th>                              
			</tr>
                         <?php while ($row = $actividades1->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoBalance[]" id="idtipoBalance_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" value="<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                    <input type="hidden" name="idsiq_formPresupuestoBalanceGeneral[]" value="" id="idsiq_formPresupuestoBalanceGeneral_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>ACTIVO NO CORRIENTE</span></th>                              
			</tr>
                         <?php while ($row = $actividades2->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoBalance[]" id="idtipoBalance_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" value="<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                    <input type="hidden" name="idsiq_formPresupuestoBalanceGeneral[]" value="" id="idsiq_formPresupuestoBalanceGeneral_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-9-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>PASIVO CORRIENTE</span></th>                              
			</tr>
                         <?php while ($row = $actividades3->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoBalance[]" id="idtipoBalance_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" value="<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                    <input type="hidden" name="idsiq_formPresupuestoBalanceGeneral[]" value="" id="idsiq_formPresupuestoBalanceGeneral_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-9-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>                        
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>PASIVO DIFERIDO</span></th>                              
			</tr>
                         <?php while ($row = $actividades4->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoBalance[]" id="idtipoBalance_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" value="<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                    <input type="hidden" name="idsiq_formPresupuestoBalanceGeneral[]" value="" id="idsiq_formPresupuestoBalanceGeneral_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-9-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>PASIVO NO CORRIENTE</span></th>                              
			</tr>
                         <?php while ($row = $actividades5->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoBalance[]" id="idtipoBalance_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" value="<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                    <input type="hidden" name="idsiq_formPresupuestoBalanceGeneral[]" value="" id="idsiq_formPresupuestoBalanceGeneral_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-9-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>PATRIMONIO</span></th>                              
			</tr>
                         <?php while ($row = $actividades6->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoBalance[]" id="idtipoBalance_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" value="<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                    <input type="hidden" name="idsiq_formPresupuestoBalanceGeneral[]" value="" id="idsiq_formPresupuestoBalanceGeneral_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-9-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>
                        <tr class="dataColumns">                             
                            <th class="column" colspan="2" style="text-align:left"><span>CUENTAS DE ORDEN</span></th>                              
			</tr>
                         <?php while ($row = $actividades7->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idtipoBalance[]" id="idtipoBalance_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" value="<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                    <input type="hidden" name="idsiq_formPresupuestoBalanceGeneral[]" value="" id="idsiq_formPresupuestoBalanceGeneral_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-9-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>                                
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_tipoDatoBalance"]; ?>" >
                                </td>-->
                            </tr>   
                        <?php } ?>  
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitpresupuestobalance" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    
    $(function(){
        $("#form_presupuestobalance input[type='text']").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:0,allowNegative:true, defaultZero:false});
    });
    
    getDatapresupuestobalance();
    
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
    
                $('#submitpresupuestobalance').click(function(event) {
                    event.preventDefault();
                    replaceCommas("#form_presupuestobalance");
                    var valido= validateForm("#form_presupuestobalance");
                    if(valido){
                        sendFormpresupuestobalance();
                    }
                });
                
                $('#form_presupuestobalance #anio').bind('change', function(event) {
                    getDatapresupuestobalance();
                });
                
                function getDatapresupuestobalance(){
                    var periodo = $('#form_presupuestobalance #anio').val();
                    var entity = $("#form_presupuestobalance #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic", entity: entity, 
                            campoPeriodo: "codigoperiodo", entityJoin: "siq_tipoDatoBalance",
                            campoJoin: "idtipoBalance",order:"ORDER BY nombre ASC"},     
                        success:function(data){
                            if (data.success == true){
                                var i=0
                                 $('#form_presupuestobalance input[name="idtipoBalance[]"]').each(function() {                                     
                                        //$(this).val(data.data[i]["idtipoBalance"]);
                                        $("#idsiq_formPresupuestoBalanceGeneral_"+data.data[i]["idtipoBalance"]).val(data.data[i]["idsiq_formPresupuestoBalanceGeneral"]);
                                        $("#valor_"+data.data[i]["idtipoBalance"]).val(data.data[i]["valor"]);                                        
                                        
                                        /*if(data.data[i]["verificada"]==1){
                                             $("#veri_"+data.data[i]["idtipoBalance"]).attr('checked', true);
                                        } else {
                                             $("#veri_"+data.data[i]["idtipoBalance"]).attr('checked', false);
                                        }
                                        $("#verificada_"+data.data[i]["idtipoBalance"]).val(data.data[i]["verificada"]);*/
                                        i = i + 1;
                                    });
                                 $("#form_presupuestobalance #action").val("updateDynamic");
                                    addCommas("#form_presupuestobalance");
                                 //$("#form_presupuestobalance #verificada_"+data.data[0]["verificada"]).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                var i = 0;
                                $('input[name="idsiq_formPresupuestoBalanceGeneral[]"]').each(function() {
                                       if( ($(this).val()!="") && (i==0)){                                           
                                        var anio = $('#form_presupuestobalance #anio').val();
                                             document.forms["form_presupuestobalance"].reset();                                                    
                                            $('#form_presupuestobalance #anio').val(anio);
                                   $("#form_presupuestobalance #action").val("saveDynamic"); 
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

                function sendFormpresupuestobalance(){
                var periodo = $('#form_presupuestobalance #anio').val();
                $('#form_presupuestobalance #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_presupuestobalance').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#form_presupuestobalance #action").val("updateDynamic");
                                 $('#form_presupuestobalance #msg-success').css('display','block');
                                 $("#form_presupuestobalance #msg-success").delay(5500).fadeOut(800);
                                 var i=0
                                 $('input[name="idsiq_formPresupuestoBalanceGeneral[]"]').each(function() {
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
                    addCommas("#form_presupuestobalance");
                }
</script>
