<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({    
                    cache: true,
                    beforeLoad: function( event, ui ) {
                            ui.jqXHR.error(function() {
                                    ui.panel.html(
                                    "Ocurrio un problema cargando el contenido." );
                                    });
                            }/*,
                    load : function(event,ui) {
                        try {
                            $(this).tabs('load',ui.index+1);
                        } catch (e) {
                        }
                    }*/
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
                
                //para hacer el menu vertical
                //$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                //$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
                
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
                $( "#tabs" ).tabs('load',2);    
                
	});
</script>

<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="#tabs-1">Personal de la universidad</a></li>
                                        <li><a href="./formularios/docentes/_formTalentoHumanoEscalafonDocentes.php?id=<?php echo $id; ?>">Docentes por escalaf&oacute;n docente</a></li>
                                        <li><a href="./formularios/docentes/_formTalentoHumanoFormacionDocentes.php?id=<?php echo $id; ?>">Docentes por nivel de Formaci&oacute;n</a></li>
                                        <li><a href="./formularios/docentes/_formTalentoHumanoPersonalPrestacionServicios.php?id=<?php echo $id; ?>">Personal por prestaci&oacute;n de servicios</a></li>
                                        <li><a href="./formularios/docentes/_formTalentoHumanoPrestamosCondonables.php?id=<?php echo $id; ?>">Pr&eacute;stamos Condonables</a></li>
					<!--<li><a href="./formularios/docentes/_formTalentoHumanoApoyosEconomicos.php?id=<?php //echo $id; ?>">Apoyos econ&oacute;micos </a></li>-->
                                        <li><a href="./formularios/docentes/_formTalentoHumanoIndiceSelectividad.php?id=<?php echo $id; ?>">&Iacute;ndice de selectividad de los acad&eacute;micos</a></li>
					<li><a href="./formularios/docentes/_formTalentoHumanoAcademicosDesvinculados.php?id=<?php echo $id; ?>">Acad&eacute;micos desvinculados</a></li>
					<li><a href="./formularios/docentes/_formTalentoHumanoAcademicosExtranjerosUnidadAcademica.php?id=<?php echo $id; ?>">Acad&eacute;micos extranjeros por Programa Acad&eacute;mico</a></li>
					<li><a href="./formularios/docentes/_formTalentoHumanoAcademicosExtranjerosPais.php?id=<?php echo $id; ?>">Acad&eacute;micos extranjeros por pa&#237;s de origen</a></li>
                                        <li><a href="./formularios/docentes/_formTalentoHumanoDedicacionDocentesEscalafon.php?id=<?php echo $id; ?>">Dedicaci&oacute;n Semanal Docentes por Escalaf&oacute;n<br/> (Universidad El Bosque)</a></li>
					<li><a href="./formularios/docentes/_formTalentoHumanoDedicacionDocentesEscalafonCNA.php?id=<?php echo $id; ?>">Dedicaci&oacute;n Semanal Docentes por Escalaf&oacute;n (CNA)</a></li>
					<!--<li><a href="./formularios/docentes/_formTalentoHumanoAcademicosDocentesOtroIdioma.php?id=<?php //echo $id; ?>">Profesores que cursan programas de idioma no materno</a></li>-->
                                        <li><a href="./formularios/docentes/_formTalentoHumanoDedicacionSemanal.php?tipo=1&id=<?php echo $id; ?>">Dedicaci&oacute;n de los Acad&eacute;micos Semanal<br>(Según categorización Universidad El Bosque), por Mayor Nivel de Formación</a></li>
                                       <li><a href="./formularios/docentes/_formTalentoHumanoDedicacionSemanal.php?tipo=2&id=<?php echo $id; ?>">Dedicaci&oacute;n de los Acad&eacute;micos Semanal<br> categorizaci&oacute;n de la Universidad El Bosque/Estudios en Curso</a></li>
                                        <li><a href="./formularios/docentes/_formTalentoHumanoDedicacionSemanalCNA.php?tipo=1&id=<?php echo $id; ?>">Dedicaci&oacute;n de los Acad&eacute;micos Semanal<br>(Según categorización del CNA), por Mayor Nivel de Formación</a></li>
                                        <li><a href="./formularios/docentes/_formTalentoHumanoDedicacionSemanalCNA.php?tipo=2&id=<?php echo $id; ?>">Dedicaci&oacute;n de los Acad&eacute;micos Semanal<br>categorizaci&oacute;n del CNA/Estudios en Curso</a></li>
                                        <li><a href="./formularios/docentes/_formTalentoHumanoActividadesAcademicos.php?tipo=2&id=<?php echo $id; ?>">Dedicaci&oacute;n de los Acad&eacute;micos por Actividades </a></li>
     			
                                </ul>
    
         
<div id="tabs-1">
<form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoNumeroPersonas" />
            <input type="hidden" name="action" value="save" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            <input type="hidden" name="idsiq_formTalentoHumanoNumeroPersonas" value="" id="idsiq_formTalentoHumanoNumeroPersonas" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Personal de la universidad</legend>
                
                <!--<label for="nombre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php //$utils->getSemestresSelect($db);  ?>-->
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,1,$('#form_test #mes').val()+'-'+$('#form_test #anio').val())","popup_verDocumentos(5,1,$('#form_test #mes').val()+'-'+$('#form_test #anio').val())"); ?>
                
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />                   
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Informaci&oacute;n verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Número de Personas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Talento Humano</span></th> 
                            <th class="column" ><span>Número de Personas</span></th> 
                            <!--<th class="column" ><span>Dato verificado</span></th> -->
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Acad&eacute;micos <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <!--<input type="text"  class="grid-4-12 required number disable" minlength="1" name="numAcademicos" id="numAcademicos" title="Total de Acad&eacute;micos" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />-->
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAcademicos" id="numAcademicos" title="Total de Acad&eacute;micos" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicos" value="1" id="vnumAcademicos" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Administrativos <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAdministrativos" id="numAdministrativos" title="Total de Administrativos" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAdministrativos" value="1" id="vnumAdministrativos" >
                            </td>-->
                        </tr>
                    </tbody>
                </table>   
                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Docentes por Vinculaci&oacute;n</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Tipo de Contrataci&oacute;n</span></th> 
                            <th class="column" ><span>Número de Acad&eacute;micos</span></th> 
                            <!--<th class="column" ><span>Dato verificado</span></th> -->
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column">Adjunto (Semestral) <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAcademicosSemestral" id="numAcademicosSemestral" title="Total de Acad&eacute;micos Semestral" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosSemestral" value="1" id="vnumAcademicosSemestral" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Académico (11 meses) <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAcademicosAnual" id="numAcademicosAnual" title="Total de Acad&eacute;micos Anual" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosAnual" value="1" id="vnumAcademicosAnual" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Núcleo Profesoral Académico <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAcademicosNucleoProfesoral" id="numAcademicosNucleoProfesoral" title="Total de Acad&eacute;micos Núcleo Profesoral" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosNucleoProfesoral" value="1" id="vnumAcademicosNucleoProfesoral" >
                            </td>-->
                        </tr>
                    </tbody>
                </table> 
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Docentes por dedicaci&oacute;n de tiempo</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Dedicaci&oacute;n</span></th> 
                            <th class="column" ><span>Número de Acad&eacute;micos</span></th>
                            <!--<th class="column" ><span>Dato verificado</span></th> --> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column">Tiempo Completo <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAcademicosTC" id="numAcademicosTC" title="Acad&eacute;micos de TC" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                           <!-- <td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosTC" value="1" id="vnumAcademicosTC" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">3/4 Tiempo <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAcademicos34T" id="numAcademicos34T" title="Acad&eacute;micos de 3/4 T" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicos34T" value="1" id="vnumAcademicos34T" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">1/2 Tiempo <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAcademicosMT" id="numAcademicosMT" title="Acad&eacute;micos de 1/2 T" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicosMT" value="1" id="vnumAcademicosMT" >
                            </td>-->
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">1/4 Tiempo <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numAcademicos14T" id="numAcademicos14T" title="Acad&eacute;micos de 1/4 T" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <!--<td class="column center"> 
                                <input type="checkbox" name="vnumAcademicos14T" value="1" id="vnumAcademicos14T" >
                            </td>-->
                        </tr>
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitPersonas" value="Guardar datos" class="first" />
        </form>
</div>
</div>
<script type="text/javascript">
    getDataPersonas();
    
                $('#submitPersonas').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                        sendFormPersonas();
                    }
                });
                
               // $('#form_test #codigoperiodo').change(function(event) {
       $('#form_test #mes').add($('#form_test #anio')).bind('change', function(event) {
                    getDataPersonas();
                });
                
                function getDataPersonas(){
                    var periodo = $('#form_test #mes').val()+"-"+$('#form_test #anio').val();
                    var entity = $("#form_test #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo", verificar: true },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formTalentoHumanoNumeroPersonas").val(data.data.idsiq_formTalentoHumanoNumeroPersonas);
                                 $("#numAcademicos").val(data.data.numAcademicos);
                                 $("#numAdministrativos").val(data.data.numAdministrativos);
                                 $("#numAcademicosSemestral").val(data.data.numAcademicosSemestral);
                                 $("#numAcademicosAnual").val(data.data.numAcademicosAnual);
                                 $("#numAcademicosNucleoProfesoral").val(data.data.numAcademicosNucleoProfesoral);
                                 $("#numAcademicosTC").val(data.data.numAcademicosTC);
                                 $("#numAcademicos34T").val(data.data.numAcademicos34T);
                                 $("#numAcademicosMT").val(data.data.numAcademicosMT);
                                 $("#numAcademicos14T").val(data.data.numAcademicos14T);
                                 
                                 /*if(data.datav.vnumAcademicos==1){
                                     $('input[name=vnumAcademicos]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicos]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAdministrativos==1){
                                     $('input[name=vnumAdministrativos]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAdministrativos]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosSemestral==1){
                                     $('input[name=vnumAcademicosSemestral]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosSemestral]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosAnual==1){
                                     $('input[name=vnumAcademicosAnual]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosAnual]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosNucleoProfesoral==1){
                                     $('input[name=vnumAcademicosNucleoProfesoral]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosNucleoProfesoral]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosTC==1){
                                     $('input[name=vnumAcademicosTC]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosTC]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicos34T==1){
                                     $('input[name=vnumAcademicos34T]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicos34T]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicosMT==1){
                                     $('input[name=vnumAcademicosMT]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicosMT]').attr('checked', false);
                                 }
                                 
                                 if(data.datav.vnumAcademicos14T==1){
                                     $('input[name=vnumAcademicos14T]').attr('checked', true);
                                 } else {
                                     $('input[name=vnumAcademicos14T]').attr('checked', false);
                                 }       */                       
                                 $("#form_test #action").val("update");
                                 //$("#form_test #verificada_"+data.data.verificada).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formTalentoHumanoNumeroPersonas").val()!=""){
                                    //var periodo = $('#form_test #codigoperiodo').val();                                    
                                        var mes = $('#form_test #mes').val();
                                        var anio = $('#form_test #anio').val();
                                    document.forms["form_test"].reset();                                       
                                            $('#form_test #mes').val(mes);
                                            $('#form_test #anio').val(anio);
                                    //$('#form_test #codigoperiodo').val(periodo);
                                    $("#form_test #action").val("save");
                                    $("#idsiq_formTalentoHumanoNumeroPersonas").val("");
                                    $('input:checkbox').removeAttr('checked');
                                }
                                
                                //como el usuario no los puede editar me toca inicializarlos
                                $("#numAcademicos").val("0");
                                $("#numAdministrativos").val("0");
                                $("#numAcademicosSemestral").val("0");
                                $("#numAcademicosAnual").val("0");
                                $("#numAcademicosNucleoProfesoral").val("0");
                                $("#numAcademicosTC").val("0");
                                $("#numAcademicos34T").val("0");
                                $("#numAcademicosMT").val("0");
                                $("#numAcademicos14T").val("0");
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormPersonas(){
                var periodo = $('#form_test #mes').val()+"-"+$('#form_test #anio').val();
                $('#form_test #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formTalentoHumanoNumeroPersonas").val(data.message);
                                 $("#form_test #action").val("update");
                                 $('#form_test #msg-success').css('display','block');
                                 $("#form_test #msg-success").delay(5500).fadeOut(800);
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