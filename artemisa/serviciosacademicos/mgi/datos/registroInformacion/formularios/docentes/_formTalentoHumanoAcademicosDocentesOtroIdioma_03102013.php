<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    
    /*$idiomas = $utils->getAll($db,"idioma","","nombreidioma"); 
    $niveles = $utils->getActives($db,"siq_nivelIdioma","nombre");
    $tipos = $utils->getActives($db,"siq_tipoCursoIdioma","nombre");*/
    $idiomas = $db->Execute("SELECT nombreidioma,ididioma FROM idioma ORDER BY nombreidioma ASC"); 
    $niveles = $db->Execute("SELECT nombre,idsiq_nivelIdioma FROM siq_nivelIdioma WHERE codigoestado=100 ORDER BY nombre ASC"); 
    $tipos = $db->Execute("SELECT nombre,idsiq_tipoCursoIdioma FROM siq_tipoCursoIdioma WHERE codigoestado=100 ORDER BY nombre ASC"); 
    $selectIdiomas = $idiomas->GetMenu2('idioma[]',null,true,false,1,'class="grid-11-12 required inputTable" style="float:none;margin:0 auto;"');
    $selectTipo = $tipos->GetMenu2('tipoCurso[]',null,true,false,1,'class="grid-11-12 required inputTable" style="float:none;margin:0 auto;"');
    $selectNivel = $niveles->GetMenu2('nivel[]',null,true,false,1,'class="grid-11-12 required inputTable" style="float:none;margin:0 auto;"');
    ?>
<div id="tabs-11">
<form action="save.php" method="post" id="form_docentesIdiomas">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoAcademicosDocentesOtroIdioma" />
            <input type="hidden" name="action" value="save2" id="action" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Profesores que cursan programas de idioma no materno</legend>
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />    
                
                <div class="vacio"></div>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Profesores que cursan programas de idioma no materno en el centro de lenguas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Nombre del profesor - estudiante</span></th> 
                            <th class="column borderR" ><span>Idioma</span></th> 
                            <th class="column borderR" ><span>Tipo de curso</span></th> 
                            <th class="column borderR" ><span>Nivel</span></th> 
                            <th class="column" ><span>Número de horas<br/>semanales de<br/>vinculación del<br/>académico</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column borderR"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="nombre[]" title="Nombre del Docente" maxlength="200" tabindex="1" autocomplete="off" value="" />
                                <input type="hidden" name="idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma[]" autocomplete="off" value="" />
                            </td>
                            <td class="column borderR"> 
                                <?php
                                // idioma[] es el nombre del select, el null es el que esta elegido de la lista, 
                                //primer true que se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
                                //el 1 es si es un listbox o un select, el último son atributos
                                echo $selectIdiomas; ?>
                            </td>
                            <td class="column borderR"> 
                                <?php echo $selectTipo; ?>
                            </td>
                            <td class="column borderR"> 
                                <?php echo $selectNivel; ?>
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-5-12 required inputTable number" minlength="1" name="horas[]" title="Horas docente" maxlength="100" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            <input type="button" class="first small" id="addMoreDocentesIdiomas" value="Agregar otro" style="margin-top:10px;">
            <input type="button" class="first small" id="removeDocentesIdiomas" value="Eliminar último" style="margin-top:10px;">
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitDocentesIdiomas" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">    
   
   $('#addMoreDocentesIdiomas').click(function(event) {
           addTableRowGeneric("#form_docentesIdiomas");
   });
   
   $('#removeDocentesIdiomas').click(function(event) {
       var formName = "#form_docentesIdiomas";
       var inputName = "input[name='idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma[]']";
       if($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()!=""){
        var id = $(formName + ' table').children('tbody').children('tr:last').find(inputName).val();
        var entity = $(formName + ' #entity').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: './formularios/academicos/saveUnidadesAcademicas.php',
            data: { action: "inactivate", idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma:id,entity:entity },                
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
    
    $('#form_docentesIdiomas #mes').add('#form_docentesIdiomas #anio').bind('change', function(event) {
             getDataDocentesIdiomas("#form_docentesIdiomas");
     });
    
                $('#submitDocentesIdiomas').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_docentesIdiomas");
                    if(valido){
                        $('input[name="horas[]"]').each(function() {
                            var num = parseInt($(this).val());
                               if(num<0 || num>40){         
                                    $(this).addClass('error');
                                    $(this).effect("pulsate", { times:3 }, 500);
                                    valido = false;
                               }
                         });
                         if(valido){
                                sendFormDocentesIdiomas("#form_docentesIdiomas");
                         }
                    }
                });  

                function getDataDocentesIdiomas(formName){
                    var inputName = "input[name='idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma[]']";
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData2", entity: entity, campoPeriodo: "codigoperiodo" },     
                            success:function(data){ 
                                if (data.success == true){
                                        //borro todas las filas
                                        $(formName + ' table').children('tbody').children('tr').remove(); 
                                    for (var i=0;i<data.total;i++)
                                    {                                 
                                        //pinto las nuevas filas
                                        var row = '<tr class="dataColumns">';
                                        row = row + '<td class="column borderR">';
                                        row = row + '<input type="text" class="grid-11-12 required inputTable" minlength="1" name="nombre[]" title="Nombre del Docente" maxlength="200" tabindex="1" autocomplete="off" value="'+data.data[i].nombre+'" />';
                                        row = row + '<input type="hidden" name="idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma[]" autocomplete="off" value="'+data.data[i].idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma+'" />';
                                        row = row + '</td><td class="column borderR" id="idioma">';
                                        row = row + '<?php echo str_replace("'",'"',preg_replace( "/\r|\n/", "", $selectIdiomas)); ?>';
                                        row = row + '</td><td class="column borderR" id="tipo">';
                                        row = row + '<?php echo str_replace("'",'"',preg_replace( "/\r|\n/", "", $selectTipo)); ?>';
                                        row = row + '</td><td class="column borderR" id="nivel">';
                                        row = row + '<?php echo str_replace("'",'"',preg_replace( "/\r|\n/", "", $selectNivel)); ?>';
                                        row = row + '</td><td class="column">';
                                        row = row + '<input type="text" class="grid-4-12 required number" minlength="1" name="horas[]" title="Horas docentes" maxlength="10" tabindex="1" autocomplete="off" value="'+data.data[i].horas+'" />';
                                        row = row + '</td></tr>';
                                        if($(formName + ' table').children('tbody').find('tr:last').length>0){
                                            $(formName + ' table').children('tbody').find('tr:last').after(row);  
                                        } else {
                                            $(formName + ' table').children('tbody').append(row); 
                                        }
                                            $(formName + ' table td#idioma select').val(data.data[i].idioma); 
                                            $('td#idioma').removeAttr('id');
                                            $(formName + ' table td#tipo select').val(data.data[i].tipoCurso); 
                                            $('td#tipo').removeAttr('id');
                                            $(formName + ' table td#nivel select').val(data.data[i].nivel); 
                                            $('td#nivel').removeAttr('id');
                                    }
                                    $(formName + " #action").val("update2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    $(formName + ' table input').each(function() {                                     
                                        $(this).val("");                                       
                                    });
                                    $(formName + ' table select').each(function() {                                     
                                        $(this).val("");   
                                    });
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    
                }

                function sendFormDocentesIdiomas(formName){
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/academicos/saveUnidadesAcademicas.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 var i = 0;
                                 $('input[name="idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma[]"]').each(function() {
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

