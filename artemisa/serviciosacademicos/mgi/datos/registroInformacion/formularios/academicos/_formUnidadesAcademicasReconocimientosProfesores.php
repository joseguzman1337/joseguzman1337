<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_reconocimientosProfesores">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasReconocimientosProfesores" />
            <input type="hidden" name="action" value="save2" id="action" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Premios o reconocimientos a los académicos</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
			
			<?php $utils->pintarBotonCargar("popup_cargarDocumento(9,4,'',$('#form_reconocimientosProfesores #unidadAcademica').val())","popup_verDocumentos(9,4,'',$('#form_reconocimientosProfesores #unidadAcademica').val())"); ?>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Premios o reconocimientos a los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nombre del Académico</span></th> 
                            <th class="column" ><span>Tipo de Reconocimiento</span></th> 
                            <th class="column" ><span>Entidad o Institución</span></th> 
                            <th class="column" ><span>Ciudad y País</span></th> 
                            <th class="column" ><span>Fecha</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="nombre[]" title="Nombre del Reconocimiento" maxlength="200" tabindex="1" autocomplete="off" value="" />
                                <input type="hidden" name="idsiq_formUnidadesAcademicasReconocimientosProfesores[]" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="tipoReconocimiento[]" title="Tipo del Reconocimiento" maxlength="200" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="institucion[]" title="Total de Proyectos" maxlength="200" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="ciudad[]" title="Total de Proyectos" maxlength="100" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-9-12 required inputTable dateInput" minlength="1" name="fechaReconocimiento[]" title="Total de Proyectos" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                            </td>
                        </tr>
                    </tbody>
                </table>
            <div class="adicionarVisitantes" onmouseover="adicionarVisitantes(this)" title="">
                <input type="button" class="first small" id="addMoreReconocimientosProfesores" value="Agregar otro" style="margin-top:10px">
            </div>
            <div class="removerVisitantes" onmouseover="removerVisitantes(this)" title="">
                <input type="button" class="first small" id="removeReconocimientosProfesores" value="Eliminar último" style="margin-top:10px">
            </div>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitReconocimientosProfesores" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">    
   
   $('#addMoreReconocimientosProfesores').click(function(event) {
           addTableRow("#form_reconocimientosProfesores");
   });
   
   $('#removeReconocimientosProfesores').click(function(event) {
       var formName = "#form_reconocimientosProfesores";
       var inputName = "input[name='idsiq_formUnidadesAcademicasReconocimientosProfesores[]']";
       if($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()!=""){
        var id = $(formName + ' table').children('tbody').children('tr:last').find(inputName).val();
        var entity = $(formName + ' #entity').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: './formularios/academicos/saveUnidadesAcademicas.php',
            data: { action: "inactivate", idsiq_formUnidadesAcademicasReconocimientosProfesores:id,entity:entity },                
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
    
                $('#submitReconocimientosProfesores').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_reconocimientosProfesores");
                    if(valido){
                        sendFormReconocimientosProfesores("#form_reconocimientosProfesores");
                    }
                });  
                
                $(document).on('change', "#form_reconocimientosProfesores #modalidad", function(){
                    getCarreras("#form_reconocimientosProfesores");
                    changeFormModalidad("#form_reconocimientosProfesores");
                });
                
                $(document).on('change', "#form_reconocimientosProfesores #unidadAcademica", function(){
                    changeFormModalidad("#form_reconocimientosProfesores");
                });

                function sendFormReconocimientosProfesores(formName){
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
                                 $('input[name="idsiq_formUnidadesAcademicasReconocimientosProfesores[]"]').each(function() {
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
            
            $( "#form_reconocimientosProfesores table" ).on("click", '.dateInput', function () {
                var inputDate = $(this);
                        //$('#form_reconocimientosProfesores table input.dateInput').each(function() {  
                            //$(this).removeAttr("id");
                            //$(this).removeClass("hasDatepicker");                                       
                    //});
                    
                    //inputDate.addClass("hasDatepicker");
                    //alert("aja");
                    //$.datepicker.setDefaults($.datepicker.regional['es']);
                    inputDate.datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,
                        changeYear: true, maxDate: "+0D"}).focus();
            });
</script>
