<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({    
                    cache: true,
                    beforeLoad: function( event, ui ) {
                            ui.jqXHR.error(function() {
                                    ui.panel.html(
                                    "Ocurrio un problema cargando el contenido." );
                                    });
                            }
		});
                
                $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más formularios", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
                
                $("#tabs").bind("tabsload",function(event,ui){
                    var total = $("#tabs").find('.ui-tabs-nav li').length;
                    if(ui.index<total){
                        try {
                            $(this).tabs( "load" , ui.index+1);
                        } catch (e) {
                        }
                    } else {
                        $(this).unbind('tabsload');
                    }
                });
                                
                //Para cargar todas las de ajax por debajo
                //$( "#tabs" ).tabs('load',2);    
                
	});
</script>
<div id="tabs" class="dontCalculate">
	<ul>
		<!--<li><a href="#tabs-1">Estudiantes beneficiados por becas</a></li>-->
		<li><a href="./formularios/financieros/_formCreditoYCarteraDescuentos.php?id=<?php echo $id; ?>">Estudiantes beneficiados por descuentos</a></li>
		<!--<li><a href="./formularios/financieros/_formCreditoYCarteraCreditos.php?id=<?php echo $id; ?>">Estudiantes beneficiados por créditos</a></li>-->
		<li><a href="./formularios/financieros/_formCreditoYCarteraApoyos.php?id=<?php echo $id; ?>">Estudiantes beneficiados por apoyos o estímulos</a></li>
        <li><a href="./formularios/financieros/BecasBeneficio_html.php?id=<?php echo $id; ?>">Estudiantes beneficiados por becas</a></li>
         <li><a href="./formularios/financieros/BeneficiadoCredito_html.php?id=<?php echo $id; ?>">Estudiantes beneficiados por créditos</a></li>
         <li><a href="./formularios/financieros/PoblacionEspecial_EstratoBajo_html.php?id=<?php echo $id; ?>">Estudiantes admitidos por programas y convenios de poblaciones especiales y estratos bajos</a></li>
         <li><a href="./formularios/financieros/EstudianteBenficiados_html.php?id=<?php echo $id; ?>">Número de estudiantes que se han beneficiado de estas modalidades</a></li>
	</ul>
    
         <!--
<div id="tabs-1">
<form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" id="entity" value="formCreditoYCarteraBecas" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formCreditoYCarteraBecas" value="" id="idsiq_formCreditoYCarteraBecas" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Estudiantes beneficiados por becas</legend>
                
                <label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php //$utils->getSemestresSelect($db);  ?>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Estudiantes que se han beneficiado por Becas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Becas</span></th> 
                            <th class="column" ><span>Número de estudiantes beneficiados</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Becas de excelencia académica <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numBecadosExcelenciaAcademica" id="numBecadosExcelenciaAcademica" title="Total de Becados por Excelencia Académica" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Beca poblaciones especiales <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numBecadosPoblacionesEspeciales" id="numBecadosPoblacionesEspeciales" title="Total de Becados de Poblaciones Especiales" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Beca Grado de Honor <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numBecadosGradoHonor" id="numBecadosGradoHonor" title="Total de Becados por Grado de Honor" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Beca graduandos (ECAES) <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numBecadosGraduandosECAES" id="numBecadosGraduandosECAES" title="Total de Becados Graduandos" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitBecas" value="Guardar datos" class="first" /> 
        </form>
</div>-->
</div>
<!--<script type="text/javascript">
    var formName1 = "#form_test";
    getDataBecas(formName1);
    
                $('#submitBecas').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm(formName1);
                    if(valido){
                        sendFormBecas(formName1);
                    }
                });
                
                $(formName1 + ' #codigoperiodo').change(function(event) {
                    getDataBecas(formName1);
                });
                
                function getDataBecas(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/financieros/saveCreditoYCartera.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo" },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formCreditoYCarteraBecas").val(data.data.idsiq_formCreditoYCarteraBecas);
                                 $("#numBecadosExcelenciaAcademica").val(data.data.numBecadosExcelenciaAcademica);
                                 $("#numBecadosPoblacionesEspeciales").val(data.data.numBecadosPoblacionesEspeciales);
                                 $("#numBecadosGradoHonor").val(data.data.numBecadosGradoHonor);
                                 $("#numBecadosGraduandosECAES").val(data.data.numBecadosGraduandosECAES);
                                 $(formName + " #action").val("update");
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formCreditoYCarteraBecas").val()!=""){
                                    var periodo = $(formName + ' #codigoperiodo').val();
                                    document.forms[formName.replace("#","")].reset();
                                    $(formName + ' #codigoperiodo').val(periodo);
                                    $(formName + " #action").val("save");
                                    $("#idsiq_formCreditoYCarteraBecas").val("");
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormBecas(formName){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/financieros/saveCreditoYCartera.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formCreditoYCarteraBecas").val(data.message);
                                 $(formName + " #action").val("update");
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
                
</script>-->