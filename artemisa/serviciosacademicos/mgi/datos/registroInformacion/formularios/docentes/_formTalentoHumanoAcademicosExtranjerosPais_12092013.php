<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-13">
<form action="save.php" method="post" id="form_extranjerosPais">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoAcademicosExtranjerosPais" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formTalentoHumanoAcademicosExtranjerosPais" value="" id="idsiq_formTalentoHumanoAcademicosExtranjerosPais" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Académicos extranjeros por país de origen</legend>
                
                <label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db); 
                    //$categories = $utils->getActives($db,"pais","nombrepais");
                $sql = "SELECT p.* FROM sala.pais p 
                        INNER JOIN docente d ON d.idpaisnacimiento=p.idpais AND p.codigoestado=100 
                        GROUP BY p.idpais ORDER BY nombrepais";
                $categories = $db->Execute($sql);
                ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Académicos extranjeros por país de origen</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>País de Origen</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th> 
                            <th class="column" ><span>Dato verificado</span></th>    
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $categories->FetchRow()) { ?>
                        <tr class="dataColumns">
                            <td class="column "><?php echo $row["nombrepais"]; ?> <span class="mandatory">(*)</span>
                                <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idpais"]; ?>" value="<?php echo $row["idpais"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais[]" value="" id="idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais_<?php echo $row["idpais"]; ?>" />
                                </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required number disable" minlength="1" name="valor[]" id="valor_<?php echo $row["idpais"]; ?>" title="Total de Estudiantes Beneficiados" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>
                                <td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idpais"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idpais"]; ?>" >
                                </td>
                        </tr>
                        <?php } ?> 
                    </tbody>
                </table>   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitExtranjerosPais" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataExtranjerosPais("#form_extranjerosPais");
    
        $(document).ready(function(){  
      
            $("#form_extranjerosPais .verificarDato").change(function() {  
                if(this.checked) {  
                    var id = $(this).attr('id').replace("veri_","");
                    $("#form_extranjerosPais #verificada_"+id).val(1);
                } else {  
                    var id = $(this).attr('id').replace("veri_","");
                    $("#form_extranjerosPais #verificada_"+id).val(0);
                }  
            });  

        });
    
                $('#submitExtranjerosPais').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_extranjerosPais");
                    if(valido){
                        sendFormExtranjerosPais("#form_extranjerosPais");
                    }
                });
                
                $('#form_extranjerosPais #codigoperiodo').change(function(event) {
                    getDataExtranjerosPais("#form_extranjerosPais");
                });
                
                function getDataExtranjerosPais(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "pais" },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formTalentoHumanoAcademicosExtranjerosPais").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {             
                                     //console.log(data.data[i].idCategory + " - " + data.data[i].valor);
                                    $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                    $("#idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais);
                                    $(formName + " #valor_"+data.data[i].idCategory).val(data.data[i].valor);
                                    if(data.data[i].verificada==1){
                                             $(formName + " #veri_"+data.data[i].idCategory).attr('checked', true);
                                        } else {
                                             $(formName + " #veri_"+data.data[i].idCategory).attr('checked', false);
                                        }
                                        $(formName + " #verificada_"+data.data[i].idCategory).val(data.data[i]["verificada"]);
                                 }
                                 $(formName + " #action").val("updateDynamic2");
                                 //$(formName + " #verificada_"+data.data[0].verificada).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formTalentoHumanoAcademicosExtranjerosPais").val()!=""){                                    
                                    var periodo = $(formName + ' #codigoperiodo').val();
                                    document.forms[formName.replace("#","")].reset();
                                    $(formName + ' #codigoperiodo').val(periodo);
                                    $(formName + " #action").val("saveDynamic2");
                                    $("#idsiq_formTalentoHumanoAcademicosExtranjerosPais").val("");
                                    $(formName + ' input:checkbox').removeAttr('checked');
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormExtranjerosPais(formName){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formTalentoHumanoAcademicosExtranjerosPais").val(data.message);
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
