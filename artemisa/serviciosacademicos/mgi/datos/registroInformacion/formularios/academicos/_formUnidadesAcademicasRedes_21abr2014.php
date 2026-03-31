<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_redes">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasRedes" />
            <input type="hidden" name="action" value="save2" id="action" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Número de redes y asociaciones Institucionales</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                ?>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Número de redes y asociaciones Institucionales</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2" ><span>Redes y Asociaciones</span></th> 
                            <th class="column" colspan="2"><span>Ámbito</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nacional</span></th> 
                            <th class="column"><span>Internacional</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column borderR"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="nombre[]" title="Nombre de la Red" maxlength="200" tabindex="1" autocomplete="off" value="" />
                                <input type="hidden" name="idsiq_formUnidadesAcademicasRedes[]" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numNacional[]" title="Total Nacional" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numInternacional[]" title="Total Internacional" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            <input type="button" class="first small" id="addMoreRedes" value="Agregar otro" style="margin-top:10px">
            <input type="button" class="first small" id="removeRedes" value="Eliminar último" style="margin-top:10px">
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitRedes" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataRedes("#form_redes");
   
   $('#addMoreRedes').click(function(event) {
           addTableRow("#form_redes");
   });
   
   $('#removeRedes').click(function(event) {
       var formName = "#form_redes";
       var inputName = "input[name='idsiq_formUnidadesAcademicasRedes[]']";
       if($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()!=""){
        var id = $(formName + ' table').children('tbody').children('tr:last').find(inputName).val();
        var entity = $(formName + ' #entity').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: './formularios/academicos/saveUnidadesAcademicas.php',
            data: { action: "inactivate", idsiq_formUnidadesAcademicasRedes:id, entity:entity },                
                            success:function(data){
                                if (data.success == true){
                                    removeTableRow(formName,inputName);
                                }
                                else{                        
                                    alert("Ocurrio un error");
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
            });  
       } else {
            removeTableRow(formName,inputName);
       }
   });
    
                $('#submitRedes').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_redes");
                    if(valido){
                        sendFormRedes("#form_redes");
                    }
                });
                
                $('#form_redes #codigoperiodo').bind('change', function(event) {
                    getDataRedes("#form_redes");
                });
                
                $(document).on('change', "#form_redes #modalidad", function(){
                    getCarreras("#form_redes");
                    changeFormModalidad("#form_redes");
                });
                
                $(document).on('change', "#form_redes #unidadAcademica", function(){
                    getDataRedes("#form_redes");
                    changeFormModalidad("#form_redes");
                });
                
                function getDataRedes(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        $(formName + ' table input').each(function() {                                     
                             $(this).val("");                                       
                        });
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData2", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    //borro todas las filas
                                    $(formName + ' table').children('tbody').children('tr').remove(); 
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        //pinto las nuevas filas
                                        var row = '<tr class="dataColumns">';
                                        row = row + '<td class="column borderR">';
                                        row = row + '<input type="text" class="grid-11-12 required inputTable" minlength="1" name="nombre[]" title="Nombre de la Red" maxlength="200" tabindex="1" autocomplete="off" value="'+data.data[i].nombre+'" />';
                                        row = row + '<input type="hidden" name="idsiq_formUnidadesAcademicasRedes[]" autocomplete="off" value="'+data.data[i].idsiq_formUnidadesAcademicasRedes+'" />';
                                        row = row + '</td><td class="column">';
                                        row = row + '<input type="text" class="grid-4-12 required number" minlength="1" name="numNacional[]" title="Total Nacional" maxlength="10" tabindex="1" autocomplete="off" value="'+data.data[i].numNacional+'" />';
                                        row = row + '</td><td class="column">';
                                        row = row + '<input type="text" class="grid-4-12 required number" minlength="1" name="numInternacional[]" title="Total Internacional" maxlength="10" tabindex="1" autocomplete="off" value="'+data.data[i].numInternacional+'" />';
                                        row = row + '</td></tr>';
                                        if($(formName + ' table').children('tbody').find('tr:last').length>0){
                                            $(formName + ' table').children('tbody').find('tr:last').after(row);  
                                        } else {
                                            $(formName + ' table').children('tbody').append(row); 
                                        }
                                    }
                                    $(formName + " #action").val("update2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    $(formName + ' table input').each(function() {                                     
                                        $(this).val("");                                       
                                    });
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

                function sendFormRedes(formName){
                activarModalidades(formName);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/academicos/saveUnidadesAcademicas.php',
                        data: $(formName).serialize(),                
                        success:function(data){
							<?php if($permisos["rol"][0]!=1) { ?>
                            desactivarModalidades(formName);
							<?php } ?>
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 var i = 0;
                                 $('input[name="idsiq_formUnidadesAcademicasRedes[]"]').each(function() {
                                        $(this).val(data.data[i]);
                                        i = i + 1;
                                 }); 
                                 $(formName + " #action").val("update2");
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
