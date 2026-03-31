<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_visitantes">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasProfesoresVisitantes" />
            <input type="hidden" name="action" value="save2" id="action" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Profesores visitantes recibidos en la Facultad</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php //$utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php //$utils->getYearsSelect("anio");  
                ?>-->
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" /> 
			
			<?php $utils->pintarBotonCargar("popup_cargarDocumento(9,3,'',$('#form_visitantes #unidadAcademica').val())","popup_verDocumentos(9,3,'',$('#form_visitantes #unidadAcademica').val())"); ?>
                            
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Profesores visitantes recibidos en la Facultad</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nombre del Académico</span></th> 
                            <th class="column" ><span>Fecha de la visita</span></th> 
                            <th class="column" ><span>Cuidad/ País de origen</span></th> 
                            <th class="column" ><span>Institución</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="nombre[]" title="Total de Proyectos" maxlength="200" tabindex="1" autocomplete="off" value="" />
                                <input type="hidden" name="idsiq_formUnidadesAcademicasProfesoresVisitantes[]" value=""  />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-6-12 required inputTable dateInput" minlength="1" name="fechaVisita[]" title="Total de Proyectos" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-6-12 required inputTable" minlength="1" name="ciudad[]" title="Total de Proyectos" maxlength="100" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="institucion[]" title="Total de Proyectos" maxlength="200" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            <div class="adicionarVisitantes" onmouseover="adicionarVisitantes(this)" title="">
                <input type="button" class="first small" id="addMoreVisitantes" value="Agregar otro" style="margin-top:10px">
            </div>
            <div class="removerVisitantes" onmouseover="removerVisitantes(this)" title="">
                <input type="button" class="first small" id="removeVisitantes" value="Eliminar último" style="margin-top:10px">
            </div>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitVisitantes" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">
    //getDataVisitantes("#form_visitantes");
   
   $('#addMoreVisitantes').click(function(event) {
           addTableRow("#form_visitantes");
   });
   
   $( "#form_visitantes table" ).on("click", '.dateInput', function () {
       var inputDate = $(this);
            /*$('#form_visitantes table input.dateInput').each(function() { 
                    $(this).removeAttr("id");
                   $(this).removeClass("hasDatepicker");                                       
           });*/
         //alert("aja");
         //$.datepicker.setDefaults($.datepicker.regional['es']);
         inputDate.datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,
             changeYear: true, maxDate: "+0D"}).focus();
   });
   
   $('#removeVisitantes').click(function(event) {
       var formName = "#form_visitantes";
       var inputName = "input[name='idsiq_formUnidadesAcademicasProfesoresVisitantes[]']";
       if($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()!=""){
        var id = $(formName + ' table').children('tbody').children('tr:last').find(inputName).val();
        var entity = $(formName + ' #entity').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: './formularios/academicos/saveUnidadesAcademicas.php',
            data: { action: "inactivate", idsiq_formUnidadesAcademicasProfesoresVisitantes:id,entity:entity },                
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
    
                $('#submitVisitantes').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_visitantes");
                    if(valido){
                        sendFormVisitantes("#form_visitantes");
                    }
                });
                
                //$('#form_visitantes #mes').add($('#form_visitantes #anio')).add($('#form_visitantes #unidadAcademica')).bind('change', function(event) {
                //    getDataVisitantes("#form_visitantes");
                //});
                
                $(document).on('change', "#form_visitantes #modalidad", function(){
                    getCarreras("#form_visitantes");
                    changeFormModalidad("#form_visitantes");
                });
                
                $(document).on('change', "#form_visitantes #unidadAcademica", function(){
                    changeFormModalidad("#form_visitantes");
                });
                
                function getDataVisitantes(formName){
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
                                    $("#idsiq_formUnidadesAcademicasProfesoresVisitantes").val(data.data.idsiq_formUnidadesAcademicasProfesoresVisitantes);
                                    $(formName + " #numAprobadas").val(data.data.numAprobadas);
                                    $(formName + " #numEjecucion").val(data.data.numEjecucion);
                                    $(formName + " #action").val("update2");
                                }
                                else{                        
                                    //no hay datos xq no hay carrera
                                    $(formName + ' table input').each(function() {                                     
                                        $(this).val("");                                       
                                    });
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

                function sendFormVisitantes(formName){
                //var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                //$(formName + ' #codigoperiodo').val(periodo);
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
                                 $('input[name="idsiq_formUnidadesAcademicasProfesoresVisitantes[]"]').each(function() {
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
