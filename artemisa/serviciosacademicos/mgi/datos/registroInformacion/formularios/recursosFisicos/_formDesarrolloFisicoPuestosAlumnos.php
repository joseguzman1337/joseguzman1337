<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
    }
?>

<div id="tabs-2">
<form action="save.php" method="post" id="formPuestosAlumnos">
            <input type="hidden" name="entity" id="entity" value="formDesarrolloFisicoPuestosAlumnos" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formDesarrolloFisicoPuestosAlumnos" value="" id="idsiq_formDesarrolloFisicoPuestosAlumnos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Puestos de trabajo para alumnos</legend>
                                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                $utils->pintarBotonCargar("popup_cargarDocumento(4,2,$('#formPuestosAlumnos #codigoperiodo').val())","popup_verDocumentos(4,2,$('#formPuestosAlumnos #codigoperiodo').val())");
                $espacios = $utils->getAll($db,"siq_espaciosFisicos","codigoestado=100 AND puestos=1","nombre"); ?>
                
                <div class="vacio"></div>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "2"; else echo "3";?>"><span>Puestos de trabajo para alumnos</span></th>                                    
                        
                         <?php if($aprobacion){ ?>
                            <th class="column"><span>
                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
				<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
	                   </span></th>  
                           <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Espacio</span></th> 
                            <!--<th class="column borderR" ><span>M<sup>2</sup> </span></th> 
                            <th class="column borderR" ><span>Unidades</span></th> -->
                            <th class="column borderR" ><span>Puestos</span></th> 
                            <th class="column" ><span>Observaciones</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $espacios->FetchRow()) { ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_espaciosFisicos"]; ?>" value="<?php echo $row["idsiq_espaciosFisicos"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformDesarrolloFisicoPuestosAlumnos[]" value="" id="idsiq_detalleformDesarrolloFisicoPuestosAlumnos_<?php echo $row["idsiq_espaciosFisicos"]; ?>" /></td>
                            <!--<td class="column borderR"> 
                                <input type="text" class="grid-6-12 required number" minlength="1" name="metros[]" id="metros_<?php echo $row["idsiq_espaciosFisicos"]; ?>" title="Total de metros cuadrados" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-6-12 required number" minlength="1" name="numUnidades[]" id="numUnidades_<?php echo $row["idsiq_espaciosFisicos"]; ?>" title="Total de unidades" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>-->
                            <td class="column borderR"> 
                                <input type="hidden" class="grid-6-12 number" minlength="1" name="metros[]" id="metros_<?php echo $row["idsiq_espaciosFisicos"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                                <input type="hidden" class="grid-6-12 number" minlength="1" name="numUnidades[]" id="numUnidades_<?php echo $row["idsiq_espaciosFisicos"]; ?>" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                                <input type="text" class="grid-6-12 required number inputTable" minlength="1" name="tenencia[]" id="tenencia_<?php echo $row["idsiq_espaciosFisicos"]; ?>" title="Puestos" maxlength="255" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-12-12 inputTable" minlength="1" name="observaciones[]" id="observaciones_<?php echo $row["idsiq_espaciosFisicos"]; ?>" title="Observaciones" maxlength="255" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <?php } ?>           
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitPuestosAlumnos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    var aprobacion = '<?php echo $aprobacion; ?>';
    getDataPuestosAlumnos("#formPuestosAlumnos");
    
                $('#submitPuestosAlumnos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#formPuestosAlumnos");
                    if(valido){
                        sendFormPuestosAlumnos("#formPuestosAlumnos");
                    }
                });
                
           $('#formPuestosAlumnos #codigoperiodo').bind('change', function(event) {
          getDataPuestosAlumnos("#formPuestosAlumnos");
    });
    
    function getDataPuestosAlumnos(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_espaciosFisicos" },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formDesarrolloFisicoPuestosAlumnos").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformDesarrolloFisicoPuestosAlumnos_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformDesarrolloFisicoPuestosAlumnos);
                                        $(formName + " #metros_"+data.data[i].idCategory).val(data.data[i].metros);
                                        $(formName + " #numUnidades_"+data.data[i].idCategory).val(data.data[i].numUnidades);
                                        $(formName + " #tenencia_"+data.data[i].idCategory).val(data.data[i].tenencia);
                                        $(formName + " #observaciones_"+data.data[i].idCategory).val(data.data[i].observaciones);
                                        
                                        if(data.data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #submitPuestosAlumnos").attr('disabled','disabled');
                                           $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").addClass("disable");
                                                 $(this).removeAttr("disabled").addClass("disable");
                                            });
                                          }else{
                                               
                                              $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                           // $(formName + " #enviafinanciamiento").removeAttr('disabled','disabled');
                                              $(formName + " #Verificado").attr("checked", false);
                                            }
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formDesarrolloFisicoPuestosAlumnos").val()!=""){
                                        $(formName + ' input[name="idsiq_detalleformDesarrolloFisicoPuestosAlumnos[]"]').each(function() {                                     
                                            $(this).val("");                                       
                                        });
                                        var mes = $(formName + ' #codigoperiodo').val();
                                        document.forms[formName.replace("#","")].reset();
                                            $(formName + ' #codigoperiodo').val(mes);
                                        $(formName + " #action").val("saveDynamic2");
                                            $("#idsiq_formDesarrolloFisicoPuestosAlumnos").val("");
                                            $(formName + " #Verificado").attr("checked", false);
                                            $(formName).find(':input').each(function() {
                                                       $(this).removeAttr("readonly").removeClass("disable");
                                            });
                                     }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                }
                
         function sendFormPuestosAlumnos(formName){
                      $(formName + " input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").removeAttr("disabled");
                      });
         
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formDesarrolloFisicoPuestosAlumnos").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformDesarrolloFisicoPuestosAlumnos_"+data.dataCat[i]).val(data.data[i]);
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
