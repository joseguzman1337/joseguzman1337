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
		<li><a href="#tabs-1">Uso del espacio</a></li>
		<li><a href="./formularios/recursosFisicos/_formDesarrolloFisicoPuestosAlumnos.php">Puestos de trabajo para alumnos</a></li>
		<li><a href="./formularios/recursosFisicos/_formDesarrolloFisicoAreas.php">Áreas</a></li>
		<!--<li><a href="./formularios/recursosFisicos/_formDesarrolloFisicoPlantaFisica.php">Índice de crecimiento planta física</a></li>-->
	</ul>
    
<div id="tabs-1">
<form action="save.php" method="post" id="form_test">
      <input type="hidden" name="entity" id="entity" value="formDesarrolloFisicoUsoEspacio" />
      <input type="hidden" name="action" value="saveDynamic2" id="action" />
      <input type="hidden" name="idsiq_formDesarrolloFisicoUsoEspacio" value="" id="idsiq_formDesarrolloFisicoUsoEspacio" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Uso del espacio, área, número de unidades y tenencia</legend>
                                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio"); 
                $espacios = $utils->getAll($db,"siq_espaciosFisicos","codigoestado=100","nombre"); ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />             
                
                <div class="vacio"></div>
                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Uso del espacio, área, número de unidades y tenencia</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Espacio</span></th> 
                            <th class="column borderR" ><span>M<sup>2</sup> </span></th> 
                            <th class="column borderR" ><span>Número de unidades</span></th> 
                            <th class="column borderR" ><span>Tenencia</span></th> 
                            <th class="column" ><span>Observaciones</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $espacios->FetchRow()) { ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_espaciosFisicos"]; ?>" value="<?php echo $row["idsiq_espaciosFisicos"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformDesarrolloFisicoUsoEspacio[]" value="" id="idsiq_detalleformDesarrolloFisicoUsoEspacio_<?php echo $row["idsiq_espaciosFisicos"]; ?>" /></td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-6-12 required number" minlength="1" name="metros[]" id="metros_<?php echo $row["idsiq_espaciosFisicos"]; ?>" title="Total de metros cuadrados" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-6-12 required number" minlength="1" name="numUnidades[]" id="numUnidades_<?php echo $row["idsiq_espaciosFisicos"]; ?>" title="Total de unidades" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-6-12 required inputTable" minlength="1" name="tenencia[]" id="tenencia_<?php echo $row["idsiq_espaciosFisicos"]; ?>" title="Tenencias" maxlength="255" tabindex="1" autocomplete="off" value="Propio" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-12-12 inputTable" minlength="1" name="observaciones[]" id="observaciones_<?php echo $row["idsiq_espaciosFisicos"]; ?>" title="Observaciones" maxlength="255" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <?php } ?>       
                    </tbody>
                </table>   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none;"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitUsoEspacios" value="Guardar datos" class="first" />
        </form>
</div>
</div>
<script type="text/javascript">
    getDataUsoEspacios("#form_test");
    
    $('#submitUsoEspacios').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                        sendFormUsoEspacios("#form_test");
                    }
    });
    
    $('#form_test #mes').add($('#form_test #anio')).bind('change', function(event) {
          getDataUsoEspacios("#form_test");
    });
    
    function getDataUsoEspacios(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_espaciosFisicos" },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formDesarrolloFisicoUsoEspacio").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformDesarrolloFisicoUsoEspacio_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformDesarrolloFisicoUsoEspacio);
                                        $(formName + " #metros_"+data.data[i].idCategory).val(data.data[i].metros);
                                        $(formName + " #numUnidades_"+data.data[i].idCategory).val(data.data[i].numUnidades);
                                        $(formName + " #tenencia_"+data.data[i].idCategory).val(data.data[i].tenencia);
                                        $(formName + " #observaciones_"+data.data[i].idCategory).val(data.data[i].observaciones);
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formDesarrolloFisicoUsoEspacio").val()!=""){
                                        $(formName + ' input[name="idsiq_detalleformDesarrolloFisicoUsoEspacio[]"]').each(function() {                                     
                                            $(this).val("");                                       
                                        });
                                        var mes = $(formName + ' #mes').val();
                                        var anio = $(formName + ' #anio').val();
                                        document.forms[formName.replace("#","")].reset();
                                            $(formName + ' #mes').val(mes);
                                            $(formName + ' #anio').val(anio);
                                        $(formName + " #action").val("saveDynamic2");
                                            $("#idsiq_formDesarrolloFisicoUsoEspacio").val("");
                                     }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                }
                
         function sendFormUsoEspacios(formName){
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formDesarrolloFisicoUsoEspacio").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformDesarrolloFisicoUsoEspacio_"+data.dataCat[i]).val(data.data[i]);
                                 }
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