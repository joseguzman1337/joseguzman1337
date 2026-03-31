<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $tipo=$_REQUEST['tipo'];
    if($tipo==1){
        $tituloT = "Nivel de Formación";
    } else {
        $tituloT = "Estudios en Curso";
    }
   // echo $tipo.'-->';
?>

<div id="tabs-13">
<form action="save.php" method="post" id="form_DedicacionSemanal3_<?php echo $_REQUEST['tipo']; ?>">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoDedicacionSemanal" />
            <!--<input type="hidden" name="entity" id="entity" value="detalleformTalentoHumanoDedicacionSemanal" />-->
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
            <input type="hidden" name="actividad" value="<?php echo $_REQUEST['tipo']; ?>" id="actividad" />
            <input type="hidden" name="idsiq_formTalentoHumanoDedicacionSemanal" value="" id="idsiq_formTalentoHumanoDedicacionSemanal" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Dedicaci&oacute;n semanal de acuerdo a la categorizaci&oacute;n de la Universidad el Bosque / <?php echo $tituloT; ?></legend>
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <?php $nivelFormacion  = $utils->getAll($db,"siq_tipoNivelFormacion","actividad=".$tipo." AND codigoestado=100","orden"); ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,13,$('#form_DedicacionSemanal3_".$_REQUEST['tipo']." #mes').val()+'-'+$('#form_DedicacionSemanal3_".$_REQUEST['tipo']." #anio').val())","popup_verDocumentos(5,13,$('#form_DedicacionSemanal3_".$_REQUEST['tipo']." #mes').val()+'-'+$('#form_DedicacionSemanal3_".$_REQUEST['tipo']." #anio').val())"); ?>
            
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Dedicación U el Bosque</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                             <?php
                                if ($tipo==1){
                                    $ti="Mayor Nivel de Formacion";
                                }else{
                                    $ti="Estudios en curso";
                                }
                            ?>
                            <th class="column borderR" rowspan="2"><span><?php echo $ti ?></span></th>  
                            <th class="column borderR"><span>1/4 Tiempo</span></th> 
                            <th class="column borderR"><span>1/2 Tiempo</span></th> 
                            <th class="column borderR"><span>3/4 Tiempo</span></th>
                            <th class="column borderR"><span>Tiempo Completo</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR"><span>1-10 horas</span></th> 
                            <th class="column borderR"><span>11-20 horas</span></th> 
                            <th class="column borderR"><span>21-30 horas</span></th>
                            <th class="column borderR"><span>31-40 horas</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($rowC = $nivelFormacion->FetchRow()) { 
                                $first = true;
                          ?>
                                <tr class="dataColumns">
                                        <td class="column borderR" >
                                            <?php echo $rowC["nombre"]; ?> <span class="mandatory">(*)</span>
                                            <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $rowC["idsiq_tipoNivelFormacion"]; ?>" value="<?php echo $rowC["idsiq_tipoNivelFormacion"]; ?>" />
                                            <input type="hidden" name="idsiq_detalleformTalentoHumanoDedicacionSemanal[]" value="" id="idsiq_detalleformTalentoHumanoDedicacionSemanal_<?php echo $rowC["idsiq_tipoNivelFormacion"]; ?>" />
                                       </td>
                                        <td class="column borderR"> <center>
                                          <input type="text"  class="grid-5-12 required number" minlength="1" name="tiempo1_4[]" id="tiempo1_4_<?php echo $rowC["idsiq_tipoNivelFormacion"]; ?>" title="1/4 Tiempo" maxlength="10" tabindex="1"  autocomplete="off" value="" />
                                       </center></td>
                                       <td class="column borderR"> <center>
                                         <input type="text"  class="grid-5-12 required number" minlength="1" name="tiempo1_2[]" id="tiempo1_2_<?php echo $rowC["idsiq_tipoNivelFormacion"]; ?>" title="1/2 Tiempo" maxlength="10" tabindex="1"  autocomplete="off" value="" />
                                       </center></td>
                                       <td class="column borderR"> <center>
                                            <input type="text"  class="grid-5-12 required number" minlength="1" name="tiempo3_4[]" id="tiempo3_4_<?php echo $rowC["idsiq_tipoNivelFormacion"]; ?>" title="1/3 Tiempo" maxlength="10" tabindex="1"  autocomplete="off" value="" />
                                        </center></td>
                                        <td class="column"> <center>
                                        <input type="text"  class="grid-5-12 required number" minlength="1" name="tiempocompleto[]" id="tiempocompleto_<?php echo $rowC["idsiq_tipoNivelFormacion"]; ?>" title="Tiempo Completo" maxlength="10" tabindex="1" autocomplete="off" value="" />
                                    </center></td>
                                </tr>
                        <?php  } ?>        
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitDedicacionSemanal3_<?php echo $_REQUEST['tipo'] ?>" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    var tipo=$("#actividad").val()
    getDataDedicacionSemanal3("#form_DedicacionSemanal3_"+<?php echo $_REQUEST['tipo'] ?>);
    
         
                $('#submitDedicacionSemanal3_'+<?php echo $_REQUEST['tipo'] ?>).click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_DedicacionSemanal3_"+<?php echo $_REQUEST['tipo'] ?>);
                    if(valido){
                       //sendDetalleFormacionActividadesAcademicos("#form_DedicacionSemanal3");
                    
                       sendFormFormacionDedicacionSemanal3("#form_DedicacionSemanal3_"+<?php echo $_REQUEST['tipo'] ?>);
                    }
                });
                
                $('#form_DedicacionSemanal3_'+<?php echo $_REQUEST['tipo'] ?>+' #mes').bind('change', function(event) {
                    getDataDedicacionSemanal3("#form_DedicacionSemanal3_"+<?php echo $_REQUEST['tipo'] ?>);
                });
                
                $('#form_DedicacionSemanal3_'+<?php echo $_REQUEST['tipo'] ?>+' #anio').bind('change', function(event) {
                    getDataDedicacionSemanal3("#form_DedicacionSemanal3_"+<?php echo $_REQUEST['tipo'] ?>);
                });
                
             
                function getDataDedicacionSemanal3(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var actividad = $(formName + " #actividad").val();
                    var entity = $(formName + " #entity").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, joinField: "idsiq_tipoNivelFormacion", actividad:actividad, campoPeriodo: "codigoperiodo",
                                    entityJoin: "siq_tipoNivelFormacion"},     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formTalentoHumanoDedicacionSemanal").val(data.message);
                                   // $("#actividad").val(data.actividad)
                                    for (var i=0;i<data.total;i++){   
                                       // alert(data.data[i].idsiq_detalleformTalentoHumanoDedicacionSemanal+'-->'+$(formName + "#idsiq_detalleformTalentoHumanoDedicacionSemanal_"+data.data[i].idCategory).val()+'-->>'+data.data[i].idCategory);
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                      //  $(formName + "#idsiq_detalleformTalentoHumanoDedicacionSemanal_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformTalentoHumanoDedicacionSemanal);
                                        //$(formName + "#idsiq_detalleformTalentoHumanoDedicacionSemanal_"+data.data[i].idCategory).val('xxx')
                                        $("#idsiq_detalleformTalentoHumanoDedicacionSemanal_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformTalentoHumanoDedicacionSemanal)
                                        $(formName + " #tiempo1_4_"+data.data[i].idCategory).val(data.data[i].tiempo1_4);
                                        $(formName + " #tiempo1_2_"+data.data[i].idCategory).val(data.data[i].tiempo1_2);
                                        $(formName + " #tiempo3_4_"+data.data[i].idCategory).val(data.data[i].tiempo3_4);
                                        $(formName + " #tiempocompleto_"+data.data[i].idCategory).val(data.data[i].tiempocompleto);
                                        
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formTalentoHumanoDedicacionSemanal").val()!=""){
                                    $(formName + ' input[name="idsiq_detalleformTalentoHumanoDedicacionSemanal[]"]').each(function() {                                     
                                  $(this).val("");                                       
                             });
                                              
                                                var mes = $(formName + ' #mes').val();
                                                var anio = $(formName + ' #anio').val();
                                                document.forms[formName.replace("#","")].reset();
                                                $(formName + ' #mes').val(mes);
                                                $(formName + ' #anio').val(mes);
                                                //$(formName + ' #actividad').val(mes);
                                                $(formName + " #action").val("saveDynamic2");
                                                $("#idsiq_formTalentoHumanoDedicacionSemanal").val("");
                                            }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                 }
                
                function sendFormFormacionDedicacionSemanal3(formName){
                    var periodo = $(formName +' #mes').val()+"-"+$(formName + ' #anio').val();
                    $(formName + " #codigoperiodo").val(periodo)
                    var entity = $(formName + " #entity1").val();
                    var anio = $(formName + " #anio").val();
                    var mes = $(formName + " #mes").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                         url: './formularios/docentes/saveTalentoHumano.php',
                         data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formTalentoHumanoDedicacionSemanal").val(data.message);
                                 
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformTalentoHumanoDedicacionSemanal_"+data.dataCat[i]).val(data.data[i]);
                                 }
                                 $(formName + " #action").val("updateDynamic2");
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
                                // sendDetalleFormacionActividadesAcademicos(formName);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
//                           
</script>
