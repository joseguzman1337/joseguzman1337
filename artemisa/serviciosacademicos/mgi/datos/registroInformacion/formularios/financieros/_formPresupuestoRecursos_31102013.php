<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $tipo='';
    $tipo=$_REQUEST['tipo'];
    
    //echo $tipo.'-->';
?>

<div id="tabs-6">
<form action="save.php" method="post" id="form_PresupuestoR3_<?php echo $_REQUEST['tipo']; ?>">
            <input type="hidden" name="entity" id="entity" value="formPresupuestoRecursos" />
            <!--<input type="hidden" name="entity" id="entity" value="detalleformPresupuestoRecursos" />-->
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
            <input type="hidden" name="actividad" value="<?php echo $_REQUEST['tipo']; ?>" id="actividad" />
            <input type="hidden" name="idsiq_formPresupuestoRecursos" value="" id="idsiq_formPresupuestoRecursos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
               <?php
                if ($tipo==1){
                    $ti="Fuentes de los Recursos";
                }else if ($tipo==2){
                    $ti="Usos de los Recursos";
                }else if ($tipo==3){
                    $ti="Presupuesto";
                }
            ?>
            <fieldset id="numPersonas">   
                <legend><?php echo $ti ?></legend>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <?php $nivelFormacion  = $utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=".$tipo." AND codigoestado=100","orden"); ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,6,$('#form_PresupuestoR3_".$_REQUEST['tipo']." #anio').val())","popup_verDocumentos(5,6,$('#form_PresupuestoR3_".$_REQUEST['tipo']." #anio').val())"); ?>
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span><?php echo $ti ?></span></th>                                    
                        </tr>
                        <tr class="dataColumns category">

                            <th class="column borderR" rowspan="2"><span><?php echo $ti ?></span></th>  
                            <th class="column "><center><span>Presupuesto del a&ntilde;o</span></center></th> 
                <th class="column "><center><span>Ejecuci&oacute;n a Junio</span></center></th> 
                        </tr>
                        
                     </thead>
                     <tbody>
                         <?php while ($rowC = $nivelFormacion->FetchRow()) { 
                                $first = true;
                          ?>
                                <tr class="dataColumns">
                                        <td class="column borderR" >
                                            <?php echo $rowC["nombre"]; ?> <span class="mandatory">(*)</span>
                                            <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" value="<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" />
                                           <input type="hidden" name="idsiq_detalleformPresupuestoRecursos[]" value="" id="idsiq_detalleformPresupuestoRecursos_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" />
                                       </td>
                                        <td class="column"> <center>
                                          <input type="text"  class="grid-5-12 required number" minlength="1" name="presupuesto[]" id="presupuesto_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" title="presupuesto" maxlength="10" tabindex="1"  autocomplete="off" value="" />
                                       </center></td>
                                       <td class="column"> <center>
                                         <input type="text"  class="grid-5-12 required number" minlength="1" name="ejecucion[]" id="ejecucion_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" title="ejecucion" maxlength="10" tabindex="1"  autocomplete="off" value="" />
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
    //var tipo=$("#actividad").val()
    $(function(){
        $("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?> + " input[type='text']").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:2,allowNegative:true, defaultZero:false});
    });
    
    getDataRecursoPresupuesto3("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
    
         
                $('#submitDedicacionSemanal3_'+<?php echo $_REQUEST['tipo'] ?>).click(function(event) {
                    event.preventDefault();
                    replaceCommas("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
                    var valido= validateForm("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
                    if(valido){
                       //sendDetalleFormacionActividadesAcademicos("#form_PresupuestoR3");
                    
                       sendFormRecursoPresupuesto("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
                    }
                });
                
                $('#form_PresupuestoR3_'+<?php echo $_REQUEST['tipo'] ?>+' #anio').bind('change', function(event) {
                    getDataRecursoPresupuesto3("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
                });
                
             
                function getDataRecursoPresupuesto3(formName){
                   // alert(formName)
                
                    var periodo = $(formName + ' #anio').val();
                    var actividad = $(formName + " #actividad").val();
                    var entity = $(formName + " #entity").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, joinField: "idsiq_tipoRecursosPresupuesto", actividad:actividad, campoPeriodo: "codigoperiodo",
                                    entityJoin: "siq_tipoRecursosPresupuesto"},     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formPresupuestoRecursos").val(data.message);
                                    //$("#anio").val(periodo);
                                   // $("#actividad").val(data.actividad)
                                   
                                    for (var i=0;i<data.total;i++)
                                    {   
                                       // alert(data.data[i].ejecucion);
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $(formName + " #idsiq_detalleformPresupuestoRecursos_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformPresupuestoRecursos);
                                        $(formName + " #presupuesto_"+data.data[i].idCategory).val(data.data[i].presupuesto);
                                        $(formName + " #ejecucion_"+data.data[i].idCategory).val(data.data[i].ejecucion);
                                         
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                    addCommas(formName);
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formPresupuestoRecursos").val()!=""){
                                    $(formName + ' input[name="idsiq_detalleformPresupuestoRecursos[]"]').each(function() {                                     
                                  $(this).val("");                                       
                             });
                                              
                                               
                                                var anio = $(formName + ' #anio').val();
                                                document.forms[formName.replace("#","")].reset();
                                                
                                                $(formName + ' #anio').val(anio);
                                                $(formName + " #action").val("saveDynamic2");
                                                $("#idsiq_formPresupuestoRecursos").val("");
                                            }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                 }
                
                function sendFormRecursoPresupuesto(formName){
                    var periodo = $(formName + ' #anio').val();
                    $(formName + " #codigoperiodo").val(periodo)
                    var entity = $(formName + " #entity1").val();
                    var anio = $(formName + " #anio").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                         url: './formularios/docentes/saveTalentoHumano.php',
                         data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formPresupuestoRecursos").val(data.message);
                                 
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformPresupuestoRecursos_"+data.dataCat[i]).val(data.data[i]);
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
                    addCommas(formName); 
                }
                
//                           
</script>
