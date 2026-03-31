<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_eventos">
            <input type="hidden" name="entity" id="entity" value="formBienestarUniversitarioEventos" />
            <input type="hidden" name="action" value="save2" id="action" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Eventos Masivos</legend>
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio"); ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" /> 
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Eventos Masivos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Servicio o actividad</span></th> 
                            <th class="column" ><span>Número de realizaciones mensuales</span></th> 
                            <th class="column" ><span>Participación Aproximada</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column"> 
                                <input type="text" class="grid-12-12 required inputTable" minlength="1" name="nombre[]" title="Nombre de la Actividad" maxlength="300" tabindex="1" autocomplete="off" value="" />
                                <input type="hidden" name="idsiq_formBienestarUniversitarioEventos[]" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numRealizaciones[]" title="Total de Realizaciones" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="participacion[]" title="Participacion" maxlength="15" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            <input type="button" class="first small" id="addMoreEventos" value="Agregar otro evento" style="margin-top:10px">
            <input type="button" class="first small" id="removeEventos" value="Eliminar último evento" style="margin-top:10px">
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitEventos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataEventos("#form_eventos");
   
   $('#addMoreEventos').click(function(event) {
           addTableRowGeneric("#form_eventos");
   });
   
   $('#removeEventos').click(function(event) {
       var formName = "#form_eventos";
       var inputName = "input[name='idsiq_formBienestarUniversitarioEventos[]']";
       if($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()!=""){
        var id = $(formName + ' table').children('tbody').children('tr:last').find(inputName).val();
        var entity = $(formName + ' #entity').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: './formularios/academicos/saveUnidadesAcademicas.php',
            data: { action: "inactivate", idsiq_formBienestarUniversitarioEventos:id, entity:entity },                
                            success:function(data){
                                if (data.success == true){
                                    removeTableRowGeneric(formName,inputName);
                                }
                                else{                        
                                    alert("Ocurrio un error");
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
            });  
       } else {
            removeTableRowGeneric(formName,inputName);
       }
   });
    
                $('#submitEventos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_eventos");
                    if(valido){
                        sendFormEventos("#form_eventos");
                    }
                });
                
                $('#form_eventos #mes').add('#form_eventos #anio').bind('change', function(event) {
             getDataEventos("#form_eventos");
     });
                
                function getDataEventos(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
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
                                        row = row + '<td class="column">';
                                        row = row + '<input type="text" class="grid-12-12 required inputTable" minlength="1" name="nombre[]" title="Nombre de la Actividad" maxlength="300" tabindex="1" autocomplete="off" value="'+data.data[i].nombre+'" />';
                                        row = row + '<input type="hidden" name="idsiq_formBienestarUniversitarioEventos[]" autocomplete="off" value="'+data.data[i].idsiq_formBienestarUniversitarioEventos+'" />';
                                        row = row + '</td><td class="column">';
                                        row = row + '<input type="text" class="grid-4-12 required number" minlength="1" name="numRealizaciones[]" title="Total de Realizaciones" maxlength="10" tabindex="1" autocomplete="off" value="'+data.data[i].numRealizaciones+'" />';
                                        row = row + '</td><td class="column">';
                                        row = row + '<input type="text" class="grid-4-12 required number" minlength="1" name="participacion[]" title="Participacion" maxlength="10" tabindex="1" autocomplete="off" value="'+data.data[i].participacion+'" />';
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

                function sendFormEventos(formName){
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/academicos/saveUnidadesAcademicas.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){ 
                                 var i = 0;
                                 $('input[name="idsiq_formBienestarUniversitarioEventos[]"]').each(function() {
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

