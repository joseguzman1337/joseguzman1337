<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>

<div id="tabs-2">
<form action="save.php" method="post" id="formAreas">
            <input type="hidden" name="entity" id="entity" value="formDesarrolloFisicoAreas" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formDesarrolloFisicoAreas" value="" id="idsiq_formDesarrolloFisicoAreas" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Áreas</legend>
                                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio"); 
                $espacios = $utils->getAll($db,"siq_areasFisicas","codigoestado=100","nombre"); ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />             
                
                <div class="vacio"></div>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Puestos de trabajo para alumnos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Áreas</span></th> 
                            <th class="column borderR" ><span>Total áreas</span></th> 
                            <th class="column borderR" ><span>M<sup>2</sup> </span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $espacios->FetchRow()) { ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_areasFisicas"]; ?>" value="<?php echo $row["idsiq_areasFisicas"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformDesarrolloFisicoAreas[]" value="" id="idsiq_detalleformDesarrolloFisicoAreas_<?php echo $row["idsiq_areasFisicas"]; ?>" /></td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-6-12 required number" minlength="1" name="metros[]" id="metros_<?php echo $row["idsiq_areasFisicas"]; ?>" title="Total de metros cuadrados" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-6-12 required number" minlength="1" name="numUnidades[]" id="numUnidades_<?php echo $row["idsiq_areasFisicas"]; ?>" title="Total de unidades" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <?php } ?>           
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitAreas" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataAreas("#formAreas");
    
                $('#submitAreas').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#formAreas");
                    if(valido){
                        sendFormAreas("#formAreas");
                    }
                });
                
     $('#formAreas #mes').add($('#formAreas #anio')).bind('change', function(event) {
          getDataAreas("#formAreas");
    });
    
    function getDataAreas(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_areasFisicas" },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formDesarrolloFisicoAreas").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformDesarrolloFisicoAreas_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformDesarrolloFisicoAreas);
                                        $(formName + " #metros_"+data.data[i].idCategory).val(data.data[i].metros);
                                        $(formName + " #numUnidades_"+data.data[i].idCategory).val(data.data[i].numUnidades);
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formDesarrolloFisicoAreas").val()!=""){
                                        $(formName + ' input[name="idsiq_detalleformDesarrolloFisicoAreas[]"]').each(function() {                                     
                                            $(this).val("");                                       
                                        });
                                        var mes = $(formName + ' #mes').val();
                                        var anio = $(formName + ' #anio').val();
                                        document.forms[formName.replace("#","")].reset();
                                            $(formName + ' #mes').val(mes);
                                            $(formName + ' #anio').val(anio);
                                        $(formName + " #action").val("saveDynamic2");
                                            $("#idsiq_formDesarrolloFisicoAreas").val("");
                                     }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                }
                
       function sendFormAreas(formName){
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formDesarrolloFisicoAreas").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformDesarrolloFisicoAreas_"+data.dataCat[i]).val(data.data[i]);
                                 }
                                 $(formName + " #action").val("updateDynamic2");
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
