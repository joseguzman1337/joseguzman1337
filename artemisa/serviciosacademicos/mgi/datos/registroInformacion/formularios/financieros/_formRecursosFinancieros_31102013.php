<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $tipo=$_REQUEST['tipo'];
    
    //echo $tipo.'-->';
?>
<div id="tabs-10">
<form action="save.php" method="post" id="form_RecursosFR3_<?php echo $_REQUEST['tipo']; ?>">
            <input type="hidden" name="entity" id="entity" value="formRecursosFinancieros" />
            <!--<input type="hidden" name="entity" id="entity" value="detalleformRecursosFinancieros" />-->
            <input type="hidden" style=" padding: 0 0 0 0"   name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
            <input type="hidden" name="actividad" value="<?php echo $_REQUEST['tipo']; ?>" id="actividad" />
            <input type="hidden" name="idsiq_formRecursosFinancieros" value="" id="idsiq_formRecursosFinancieros" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <?php
                                if ($tipo==39){
                                    $ti="Cambios en el Patrimonio";
                                    $t1="<input type=text id='anio1' name='anio1' value='' style='width: 250px; border:none; background-color:#D8D8C0'/>";
                                    $t2="<input type=text id='anio2' name='anio2' value='' style='width: 250px; border:none; background-color:#D8D8C0'/>";
                                    $t3="<input type=text id='anio3' name='anio3' value='' style='width: 250px; border:none; background-color:#D8D8C0'/>";
                                }else if ($tipo==40){
                                    $ti="Depuración  y Ajustes sobre los Activos Fijos";
                                    $t1="Adiciones";
                                    $t2="Bajas o Pérdidas";
                                    $t3="Donaciones";
                                }
                            ?>
            <fieldset id="numPersonas">   
                <legend><?php; echo $ti ?></legend>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <?php $nivelFormacion  = $utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=".$tipo." AND codigoestado=100","orden"); ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,10,$('#form_RecursosFR3_".$_REQUEST['tipo']." #anio').val())","popup_verDocumentos(5,10,$('#form_RecursosFR3_".$_REQUEST['tipo']." #anio').val())"); ?>
            
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span><?php; echo $ti ?></span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                             
                            <th class="column borderR" rowspan="2"><span>Detalle</span></th>  
                            <th class="column "><center><span><?php echo $t1 ?></span></center></th> 
                            <th class="column "><center><span><?php echo $t2 ?></span></center></th> 
                            <th class="column "><center><span><?php echo $t3 ?></span></center></th> 
                        </tr>
                        
                     </thead>
                     <tbody>
                         <?php 
                             $i=0;
                             while ($rowC = $nivelFormacion->FetchRow()) { 
                                $first = true;
                          ?>
                                <tr class="dataColumns">
                                        <td class="column borderR" >
                                            <?php echo $rowC["nombre"]; ?> <span class="mandatory">(*)</span>
                                            <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" value="<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" />
                                           <input type="hidden" name="idsiq_detalleformRecursosFinancieros[]" value="" id="idsiq_detalleformRecursosFinancieros_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" />
                                       </td>
                                        <td class="column"> <center>
                                          <input type="text"  class="grid-5-12 required decimal" minlength="1" name="dato1[]" id="dato1_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" title="presupuesto" maxlength="10" tabindex="1"  autocomplete="off" value="" />
                                       </center></td>
                                       <td class="column"> <center>
                                         <input type="text"  class="grid-5-12 required decimal" minlength="1" name="dato2[]" id="dato2_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" title="ejecucion" maxlength="10" tabindex="1"  autocomplete="off" value="" />
                                       </center></td>
                                       <td class="column"> <center>
                                         <input type="text"  class="grid-5-12 required decimal" minlength="1" name="dato3[]" id="dato3_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" title="ejecucion" maxlength="10" tabindex="1"  autocomplete="off" value="" />
                                       </center></td>

                                </tr>
                        <?php  $i++;
                                } ?>        
                    </tbody>
                </table>                   
                <input type="hidden" name="total1" value="<?php echo $i?>" id="total1" />
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitRecursosFinana3_<?php echo $_REQUEST['tipo'] ?>" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    
    //var tipo=$("#form_RecursosFR3_"+<?php echo $_REQUEST['tipo'] ?>+" #actividad").val();
    
    $(function(){
        $("#form_RecursosFR3_"+<?php echo $_REQUEST['tipo'] ?> + " input[type='text']").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:2,allowNegative:true, defaultZero:false});
    });

    getDataRecursosFinancieros3("#form_RecursosFR3_"+<?php echo $_REQUEST['tipo'] ?>);
     
         
                $('#submitRecursosFinana3_'+<?php echo $_REQUEST['tipo'] ?>).click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_RecursosFR3_"+<?php echo $_REQUEST['tipo'] ?>);
                    if(valido){
                       //sendDetalleFormacionActividadesAcademicos("#form_RecursosFR3");
                    
                       sendFormRecursosFinancieros3("#form_RecursosFR3_"+<?php echo $_REQUEST['tipo'] ?>);
                    }
                });
                
                $('#form_RecursosFR3_'+<?php echo $_REQUEST['tipo'] ?>+' #anio').bind('change', function(event) {
                    getDataRecursosFinancieros3("#form_RecursosFR3_"+<?php echo $_REQUEST['tipo'] ?>);
                });
                
             
                function getDataRecursosFinancieros3(formName){
                   // alert(formName)
                
                    var periodo = $(formName + ' #anio').val();
                    var actividad = $(formName + " #actividad").val();
                    var entity = $(formName + " #entity").val();
                    var per1=periodo;
                    var per2=periodo-1;
                    var per3=periodo-2;
                    $("#anio1").val('Saldo a Diciembre 31 del '+per1);
                    $("#anio2").val('Saldo a Diciembre 31 del '+per2);
                    $("#anio3").val('Saldo a Diciembre 31 del '+per3);
                    
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, joinField: "idsiq_tipoRecursosPresupuesto", actividad:actividad, campoPeriodo: "codigoperiodo",
                                    entityJoin: "siq_tipoRecursosPresupuesto"},     
                            success:function(data){
                                if (data.success == true){
                                    $(formName + " #idsiq_formRecursosFinancieros").val(data.message);
                                    //$("#anio").val(periodo);
                                   // $("#actividad").val(data.actividad)
                                   
                                    for (var i=0;i<data.total;i++)
                                    {   
                                       // alert(data.data[i].dato1);
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $(formName + " #idsiq_detalleformRecursosFinancieros_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformRecursosFinancieros);
                                        $(formName + " #dato1_"+data.data[i].idCategory).val(data.data[i].dato1);
                                        $(formName + " #dato2_"+data.data[i].idCategory).val(data.data[i].dato2);
                                        $(formName + " #dato3_"+data.data[i].idCategory).val(data.data[i].dato3);
                                        
                                       /* $(formName + " #dato1_"+data.data[i].idCategory).parseNumber({format:"#,###.00", locale:"us"});
                                        $(formName + " #dato1_"+data.data[i].idCategory).formatNumber({format:"#,###.00", locale:"us"});
                                        
                                       $(formName + " #dato2_"+data.data[i].idCategory).parseNumber({format:"#,###.00", locale:"us"});
                                        $(formName + " #dato2_"+data.data[i].idCategory).formatNumber({format:"#,###.00", locale:"us"});
                                        
                                        $(formName + " #dato3_"+data.data[i].idCategory).parseNumber({format:"#,###.00", locale:"us"});
                                        $(formName + " #dato3_"+data.data[i].idCategory).formatNumber({format:"#,###.00", locale:"us"});
                                    */
                                    }

                                    $(formName + " #action").val("updateDynamic2");
                                    addCommas(formName);
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($(formName + " #idsiq_formRecursosFinancieros").val()!=""){
                                    $(formName + ' input[name="idsiq_detalleformRecursosFinancieros[]"]').each(function() {                                     
                                  $(this).val("");                                       
                             });
                                              
                                               
                                                var anio = $(formName + ' #anio').val();
                                                document.forms[formName.replace("#","")].reset();
                                                $("#anio1").val('Saldo a Diciembre 31 del '+per1);
                                                $("#anio2").val('Saldo a Diciembre 31 del '+per2);
                                                $("#anio3").val('Saldo a Diciembre 31 del '+per3);
                                                $(formName + ' #anio').val(anio);
                                                $(formName + " #action").val("saveDynamic2");
                                                $(formName + " #idsiq_formRecursosFinancieros").val("");
                                            }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                 }
                
                function sendFormRecursosFinancieros3(formName){
                    var periodo = $(formName + ' #anio').val();
                    $(formName + " #codigoperiodo").val(periodo)
                    var entity = $(formName + " #entity").val();
                    var anio = $(formName + " #anio").val();
                    replaceCommas(formName);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                         url: './formularios/docentes/saveTalentoHumano.php',
                         data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $(formName + " #idsiq_formRecursosFinancieros").val(data.message);
                                 
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $(formName + " #idsiq_detalleformRecursosFinancieros_"+data.dataCat[i]).val(data.data[i]);
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
