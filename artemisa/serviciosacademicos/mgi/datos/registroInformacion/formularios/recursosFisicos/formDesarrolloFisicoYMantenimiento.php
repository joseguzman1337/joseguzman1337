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
<?php
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
    }
?>
<div id="tabs" class="dontCalculate">
	<ul>
		<li><a href="#tabs-1">Uso del espacio</a></li>
		<li><a href="./formularios/recursosFisicos/_formDesarrolloFisicoPuestosAlumnos.php">Puestos de trabajo para alumnos</a></li>
                <li><a href="./formularios/recursosFisicos/_formDesarrolloFisicoAreas.php">&Aacute;reas</a></li>
		<!--<li><a href="./formularios/recursosFisicos/_formDesarrolloFisicoPlantaFisica.php">�?ndice de crecimiento planta física</a></li>-->
	</ul>
    
<div id="tabs-1">
<form action="save.php" method="post" id="form_test">
      <input type="hidden" name="entity" id="entity" value="formDesarrolloFisicoUsoEspacio" />
      <input type="hidden" name="action" value="saveDynamic2" id="action" />
      <input type="hidden" name="idsiq_formDesarrolloFisicoUsoEspacio" value="" id="idsiq_formDesarrolloFisicoUsoEspacio" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Uso del espacio, área, número de unidades y tenencia</legend>
                                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                $utils->pintarBotonCargar("popup_cargarDocumento(4,1,$('#form_test #codigoperiodo').val())","popup_verDocumentos(4,1,$('#form_test #codigoperiodo').val())");
                $espacios = $utils->getAll($db,"siq_espaciosFisicos","codigoestado=100","idsiq_espaciosFisicos"); ?>
                
                <div class="vacio"></div>
                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "4"; else echo "5";?>"><span>Uso del espacio, área, número de unidades y tenencia</span></th>                                    
                            <?php if($aprobacion){ ?>
                            <th class="column"><span>
                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
				<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
	                   </span></th>  
                           <?php } ?>
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
    var aprobacion = '<?php echo $aprobacion; ?>';
    getDataUsoEspacios("#form_test");
    
    $('#submitUsoEspacios').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                        sendFormUsoEspacios("#form_test");
                    }
    });
    
    $('#form_test #codigoperiodo').bind('change', function(event) {
          getDataUsoEspacios("#form_test");
    });
    
    function getDataUsoEspacios(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
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
                                        
                                        if(data.data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #submitUsoEspacios").attr('disabled','disabled');
                                           $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").addClass("disable");
                                                 $(this).removeAttr("disabled").addClass("disable");
                                            });
                                          }else{
                                               
                                              $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                           // $(formName + " #enviafinanciamiento").removeAttr('disabled','disabled');
                                              $(formName + " #Verificado").attr("checked", false);
                                            }
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formDesarrolloFisicoUsoEspacio").val()!=""){
                                        $(formName + ' input[name="idsiq_detalleformDesarrolloFisicoUsoEspacio[]"]').each(function() {                                     
                                            $(this).val("");                                       
                                        });
                                        var mes = $(formName + ' #codigoperiodo').val();
                                        document.forms[formName.replace("#","")].reset();
                                            $(formName + ' #codigoperiodo').val(mes);
                                        $(formName + " #action").val("saveDynamic2");
                                            $("#idsiq_formDesarrolloFisicoUsoEspacio").val("");
                                              $(formName + " #Verificado").attr("checked", false);
                                            $(formName).find(':input').each(function() {
                                                       $(this).removeAttr("readonly").removeClass("disable");
                                            });
                                     }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                }
                
         function sendFormUsoEspacios(formName){
                      $(formName + " input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").removeAttr("disabled");
                      });
         
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